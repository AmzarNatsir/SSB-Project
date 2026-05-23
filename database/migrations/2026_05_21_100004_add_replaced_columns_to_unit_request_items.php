<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->timestamp('replaced_at')->nullable()->after('operator_name');
            $table->foreignId('replaced_by_item_id')
                ->nullable()
                ->after('replaced_at')
                ->constrained('unit_replacement_items')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('replaced_by_item_id');
            $table->dropColumn('replaced_at');
        });
    }
};
