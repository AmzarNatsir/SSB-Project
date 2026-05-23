<?php

namespace App\Services;

use App\Enums\PettyCashPurchaseStatus;
use App\Enums\PettyCashRequestStatus;
use App\Models\PettyCashPurchase;
use App\Models\PettyCashPurchaseApproval;
use App\Models\PettyCashRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PettyCashPurchaseService
{
    public const FLOW_CODE = 'PettyCashPurchase';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
        protected PettyCashRequestService $requestService,
    ) {}

    public function create(array $data, int $userId): PettyCashPurchase
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
            $purchase = PettyCashPurchase::create([
                'purchase_number'        => $this->generateNumber($data['purchase_date']),
                'petty_cash_request_id'  => $request->id,
                'expense_category_id'    => $data['expense_category_id'] ?? null,
                'project_id'             => $request->project_id,
                'purchase_order_number'  => $data['purchase_order_number'] ?? null,
                'purchase_date'          => $data['purchase_date'],
                'description'            => $data['description'],
                'amount'                 => $amount,
                'status'                 => PettyCashPurchaseStatus::DRAFT,
                'current_approval_level' => 0,
                'created_by'             => $userId,
            ]);

            $this->handleAttachment($purchase, $data);

            $this->audit->log($purchase, 'PETTY_CASH_PURCHASE_CREATED', $userId, [], [
                'purchase_number' => $purchase->purchase_number,
                'amount'          => $amount,
                'request'         => $request->request_number,
                'po_number'       => $purchase->purchase_order_number,
            ]);

            return $purchase->fresh(['request', 'expenseCategory', 'project']);
        });
    }

    public function update(PettyCashPurchase $purchase, array $data, int $userId): PettyCashPurchase
    {
        if (! $purchase->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Pembelian dengan status {$purchase->status->label()} tidak bisa diedit.",
            ]);
        }

        if (isset($data['amount'])) {
            $newAmount = (float) $data['amount'];
            $request = $purchase->request;
            if ($newAmount > $request->remaining_amount + 0.001) {
                throw ValidationException::withMessages([
                    'amount' => sprintf(
                        'Nominal melebihi sisa permintaan (sisa: Rp %s).',
                        number_format($request->remaining_amount, 0, ',', '.')
                    ),
                ]);
            }
        }

        return DB::transaction(function () use ($purchase, $data, $userId) {
            $old = $purchase->only(['amount', 'description', 'purchase_date', 'purchase_order_number', 'expense_category_id']);

            $purchase->update([
                'purchase_date'         => $data['purchase_date'] ?? $purchase->purchase_date,
                'description'           => $data['description']   ?? $purchase->description,
                'amount'                => $data['amount']        ?? $purchase->amount,
                'purchase_order_number' => $data['purchase_order_number'] ?? $purchase->purchase_order_number,
                'expense_category_id'   => array_key_exists('expense_category_id', $data) ? $data['expense_category_id'] : $purchase->expense_category_id,
            ]);

            $this->handleAttachment($purchase, $data);

            $this->audit->log($purchase, 'PETTY_CASH_PURCHASE_UPDATED', $userId, $old, $purchase->only([
                'amount', 'description', 'purchase_date', 'purchase_order_number', 'expense_category_id',
            ]));

            return $purchase->fresh();
        });
    }

    public function submit(PettyCashPurchase $purchase, int $userId): PettyCashPurchase
    {
        if (! $purchase->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Pembelian dengan status {$purchase->status->label()} tidak bisa diajukan.",
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Petty Cash Purchase belum diatur.',
            ]);
        }

        return DB::transaction(function () use ($purchase, $userId, $levels) {
            $first = $levels->first();
            PettyCashPurchaseApproval::create([
                'petty_cash_purchase_id' => $purchase->id,
                'level'                  => $first->level_number,
                'approver_id'            => null,
                'status'                 => 'pending',
            ]);

            $purchase->update([
                'status' => PettyCashPurchaseStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);

            $this->audit->log($purchase, 'PETTY_CASH_PURCHASE_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $purchase->fresh(['approvals']);
        });
    }

    public function processApproval(
        PettyCashPurchase $purchase,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): PettyCashPurchase {
        if (! $purchase->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Pembelian dengan status {$purchase->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages(['decision' => 'Keputusan tidak valid.']);
        }

        return DB::transaction(function () use ($purchase, $approverId, $decision, $remarks) {
            $currentLevel = $purchase->current_approval_level;
            $pending = $purchase->approvals()
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
                $purchase->update([
                    'status' => PettyCashPurchaseStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($purchase, 'PETTY_CASH_PURCHASE_REJECTED', $approverId, [], [
                    'level' => $currentLevel, 'remarks' => $remarks,
                ]);
                return $purchase->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                PettyCashPurchaseApproval::create([
                    'petty_cash_purchase_id' => $purchase->id,
                    'level'                  => $nextLevel->level_number,
                    'approver_id'            => null,
                    'status'                 => 'pending',
                ]);
                $purchase->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($purchase, 'PETTY_CASH_PURCHASE_APPROVED_LEVEL', $approverId, [], [
                    'level' => $currentLevel, 'next_level' => $nextLevel->level_number,
                ]);
            } else {
                $this->requestService->consumeAmount($purchase->request, (float) $purchase->amount);

                $purchase->update([
                    'status' => PettyCashPurchaseStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($purchase, 'PETTY_CASH_PURCHASE_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                    'amount_consumed' => (float) $purchase->amount,
                ]);
            }

            return $purchase->fresh(['approvals', 'request']);
        });
    }

    protected function handleAttachment(PettyCashPurchase $purchase, array $data): void
    {
        if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
            $path = $this->uploadFile($data['attachment'], 'pcb');
            $purchase->update(['attachment_path' => $path]);
        }
    }

    protected function uploadFile(UploadedFile $file, string $prefix): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('petty-cash/purchases', $filename, 'private');
    }

    public function generateNumber(string $date): string
    {
        $year = Carbon::parse($date)->format('Y');
        $count = PettyCashPurchase::whereYear('created_at', $year)->count() + 1;
        do {
            $number = sprintf('PCB/%s/%03d', $year, $count);
            $count++;
        } while (PettyCashPurchase::where('purchase_number', $number)->exists());
        return $number;
    }
}
