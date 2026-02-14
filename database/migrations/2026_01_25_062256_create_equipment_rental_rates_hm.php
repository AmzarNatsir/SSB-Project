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
        Schema::create('equipment_rental_rates_hm', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();    
            $table->string('jenis_alat');
            $table->double('tarif_hm')->default(0);
            $table->double('harga_pasar')->default(0);
            $table->double('harga_fuel')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_rental_rates_hm');
    }
};
