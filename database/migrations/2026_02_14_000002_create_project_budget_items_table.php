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
        Schema::create('project_budget_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_budget_id');
            $table->string('category'); // LABOR, EQUIPMENT, etc.
            $table->string('item_name');
            $table->decimal('qty', 10, 2);
            $table->string('units')->nullable(); // hours, days, pcs, etc.
            $table->decimal('unit_cost', 15, 2);
            $table->decimal('total_cost', 15, 2);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_budget_id')->references('id')->on('project_budgets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_budget_items');
    }
};
