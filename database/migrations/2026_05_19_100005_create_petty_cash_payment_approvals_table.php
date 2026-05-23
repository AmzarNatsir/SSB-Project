<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petty_cash_payment_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petty_cash_payment_id')->constrained()->onDelete('cascade');
            $table->integer('level');
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['petty_cash_payment_id', 'level'], 'pcpa_payment_level_idx');
            $table->index(['petty_cash_payment_id', 'status'], 'pcpa_payment_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petty_cash_payment_approvals');
    }
};
