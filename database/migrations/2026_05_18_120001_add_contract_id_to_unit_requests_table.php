<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah relasi ke Final Contract pada Unit Request.
 *
 * - unit_requests.contract_id: source of truth untuk sumber tagihan/operasional.
 * - unit_request_items.contract_item_id: snapshot ke contract_items (bukan quotation_items).
 *
 * Kolom dibuat nullable demi backward-compat dengan data lama (yang masih merujuk negotiation).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_requests', function (Blueprint $table) {
            $table->foreignId('contract_id')
                ->nullable()
                ->after('negotiation_id')
                ->constrained('contracts')
                ->onDelete('cascade');

            $table->index(['contract_id', 'status'], 'ur_contract_status_idx');
        });

        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->foreignId('contract_item_id')
                ->nullable()
                ->after('quotation_item_id')
                ->constrained('contract_items')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->dropForeign(['contract_item_id']);
            $table->dropColumn('contract_item_id');
        });

        Schema::table('unit_requests', function (Blueprint $table) {
            $table->dropIndex('ur_contract_status_idx');
            $table->dropForeign(['contract_id']);
            $table->dropColumn('contract_id');
        });
    }
};
