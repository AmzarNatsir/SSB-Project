<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheet_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_journal_id')->constrained()->onDelete('cascade');

            // Link ke Unit Formation Item (alat + operator yang sedang aktif)
            $table->foreignId('unit_formation_item_id')->nullable()->constrained()->onDelete('set null');

            // External IDs — equipment dari API_WORKSHOP, operator dari API_EMPLOYEE
            $table->unsignedBigInteger('equipment_unit_id')->nullable();    // external ID dari API_WORKSHOP
            $table->unsignedBigInteger('operator_employee_id')->nullable(); // external ID dari API_EMPLOYEE

            $table->string('unit_name');                  // snapshot dari API
            $table->string('operator_name')->nullable();  // snapshot dari API

            // HAULING, LOADING, IDLE, MAINTENANCE, STANDBY, BREAKDOWN
            $table->string('activity_code', 30)->index();

            $table->decimal('hm_start', 12, 2)->default(0);
            $table->decimal('hm_end', 12, 2)->default(0);
            $table->decimal('hm_total', 12, 2)->storedAs('hm_end - hm_start'); // computed

            $table->decimal('working_hours', 8, 2)->default(0);
            $table->decimal('idle_hours', 8, 2)->default(0);
            $table->decimal('breakdown_hours', 8, 2)->default(0);

            $table->decimal('fuel_consumed_liter', 12, 2)->default(0);
            $table->integer('trip_count')->default(0);
            $table->decimal('tonnage', 12, 2)->default(0);

            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('timesheet_journal_id');
            $table->index('unit_formation_item_id');
            $table->index('operator_employee_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheet_entries');
    }
};
