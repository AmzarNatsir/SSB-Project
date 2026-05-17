<?php

namespace App\Services;

use App\Enums\WorkforceFormationStatus;
use App\Models\WorkforceFormation;
use App\Models\WorkforceFormationApproval;
use App\Models\WorkforceFormationMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class WorkforceFormationService
{
    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
        protected EmployeeApiService $employees,
    ) {}

    public const FLOW_CODE = 'WorkforceFormation';

    public function create(array $data, int $userId): WorkforceFormation
    {
        return DB::transaction(function () use ($data, $userId) {
            $attachmentPath = $this->uploadAttachmentIfAny($data['attachment'] ?? null);

            $formation = WorkforceFormation::create([
                'formation_number' => $this->generateNumber(),
                'project_id' => $data['project_id'],
                'contract_id' => $data['contract_id'],
                'effective_date' => $data['effective_date'],
                'end_date' => $data['end_date'] ?? null,
                'status' => WorkforceFormationStatus::DRAFT,
                'current_approval_level' => 0,
                'notes' => $data['notes'] ?? null,
                'attachment_path' => $attachmentPath,
                'created_by' => $userId,
            ]);

            if (! empty($data['members'])) {
                $this->syncMembers($formation, $data['members']);
            }

            $this->audit->log($formation, 'WORKFORCE_FORMATION_CREATED', $userId, [], [
                'formation_number' => $formation->formation_number,
                'members_count' => $formation->members()->count(),
            ]);

            return $formation->fresh(['members', 'project', 'contract']);
        });
    }

    public function update(WorkforceFormation $formation, array $data, int $userId): WorkforceFormation
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

            if (array_key_exists('members', $data) && is_array($data['members'])) {
                $this->syncMembers($formation, $data['members']);
            }

            $this->audit->log($formation, 'WORKFORCE_FORMATION_UPDATED', $userId, $old, $update);

            return $formation->fresh(['members']);
        });
    }

    public function submit(WorkforceFormation $formation, int $userId): WorkforceFormation
    {
        if (! $formation->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "SK dengan status {$formation->status->label()} tidak bisa diajukan untuk approval.",
            ]);
        }

        if ($formation->members()->count() === 0) {
            throw ValidationException::withMessages([
                'members' => 'SK Penugasan harus memiliki minimal 1 anggota tim.',
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);

        // Strict mode: tolak submit kalau matriks approval belum dikonfigurasi.
        // Sebelumnya auto-approve, tapi itu bypass policy approval — berbahaya untuk SK formal.
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk SK Penugasan Tim belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($formation, $userId, $levels) {
            $first = $levels->first();
            WorkforceFormationApproval::create([
                'workforce_formation_id' => $formation->id,
                'level' => $first->level_number,
                'approver_id' => null,
                'status' => 'pending',
            ]);

            $formation->update([
                'status' => WorkforceFormationStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);
            $this->audit->log($formation, 'WORKFORCE_FORMATION_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $formation->fresh(['approvals']);
        });
    }

    public function processApproval(
        WorkforceFormation $formation,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): WorkforceFormation {
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
                    'status' => WorkforceFormationStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($formation, 'WORKFORCE_FORMATION_REJECTED', $approverId, [], [
                    'level' => $currentLevel,
                    'remarks' => $remarks,
                ]);
                return $formation->fresh();
            }

            // Approved — check next level
            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                WorkforceFormationApproval::create([
                    'workforce_formation_id' => $formation->id,
                    'level' => $nextLevel->level_number,
                    'approver_id' => null,
                    'status' => 'pending',
                ]);
                $formation->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($formation, 'WORKFORCE_FORMATION_APPROVED_LEVEL', $approverId, [], [
                    'level' => $currentLevel,
                    'next_level' => $nextLevel->level_number,
                ]);
            } else {
                // Final approval
                $formation->update([
                    'status' => WorkforceFormationStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($formation, 'WORKFORCE_FORMATION_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                ]);
            }

            return $formation->fresh(['approvals']);
        });
    }

    public function activate(WorkforceFormation $formation, int $userId): WorkforceFormation
    {
        if (! $formation->canActivate()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya SK yang sudah Disetujui yang bisa diaktifkan.',
            ]);
        }

        $formation->update(['status' => WorkforceFormationStatus::ACTIVE]);
        $this->audit->log($formation, 'WORKFORCE_FORMATION_ACTIVATED', $userId);

        return $formation->fresh();
    }

    /**
     * Buat versi REVISED (clone formation aktif untuk diedit).
     */
    public function revise(WorkforceFormation $formation, int $userId): WorkforceFormation
    {
        if (! $formation->canRevise()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya SK Aktif yang bisa direvisi.',
            ]);
        }

        return DB::transaction(function () use ($formation, $userId) {
            $revision = $formation->replicate(['uid', 'formation_number', 'status', 'approved_by', 'approved_at']);
            $revision->formation_number = $this->generateNumber();
            $revision->status = WorkforceFormationStatus::REVISED;
            $revision->current_approval_level = 0;
            $revision->created_by = $userId;
            $revision->save();

            foreach ($formation->members as $m) {
                $clone = $m->replicate();
                $clone->workforce_formation_id = $revision->id;
                $clone->save();
            }

            $this->audit->log($revision, 'WORKFORCE_FORMATION_REVISED', $userId, [], [
                'parent_formation_number' => $formation->formation_number,
            ]);

            return $revision->fresh(['members']);
        });
    }

    public function end(WorkforceFormation $formation, int $userId): WorkforceFormation
    {
        if (! $formation->canEnd()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya SK Aktif yang bisa diakhiri.',
            ]);
        }

        $formation->update([
            'status' => WorkforceFormationStatus::ENDED,
            'end_date' => $formation->end_date ?? now()->toDateString(),
        ]);
        $this->audit->log($formation, 'WORKFORCE_FORMATION_ENDED', $userId);

        return $formation->fresh();
    }

    /**
     * Sync members — replace strategy (delete all, recreate).
     * Snapshot data dari API_EMPLOYEE bila employee_id valid.
     *
     * @param  array<int,array>  $members
     */
    protected function syncMembers(WorkforceFormation $formation, array $members): void
    {
        $formation->members()->delete();

        foreach ($members as $m) {
            $employeeId = (int) ($m['employee_id'] ?? 0);
            if ($employeeId <= 0) {
                continue;
            }

            // Snapshot dari API employee bila nama tidak dikirim frontend
            $snapshot = null;
            if (empty($m['employee_name']) || empty($m['position_name'])) {
                $snapshot = $this->employees->find($employeeId);
            }

            WorkforceFormationMember::create([
                'workforce_formation_id' => $formation->id,
                'employee_id' => $employeeId,
                'employee_name' => $m['employee_name'] ?? ($snapshot['name'] ?? 'Unknown'),
                'position_name' => $m['position_name'] ?? ($snapshot['position'] ?? '-'),
                'daily_rate' => $m['daily_rate'] ?? 0,
                'allowance' => $m['allowance'] ?? 0,
                'shift' => $m['shift'] ?? 'DAY',
                'start_date' => $m['start_date'] ?? $formation->effective_date,
                'end_date' => $m['end_date'] ?? null,
                'is_active' => $m['is_active'] ?? true,
                'remarks' => $m['remarks'] ?? null,
            ]);
        }
    }

    protected function generateNumber(): string
    {
        $year = date('Y');
        $count = WorkforceFormation::whereYear('created_at', $year)->count() + 1;

        do {
            $number = sprintf('WF/%s/%03d', $year, $count);
            $count++;
        } while (WorkforceFormation::where('formation_number', $number)->exists());

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

        return $file->storeAs('workforce-formations/attachments', $filename, 'private');
    }
}
