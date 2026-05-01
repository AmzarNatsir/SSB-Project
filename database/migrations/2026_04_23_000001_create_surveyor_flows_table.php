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
        Schema::create('surveyor_flows', function (Blueprint $table) {
            $table->id();
            $table->string('department'); // HSE, OPERATION, PROJECT, WORKSHOP, etc.
            $table->string('surveyor_type'); // USER or ROLE
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // One active mapping per department
            $table->unique(['department']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // role_id references spatie roles table
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveyor_flows');
    }
};
