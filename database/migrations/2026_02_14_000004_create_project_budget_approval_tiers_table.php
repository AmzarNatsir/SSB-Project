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
        Schema::create('project_budget_approval_tiers', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->unique(); // 1, 2, 3
            $table->string('role_name'); // e.g., 'Project Manager', 'Ops Manager'
            $table->decimal('min_amount', 15, 2)->default(0); // Optional threshold
            $table->decimal('max_amount', 15, 2)->nullable(); // Optional threshold
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_budget_approval_tiers');
    }
};
