<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('project_unit_return_items');
        Schema::create('project_unit_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_return_id')->constrained('project_unit_returns')->cascadeOnDelete();
            $table->string('project_unit_id')->nullable();
            $table->string('equipment_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_unit_return_items');
    }
};

