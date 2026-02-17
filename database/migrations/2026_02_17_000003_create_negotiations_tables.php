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
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique(); // For secure URLs
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->string('negotiation_number')->unique(); // E.g. NEG/2026/001
            $table->date('negotiation_date');
            
            // Decimal 18,2 for currency
            $table->decimal('client_offer_value', 18, 2)->default(0);
            $table->decimal('company_offer_value', 18, 2)->default(0); // Initial quote price or counter offer
            $table->decimal('final_agreed_value', 18, 2)->nullable();
            
            $table->string('status')->default('DRAFT'); // stored as string, cast to Enum in model
            $table->text('notes')->nullable();
            
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('negotiation_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id')->constrained()->onDelete('cascade');
            $table->integer('round_number');
            
            $table->decimal('client_offer_value', 18, 2);
            $table->decimal('company_counter_offer', 18, 2);
            
            $table->date('meeting_date');
            $table->text('summary_notes')->nullable();
            $table->string('attachment_path')->nullable(); // File path
            
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('negotiation_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id')->constrained()->onDelete('cascade');
            $table->integer('level'); // 1=Manager, 2=Director etc
            $table->foreignId('approver_id')->constrained('users');
            $table->string('status'); // PENDING, APPROVED, REJECTED
            $table->text('remarks')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiation_approvals');
        Schema::dropIfExists('negotiation_rounds');
        Schema::dropIfExists('negotiations');
    }
};
