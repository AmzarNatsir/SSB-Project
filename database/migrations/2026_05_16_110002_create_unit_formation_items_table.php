<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_formation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_formation_id')->constrained()->onDelete('cascade');

            // Link ke baseline kontrak (contract_items)
            $table->foreignId('contract_item_id')->nullable()->constrained()->onDelete('set null');

            // External IDs — equipment dari API_WORKSHOP, operator dari API_EMPLOYEE
            $table->unsignedBigInteger('equipment_unit_id');         // external ID dari API_WORKSHOP
            $table->unsignedBigInteger('assigned_operator_id')->nullable(); // external ID dari API_EMPLOYEE

            $table->string('unit_name');             // snapshot dari API
            $table->string('equipment_code')->nullable();
            $table->string('operator_name')->nullable(); // snapshot dari API

            $table->decimal('hm_start', 12, 2)->default(0);
            $table->decimal('hm_target_monthly', 12, 2)->nullable();

            // READY, ACTIVE, DOWN, RETURNED, REPLACED
            $table->string('status', 20)->default('READY')->index();

            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('unit_formation_id');
            $table->index('equipment_unit_id');
            $table->index(['unit_formation_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_formation_items');
    }
};
