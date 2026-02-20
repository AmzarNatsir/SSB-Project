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
        Schema::create('unit_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->foreignId('negotiation_id')->constrained()->onDelete('cascade');

            $table->string('request_number', 50)->unique(); // Format: UR/YYYY/NNN
            $table->date('request_date');
            $table->date('mobilization_date');

            $table->string('status')->default('draft')->index(); // Enum: UnitRequestStatus
            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable();

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Composite index for filtering active requests per project
            $table->index(['project_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_requests');
    }
};
