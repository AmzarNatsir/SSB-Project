<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('project_unit_replacements');
        Schema::create('project_unit_replacements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('ptu_number')->unique();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->date('replacement_date');
            $table->date('mobilization_date')->nullable();
            $table->text('replacement_reason')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('DRAFT');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_unit_replacements');
    }
};

