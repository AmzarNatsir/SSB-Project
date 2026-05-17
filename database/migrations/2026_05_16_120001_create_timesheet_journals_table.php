<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timesheet_journals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('journal_number', 50)->unique(); // TJ/YYYY/MM/NNN

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->nullable()->constrained()->onDelete('set null');

            $table->date('journal_date')->index();
            // DAY, NIGHT
            $table->string('shift', 10)->default('DAY');

            // DRAFT, SUBMITTED, VERIFIED, APPROVED, REJECTED
            $table->string('status', 20)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->text('notes')->nullable();

            $table->foreignId('submitted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // 1 jurnal per project / tanggal / shift
            $table->unique(['project_id', 'journal_date', 'shift'], 'tj_project_date_shift_unique');
            $table->index(['project_id', 'status']);
            $table->index(['journal_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheet_journals');
    }
};
