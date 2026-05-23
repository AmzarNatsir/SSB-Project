<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petty_cash_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();

            // Format: PCR/2026/001
            $table->string('request_number', 50)->unique();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->nullable()->constrained()->onDelete('set null');

            $table->date('request_date');
            $table->text('description');
            $table->decimal('requested_amount', 18, 2)->default(0);

            // Akumulasi pemakaian: bertambah saat Payment/Purchase APPROVED, validasi tidak melebihi requested
            $table->decimal('used_amount', 18, 2)->default(0);

            $table->string('attachment_path')->nullable();

            // DRAFT, SUBMITTED, APPROVED, REJECTED, CLOSED
            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'status'], 'pcr_project_status_idx');
            $table->index('request_date', 'pcr_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petty_cash_requests');
    }
};
