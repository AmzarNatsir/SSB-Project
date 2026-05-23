<?php

namespace App\Services;

use App\Enums\PettyCashPaymentStatus;
use App\Enums\PettyCashRequestStatus;
use App\Models\PettyCashPayment;
use App\Models\PettyCashPaymentApproval;
use App\Models\PettyCashRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PettyCashPaymentService
{
    public const FLOW_CODE = 'PettyCashPayment';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
        protected PettyCashRequestService $requestService,
    ) {}

    public function create(array $data, int $userId): PettyCashPayment
    {
        $request = PettyCashRequest::findOrFail($data['petty_cash_request_id']);

        if ($request->status !== PettyCashRequestStatus::APPROVED) {
            throw ValidationException::withMessages([
                'petty_cash_request_id' => 'Permintaan Kas Kecil harus berstatus Disetujui.',
            ]);
        }

        $amount = (float) $data['amount'];
        if ($amount > $request->remaining_amount + 0.001) {
            throw ValidationException::withMessages([
                'amount' => sprintf(
                    'Nominal melebihi sisa permintaan (sisa: Rp %s).',
                    number_format($request->remaining_amount, 0, ',', '.')
                ),
            ]);
        }

        return DB::transaction(function () use ($data, $userId, $request, $amount) {
            $payment = PettyCashPayment::create([
                'payment_number'        => $this->generateNumber($data['payment_date']),
                'petty_cash_request_id' => $request->id,
                'expense_category_id'   => $data['expense_category_id'],
                'project_id'            => $request->project_id,
                'payment_date'          => $data['payment_date'],
                'description'           => $data['description'],
                'amount'                => $amount,
                'status'                => PettyCashPaymentStatus::DRAFT,
                'current_approval_level' => 0,
                'created_by'            => $userId,
            ]);

            $this->handleAttachment($payment, $data);

            $this->audit->log($payment, 'PETTY_CASH_PAYMENT_CREATED', $userId, [], [
                'payment_number' => $payment->payment_number,
                'amount'         => $amount,
                'request'        => $request->request_number,
            ]);

            return $payment->fresh(['request', 'expenseCategory', 'project']);
        });
    }

    public function update(PettyCashPayment $payment, array $data, int $userId): PettyCashPayment
    {
        if (! $payment->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Pembayaran dengan status {$payment->status->label()} tidak bisa diedit.",
            ]);
        }

        // Validate new amount against request's remaining + current payment's amount (since it's not yet consumed in DRAFT)
        if (isset($data['amount'])) {
            $newAmount = (float) $data['amount'];
            $request = $payment->request;
            if ($newAmount > $request->remaining_amount + 0.001) {
                throw ValidationException::withMessages([
                    'amount' => sprintf(
                        'Nominal melebihi sisa permintaan (sisa: Rp %s).',
                        number_format($request->remaining_amount, 0, ',', '.')
                    ),
                ]);
            }
        }

        return DB::transaction(function () use ($payment, $data, $userId) {
            $old = $payment->only(['amount', 'description', 'payment_date', 'expense_category_id']);

            $payment->update([
                'payment_date'        => $data['payment_date'] ?? $payment->payment_date,
                'description'         => $data['description']  ?? $payment->description,
                'amount'              => $data['amount']       ?? $payment->amount,
                'expense_category_id' => $data['expense_category_id'] ?? $payment->expense_category_id,
            ]);

            $this->handleAttachment($payment, $data);

            $this->audit->log($payment, 'PETTY_CASH_PAYMENT_UPDATED', $userId, $old, $payment->only([
                'amount', 'description', 'payment_date', 'expense_category_id',
            ]));

            return $payment->fresh();
        });
    }

    public function submit(PettyCashPayment $payment, int $userId): PettyCashPayment
    {
        if (! $payment->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Pembayaran dengan status {$payment->status->label()} tidak bisa diajukan.",
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Petty Cash Payment belum diatur.',
            ]);
        }

        return DB::transaction(function () use ($payment, $userId, $levels) {
            $first = $levels->first();
            PettyCashPaymentApproval::create([
                'petty_cash_payment_id' => $payment->id,
                'level'                 => $first->level_number,
                'approver_id'           => null,
                'status'                => 'pending',
            ]);

            $payment->update([
                'status' => PettyCashPaymentStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);

            $this->audit->log($payment, 'PETTY_CASH_PAYMENT_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $payment->fresh(['approvals']);
        });
    }

    public function processApproval(
        PettyCashPayment $payment,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): PettyCashPayment {
        if (! $payment->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Pembayaran dengan status {$payment->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages(['decision' => 'Keputusan tidak valid.']);
        }

        return DB::transaction(function () use ($payment, $approverId, $decision, $remarks) {
            $currentLevel = $payment->current_approval_level;
            $pending = $payment->approvals()
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
                $payment->update([
                    'status' => PettyCashPaymentStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($payment, 'PETTY_CASH_PAYMENT_REJECTED', $approverId, [], [
                    'level' => $currentLevel, 'remarks' => $remarks,
                ]);
                return $payment->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                PettyCashPaymentApproval::create([
                    'petty_cash_payment_id' => $payment->id,
                    'level'                 => $nextLevel->level_number,
                    'approver_id'           => null,
                    'status'                => 'pending',
                ]);
                $payment->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($payment, 'PETTY_CASH_PAYMENT_APPROVED_LEVEL', $approverId, [], [
                    'level' => $currentLevel, 'next_level' => $nextLevel->level_number,
                ]);
            } else {
                // Final approval: consume amount dari Request
                $this->requestService->consumeAmount($payment->request, (float) $payment->amount);

                $payment->update([
                    'status' => PettyCashPaymentStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($payment, 'PETTY_CASH_PAYMENT_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                    'amount_consumed' => (float) $payment->amount,
                ]);
            }

            return $payment->fresh(['approvals', 'request']);
        });
    }

    protected function handleAttachment(PettyCashPayment $payment, array $data): void
    {
        if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
            $path = $this->uploadFile($data['attachment'], 'pcp');
            $payment->update(['attachment_path' => $path]);
        }
    }

    protected function uploadFile(UploadedFile $file, string $prefix): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('petty-cash/payments', $filename, 'private');
    }

    public function generateNumber(string $date): string
    {
        $year = Carbon::parse($date)->format('Y');
        $count = PettyCashPayment::whereYear('created_at', $year)->count() + 1;
        do {
            $number = sprintf('PCP/%s/%03d', $year, $count);
            $count++;
        } while (PettyCashPayment::where('payment_number', $number)->exists());
        return $number;
    }
}
