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
        Schema::create('approval_flow_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_flow_id')->constrained()->onDelete('cascade');
            $table->integer('level_number'); // 1, 2, 3...
            $table->string('approver_type'); // USER, ROLE, DEPARTMENT
            $table->unsignedBigInteger('approver_user_id')->nullable();
            $table->unsignedBigInteger('approver_role_id')->nullable();
            $table->unsignedBigInteger('approver_department_id')->nullable();
            $table->boolean('is_mandatory')->default(true);
            $table->integer('sla_hours')->nullable();
            $table->timestamps();

            // Ensure unique level per flow
            $table->unique(['approval_flow_id', 'level_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_flow_levels');
    }
};
