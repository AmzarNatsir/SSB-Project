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
        Schema::create('project_budgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->index();
            $table->integer('version')->default(1);
            $table->string('status')->default('DRAFT')->index(); // Enum: ProjectStatus
            
            // Cost components
            $table->decimal('total_labor_cost', 15, 2)->default(0);
            $table->decimal('total_equipment_cost', 15, 2)->default(0);
            $table->decimal('total_maintenance_cost', 15, 2)->default(0);
            $table->decimal('total_operational_cost', 15, 2)->default(0);
            $table->decimal('total_mobilization_cost', 15, 2)->default(0);
            $table->decimal('total_other_cost', 15, 2)->default(0);
            
            $table->decimal('total_hpp', 15, 2)->default(0); // COGS
            $table->decimal('profit_margin_percent', 5, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            
            $table->timestamp('baseline_locked_at')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            // Assuming users table exists
             $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_budgets');
    }
};
