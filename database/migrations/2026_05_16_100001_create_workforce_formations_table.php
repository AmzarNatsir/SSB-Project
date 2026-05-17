<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workforce_formations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('formation_number', 50)->unique(); // WF/YYYY/NNN

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');

            $table->date('effective_date');
            $table->date('end_date')->nullable();

            // DRAFT, SUBMITTED, APPROVED, ACTIVE, REVISED, ENDED, REJECTED
            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'status']);
            $table->index(['contract_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workforce_formations');
    }
};
