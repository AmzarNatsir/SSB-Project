<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spare_part_usages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();

            // Format: SPU/2026/001
            $table->string('usage_number', 50)->unique();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            // Optional link to a specific unit/alat
            $table->string('unit_name', 200)->nullable()->comment('Nama unit/alat yang menggunakan spare part');
            $table->string('equipment_code', 100)->nullable()->comment('Kode alat / nomor polisi');

            $table->date('usage_date')->index();

            // Spare part detail
            $table->string('part_name', 200)->comment('Nama spare part / suku cadang');
            $table->string('part_number', 100)->nullable()->comment('Part number / kode katalog');
            $table->string('part_category', 100)->nullable()->comment('Kategori: Mesin, Transmisi, Elektrikal, dst.');

            // Quantity & cost
            $table->decimal('quantity', 15, 3)->default(1);
            $table->string('unit_of_measure', 30)->default('PCS')->comment('PCS, SET, LITER, METER, dst.');
            $table->decimal('unit_price', 18, 2)->nullable();
            $table->decimal('total_price', 18, 2)->nullable();

            // Vendor / PO (stub, future Warehouse module)
            $table->string('vendor_name', 200)->nullable();
            $table->string('purchase_order_number', 100)->nullable();

            $table->text('description')->nullable()->comment('Keterangan / alasan penggantian');
            $table->string('attachment_path')->nullable();

            // Approval flow
            $table->string('status', 30)->default('DRAFT')->index();
            $table->integer('current_approval_level')->default(0);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Composite indexes for report queries
            $table->index(['project_id', 'usage_date'], 'spu_project_date_idx');
            $table->index(['usage_date', 'status'], 'spu_date_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spare_part_usages');
    }
};
