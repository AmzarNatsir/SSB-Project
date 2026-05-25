<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unit_transfers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('transfer_number', 20)->unique();
            $table->foreignId('source_project_id')->constrained('projects');
            $table->foreignId('source_unit_request_id')->nullable()->constrained('unit_requests')->nullOnDelete();
            $table->foreignId('destination_project_id')->constrained('projects');
            $table->date('transfer_date');
            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('status', 20)->default('DRAFT');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['source_project_id', 'status']);
            $table->index(['destination_project_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_transfers');
    }
};
