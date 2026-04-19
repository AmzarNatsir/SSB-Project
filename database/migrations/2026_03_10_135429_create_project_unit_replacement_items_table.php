<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('project_unit_replacement_items');
        Schema::create('project_unit_replacement_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_replacement_id')->constrained('project_unit_replacements')->cascadeOnDelete();
            $table->string('old_unit_id')->nullable();
            $table->string('old_unit_name')->nullable();
            $table->string('replacement_unit_id')->nullable();
            $table->string('replacement_unit_name')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_unit_replacement_items');
    }
};

