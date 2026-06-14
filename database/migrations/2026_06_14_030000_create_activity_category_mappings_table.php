<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration creates the activity_category_mappings table that maps
     * activity codes from timesheet entries to budget categories from project budgets.
     * This enables automatic categorization of timesheet activities for budget realization analysis.
     */
    public function up(): void
    {
        Schema::create('activity_category_mappings', function (Blueprint $table) {
            $table->id();

            // Activity code from timesheet entries
            // Valid values: HAULING, LOADING, IDLE, MAINTENANCE, STANDBY, BREAKDOWN
            $table->string('activity_code', 30)->unique();

            // Budget category from project_budget_items
            // Valid enum values: LABOR, EQUIPMENT, MAINTENANCE, OPERATIONAL, MOBILIZATION, OTHER
            $table->string('budget_category', 30);

            // Description explaining the mapping rationale
            $table->text('description')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index('activity_code', 'idx_activity_category_activity');
            $table->index('budget_category', 'idx_activity_category_budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_category_mappings');
    }
};
