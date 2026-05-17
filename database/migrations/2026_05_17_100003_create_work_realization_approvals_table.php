<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_realization_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_realization_id')->constrained()->onDelete('cascade');
            $table->integer('level');
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['work_realization_id', 'level'], 'wra_realization_level_idx');
            $table->index(['work_realization_id', 'status'], 'wra_realization_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_realization_approvals');
    }
};
