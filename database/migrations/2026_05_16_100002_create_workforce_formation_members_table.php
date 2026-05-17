<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workforce_formation_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workforce_formation_id')->constrained()->onDelete('cascade');

            // Employee data fetched from external API (API_EMPLOYEE)
            $table->unsignedBigInteger('employee_id'); // external ID dari API_EMPLOYEE
            $table->string('employee_name');           // snapshot dari API
            $table->string('position_name');           // snapshot dari API

            $table->decimal('daily_rate', 15, 2)->default(0);
            $table->decimal('allowance', 15, 2)->default(0);

            // DAY, NIGHT, ROTATING
            $table->string('shift', 20)->default('DAY');

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('workforce_formation_id', 'wfm_formation_idx');
            $table->index('employee_id', 'wfm_employee_idx');
            $table->index(['workforce_formation_id', 'is_active'], 'wfm_formation_active_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workforce_formation_members');
    }
};
