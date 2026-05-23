<?php

namespace App\Services;

use App\Enums\PettyCashRequestStatus;
use App\Models\PettyCashRequest;
use App\Models\PettyCashRequestApproval;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PettyCashRequestService
{
    public const FLOW_CODE = 'PettyCashRequest';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
    ) {}

    public function create(array $data, int $userId): PettyCashRequest
    {
        return DB::transaction(function () use ($data, $userId) {
            $request = PettyCashRequest::create([
                'request_number'   => $this->generateNumber($data['request_date']),
                'project_id'       => $data['project_id'],
                'contract_id'      => $data['contract_id'] ?? null,
                'request_date'     => $data['request_date'],
                'description'      => $data['description'],
                'requested_amount' => $data['requested_amount'],
                'used_amount'      => 0,
                'status'           => PettyCashRequestStatus::DRAFT,
                'current_approval_level' => 0,
                'created_by'       => $userId,
            ]);

            $this->handleAttachment($request, $data);

            $this->audit->log($request, 'PETTY_CASH_REQUEST_CREATED', $userId, [], [
                'request_number'   => $request->request_number,
                'requested_amount' => (float) $request->requested_amount,
            ]);

            return $request->fresh(['project']);
        });
    }

    public function update(PettyCashRequest $request, array $data, int $userId): PettyCashRequest
    {
        if (! $request->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Permintaan dengan status {$request->status->label()} tidak bisa diedit.",
            ]);
        }

        return DB::transaction(function () use ($request, $data, $userId) {
            $old = $request->only(['description', 'requested_amount', 'request_date']);

            $request->update([
                'request_date'     => $data['request_date'] ?? $request->request_date,
                'description'      => $data['description']  ?? $request->description,
                'requested_amount' => $data['requested_amount'] ?? $request->requested_amount,
                'project_id'       => $data['project_id']  ?? $request->project_id,
                'contract_id'      => $data['contract_id'] ?? $request->contract_id,
            ]);

            $this->handleAttachment($request, $data);

            $this->audit->log($request, 'PETTY_CASH_REQUEST_UPDATED', $userId, $old, $request->only([
                'description', 'requested_amount', 'request_date',
            ]));

            return $request->fresh();
        });
    }

    public function submit(PettyCashRequest $request, int $userId): PettyCashRequest
    {
        if (! $request->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Permintaan dengan status {$request->status->label()} tidak bisa diajukan.",
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Petty Cash Request belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($request, $userId, $levels) {
            $first = $levels->first();
            PettyCashRequestApproval::create([
                'petty_cash_request_id' => $request->id,
                'level'                 => $first->level_number,
                'approver_id'           => null,
                'status'                => 'pending',
            ]);

            $request->update([
                'status' => PettyCashRequestStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);

            $this->audit->log($request, 'PETTY_CASH_REQUEST_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $request->fresh(['approvals']);
        });
    }

    public function processApproval(
        PettyCashRequest $request,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): PettyCashRequest {
        if (! $request->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Permintaan dengan status {$request->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages([
                'decision' => 'Keputusan harus "approved" atau "rejected".',
            ]);
        }

        return DB::transaction(function () use ($request, $approverId, $decision, $remarks) {
            $currentLevel = $request->current_approval_level;
            $pending = $request->approvals()
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
                $request->update([
                    'status' => PettyCashRequestStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($request, 'PETTY_CASH_REQUEST_REJECTED', $approverId, [], [
                    'level' => $currentLevel, 'remarks' => $remarks,
                ]);
                return $request->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                PettyCashRequestApproval::create([
                    'petty_cash_request_id' => $request->id,
                    'level'                 => $nextLevel->level_number,
                    'approver_id'           => null,
                    'status'                => 'pending',
                ]);
                $request->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($request, 'PETTY_CASH_REQUEST_APPROVED_LEVEL', $approverId, [], [
                    'level' => $currentLevel, 'next_level' => $nextLevel->level_number,
                ]);
            } else {
                $request->update([
                    'status' => PettyCashRequestStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($request, 'PETTY_CASH_REQUEST_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                ]);
            }

            return $request->fresh(['approvals']);
        });
    }

    public function close(PettyCashRequest $request, int $userId): PettyCashRequest
    {
        if ($request->status !== PettyCashRequestStatus::APPROVED) {
            throw ValidationException::withMessages([
                'status' => 'Hanya Permintaan yang Disetujui yang bisa di-close.',
            ]);
        }

        $request->update(['status' => PettyCashRequestStatus::CLOSED]);
        $this->audit->log($request, 'PETTY_CASH_REQUEST_CLOSED', $userId, [], [
            'used_amount'      => (float) $request->used_amount,
            'remaining_amount' => $request->remaining_amount,
        ]);

        return $request->fresh();
    }

    /**
     * Tambahkan ke used_amount. Dipanggil saat Payment/Purchase APPROVED.
     * Validasi: tidak boleh overshoot requested_amount.
     */
    public function consumeAmount(PettyCashRequest $request, float $amount): void
    {
        $request->refresh();
        $newUsed = (float) $request->used_amount + $amount;
        if ($newUsed > (float) $request->requested_amount + 0.001) {
            throw ValidationException::withMessages([
                'amount' => sprintf(
                    'Nominal melebihi sisa permintaan (sisa: Rp %s, diminta: Rp %s).',
                    number_format($request->remaining_amount, 0, ',', '.'),
                    number_format($amount, 0, ',', '.')
                ),
            ]);
        }
        $request->update(['used_amount' => $newUsed]);
    }

    /**
     * Kurangi used_amount. Dipanggil saat Payment/Purchase di-soft-delete atau rejected setelah approved (rare).
     */
    public function releaseAmount(PettyCashRequest $request, float $amount): void
    {
        $request->refresh();
        $newUsed = max(0, (float) $request->used_amount - $amount);
        $request->update(['used_amount' => $newUsed]);
    }

    protected function handleAttachment(PettyCashRequest $request, array $data): void
    {
        if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
            $path = $this->uploadFile($data['attachment'], 'pcr');
            $request->update(['attachment_path' => $path]);
        }
    }

    protected function uploadFile(UploadedFile $file, string $prefix): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('petty-cash/requests', $filename, 'private');
    }

    public function generateNumber(string $date): string
    {
        $year = Carbon::parse($date)->format('Y');
        $count = PettyCashRequest::whereYear('created_at', $year)->count() + 1;
        do {
            $number = sprintf('PCR/%s/%03d', $year, $count);
            $count++;
        } while (PettyCashRequest::where('request_number', $number)->exists());
        return $number;
    }
}
