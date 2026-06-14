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
        Schema::table('timesheet_journals', function (Blueprint $table) {
            // Add composite index on project_id, journal_date, and status
            // This optimizes queries that filter by project and date range in the project realization report
            $table->index(['project_id', 'journal_date', 'status'], 'idx_timesheet_journals_project_date_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timesheet_journals', function (Blueprint $table) {
            // Drop the composite index
            $table->dropIndex('idx_timesheet_journals_project_date_status');
        });
    }
};
