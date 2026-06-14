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
        Schema::table('project_budget_items', function (Blueprint $table) {
            // Add composite index on project_budget_id and category
            // This optimizes queries that filter budget items by category for a specific budget
            $table->index(['project_budget_id', 'category'], 'idx_project_budget_items_budget_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_budget_items', function (Blueprint $table) {
            // Drop the composite index
            $table->dropIndex('idx_project_budget_items_budget_category');
        });
    }
};
