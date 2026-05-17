<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentType;
use App\Enums\ReceivableSettlementStatus;
use App\Enums\ReceivableStatus;
use App\Models\Invoice;
use App\Models\Receivable;
use App\Models\ReceivableSettlement;
use App\Models\ReceivableSettlementApproval;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReceivableSettlementService
{
    public const FLOW_CODE = 'ReceivableSettlement';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
    ) {}

    public function create(array $data, int $userId): ReceivableSettlement
    {
        $invoice = Invoice::with('project')->findOrFail($data['invoice_id']);

        if (! in_array($invoice->status, [InvoiceStatus::APPROVED, InvoiceStatus::SUBMITTED])) {
            throw ValidationException::withMessages([
                'invoice_id' => 'Invoice harus berstatus Disetujui. Status saat ini: ' . $invoice->status->label(),
            ]);
        }

        if ($invoice->status === InvoiceStatus::PAID) {
            throw ValidationException::withMessages([
                'invoice_id' => 'Invoice sudah Lunas, tidak perlu di-settle lagi.',
            ]);
        }

        $deposit = null;
        $depositAmount = 0.0;
        if (! empty($data['deposit_receivable_id'])) {
            $deposit = Receivable::findOrFail($data['deposit_receivable_id']);
            $this->validateDeposit($deposit, $invoice);
            $depositAmount = (float) $deposit->amount;
        }

        $paymentAmount = (float) ($data['payment_amount'] ?? 0);
        $totalSettled  = round($depositAmount + $paymentAmount, 2);
        $invoiceTotal  = (float) $invoice->total_amount;
        $remaining     = round($invoiceTotal - $totalSettled, 2);

        if ($totalSettled <= 0) {
            throw ValidationException::withMessages([
                'payment_amount' => 'Total settlement (DP + Pembayaran Baru) harus lebih dari 0.',
            ]);
        }

        // Sum of approved settlements for this invoice so far (di-luar yg sedang dibuat)
        $alreadySettled = (float) ReceivableSettlement::where('invoice_id', $invoice->id)
            ->where('status', ReceivableSettlementStatus::APPROVED)
            ->sum('total_settled');

        if (round($alreadySettled + $totalSettled, 2) > round($invoiceTotal, 2)) {
            throw ValidationException::withMessages([
                'payment_amount' => sprintf(
                    'Total settlement (Rp %s) melebihi sisa tagihan Invoice (Rp %s).',
                    number_format($alreadySettled + $totalSettled, 0, ',', '.'),
                    number_format($invoiceTotal - $alreadySettled, 0, ',', '.')
                ),
            ]);
        }

        return DB::transaction(function () use ($data, $userId, $invoice, $deposit, $depositAmount, $paymentAmount, $totalSettled, $invoiceTotal, $remaining) {
            $paymentDate = Carbon::parse($data['payment_date']);

            $settlement = ReceivableSettlement::create([
                'settlement_number'     => $this->generateNumber($paymentDate),
                'project_id'            => $invoice->project_id,
                'invoice_id'            => $invoice->id,
                'deposit_receivable_id' => $deposit?->id,
                'customer_name'         => $invoice->customer_name ?? $invoice->project->user_name,
                'payment_date'          => $paymentDate->toDateString(),
                'payment_amount'        => $paymentAmount,
                'payment_type'          => $data['payment_type'],
                'payment_reference'     => $data['payment_reference'] ?? null,
                'deposit_amount'        => $depositAmount,
                'invoice_total'         => $invoiceTotal,
                'total_settled'         => $totalSettled,
                'remaining'             => $remaining,
                'description'           => $data['description'] ?? null,
                'status'                => ReceivableSettlementStatus::DRAFT,
                'current_approval_level' => 0,
                'created_by'            => $userId,
            ]);

            $this->handleAttachment($settlement, $data);

            $this->audit->log($settlement, 'SETTLEMENT_CREATED', $userId, [], [
                'settlement_number' => $settlement->settlement_number,
                'invoice_id'        => $invoice->id,
                'deposit_id'        => $deposit?->id,
                'total_settled'     => $totalSettled,
            ]);

            return $settlement->fresh(['invoice', 'depositReceivable', 'project']);
        });
    }

    public function update(ReceivableSettlement $settlement, array $data, int $userId): ReceivableSettlement
    {
        if (! $settlement->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Settlement dengan status {$settlement->status->label()} tidak bisa diedit.",
            ]);
        }

        return DB::transaction(function () use ($settlement, $data, $userId) {
            $old = $settlement->only([
                'payment_date', 'payment_amount', 'payment_type',
                'payment_reference', 'deposit_receivable_id', 'description',
            ]);

            // Rebuild deposit info kalau berubah
            $depositReceivableId = array_key_exists('deposit_receivable_id', $data)
                ? ($data['deposit_receivable_id'] ?: null)
                : $settlement->deposit_receivable_id;

            $depositAmount = 0.0;
            if ($depositReceivableId) {
                $deposit = Receivable::findOrFail($depositReceivableId);
                $this->validateDeposit($deposit, $settlement->invoice, $settlement->id);
                $depositAmount = (float) $deposit->amount;
            }

            $paymentAmount = isset($data['payment_amount'])
                ? (float) $data['payment_amount']
                : (float) $settlement->payment_amount;

            $totalSettled = round($depositAmount + $paymentAmount, 2);
            $invoiceTotal = (float) $settlement->invoice_total;
            $remaining    = round($invoiceTotal - $totalSettled, 2);

            // Cek ulang plafon
            $alreadySettled = (float) ReceivableSettlement::where('invoice_id', $settlement->invoice_id)
                ->where('id', '!=', $settlement->id)
                ->where('status', ReceivableSettlementStatus::APPROVED)
                ->sum('total_settled');

            if (round($alreadySettled + $totalSettled, 2) > round($invoiceTotal, 2)) {
                throw ValidationException::withMessages([
                    'payment_amount' => sprintf(
                        'Total settlement (Rp %s) melebihi sisa tagihan Invoice (Rp %s).',
                        number_format($alreadySettled + $totalSettled, 0, ',', '.'),
                        number_format($invoiceTotal - $alreadySettled, 0, ',', '.')
                    ),
                ]);
            }

            $settlement->update([
                'deposit_receivable_id' => $depositReceivableId,
                'payment_date'          => $data['payment_date']     ?? $settlement->payment_date,
                'payment_amount'        => $paymentAmount,
                'payment_type'          => $data['payment_type']     ?? $settlement->payment_type,
                'payment_reference'     => $data['payment_reference'] ?? $settlement->payment_reference,
                'deposit_amount'        => $depositAmount,
                'total_settled'         => $totalSettled,
                'remaining'             => $remaining,
                'description'           => $data['description']      ?? $settlement->description,
            ]);

            $this->handleAttachment($settlement, $data);

            $this->audit->log($settlement, 'SETTLEMENT_UPDATED', $userId, $old, $settlement->only([
                'payment_date', 'payment_amount', 'payment_type',
                'payment_reference', 'deposit_receivable_id', 'description',
            ]));

            return $settlement->fresh(['invoice', 'depositReceivable']);
        });
    }

    public function submit(ReceivableSettlement $settlement, int $userId): ReceivableSettlement
    {
        if (! $settlement->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Settlement dengan status {$settlement->status->label()} tidak bisa diajukan.",
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Receivable Settlement belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($settlement, $userId, $levels) {
            $first = $levels->first();
            ReceivableSettlementApproval::create([
                'receivable_settlement_id' => $settlement->id,
                'level'        => $first->level_number,
                'approver_id'  => null,
                'status'       => 'pending',
            ]);

            $settlement->update([
                'status' => ReceivableSettlementStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);

            $this->audit->log($settlement, 'SETTLEMENT_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $settlement->fresh(['approvals']);
        });
    }

    public function processApproval(
        ReceivableSettlement $settlement,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): ReceivableSettlement {
        if (! $settlement->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Settlement dengan status {$settlement->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages([
                'decision' => 'Keputusan harus berupa "approved" atau "rejected".',
            ]);
        }

        return DB::transaction(function () use ($settlement, $approverId, $decision, $remarks) {
            $currentLevel = $settlement->current_approval_level;

            $pending = $settlement->approvals()
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
                $settlement->update([
                    'status' => ReceivableSettlementStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($settlement, 'SETTLEMENT_REJECTED', $approverId, [], [
                    'level'   => $currentLevel,
                    'remarks' => $remarks,
                ]);
                return $settlement->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                ReceivableSettlementApproval::create([
                    'receivable_settlement_id' => $settlement->id,
                    'level'        => $nextLevel->level_number,
                    'approver_id'  => null,
                    'status'       => 'pending',
                ]);
                $settlement->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($settlement, 'SETTLEMENT_APPROVED_LEVEL', $approverId, [], [
                    'level'      => $currentLevel,
                    'next_level' => $nextLevel->level_number,
                ]);
            } else {
                // Final approval: update status, link deposit, dan auto-mark invoice PAID kalau lunas
                $settlement->update([
                    'status' => ReceivableSettlementStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);

                $this->applySideEffects($settlement, $approverId);

                $this->audit->log($settlement, 'SETTLEMENT_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                ]);
            }

            return $settlement->fresh(['approvals', 'invoice', 'depositReceivable']);
        });
    }

    /**
     * Saat settlement APPROVED:
     *  - Deposit Receivable di-link ke Invoice (invoice_id di-set).
     *  - Kalau total settled approved >= invoice.total_amount → Invoice di-mark PAID.
     */
    protected function applySideEffects(ReceivableSettlement $settlement, int $userId): void
    {
        if ($settlement->deposit_receivable_id) {
            $deposit = Receivable::find($settlement->deposit_receivable_id);
            if ($deposit && empty($deposit->invoice_id)) {
                $deposit->update(['invoice_id' => $settlement->invoice_id]);
                $this->audit->log($deposit, 'RECEIVABLE_LINKED_TO_INVOICE', $userId, [], [
                    'invoice_id'    => $settlement->invoice_id,
                    'settlement_id' => $settlement->id,
                ]);
            }
        }

        $invoice = Invoice::find($settlement->invoice_id);
        if (! $invoice) return;

        $totalApprovedSettled = (float) ReceivableSettlement::where('invoice_id', $invoice->id)
            ->where('status', ReceivableSettlementStatus::APPROVED)
            ->sum('total_settled');

        if ($totalApprovedSettled + 0.005 >= (float) $invoice->total_amount && $invoice->status !== InvoiceStatus::PAID) {
            $invoice->update([
                'status'        => InvoiceStatus::PAID,
                'paid_date'     => now()->toDateString(),
                'payment_notes' => 'Auto-PAID via Settlement ' . $settlement->settlement_number,
            ]);
            $this->audit->log($invoice, 'INVOICE_AUTO_PAID', $userId, [], [
                'via_settlement' => $settlement->settlement_number,
                'total_settled'  => $totalApprovedSettled,
            ]);
        }
    }

    /**
     * Validasi sebuah Receivable boleh dipakai sebagai DP.
     */
    protected function validateDeposit(Receivable $deposit, Invoice $invoice, ?int $excludeSettlementId = null): void
    {
        if ($deposit->project_id !== $invoice->project_id) {
            throw ValidationException::withMessages([
                'deposit_receivable_id' => 'Uang Muka harus berasal dari proyek yang sama dengan Invoice.',
            ]);
        }

        if ($deposit->status !== ReceivableStatus::APPROVED) {
            throw ValidationException::withMessages([
                'deposit_receivable_id' => 'Uang Muka harus berstatus Disetujui. Status saat ini: ' . $deposit->status->label(),
            ]);
        }

        if (! empty($deposit->invoice_id) && $deposit->invoice_id !== $invoice->id) {
            throw ValidationException::withMessages([
                'deposit_receivable_id' => 'Uang Muka ini sudah terhubung ke invoice lain.',
            ]);
        }

        $usedQuery = ReceivableSettlement::where('deposit_receivable_id', $deposit->id)
            ->whereNotIn('status', [ReceivableSettlementStatus::REJECTED]);
        if ($excludeSettlementId) {
            $usedQuery->where('id', '!=', $excludeSettlementId);
        }
        if ($usedQuery->exists()) {
            throw ValidationException::withMessages([
                'deposit_receivable_id' => 'Uang Muka ini sudah digunakan di Settlement lain.',
            ]);
        }
    }

    protected function handleAttachment(ReceivableSettlement $settlement, array $data): void
    {
        if (isset($data['attachment']) && $data['attachment'] instanceof UploadedFile) {
            $path = $this->uploadFile($data['attachment'], 'bukti_settlement');
            $settlement->update(['attachment_path' => $path]);
        }
    }

    protected function uploadFile(UploadedFile $file, string $prefix): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('receivable-settlements/attachments', $filename, 'private');
    }

    public function generateNumber(Carbon $date): string
    {
        $year = $date->format('Y');
        $count = ReceivableSettlement::whereYear('payment_date', $year)->count() + 1;

        do {
            $number = sprintf('RST/%s/%03d', $year, $count);
            $count++;
        } while (ReceivableSettlement::where('settlement_number', $number)->exists());

        return $number;
    }
}
