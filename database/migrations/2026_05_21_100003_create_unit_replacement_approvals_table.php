<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_replacement_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_replacement_id')->constrained()->onDelete('cascade');
            $table->integer('level');
            $table->foreignId('approver_id')->constrained('users');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['unit_replacement_id', 'level']);
            $table->index(['unit_replacement_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_replacement_approvals');
    }
};
