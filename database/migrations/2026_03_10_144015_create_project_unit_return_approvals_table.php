<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_unit_return_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_return_id')->constrained('project_unit_returns')->cascadeOnDelete();
            $table->integer('level');
            $table->foreignId('approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['unit_return_id', 'level']);
            $table->index(['unit_return_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_unit_return_approvals');
    }
};
