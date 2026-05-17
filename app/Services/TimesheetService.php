<?php

namespace App\Services;

use App\Enums\TimesheetJournalStatus;
use App\Models\TimesheetEntry;
use App\Models\TimesheetJournal;
use App\Models\UnitFormationItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TimesheetService
{
    public const FLOW_CODE = 'TimesheetJournal';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
    ) {}

    public function create(array $data, int $userId): TimesheetJournal
    {
        // Cek unique combo project + date + shift sebelum DB constraint melempar SQL error
        $exists = TimesheetJournal::where('project_id', $data['project_id'])
            ->whereDate('journal_date', $data['journal_date'])
            ->where('shift', $data['shift'])
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'journal_date' => "Sudah ada jurnal untuk proyek ini pada tanggal {$data['journal_date']} shift {$data['shift']}.",
            ]);
        }

        return DB::transaction(function () use ($data, $userId) {
            $journal = TimesheetJournal::create([
                'journal_number' => $this->generateNumber($data['journal_date']),
                'project_id' => $data['project_id'],
                'contract_id' => $data['contract_id'] ?? null,
                'journal_date' => $data['journal_date'],
                'shift' => $data['shift'],
                'status' => TimesheetJournalStatus::DRAFT,
                'current_approval_level' => 0,
                'notes' => $data['notes'] ?? null,
            ]);

            if (! empty($data['entries'])) {
                $this->syncEntries($journal, $data['entries']);
            }

            $this->audit->log($journal, 'TIMESHEET_CREATED', $userId, [], [
                'journal_number' => $journal->journal_number,
                'entries_count' => $journal->entries()->count(),
            ]);

            return $journal->fresh(['entries', 'project']);
        });
    }

    public function update(TimesheetJournal $journal, array $data, int $userId): TimesheetJournal
    {
        if (! $journal->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Timesheet dengan status {$journal->status->label()} tidak bisa diedit.",
            ]);
        }

        return DB::transaction(function () use ($journal, $data, $userId) {
            $old = $journal->only(['notes']);

            $update = array_filter([
                'notes' => $data['notes'] ?? null,
            ], fn ($v) => $v !== null);

            if (! empty($update)) {
                $journal->update($update);
            }

            if (array_key_exists('entries', $data) && is_array($data['entries'])) {
                $this->syncEntries($journal, $data['entries']);
            }

            $this->audit->log($journal, 'TIMESHEET_UPDATED', $userId, $old, $update);

            return $journal->fresh(['entries']);
        });
    }

    public function submit(TimesheetJournal $journal, int $userId): TimesheetJournal
    {
        if (! $journal->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Timesheet dengan status {$journal->status->label()} tidak bisa diajukan.",
            ]);
        }

        if ($journal->entries()->count() === 0) {
            throw ValidationException::withMessages([
                'entries' => 'Timesheet harus memiliki minimal 1 entry sebelum diajukan.',
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Timesheet belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($journal, $userId, $levels) {
            $first = $levels->first();
            $journal->update([
                'status' => TimesheetJournalStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
                'submitted_by' => $userId,
                'submitted_at' => now(),
            ]);

            $this->audit->log($journal, 'TIMESHEET_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $journal->fresh();
        });
    }

    public function processApproval(
        TimesheetJournal $journal,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): TimesheetJournal {
        if (! $journal->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Timesheet dengan status {$journal->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages([
                'decision' => 'Keputusan harus berupa "approved" atau "rejected".',
            ]);
        }

        return DB::transaction(function () use ($journal, $approverId, $decision, $remarks) {
            $currentLevel = $journal->current_approval_level;

            if ($decision === 'rejected') {
                $journal->update([
                    'status' => TimesheetJournalStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($journal, 'TIMESHEET_REJECTED', $approverId, [], [
                    'level' => $currentLevel,
                    'remarks' => $remarks,
                ]);
                return $journal->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                $journal->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($journal, 'TIMESHEET_APPROVED_LEVEL', $approverId, [], [
                    'level' => $currentLevel,
                    'next_level' => $nextLevel->level_number,
                ]);
            } else {
                $journal->update([
                    'status' => TimesheetJournalStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($journal, 'TIMESHEET_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                    'remarks' => $remarks,
                ]);
            }

            return $journal->fresh();
        });
    }

    /**
     * Sync entries — replace strategy. Snapshot unit_name + operator_name dari UnitFormationItem.
     *
     * @param  array<int,array>  $entries
     */
    protected function syncEntries(TimesheetJournal $journal, array $entries): void
    {
        $journal->entries()->delete();

        foreach ($entries as $e) {
            $unitFormationItemId = (int) ($e['unit_formation_item_id'] ?? 0);
            if ($unitFormationItemId <= 0) {
                continue;
            }

            // Snapshot dari UnitFormationItem (lebih reliable daripada panggil API setiap entry)
            $snapshot = UnitFormationItem::find($unitFormationItemId);
            if (! $snapshot) {
                continue;
            }

            TimesheetEntry::create([
                'timesheet_journal_id' => $journal->id,
                'unit_formation_item_id' => $unitFormationItemId,
                'equipment_unit_id' => $snapshot->equipment_unit_id,
                'operator_employee_id' => $snapshot->assigned_operator_id,
                'unit_name' => $snapshot->unit_name,
                'operator_name' => $snapshot->operator_name,
                'activity_code' => $e['activity_code'] ?? 'IDLE',
                'hm_start' => $e['hm_start'] ?? 0,
                'hm_end' => $e['hm_end'] ?? 0,
                'operating_start_time' => $e['operating_start_time'] ?? null,
                'operating_end_time' => $e['operating_end_time'] ?? null,
                'working_hours' => $e['working_hours'] ?? 0,
                'idle_start_time' => $e['idle_start_time'] ?? null,
                'idle_end_time' => $e['idle_end_time'] ?? null,
                'idle_reason' => $e['idle_reason'] ?? null,
                'idle_hours' => $e['idle_hours'] ?? 0,
                'breakdown_start_time' => $e['breakdown_start_time'] ?? null,
                'breakdown_end_time' => $e['breakdown_end_time'] ?? null,
                'breakdown_reason' => $e['breakdown_reason'] ?? null,
                'breakdown_hours' => $e['breakdown_hours'] ?? 0,
                'fuel_consumed_liter' => $e['fuel_consumed_liter'] ?? 0,
                'trip_count' => $e['trip_count'] ?? 0,
                'tonnage' => $e['tonnage'] ?? 0,
                'remarks' => $e['remarks'] ?? null,
            ]);
        }
    }

    /**
     * Format: TJ/YYYY/MM/NNN  (NNN sequence per month per year)
     */
    protected function generateNumber(string $journalDate): string
    {
        $date = \Carbon\Carbon::parse($journalDate);
        $year = $date->format('Y');
        $month = $date->format('m');
        $count = TimesheetJournal::whereYear('journal_date', $year)
            ->whereMonth('journal_date', $month)
            ->count() + 1;

        do {
            $number = sprintf('TJ/%s/%s/%03d', $year, $month, $count);
            $count++;
        } while (TimesheetJournal::where('journal_number', $number)->exists());

        return $number;
    }
}
