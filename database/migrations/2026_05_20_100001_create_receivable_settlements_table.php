<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivable_settlements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();

            // Format: RST/2026/001
            $table->string('settlement_number', 50)->unique();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            // Invoice yang di-lunasi
            $table->foreignId('invoice_id')->constrained()->onDelete('restrict');

            // Uang Muka (Deposit) yang dialokasikan — Receivable dengan invoice_id NULL
            // Optional: kalau tidak pakai DP, isi NULL.
            $table->foreignId('deposit_receivable_id')->nullable()
                ->constrained('receivables')->onDelete('restrict');

            // Snapshot customer
            $table->string('customer_name')->nullable();

            // Penerimaan dana baru (selain DP)
            $table->date('payment_date');
            $table->decimal('payment_amount', 18, 2)->default(0);
            $table->string('payment_type', 20);
            $table->string('payment_reference', 100)->nullable();

            // Snapshot nominal DP & invoice total saat create (anti-rot)
            $table->decimal('deposit_amount', 18, 2)->default(0);
            $table->decimal('invoice_total', 18, 2)->default(0);
            $table->decimal('total_settled', 18, 2)->default(0);    // deposit + payment
            $table->decimal('remaining', 18, 2)->default(0);        // invoice_total - total_settled

            $table->text('description')->nullable();
            $table->string('attachment_path')->nullable();

            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['invoice_id', 'status'], 'rs_invoice_status_idx');
            $table->index(['deposit_receivable_id'], 'rs_deposit_idx');
            $table->index(['payment_date'], 'rs_payment_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivable_settlements');
    }
};
