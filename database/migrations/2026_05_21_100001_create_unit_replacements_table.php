<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_replacements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_request_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('contract_id')->nullable()->constrained()->onDelete('set null');

            $table->string('replacement_number', 50)->unique(); // Format: PTU/YYYY/000001
            $table->date('replacement_date');
            $table->date('mobilization_date')->nullable();
            $table->text('cause'); // Penyebab penggantian unit (overall reason)

            $table->string('status')->default('DRAFT')->index(); // Enum: UnitReplacementStatus
            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable();

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_replacements');
    }
};
