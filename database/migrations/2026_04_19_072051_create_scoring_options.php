<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scoring_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')
                ->constrained('scoring_criteria')
                ->cascadeOnDelete();

            $table->string('label'); // Kurang, Cukup, Bagus
            $table->integer('score'); // 1, 2, 3
            $table->text('description')->nullable(); // Penjelasan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scoring_options');
    }
};
