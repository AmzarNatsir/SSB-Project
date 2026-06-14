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
        Schema::table('project_budgets', function (Blueprint $table) {
            // Add composite index on project_id and status
            // This optimizes queries that filter for BASELINE_APPROVED budgets by project
            $table->index(['project_id', 'status'], 'idx_project_budgets_project_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_budgets', function (Blueprint $table) {
            // Drop the composite index
            $table->dropIndex('idx_project_budgets_project_status');
        });
    }
};
