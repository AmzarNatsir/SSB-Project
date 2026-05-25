<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->timestamp('returned_at')->nullable()->after('replaced_by_item_id');
            $table->foreignId('returned_by_item_id')
                ->nullable()
                ->after('returned_at')
                ->constrained('project_unit_return_items')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('returned_by_item_id');
            $table->dropColumn('returned_at');
        });
    }
};
