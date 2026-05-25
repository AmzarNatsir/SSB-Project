<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->decimal('returned_qty', 15, 2)->default(0)->after('returned_by_item_id');
        });
    }

    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->dropColumn('returned_qty');
        });
    }
};
