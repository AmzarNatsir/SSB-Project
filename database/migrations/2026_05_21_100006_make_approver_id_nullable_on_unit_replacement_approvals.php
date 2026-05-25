<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unit_replacement_approvals', function (Blueprint $table) {
            // Drop FK before altering column on MySQL
            $table->dropForeign(['approver_id']);
            $table->unsignedBigInteger('approver_id')->nullable()->change();
            $table->foreign('approver_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('unit_replacement_approvals', function (Blueprint $table) {
            $table->dropForeign(['approver_id']);
            $table->unsignedBigInteger('approver_id')->nullable(false)->change();
            $table->foreign('approver_id')->references('id')->on('users');
        });
    }
};
