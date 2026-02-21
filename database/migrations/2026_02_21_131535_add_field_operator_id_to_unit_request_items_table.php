<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->unsignedBigInteger('operator_id')->nullable()->after('unit_ready');
            $table->string('operator_name', 200)->nullable()->after('operator_id');
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_request_items', function (Blueprint $table) {
            $table->dropColumn('operator_id');
            $table->dropColumn('operator_name');
        });
    }
};
