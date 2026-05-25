<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->foreignId('source_unit_transfer_item_id')
                ->nullable()
                ->after('transferred_qty')
                ->constrained('unit_transfer_items')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('source_unit_transfer_item_id');
        });
    }
};
