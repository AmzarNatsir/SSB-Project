<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petty_cash_payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();

            // Format: PCP/2026/001
            $table->string('payment_number', 50)->unique();

            // Wajib link ke Request yang APPROVED, saldo Request dipotong saat Payment APPROVED
            $table->foreignId('petty_cash_request_id')->constrained()->onDelete('restrict');
            $table->foreignId('expense_category_id')
                ->constrained('petty_cash_expense_categories')
                ->onDelete('restrict');

            // Snapshot dari Request (anti-rot)
            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            $table->date('payment_date');
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

            $table->index(['petty_cash_request_id', 'status'], 'pcp_request_status_idx');
            $table->index(['project_id', 'status'], 'pcp_project_status_idx');
            $table->index('payment_date', 'pcp_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petty_cash_payments');
    }
};
