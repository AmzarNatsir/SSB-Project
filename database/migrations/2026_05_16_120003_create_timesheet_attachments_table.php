<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheet_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timesheet_entry_id')->constrained()->onDelete('cascade');

            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('file_type', 50)->nullable(); // image/pdf/excel
            $table->unsignedBigInteger('file_size')->nullable(); // bytes

            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('timesheet_entry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheet_attachments');
    }
};
