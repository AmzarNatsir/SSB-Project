<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_replacement_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_replacement_id')->constrained()->onDelete('cascade');

            // Original unit being replaced (sourced from unit_request_items)
            $table->foreignId('original_unit_request_item_id')->constrained('unit_request_items')->onDelete('cascade');
            $table->string('original_unit_name'); // snapshot
            $table->string('original_equipment_code')->nullable(); // snapshot

            // Replacement unit (sourced from contract_items active project)
            $table->foreignId('replacement_contract_item_id')->nullable()->constrained('contract_items')->onDelete('set null');
            $table->string('replacement_unit_name');
            $table->string('replacement_equipment_code')->nullable();
            $table->decimal('replacement_qty', 15, 2)->default(1);
            $table->integer('replacement_duration_days')->nullable();

            // Reason per item & operator/availability info (filled by Workshop)
            $table->text('reason'); // alasan penggantian per item
            $table->boolean('unit_ready')->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->string('operator_name', 200)->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('unit_replacement_id');
            $table->index('original_unit_request_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_replacement_items');
    }
};
