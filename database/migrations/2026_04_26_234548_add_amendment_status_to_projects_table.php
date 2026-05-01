<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Using raw SQL because Laravel's change() doesn't support ENUM reliably without doctrine/dbal
            // and even then it's better to be explicit with MySQL ENUM
            DB::statement("ALTER TABLE projects MODIFY COLUMN project_status ENUM('NOT STARTED', 'ON PROGRESS', 'COMPLETED', 'ON HOLD', 'CANCELLED', 'AMENDMENT') DEFAULT 'NOT STARTED'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            DB::statement("ALTER TABLE projects MODIFY COLUMN project_status ENUM('NOT STARTED', 'ON PROGRESS', 'COMPLETED', 'ON HOLD', 'CANCELLED') DEFAULT 'NOT STARTED'");
        });
    }
};
