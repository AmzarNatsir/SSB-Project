<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workforce_formation_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workforce_formation_id')->constrained()->onDelete('cascade');
            $table->integer('level');
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['workforce_formation_id', 'level'], 'wfa_formation_level_idx');
            $table->index(['workforce_formation_id', 'status'], 'wfa_formation_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workforce_formation_approvals');
    }
};
