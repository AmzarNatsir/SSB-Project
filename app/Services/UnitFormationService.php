<?php

namespace App\Services;

use App\Enums\UnitFormationStatus;
use App\Models\UnitFormation;
use App\Models\UnitFormationApproval;
use App\Models\UnitFormationItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UnitFormationService
{
    public const FLOW_CODE = 'UnitFormation';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
        protected EmployeeApiService $employees,
        protected WorkshopApiService $units,
    ) {}

    public function create(array $data, int $userId): UnitFormation
    {
        return DB::transaction(function () use ($data, $userId) {
            $attachmentPath = $this->uploadAttachmentIfAny($data['attachment'] ?? null);

            $formation = UnitFormation::create([
                'formation_number' => $this->generateNumber(),
                'project_id' => $data['project_id'],
                'contract_id' => $data['contract_id'],
                'unit_request_id' => $data['unit_request_id'] ?? null,
                'effective_date' => $data['effective_date'],
                'end_date' => $data['end_date'] ?? null,
                'status' => UnitFormationStatus::DRAFT,
                'current_approval_level' => 0,
                'notes' => $data['notes'] ?? null,
                'attachment_path' => $attachmentPath,
                'created_by' => $userId,
            ]);

            if (! empty($data['items'])) {
                $this->syncItems($formation, $data['items']);
            }

            $this->audit->log($formation, 'UNIT_FORMATION_CREATED', $userId, [], [
                'formation_number' => $formation->formation_number,
                'items_count' => $formation->items()->count(),
            ]);

            return $formation->fresh(['items', 'project', 'contract']);
        });
    }

    public function update(UnitFormation $formation, array $data, int $userId): UnitFormation
    {
        if (! $formation->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "SK dengan status {$formation->status->label()} tidak bisa diedit.",
            ]);
        }

        return DB::transaction(function () use ($formation, $data, $userId) {
            $old = $formation->only(['effective_date', 'end_date', 'notes']);

            $update = array_filter([
                'effective_date' => $data['effective_date'] ?? null,
                'end_date' => $data['end_date'] ?? null,
                'notes' => $data['notes'] ?? null,
            ], fn ($v) => $v !== null);

            if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
                $update['attachment_path'] = $this->uploadAttachmentIfAny($data['attachment']);
            }

            if (! empty($update)) {
                $formation->update($update);
            }

            if (array_key_exists('items', $data) && is_array($data['items'])) {
                $this->syncItems($formation, $data['items']);
            }

            $this->audit->log($formation, 'UNIT_FORMATION_UPDATED', $userId, $old, $update);
            return $formation->fresh(['items']);
        });
    }

    public function submit(UnitFormation $formation, int $userId): UnitFormation
    {
        if (! $formation->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "SK dengan status {$formation->status->label()} tidak bisa diajukan untuk approval.",
            ]);
        }

        if ($formation->items()->count() === 0) {
            throw ValidationException::withMessages([
                'items' => 'SK Penetapan Unit harus memiliki minimal 1 unit.',
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk SK Penetapan Unit belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($formation, $userId, $levels) {
            $first = $levels->first();
            UnitFormationApproval::create([
                'unit_formation_id' => $formation->id,
                'level' => $first->level_number,
                'approver_id' => null,
                'status' => 'pending',
            ]);

            $formation->update([
                'status' => UnitFormationStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);
            $this->audit->log($formation, 'UNIT_FORMATION_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $formation->fresh(['approvals']);
        });
    }

    public function processApproval(
        UnitFormation $formation,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): UnitFormation {
        if (! $formation->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "SK dengan status {$formation->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages([
                'decision' => 'Keputusan harus berupa "approved" atau "rejected".',
            ]);
        }

        return DB::transaction(function () use ($formation, $approverId, $decision, $remarks) {
            $currentLevel = $formation->current_approval_level;

            $pending = $formation->approvals()
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
                $formation->update([
                    'status' => UnitFormationStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($formation, 'UNIT_FORMATION_REJECTED', $approverId, [], [
                    'level' => $currentLevel,
                    'remarks' => $remarks,
                ]);
                return $formation->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                UnitFormationApproval::create([
                    'unit_formation_id' => $formation->id,
                    'level' => $nextLevel->level_number,
                    'approver_id' => null,
                    'status' => 'pending',
                ]);
                $formation->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($formation, 'UNIT_FORMATION_APPROVED_LEVEL', $approverId, [], [
                    'level' => $currentLevel,
                    'next_level' => $nextLevel->level_number,
                ]);
            } else {
                $formation->update([
                    'status' => UnitFormationStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($formation, 'UNIT_FORMATION_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                ]);
            }

            return $formation->fresh(['approvals']);
        });
    }

    public function activate(UnitFormation $formation, int $userId): UnitFormation
    {
        if (! $formation->canActivate()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya SK yang sudah Disetujui yang bisa diaktifkan.',
            ]);
        }

        $formation->update(['status' => UnitFormationStatus::ACTIVE]);
        $this->audit->log($formation, 'UNIT_FORMATION_ACTIVATED', $userId);
        return $formation->fresh();
    }

    public function revise(UnitFormation $formation, int $userId): UnitFormation
    {
        if (! $formation->canRevise()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya SK Aktif yang bisa direvisi.',
            ]);
        }

        return DB::transaction(function () use ($formation, $userId) {
            $revision = $formation->replicate(['uid', 'formation_number', 'status', 'approved_by', 'approved_at']);
            $revision->formation_number = $this->generateNumber();
            $revision->status = UnitFormationStatus::REVISED;
            $revision->current_approval_level = 0;
            $revision->created_by = $userId;
            $revision->save();

            foreach ($formation->items as $item) {
                $clone = $item->replicate();
                $clone->unit_formation_id = $revision->id;
                $clone->save();
            }

            $this->audit->log($revision, 'UNIT_FORMATION_REVISED', $userId, [], [
                'parent_formation_number' => $formation->formation_number,
            ]);

            return $revision->fresh(['items']);
        });
    }

    public function end(UnitFormation $formation, int $userId): UnitFormation
    {
        if (! $formation->canEnd()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya SK Aktif yang bisa diakhiri.',
            ]);
        }

        $formation->update([
            'status' => UnitFormationStatus::ENDED,
            'end_date' => $formation->end_date ?? now()->toDateString(),
        ]);
        $this->audit->log($formation, 'UNIT_FORMATION_ENDED', $userId);
        return $formation->fresh();
    }

    /**
     * Sync items — replace strategy. Snapshot unit_name/operator_name dari external API
     * kalau frontend tidak kirim.
     *
     * @param  array<int,array>  $items
     */
    protected function syncItems(UnitFormation $formation, array $items): void
    {
        $formation->items()->delete();

        foreach ($items as $item) {
            $equipmentId = (int) ($item['equipment_unit_id'] ?? 0);
            if ($equipmentId <= 0) {
                continue;
            }

            // Snapshot unit dari Workshop API kalau nama tidak dikirim
            $unitSnapshot = null;
            if (empty($item['unit_name']) || empty($item['equipment_code'])) {
                $unitSnapshot = $this->units->find($equipmentId);
            }

            // Snapshot operator dari Employee API kalau nama tidak dikirim
            $operatorSnapshot = null;
            $operatorId = (int) ($item['assigned_operator_id'] ?? 0);
            if ($operatorId > 0 && empty($item['operator_name'])) {
                $operatorSnapshot = $this->employees->find($operatorId);
            }

            UnitFormationItem::create([
                'unit_formation_id' => $formation->id,
                'contract_item_id' => $item['contract_item_id'] ?? null,
                'equipment_unit_id' => $equipmentId,
                'assigned_operator_id' => $operatorId > 0 ? $operatorId : null,
                'unit_name' => $item['unit_name'] ?? ($unitSnapshot['name'] ?? 'Unknown Unit'),
                'equipment_code' => $item['equipment_code'] ?? ($unitSnapshot['equipment_code'] ?? null),
                'operator_name' => $item['operator_name'] ?? ($operatorSnapshot['name'] ?? null),
                'hm_start' => $item['hm_start'] ?? 0,
                'hm_target_monthly' => $item['hm_target_monthly'] ?? null,
                'status' => $item['status'] ?? 'READY',
                'remarks' => $item['remarks'] ?? null,
            ]);
        }
    }

    protected function generateNumber(): string
    {
        $year = date('Y');
        $count = UnitFormation::whereYear('created_at', $year)->count() + 1;

        do {
            $number = sprintf('UF/%s/%03d', $year, $count);
            $count++;
        } while (UnitFormation::where('formation_number', $number)->exists());

        return $number;
    }

    protected function uploadAttachmentIfAny(?UploadedFile $file): ?string
    {
        if (! $file instanceof UploadedFile) {
            return null;
        }

        $filename = time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('unit-formations/attachments', $filename, 'private');
    }
}
