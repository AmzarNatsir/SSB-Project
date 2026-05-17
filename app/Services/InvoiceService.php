<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\WorkRealizationStatus;
use App\Models\Invoice;
use App\Models\InvoiceApproval;
use App\Models\WorkRealization;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvoiceService
{
    public const FLOW_CODE = 'Invoice';

    public function __construct(
        protected AuditService $audit,
        protected ApprovalFlowService $flow,
    ) {}

    /**
     * Buat Invoice baru dari Work Realization yang sudah APPROVED.
     * Subtotal otomatis di-pull dari WR.total_realized_amount, PPN/PPH dihitung.
     */
    public function create(array $data, int $userId): Invoice
    {
        $wr = WorkRealization::with('project', 'contract')->findOrFail($data['work_realization_id']);

        if ($wr->status !== WorkRealizationStatus::APPROVED) {
            throw ValidationException::withMessages([
                'work_realization_id' => 'Hanya Work Realization dengan status Disetujui yang bisa di-invoice.',
            ]);
        }

        if (Invoice::where('work_realization_id', $wr->id)->exists()) {
            throw ValidationException::withMessages([
                'work_realization_id' => 'Work Realization ini sudah memiliki Invoice (tidak boleh double-billing).',
            ]);
        }

        return DB::transaction(function () use ($data, $userId, $wr) {
            $invoiceDate = Carbon::parse($data['invoice_date']);
            $project = $wr->project;

            $subtotal  = (float) $wr->total_realized_amount;
            $ppnRate   = (float) ($data['ppn_rate'] ?? 11.00);
            $pphRate   = (float) ($data['pph_rate'] ?? 2.00);
            $ppnAmount = round($subtotal * $ppnRate / 100, 2);
            $pphAmount = round($subtotal * $pphRate / 100, 2);
            $total     = round($subtotal + $ppnAmount - $pphAmount, 2);

            $invoice = Invoice::create([
                'invoice_number'        => $this->generateNumber($invoiceDate),
                'project_id'            => $wr->project_id,
                'contract_id'           => $wr->contract_id,
                'work_realization_id'   => $wr->id,
                'customer_name'         => $project->user_name,
                'customer_code'         => $project->user_code,
                'customer_address'      => $project->user_address,
                'customer_taxpayer_id'  => $project->taxpayer_id,
                'invoice_date'          => $invoiceDate->toDateString(),
                'due_date'              => $data['due_date'] ?? $invoiceDate->copy()->addDays(30)->toDateString(),
                'period_start'          => $wr->period_start,
                'period_end'            => $wr->period_end,
                'subtotal'              => $subtotal,
                'ppn_rate'              => $ppnRate,
                'ppn_amount'            => $ppnAmount,
                'pph_rate'              => $pphRate,
                'pph_amount'            => $pphAmount,
                'total_amount'          => $total,
                'faktur_pajak_number'   => $data['faktur_pajak_number'] ?? null,
                'notes'                 => $data['notes'] ?? null,
                'status'                => InvoiceStatus::DRAFT,
                'current_approval_level' => 0,
                'created_by'            => $userId,
            ]);

            $this->handleAttachments($invoice, $data);

            $this->audit->log($invoice, 'INVOICE_CREATED', $userId, [], [
                'invoice_number'      => $invoice->invoice_number,
                'work_realization_id' => $wr->id,
                'total_amount'        => $total,
            ]);

            return $invoice->fresh(['project', 'workRealization']);
        });
    }

    public function update(Invoice $invoice, array $data, int $userId): Invoice
    {
        if (! $invoice->canEdit()) {
            throw ValidationException::withMessages([
                'status' => "Invoice dengan status {$invoice->status->label()} tidak bisa diedit.",
            ]);
        }

        return DB::transaction(function () use ($invoice, $data, $userId) {
            $old = $invoice->only([
                'invoice_date', 'due_date', 'ppn_rate', 'pph_rate',
                'faktur_pajak_number', 'notes',
            ]);

            $ppnRate = isset($data['ppn_rate']) ? (float) $data['ppn_rate'] : (float) $invoice->ppn_rate;
            $pphRate = isset($data['pph_rate']) ? (float) $data['pph_rate'] : (float) $invoice->pph_rate;
            $subtotal = (float) $invoice->subtotal;
            $ppnAmount = round($subtotal * $ppnRate / 100, 2);
            $pphAmount = round($subtotal * $pphRate / 100, 2);
            $total = round($subtotal + $ppnAmount - $pphAmount, 2);

            $invoice->update([
                'invoice_date'        => $data['invoice_date'] ?? $invoice->invoice_date,
                'due_date'            => $data['due_date']     ?? $invoice->due_date,
                'ppn_rate'            => $ppnRate,
                'ppn_amount'          => $ppnAmount,
                'pph_rate'            => $pphRate,
                'pph_amount'          => $pphAmount,
                'total_amount'        => $total,
                'faktur_pajak_number' => $data['faktur_pajak_number'] ?? $invoice->faktur_pajak_number,
                'notes'               => $data['notes'] ?? $invoice->notes,
            ]);

            $this->handleAttachments($invoice, $data);

            $this->audit->log($invoice, 'INVOICE_UPDATED', $userId, $old, $invoice->only([
                'invoice_date', 'due_date', 'ppn_rate', 'pph_rate',
                'faktur_pajak_number', 'notes',
            ]));

            return $invoice->fresh();
        });
    }

    public function submit(Invoice $invoice, int $userId): Invoice
    {
        if (! $invoice->canSubmit()) {
            throw ValidationException::withMessages([
                'status' => "Invoice dengan status {$invoice->status->label()} tidak bisa diajukan.",
            ]);
        }

        $levels = $this->flow->getLevels(self::FLOW_CODE);
        if ($levels->isEmpty()) {
            throw ValidationException::withMessages([
                'approval' => 'Matriks approval untuk Invoice belum diatur. Hubungi admin untuk konfigurasi di menu Approval Matrix.',
            ]);
        }

        return DB::transaction(function () use ($invoice, $userId, $levels) {
            $first = $levels->first();
            InvoiceApproval::create([
                'invoice_id'  => $invoice->id,
                'level'       => $first->level_number,
                'approver_id' => null,
                'status'      => 'pending',
            ]);

            $invoice->update([
                'status' => InvoiceStatus::SUBMITTED,
                'current_approval_level' => $first->level_number,
            ]);

            $this->audit->log($invoice, 'INVOICE_SUBMITTED', $userId, [], [
                'level' => $first->level_number,
            ]);

            return $invoice->fresh(['approvals']);
        });
    }

    public function processApproval(
        Invoice $invoice,
        int $approverId,
        string $decision,
        ?string $remarks = null
    ): Invoice {
        if (! $invoice->canApprove()) {
            throw ValidationException::withMessages([
                'status' => "Invoice dengan status {$invoice->status->label()} tidak bisa di-approve/reject.",
            ]);
        }

        $decision = strtolower($decision);
        if (! in_array($decision, ['approved', 'rejected'])) {
            throw ValidationException::withMessages([
                'decision' => 'Keputusan harus berupa "approved" atau "rejected".',
            ]);
        }

        return DB::transaction(function () use ($invoice, $approverId, $decision, $remarks) {
            $currentLevel = $invoice->current_approval_level;

            $pending = $invoice->approvals()
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
                $invoice->update([
                    'status' => InvoiceStatus::REJECTED,
                    'current_approval_level' => 0,
                ]);
                $this->audit->log($invoice, 'INVOICE_REJECTED', $approverId, [], [
                    'level'   => $currentLevel,
                    'remarks' => $remarks,
                ]);
                return $invoice->fresh();
            }

            $levels = $this->flow->getLevels(self::FLOW_CODE);
            $nextLevel = $levels->firstWhere('level_number', $currentLevel + 1);

            if ($nextLevel) {
                InvoiceApproval::create([
                    'invoice_id'  => $invoice->id,
                    'level'       => $nextLevel->level_number,
                    'approver_id' => null,
                    'status'      => 'pending',
                ]);
                $invoice->update(['current_approval_level' => $nextLevel->level_number]);
                $this->audit->log($invoice, 'INVOICE_APPROVED_LEVEL', $approverId, [], [
                    'level'      => $currentLevel,
                    'next_level' => $nextLevel->level_number,
                ]);
            } else {
                $invoice->update([
                    'status' => InvoiceStatus::APPROVED,
                    'current_approval_level' => 0,
                    'approved_by' => $approverId,
                    'approved_at' => now(),
                ]);
                $this->audit->log($invoice, 'INVOICE_APPROVED', $approverId, [], [
                    'final_level' => $currentLevel,
                ]);
            }

            return $invoice->fresh(['approvals']);
        });
    }

    public function markPaid(Invoice $invoice, array $data, int $userId): Invoice
    {
        if (! $invoice->canMarkPaid()) {
            throw ValidationException::withMessages([
                'status' => 'Hanya Invoice yang sudah Disetujui yang bisa ditandai Lunas.',
            ]);
        }

        return DB::transaction(function () use ($invoice, $data, $userId) {
            $invoice->update([
                'status'        => InvoiceStatus::PAID,
                'paid_date'     => $data['paid_date'] ?? now()->toDateString(),
                'payment_notes' => $data['payment_notes'] ?? null,
            ]);

            $this->audit->log($invoice, 'INVOICE_PAID', $userId, [], [
                'paid_date' => $invoice->paid_date->toDateString(),
            ]);

            return $invoice->fresh();
        });
    }

    protected function handleAttachments(Invoice $invoice, array $data): void
    {
        if (isset($data['faktur_pajak_attachment']) && $data['faktur_pajak_attachment'] instanceof UploadedFile) {
            $path = $this->uploadFile($data['faktur_pajak_attachment'], 'faktur_pajak');
            $invoice->update(['faktur_pajak_path' => $path]);
        }
    }

    protected function uploadFile(UploadedFile $file, string $prefix): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::slug(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        ) . '.' . $file->getClientOriginalExtension();

        return $file->storeAs('invoices/attachments', $filename, 'private');
    }

    /**
     * Format: nomor_urut/SSB/bulan_romawi/tahun  (e.g. 001/SSB/V/2026)
     * Nomor urut per-bulan, di-reset setiap bulan.
     */
    public function generateNumber(Carbon $invoiceDate): string
    {
        $year  = $invoiceDate->format('Y');
        $month = (int) $invoiceDate->format('m');
        $roman = $this->toRoman($month);

        $count = Invoice::whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->count() + 1;

        do {
            $number = sprintf('%03d/SSB/%s/%s', $count, $roman, $year);
            $count++;
        } while (Invoice::where('invoice_number', $number)->exists());

        return $number;
    }

    protected function toRoman(int $month): string
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        return $map[$month] ?? '';
    }
}
