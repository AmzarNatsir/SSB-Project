<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Permintaan Unit sekarang snapshot dari contract_items (bukan quotation_items).
 * quotation_item_id jadi nullable untuk mendukung skema baru — sekaligus backward-compat
 * dengan data lama yang masih merujuk ke quotation.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->foreignId('quotation_item_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->foreignId('quotation_item_id')->nullable(false)->change();
        });
    }
};
