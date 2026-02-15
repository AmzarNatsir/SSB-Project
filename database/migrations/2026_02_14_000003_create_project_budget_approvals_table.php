<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_budget_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_budget_id');
            $table->integer('level'); // 1, 2, 3
            $table->unsignedBigInteger('approver_id');
            $table->string('decision'); // APPROVED, REJECTED, REVISION
            $table->text('notes')->nullable();
            $table->timestamp('decided_at')->useCurrent();
            $table->timestamps();

            $table->foreign('project_budget_id')->references('id')->on('project_budgets')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_budget_approvals');
    }
};
