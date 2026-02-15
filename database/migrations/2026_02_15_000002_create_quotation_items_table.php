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
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            
            // Item details (from API or manual)
            $table->string('unit_name');
            $table->unsignedBigInteger('unit_id')->nullable(); // Reference ID from external system/API
            
            // Pricing factors
            $table->decimal('rate', 15, 2)->default(0);
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('duration', 10, 2)->default(1);
            $table->string('duration_unit')->default('MONTH'); // DAY, MONTH, TRIP
            
            // Calculation results
            $table->decimal('total_price', 15, 2)->default(0); // rate * quantity * duration
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
