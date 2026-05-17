<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivable_settlement_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receivable_settlement_id')->constrained()->onDelete('cascade');
            $table->integer('level');
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['receivable_settlement_id', 'level'], 'rsa_settlement_level_idx');
            $table->index(['receivable_settlement_id', 'status'], 'rsa_settlement_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivable_settlement_approvals');
    }
};
