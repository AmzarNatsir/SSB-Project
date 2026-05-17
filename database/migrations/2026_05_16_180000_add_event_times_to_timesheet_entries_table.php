<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah field event time per type (Operating/Idle/Breakdown) di timesheet_entries.
     * Sebelumnya hanya simpan durasi total — sekarang juga simpan jam mulai-selesai per event,
     * supaya audit-friendly dan bisa cross-check dengan HM start/end.
     */
    public function up(): void
    {
        Schema::table('timesheet_entries', function (Blueprint $table) {
            $table->time('operating_start_time')->nullable()->after('hm_end');
            $table->time('operating_end_time')->nullable()->after('operating_start_time');

            $table->time('idle_start_time')->nullable()->after('idle_hours');
            $table->time('idle_end_time')->nullable()->after('idle_start_time');
            $table->text('idle_reason')->nullable()->after('idle_end_time');

            $table->time('breakdown_start_time')->nullable()->after('breakdown_hours');
            $table->time('breakdown_end_time')->nullable()->after('breakdown_start_time');
            $table->text('breakdown_reason')->nullable()->after('breakdown_end_time');
        });
    }

    public function down(): void
    {
        Schema::table('timesheet_entries', function (Blueprint $table) {
            $table->dropColumn([
                'operating_start_time', 'operating_end_time',
                'idle_start_time', 'idle_end_time', 'idle_reason',
                'breakdown_start_time', 'breakdown_end_time', 'breakdown_reason',
            ]);
        });
    }
};
