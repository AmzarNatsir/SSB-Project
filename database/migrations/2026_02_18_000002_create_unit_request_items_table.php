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
        Schema::create('unit_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('quotation_item_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('equipment_id')->nullable(); // FK to equipments table (when available)

            $table->string('unit_name');
            $table->integer('qty');
            $table->integer('duration_days')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('unit_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_request_items');
    }
};
