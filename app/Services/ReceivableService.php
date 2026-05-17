<?php

namespace App\Services;

use App\Enums\PaymentType;
use App\Enums\ReceivableStatus;
use App\Models\Project;
use App\Models\Receivable;
use App\Models\ReceivableApproval;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReceivableService
{
    public const FLOW_CODE = 'Receivable';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
    ) {}

    public function create(array $data, int $userId): Receivable
    {
        return DB::transaction(function () use ($data, $userId) {
            $project = Project::findOrFail($data['project_id']);
            $receivedDate = Carbon::parse($data['received_date']);

            $receivable = Receivable::create([
                'receivable_number' => $this->generateNumber($receivedDate),
                'project_id'        => $project->id,
                'invoice_id'        => $data['invoice_id'] ?? null,
                'customer_name'     => $project->user_name,
                'received_date'     => $receivedDate->toDateString(),
                'amount'            => (float) $data['amount'],
                'payment_type'      => $data['payment_type'],
                'payment_reference' => $data['payment_reference'] ?? null,
                'description'       => $data['description'] ?? null,
                'status'            => ReceivableStatus::DRAFT,
                'current_approval_level' => 0,
                'created_by'        => $userId,
            ]);

            $this->handleAttachment($receivable, $data);

            $this->audit->log($receivable, 'RECEIVABLE_CREATED', $userId, [], [
                'receivable_number' => $receivable->receivable_number,
                'amount'            => $receivable->amount,
                'payment_type'      => $receivable->payment_type->value,
            ]);

            return $receivable->fresh(['project', 'invoice']);
        });
    }

    public function update(Receivable $receivable, array $data, int $userId): Receivable
    {
        if (! $receivable->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Penerimaan dengan status {$receivable->status->label()} tidak bisa diedit.",
            ]);
        }

        return DB::transaction(function () use ($receivable, $data, $userId) {
            $old = $receivable->only([
                'received_date', 'amount', 'payment_type',
                'payment_reference', 'description', 'invoice_id',
            ]);

            $receivable->update([
                'invoice_id'        => $data['invoice_id'] ?? $receivable->invoice_id,
                'received_date'     => $data['received_date'] ?? $receivable->received_date,
                'amount'            => isset($data['amount']) ? (float) $data['amount'] : $receivable->amount,
                'payment_type'      => $data['payment_type'] ?? $receivable->payment_type,
                'payment_reference' => $data['payment_reference'] ?? $receivable->payment_reference,
                'description'       => $data['description'] ?? $receivable->description,
            ]);

            $this->handleAttachment($receivable, $data);

            $this->audit->log($receivable, 'RECEIVABLE_UPDATED', $userId, $old, $receivable->only([
                'received_date', 'amount', 'payment_type',
                'payment_reference', 'description', 'invoice_id',
            ]));

            return $receivable->fresh();
        });
    }

    public function submit(Receivable $receivable, int $userId): Receivable
    {
        if (! $receivable->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Penerimaan dengan status {$receivable->status->label()} tidak bisa diajukan.",
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Receivable belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($receivable, $userId, $levels) {
            $first = $levels->first();
            ReceivableApproval::create([
                'receivable_id' => $receivable->id,
                'level'         => $first->level_number,
                'approver_id'   => null,
                'status'        => 'pending',
            ]);

            $receivable->update([
                'status' => ReceivableStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);

            $this->audit->log($receivable, 'RECEIVABLE_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $receivable->fresh(['approvals']);
        });
    }

    public function processApproval(
        Receivable $receivable,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): Receivable {
        if (! $receivable->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Penerimaan dengan status {$receivable->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages([
                'decision' => 'Keputusan harus berupa "approved" atau "rejected".',
            ]);
        }

        return DB::transaction(function () use ($receivable, $approverId, $decision, $remarks) {
            $currentLevel = $receivable->current_approval_level;

            $pending = $receivable->approvals()
                ->where('level', $currentLevel)
                ->where('status', 'pending')
                ->first();

            if ($pending) {
                $pending->update([
                    'approver_id' => $approverId,
                    'status'      => $decision,
                    'remarks'     => $remarks,
                    'approved_at' => now(),
                ]);
            }

            if ($decision === 'rejected') {
                $receivable->update([
                    'status' => ReceivableStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($receivable, 'RECEIVABLE_REJECTED', $approverId, [], [
                    'level'   => $currentLevel,
                    'remarks' => $remarks,
                ]);
                return $receivable->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                ReceivableApproval::create([
                    'receivable_id' => $receivable->id,
                    'level'         => $nextLevel->level_number,
                    'approver_id'   => null,
                    'status'        => 'pending',
                ]);
                $receivable->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($receivable, 'RECEIVABLE_APPROVED_LEVEL', $approverId, [], [
                    'level'      => $currentLevel,
                    'next_level' => $nextLevel->level_number,
                ]);
            } else {
                $receivable->update([
                    'status' => ReceivableStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($receivable, 'RECEIVABLE_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                ]);
            }

            return $receivable->fresh(['approvals']);
        });
    }

    protected function handleAttachment(Receivable $receivable, array $data): void
    {
        if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
            $path = $this->uploadFile($data['attachment'], 'bukti_penerimaan');
            $receivable->update(['attachment_path' => $path]);
        }
    }

    protected function uploadFile(UploadedFile $file, string $prefix): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('receivables/attachments', $filename, 'private');
    }

    /**
     * Format: RCV/YYYY/NNN (per tahun, di-reset awal tahun).
     */
    public function generateNumber(Carbon $date): string
    {
        $year = $date->format('Y');
        $count = Receivable::whereYear('received_date', $year)->count() + 1;

        do {
            $number = sprintf('RCV/%s/%03d', $year, $count);
            $count++;
        } while (Receivable::where('receivable_number', $number)->exists());

        return $number;
    }
}
