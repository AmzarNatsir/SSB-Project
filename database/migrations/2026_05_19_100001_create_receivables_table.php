<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();

            // Format: RCV/2026/001
            $table->string('receivable_number', 50)->unique();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            // Optional link ke Invoice (kalau penerimaan ini settle invoice tertentu).
            // Null untuk Down Payment / Uang Muka yang belum ber-invoice.
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('set null');

            // Snapshot customer dari project
            $table->string('customer_name')->nullable();

            $table->date('received_date');                  // Tanggal Penerimaan Dana
            $table->decimal('amount', 18, 2)->default(0);   // Nominal

            // Jenis Pembayaran: TUNAI / TRANSFER
            $table->string('payment_type', 20);

            // Opsional: no. kwitansi / no. referensi transfer
            $table->string('payment_reference', 100)->nullable();

            $table->text('description')->nullable();        // Keterangan

            // Bukti Uang Muka (Kwitansi / Slip Transfer)
            $table->string('attachment_path')->nullable();

            // Status: DRAFT, SUBMITTED, APPROVED, REJECTED
            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'status'], 'rcv_project_status_idx');
            $table->index(['received_date'], 'rcv_received_date_idx');
            $table->index(['invoice_id'], 'rcv_invoice_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivables');
    }
};
