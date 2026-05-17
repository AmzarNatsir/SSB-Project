<?php

namespace App\Services;

use App\Enums\TimesheetJournalStatus;
use App\Enums\WorkRealizationStatus;
use App\Models\ContractItem;
use App\Models\TimesheetEntry;
use App\Models\WorkRealization;
use App\Models\WorkRealizationApproval;
use App\Models\WorkRealizationItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class WorkRealizationService
{
    public const FLOW_CODE = 'WorkRealization';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
    ) {}

    /**
     * Create + generate items dalam satu transaksi.
     * Items di-agregasi otomatis dari TimesheetEntry pada timesheet APPROVED dalam periode tsb.
     */
    public function create(array $data, int $userId): WorkRealization
    {
        // Validate period
        $periodStart = $data['period_start'];
        $periodEnd = $data['period_end'];
        if ($periodEnd < $periodStart) {
            throw ValidationException::withMessages([
                'period_end' => 'Tanggal akhir periode harus setelah atau sama dengan tanggal mulai.',
            ]);
        }

        // Cek apakah sudah ada realisasi untuk project+periode yang overlap
        $overlap = WorkRealization::where('project_id', $data['project_id'])
            ->where(function ($q) use ($periodStart, $periodEnd) {
                $q->whereBetween('period_start', [$periodStart, $periodEnd])
                  ->orWhereBetween('period_end', [$periodStart, $periodEnd])
                  ->orWhere(function ($q2) use ($periodStart, $periodEnd) {
                      $q2->where('period_start', '<=', $periodStart)
                         ->where('period_end', '>=', $periodEnd);
                  });
            })
            ->whereNotIn('status', [WorkRealizationStatus::REJECTED])
            ->exists();
        if ($overlap) {
            throw ValidationException::withMessages([
                'period_start' => 'Sudah ada Work Realization aktif untuk proyek ini di periode yang overlap.',
            ]);
        }

        return DB::transaction(function () use ($data, $userId, $periodStart, $periodEnd) {
            $realization = WorkRealization::create([
                'realization_number' => $this->generateNumber($periodStart),
                'project_id' => $data['project_id'],
                'contract_id' => $data['contract_id'] ?? null,
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'status' => WorkRealizationStatus::DRAFT,
                'current_approval_level' => 0,
                'total_realized_amount' => 0,
                'notes' => $data['notes'] ?? null,
                'created_by' => $userId,
            ]);

            // Upload attachments
            $this->handleAttachments($realization, $data);

            // Auto-aggregate dari Timesheet APPROVED dalam periode
            $itemsGenerated = $this->generateItemsFromTimesheets($realization);

            // Hitung total amount
            $this->recalculateTotal($realization);

            $this->audit->log($realization, 'WORK_REALIZATION_CREATED', $userId, [], [
                'realization_number' => $realization->realization_number,
                'period' => "{$periodStart} → {$periodEnd}",
                'items_generated' => $itemsGenerated,
            ]);

            return $realization->fresh(['items', 'project', 'contract']);
        });
    }

    /**
     * Update header + items (penyesuaian tarif sewa per item).
     * Header field yang bisa diupdate: notes, attachments. Period & project di-lock setelah create.
     */
    public function update(WorkRealization $realization, array $data, int $userId): WorkRealization
    {
        if (! $realization->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Work Realization dengan status {$realization->status->label()} tidak bisa diedit.",
            ]);
        }

        return DB::transaction(function () use ($realization, $data, $userId) {
            $old = $realization->only(['notes']);

            if (isset($data['notes'])) {
                $realization->update(['notes' => $data['notes']]);
            }

            $this->handleAttachments($realization, $data);

            // Update items — hanya field yang user boleh edit (rate adjustment, notes)
            // total_hm + timesheet_count NOT editable (sumber dari timesheet, immutable)
            if (! empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $itemId => $itemData) {
                    $item = WorkRealizationItem::where('id', $itemId)
                        ->where('work_realization_id', $realization->id)
                        ->first();
                    if (! $item) continue;

                    $adjustedRate = isset($itemData['adjusted_rate']) ? (float) $itemData['adjusted_rate'] : (float) $item->adjusted_rate;

                    $item->update([
                        'adjusted_rate' => $adjustedRate,
                        'rate_adjustment_reason' => $itemData['rate_adjustment_reason'] ?? $item->rate_adjustment_reason,
                        'notes' => $itemData['notes'] ?? $item->notes,
                        'realized_amount' => round($item->total_hm * $adjustedRate, 2),
                    ]);
                }
            }

            $this->recalculateTotal($realization);

            $this->audit->log($realization, 'WORK_REALIZATION_UPDATED', $userId, $old, [
                'notes' => $realization->notes,
            ]);

            return $realization->fresh(['items']);
        });
    }

    /**
     * Regenerate items dari Timesheet (overwrite). Berguna kalau ada timesheet baru
     * yang di-approve setelah realisasi dibuat tapi sebelum di-submit.
     */
    public function regenerate(WorkRealization $realization, int $userId): WorkRealization
    {
        if (! $realization->canEdit()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya Work Realization Draft / Ditolak yang bisa di-regenerate.',
            ]);
        }

        return DB::transaction(function () use ($realization, $userId) {
            // Preserve existing rate adjustments — keyed by unit_formation_item_id
            $existingAdjustments = $realization->items()
                ->whereNotNull('unit_formation_item_id')
                ->get()
                ->keyBy('unit_formation_item_id');

            $realization->items()->delete();
            $itemsGenerated = $this->generateItemsFromTimesheets($realization);

            // Re-apply rate adjustments where user had set custom values
            foreach ($realization->items()->get() as $newItem) {
                $existing = $existingAdjustments->get($newItem->unit_formation_item_id);
                if ($existing && (float) $existing->adjusted_rate !== (float) $newItem->contract_rate) {
                    $newItem->update([
                        'adjusted_rate' => $existing->adjusted_rate,
                        'rate_adjustment_reason' => $existing->rate_adjustment_reason,
                        'notes' => $existing->notes,
                        'realized_amount' => round($newItem->total_hm * $existing->adjusted_rate, 2),
                    ]);
                }
            }

            $this->recalculateTotal($realization);

            $this->audit->log($realization, 'WORK_REALIZATION_REGENERATED', $userId, [], [
                'items_regenerated' => $itemsGenerated,
            ]);

            return $realization->fresh(['items']);
        });
    }

    public function submit(WorkRealization $realization, int $userId): WorkRealization
    {
        if (! $realization->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Work Realization dengan status {$realization->status->label()} tidak bisa diajukan.",
            ]);
        }

        if ($realization->items()->count() === 0) {
            throw ValidationException::withMessages([
                'items' => 'Tidak ada data realisasi unit untuk diajukan. Pastikan ada Timesheet APPROVED dalam periode tsb.',
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Work Realization belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($realization, $userId, $levels) {
            $first = $levels->first();
            WorkRealizationApproval::create([
                'work_realization_id' => $realization->id,
                'level' => $first->level_number,
                'approver_id' => null,
                'status' => 'pending',
            ]);

            $realization->update([
                'status' => WorkRealizationStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);

            $this->audit->log($realization, 'WORK_REALIZATION_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $realization->fresh(['approvals']);
        });
    }

    public function processApproval(
        WorkRealization $realization,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): WorkRealization {
        if (! $realization->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Work Realization dengan status {$realization->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages([
                'decision' => 'Keputusan harus berupa "approved" atau "rejected".',
            ]);
        }

        return DB::transaction(function () use ($realization, $approverId, $decision, $remarks) {
            $currentLevel = $realization->current_approval_level;

            $pending = $realization->approvals()
                ->where('level', $currentLevel)
                ->where('status', 'pending')
                ->first();

            if ($pending) {
                $pending->update([
                    'approver_id' => $approverId,
                    'status' => $decision,
                    'remarks' => $remarks,
                    'approved_at' => now(),
                ]);
            }

            if ($decision === 'rejected') {
                $realization->update([
                    'status' => WorkRealizationStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($realization, 'WORK_REALIZATION_REJECTED', $approverId, [], [
                    'level' => $currentLevel,
                    'remarks' => $remarks,
                ]);
                return $realization->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                WorkRealizationApproval::create([
                    'work_realization_id' => $realization->id,
                    'level' => $nextLevel->level_number,
                    'approver_id' => null,
                    'status' => 'pending',
                ]);
                $realization->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($realization, 'WORK_REALIZATION_APPROVED_LEVEL', $approverId, [], [
                    'level' => $currentLevel,
                    'next_level' => $nextLevel->level_number,
                ]);
            } else {
                $realization->update([
                    'status' => WorkRealizationStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($realization, 'WORK_REALIZATION_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                ]);
            }

            return $realization->fresh(['approvals']);
        });
    }

    /**
     * Agregasi dari TimesheetEntry pada timesheet APPROVED dalam periode realisasi.
     * Group by unit_formation_item_id → sum hm_total, count jurnal, min/max date.
     */
    protected function generateItemsFromTimesheets(WorkRealization $realization): int
    {
        // Ambil semua timesheet APPROVED dalam periode + project
        $entries = TimesheetEntry::query()
            ->select([
                'unit_formation_item_id',
                'unit_name',
                'operator_name',
                DB::raw('SUM(hm_total) as total_hm'),
                DB::raw('COUNT(DISTINCT timesheet_journal_id) as timesheet_count'),
                DB::raw('MIN(timesheet_journals.journal_date) as period_start'),
                DB::raw('MAX(timesheet_journals.journal_date) as period_end'),
            ])
            ->join('timesheet_journals', 'timesheet_entries.timesheet_journal_id', '=', 'timesheet_journals.id')
            ->where('timesheet_journals.project_id', $realization->project_id)
            ->where('timesheet_journals.status', TimesheetJournalStatus::APPROVED)
            ->whereBetween('timesheet_journals.journal_date', [$realization->period_start, $realization->period_end])
            ->whereNotNull('timesheet_entries.unit_formation_item_id')
            ->groupBy(['unit_formation_item_id', 'unit_name', 'operator_name'])
            ->get();

        $generated = 0;
        foreach ($entries as $row) {
            // Ambil baseline contract rate dari ContractItem (via UnitFormationItem.contract_item_id)
            $contractRate = 0;
            $contractItemId = null;
            $equipmentCode = null;

            $ufItem = \App\Models\UnitFormationItem::find($row->unit_formation_item_id);
            if ($ufItem) {
                $equipmentCode = $ufItem->equipment_code;
                if ($ufItem->contract_item_id) {
                    $ci = ContractItem::find($ufItem->contract_item_id);
                    if ($ci) {
                        $contractRate = (float) $ci->unit_price;
                        $contractItemId = $ci->id;
                    }
                }
            }

            $totalHm = (float) $row->total_hm;
            $realizedAmount = round($totalHm * $contractRate, 2);

            WorkRealizationItem::create([
                'work_realization_id' => $realization->id,
                'unit_formation_item_id' => $row->unit_formation_item_id,
                'contract_item_id' => $contractItemId,
                'unit_name' => $row->unit_name,
                'equipment_code' => $equipmentCode,
                'operator_name' => $row->operator_name,
                'period_start' => $row->period_start,
                'period_end' => $row->period_end,
                'total_hm' => $totalHm,
                'timesheet_count' => (int) $row->timesheet_count,
                'contract_rate' => $contractRate,
                'adjusted_rate' => $contractRate, // default sama dgn baseline
                'rate_adjustment_reason' => null,
                'realized_amount' => $realizedAmount,
            ]);
            $generated++;
        }

        return $generated;
    }

    protected function recalculateTotal(WorkRealization $realization): void
    {
        $total = $realization->items()->sum('realized_amount');
        $realization->update(['total_realized_amount' => $total]);
    }

    protected function handleAttachments(WorkRealization $realization, array $data): void
    {
        $map = [
            'pa_ma_attachment' => 'pa_ma_attachment_path',
            'safety_attachment' => 'safety_attachment_path',
            'berita_acara_attachment' => 'berita_acara_attachment_path',
        ];

        foreach ($map as $inputKey => $dbField) {
            if (isset($data[$inputKey]) && $data[$inputKey] instanceof UploadedFile) {
                $path = $this->uploadFile($data[$inputKey], $inputKey);
                $realization->update([$dbField => $path]);
            }
        }
    }

    protected function uploadFile(UploadedFile $file, string $prefix): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('work-realizations/attachments', $filename, 'private');
    }

    protected function generateNumber(string $periodStart): string
    {
        $date = \Carbon\Carbon::parse($periodStart);
        $year = $date->format('Y');
        $count = WorkRealization::whereYear('created_at', $year)->count() + 1;

        do {
            $number = sprintf('WR/%s/%03d', $year, $count);
            $count++;
        } while (WorkRealization::where('realization_number', $number)->exists());

        return $number;
    }
}
