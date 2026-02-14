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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->date('request_date');
            $table->unsignedBigInteger('project_categories_id');
            $table->unsignedBigInteger('project_sub_categories_id')->nullable();
            $table->string('project_code')->unique();
            $table->string('project_number');
            $table->string('project_name');
            $table->string('project_location')->nullable();
            $table->string('project_coordinates')->nullable();
            $table->string('user_name');
            $table->string('user_code')->nullable();
            $table->string('user_address')->nullable();
            $table->string('job_type')->nullable();
            $table->string('taxpayer_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('pic_id')->nullable();
            $table->text('scope_of_work')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration_of_work')->nullable();
            $table->string('bank_account')->nullable();
            $table->double('project_value')->default(0);
            $table->enum('project_status', ['NOT STARTED', 'ON PROGRESS', 'COMPLETED', 'ON HOLD', 'CANCELLED'])->default('NOT STARTED');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('equipment_rental_rates_hm_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('project_categories_id')->references('id')->on('project_categories')->onDelete('cascade');
            $table->foreign('project_sub_categories_id')->references('id')->on('project_sub_categories')->onDelete('set null');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('equipment_rental_rates_hm_id')->references('id')->on('equipment_rental_rates_hm')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
