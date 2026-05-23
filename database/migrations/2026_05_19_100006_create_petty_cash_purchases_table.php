<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petty_cash_purchases', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();

            // Format: PCB/2026/001
            $table->string('purchase_number', 50)->unique();

            $table->foreignId('petty_cash_request_id')->constrained()->onDelete('restrict');

            // Optional "Jenis Biaya tambahan jika ada"
            $table->foreignId('expense_category_id')
                ->nullable()
                ->constrained('petty_cash_expense_categories')
                ->onDelete('set null');

            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            // Stub: nomor PO sebagai text, akan jadi FK saat modul Warehouse/PO dibuat
            $table->string('purchase_order_number', 100)->nullable();

            $table->date('purchase_date');
            $table->text('description');
            $table->decimal('amount', 18, 2);

            $table->string('attachment_path')->nullable();

            // DRAFT, SUBMITTED, APPROVED, REJECTED
            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['petty_cash_request_id', 'status'], 'pcb_request_status_idx');
            $table->index(['project_id', 'status'], 'pcb_project_status_idx');
            $table->index('purchase_date', 'pcb_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petty_cash_purchases');
    }
};
