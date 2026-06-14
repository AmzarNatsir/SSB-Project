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
        Schema::table('timesheet_entries', function (Blueprint $table) {
            // Add composite index on timesheet_journal_id and activity_code
            // This optimizes queries that filter or join on these columns
            $table->index(['timesheet_journal_id', 'activity_code'], 'idx_timesheet_entries_journal_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timesheet_entries', function (Blueprint $table) {
            // Drop the composite index
            $table->dropIndex('idx_timesheet_entries_journal_activity');
        });
    }
};
