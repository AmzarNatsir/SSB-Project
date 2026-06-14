@php
    $spu = $spu ?? null;
    $isEdit = $spu !== null;
@endphp

@if($errors->any())
    <div class="alert alert-danger d-print-none">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0 text-warning"><i class="ti ti-info-circle me-1"></i>Informasi Transaksi</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            {{-- Proyek --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold mb-1 small">Proyek <span class="text-danger">*</span></label>
                <select name="project_id" id="project_id" class="form-select form-select-sm select2" required>
                    <option value="">-- Pilih Proyek --</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" @selected(old('project_id', $spu?->project_id) == $p->id)>
                            {{ $p->project_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal Pemakaian --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold mb-1 small">Tanggal Pemakaian <span class="text-danger">*</span></label>
                <input type="date" name="usage_date" id="usage_date" class="form-control form-control-sm"
                       value="{{ old('usage_date', $spu?->usage_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
            </div>

            {{-- Nama Unit / Alat --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold mb-1 small">Nama Unit / Alat</label>
                <input type="text" name="unit_name" id="unit_name" class="form-control form-control-sm"
                       placeholder="Misal: Excavator Komatsu PC200" value="{{ old('unit_name', $spu?->unit_name ?? '') }}">
            </div>

            {{-- Kode Alat --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold mb-1 small">Kode Alat / No. Polisi</label>
                <input type="text" name="equipment_code" id="equipment_code" class="form-control form-control-sm"
                       placeholder="Misal: EQ-EX200 atau DT-05" value="{{ old('equipment_code', $spu?->equipment_code ?? '') }}">
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0 text-warning"><i class="ti ti-tool me-1"></i>Detail Suku Cadang &amp; Biaya</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            {{-- Nama Spare Part --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold mb-1 small">Nama Spare Part <span class="text-danger">*</span></label>
                <input type="text" name="part_name" id="part_name" class="form-control form-control-sm"
                       placeholder="Masukkan nama spare part" value="{{ old('part_name', $spu?->part_name ?? '') }}" required>
            </div>

            {{-- Part Number --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1 small">Part Number / Katalog</label>
                <input type="text" name="part_number" id="part_number" class="form-control form-control-sm"
                       placeholder="Misal: PN-987452" value="{{ old('part_number', $spu?->part_number ?? '') }}">
            </div>

            {{-- Kategori Part --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1 small">Kategori</label>
                <select name="part_category" id="part_category" class="form-select form-select-sm">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Engine" @selected(old('part_category', $spu?->part_category) === 'Engine')>Engine</option>
                    <option value="Hydraulics" @selected(old('part_category', $spu?->part_category) === 'Hydraulics')>Hydraulics</option>
                    <option value="Tires & Tracks" @selected(old('part_category', $spu?->part_category) === 'Tires & Tracks')>Tires &amp; Tracks</option>
                    <option value="Electrical" @selected(old('part_category', $spu?->part_category) === 'Electrical')>Electrical</option>
                    <option value="Filters" @selected(old('part_category', $spu?->part_category) === 'Filters')>Filters</option>
                    <option value="Brakes" @selected(old('part_category', $spu?->part_category) === 'Brakes')>Brakes</option>
                    <option value="Lainnya" @selected(old('part_category', $spu?->part_category) === 'Lainnya')>Lainnya</option>
                </select>
            </div>

            {{-- Qty --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1 small">Jumlah (Quantity) <span class="text-danger">*</span></label>
                <input type="number" name="quantity" id="quantity" class="form-control form-control-sm text-end"
                       value="{{ old('quantity', $spu?->quantity ?? '1') }}" step="0.001" min="0.001" required>
            </div>

            {{-- UoM --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1 small">Satuan (UoM) <span class="text-danger">*</span></label>
                <input type="text" name="unit_of_measure" id="unit_of_measure" class="form-control form-control-sm"
                       placeholder="PCS, SET, LITER, m, dst." value="{{ old('unit_of_measure', $spu?->unit_of_measure ?? 'PCS') }}" required>
            </div>

            {{-- Harga Satuan --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1 small">Harga Satuan (Rp)</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light">Rp</span>
                    <input type="number" name="unit_price" id="unit_price" class="form-control text-end"
                           value="{{ old('unit_price', $spu?->unit_price ?? '') }}" step="0.01" min="0">
                </div>
            </div>

            {{-- Estimasi Total --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1 small">Estimasi Total</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light">Rp</span>
                    <input type="text" id="total_price_display" class="form-control text-end"
                           value="{{ $spu?->total_price ? number_format($spu->total_price, 0, ',', '.') : '-' }}" readonly disabled>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0 text-warning"><i class="ti ti-shopping-cart me-1"></i>Informasi Pembelian / Vendor (Opsional)</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            {{-- Vendor Name --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold mb-1 small">Nama Vendor / Pemasok</label>
                <input type="text" name="vendor_name" id="vendor_name" class="form-control form-control-sm"
                       placeholder="Misal: PT. United Tractors" value="{{ old('vendor_name', $spu?->vendor_name ?? '') }}">
            </div>

            {{-- PO Number --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold mb-1 small">Nomor Purchase Order (PO)</label>
                <input type="text" name="purchase_order_number" id="purchase_order_number" class="form-control form-control-sm"
                       placeholder="Misal: PO-2026-009" value="{{ old('purchase_order_number', $spu?->purchase_order_number ?? '') }}">
            </div>

            {{-- Description / Catatan --}}
            <div class="col-12">
                <label class="form-label fw-semibold mb-1 small">Alasan Penggantian / Keterangan</label>
                <textarea name="description" id="description" rows="3" class="form-control form-control-sm"
                          placeholder="Tulis alasan penggantian, deskripsi kerusakan, atau catatan lainnya..."
                          >{{ old('description', $spu?->description ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="d-flex align-items-center gap-2 mt-4">
    <button type="submit" class="btn btn-warning text-dark px-4">
        <i class="ti ti-device-floppy me-1"></i>Simpan
    </button>
    <a href="{{ route('spare-part-usages.index') }}" class="btn btn-light px-3">Batal</a>
</div>

@push('scripts')
<script>
(function() {
    'use strict';

    const $qty = document.getElementById('quantity');
    const $price = document.getElementById('unit_price');
    const $total = document.getElementById('total_price_display');

    function calcTotal() {
        const q = parseFloat($qty.value) || 0;
        const p = parseFloat($price.value) || 0;
        const tot = q * p;
        if (tot > 0) {
            $total.value = new Intl.NumberFormat('id-ID').format(Math.round(tot));
        } else {
            $total.value = '-';
        }
    }

    $qty.addEventListener('input', calcTotal);
    $price.addEventListener('input', calcTotal);
})();
</script>
@endpush
