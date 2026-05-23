<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_replacement_items', function (Blueprint $table) {
            // External Workshop API unit id — no FK constraint (data lives in remote system).
            $table->unsignedBigInteger('replacement_workshop_unit_id')
                ->nullable()
                ->after('original_equipment_code');

            $table->index('replacement_workshop_unit_id');
        });
    }

    public function down(): void
    {
        Schema::table('unit_replacement_items', function (Blueprint $table) {
            $table->dropIndex(['replacement_workshop_unit_id']);
            $table->dropColumn('replacement_workshop_unit_id');
        });
    }
};
