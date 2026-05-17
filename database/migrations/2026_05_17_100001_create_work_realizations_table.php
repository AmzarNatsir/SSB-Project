<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_realizations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('realization_number', 50)->unique(); // WR/YYYY/NNN

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->nullable()->constrained()->onDelete('set null');

            $table->date('period_start');
            $table->date('period_end');

            // DRAFT, SUBMITTED, APPROVED, REJECTED
            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            // Total realisasi (sum dari semua items, computed at save)
            $table->decimal('total_realized_amount', 18, 2)->default(0);

            // 3 attachment slots — sesuai UR
            $table->string('pa_ma_attachment_path')->nullable();           // Laporan PA & MA dari Workshop
            $table->string('safety_attachment_path')->nullable();          // Laporan Safety Plan dari HSE
            $table->string('berita_acara_attachment_path')->nullable();    // File Lampiran Berita Acara

            $table->text('notes')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_id', 'status']);
            $table->index(['period_start', 'period_end']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_realizations');
    }
};
