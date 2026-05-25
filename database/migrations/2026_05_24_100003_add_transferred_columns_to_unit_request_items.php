<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->timestamp('transferred_at')->nullable()->after('returned_qty');
            $table->unsignedBigInteger('transferred_by_item_id')->nullable()->after('transferred_at');
            $table->decimal('transferred_qty', 15, 2)->default(0)->after('transferred_by_item_id');

            $table->foreign('transferred_by_item_id')
                ->references('id')->on('unit_transfer_items')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->dropForeign(['transferred_by_item_id']);
            $table->dropColumn(['transferred_at', 'transferred_by_item_id', 'transferred_qty']);
        });
    }
};
