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
        Schema::create('project_budget_revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_budget_id');
            $table->integer('revision_no');
            $table->text('reasons');
            $table->unsignedBigInteger('revised_by');
            $table->timestamp('revised_at')->useCurrent();
            $table->timestamps();

            $table->foreign('project_budget_id')->references('id')->on('project_budgets')->onDelete('cascade');
             $table->foreign('revised_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_budget_revisions');
    }
};
