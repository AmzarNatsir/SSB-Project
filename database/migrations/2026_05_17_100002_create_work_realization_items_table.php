<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_realization_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_realization_id')->constrained()->onDelete('cascade');

            // Sumber data: unit yang ditetapkan di SK Penetapan Unit, baseline dari ContractItem
            $table->foreignId('unit_formation_item_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('contract_item_id')->nullable()->constrained()->onDelete('set null');

            // Snapshot supaya tidak rot saat master/SK berubah
            $table->string('unit_name');
            $table->string('equipment_code')->nullable();
            $table->string('operator_name')->nullable();

            // Periode aktual (bisa beda dari header kalau unit hanya beroperasi di sebagian periode)
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();

            // Akumulasi dari timesheet_entries.hm_total
            $table->decimal('total_hm', 12, 2)->default(0);
            $table->integer('timesheet_count')->default(0); // jumlah jurnal yang masuk

            // Penyesuaian tarif sewa — baseline dari kontrak, adjusted by user
            $table->decimal('contract_rate', 15, 2)->default(0);   // Rp per HM (baseline dari ContractItem)
            $table->decimal('adjusted_rate', 15, 2)->default(0);   // Rp per HM (final yang dipakai)
            $table->text('rate_adjustment_reason')->nullable();

            // Jumlah realisasi = total_hm × adjusted_rate (computed di service saat save)
            $table->decimal('realized_amount', 18, 2)->default(0);

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('work_realization_id', 'wri_realization_idx');
            $table->index('unit_formation_item_id', 'wri_uf_item_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_realization_items');
    }
};
