<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unit_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_transfer_id')->constrained('unit_transfers')->cascadeOnDelete();
            $table->foreignId('original_unit_request_item_id')->nullable()->constrained('unit_request_items')->nullOnDelete();
            $table->string('unit_name');
            $table->string('equipment_code')->nullable();
            $table->decimal('qty', 15, 2)->default(1);
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->string('operator_name', 200)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_transfer_items');
    }
};
