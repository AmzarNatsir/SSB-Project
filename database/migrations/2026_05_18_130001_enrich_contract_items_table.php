<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Perkuat snapshot di contract_items dengan field tambahan agar:
 *  1. Konsisten dengan quotation_items (uid_unit, duration_unit)
 *  2. Tahan rot kalau master Workshop API berubah (equipment_code snapshot)
 *  3. Mendukung negotiated terms per-item (notes)
 *
 * Semua field nullable agar aman untuk data existing.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contract_items', function (Blueprint $table) {
            // UUID dari Workshop API — konsisten dengan quotation_items.uid_unit
            $table->string('uid_unit')->nullable()->after('unit_id');

            // Snapshot kode alat (anti round-trip ke Workshop API saat tampilkan kontrak)
            $table->string('equipment_code', 100)->nullable()->after('uid_unit');

            // Unit waktu: DAY / MONTH / TRIP / HM (sesuai quotation_items)
            $table->string('duration_unit', 20)->default('MONTH')->after('duration');

            // Catatan negotiated terms per item
            $table->text('notes')->nullable()->after('tax');

            $table->index('uid_unit', 'ci_uid_unit_idx');
        });
    }

    public function down(): void
    {
        Schema::table('contract_items', function (Blueprint $table) {
            $table->dropIndex('ci_uid_unit_idx');
            $table->dropColumn(['uid_unit', 'equipment_code', 'duration_unit', 'notes']);
        });
    }
};
