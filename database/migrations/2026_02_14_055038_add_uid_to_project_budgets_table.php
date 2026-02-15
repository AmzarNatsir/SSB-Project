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
            $table->uuid('uid')->after('id')->index()->nullable(); // Temporarily nullable to fill data
        });

        // Fill existing rows with UUIDs
        $rows = DB::table('project_budgets')->whereNull('uid')->get();
        foreach ($rows as $row) {
            DB::table('project_budgets')
                ->where('id', $row->id)
                ->update(['uid' => (string) str()->uuid()]);
        }

        // Make it non-nullable and unique
        Schema::table('project_budgets', function (Blueprint $table) {
            $table->uuid('uid')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_budgets', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
    }
};
