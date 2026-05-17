<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_formation_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_formation_id')->constrained()->onDelete('cascade');
            $table->integer('level');
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['unit_formation_id', 'level']);
            $table->index(['unit_formation_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_formation_approvals');
    }
};
