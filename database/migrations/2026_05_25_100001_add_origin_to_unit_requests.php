<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_requests', function (Blueprint $table) {
            $table->string('origin', 20)->default('REQUEST')->after('status')->index();
            $table->foreignId('source_unit_transfer_id')
                ->nullable()
                ->after('origin')
                ->constrained('unit_transfers')
                ->nullOnDelete();
            $table->foreignId('quotation_id')->nullable()->change();
            $table->foreignId('negotiation_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('unit_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('source_unit_transfer_id');
            $table->dropColumn('origin');
        });
    }
};
