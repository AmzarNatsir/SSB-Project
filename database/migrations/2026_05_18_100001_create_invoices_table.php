<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();

            // Format: 001/SSB/V/2026 (nomor_urut / SSB / bulan_romawi / tahun)
            $table->string('invoice_number', 50)->unique();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->nullable()->constrained()->onDelete('set null');

            // Sumber tagihan: 1 Work Realization = 1 Invoice (cegah double-billing)
            $table->foreignId('work_realization_id')->unique()->constrained()->onDelete('restrict');

            // Snapshot customer dari project (anti-rot kalau project di-update)
            $table->string('customer_name')->nullable();
            $table->string('customer_code', 50)->nullable();
            $table->text('customer_address')->nullable();
            $table->string('customer_taxpayer_id', 50)->nullable(); // NPWP

            $table->date('invoice_date');
            $table->date('due_date')->nullable();

            // Periode realisasi (snapshot dari work_realizations)
            $table->date('period_start');
            $table->date('period_end');

            // Nilai-nilai
            $table->decimal('subtotal', 18, 2)->default(0);             // dari work_realization.total_realized_amount
            $table->decimal('ppn_rate', 5, 2)->default(11.00);          // default 11%
            $table->decimal('ppn_amount', 18, 2)->default(0);
            $table->decimal('pph_rate', 5, 2)->default(2.00);           // default 2%
            $table->decimal('pph_amount', 18, 2)->default(0);
            $table->decimal('total_amount', 18, 2)->default(0);         // subtotal + ppn - pph

            // Lampiran Faktur Pajak
            $table->string('faktur_pajak_number', 100)->nullable();
            $table->string('faktur_pajak_path')->nullable();

            $table->text('notes')->nullable();

            // Status: DRAFT, SUBMITTED, APPROVED, REJECTED, PAID
            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->date('paid_date')->nullable();
            $table->text('payment_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'status'], 'inv_project_status_idx');
            $table->index(['invoice_date'], 'inv_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
