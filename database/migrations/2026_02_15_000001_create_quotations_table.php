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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            // Link to the budget baseline (optional, but good for traceability)
            $table->foreignId('project_budget_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('status')->default('DRAFT')->index(); // DRAFT, SUBMITTED, APPROVED, SENT, REVISION_REQUIRED
            
            // Financials
            $table->decimal('total_project_value', 15, 2)->default(0); // sum(rate * qty * duration)
            $table->decimal('quotation_price', 15, 2)->default(0);     // Cost base (Budget Baseline)
            $table->decimal('profit_value', 15, 2)->default(0);        // total_project_value - quotation_price
            $table->decimal('profit_margin_percent', 5, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);       // Final price to client
            
            // Meta
            $table->date('valid_until')->nullable();
            $table->text('terms_conditions')->nullable();
            
            // Approval flow
            $table->integer('current_approval_level')->default(0);
            
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
