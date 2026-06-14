@extends('layout.mainlayout')
@section('title', 'Detail Pemakaian Spare Part')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- Header --}}
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 d-print-none">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    {{ $spu->usage_number }}
                    @php
                        $sc = match($spu->status) {
                            'APPROVED'  => 'success',
                            'SUBMITTED' => 'warning',
                            'REJECTED'  => 'danger',
                            default     => 'secondary',
                        };
                        $sl = match($spu->status) {
                            'APPROVED'  => 'Disetujui',
                            'SUBMITTED' => 'Diajukan',
                            'REJECTED'  => 'Ditolak',
                            default     => 'Draft',
                        };
                    @endphp
                    <span class="badge bg-{{ $sc }}-subtle text-{{ $sc }} fs-13 text-uppercase ms-2">
                        {{ $sl }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('spare-part-usages.index') }}">Spare Part Usage</a></li>
                        <li class="breadcrumb-item active">{{ $spu->usage_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <a href="{{ route('spare-part-usages.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left me-1"></i>Kembali
                </a>
                <button class="btn btn-outline-dark btn-sm" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i>Cetak
                </button>
                @if($spu->canEdit())
                    <a href="{{ route('spare-part-usages.edit', $spu->uid) }}" class="btn btn-warning text-dark btn-sm">
                        <i class="ti ti-edit me-1"></i>Edit Data
                    </a>
                @endif
            </div>
        </div>

        {{-- Main Grid --}}
        <div class="row">
            {{-- Left Column: Details --}}
            <div class="col-lg-8">
                {{-- Transaction Info --}}
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0"><i class="ti ti-info-circle me-1 text-warning"></i>Informasi Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Proyek</dt>
                            <dd class="col-sm-9 fw-semibold text-dark">{{ $spu->project?->project_name ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Tanggal Pemakaian</dt>
                            <dd class="col-sm-9">{{ $spu->usage_date?->format('d M Y') ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Unit / Alat</dt>
                            <dd class="col-sm-9">{{ $spu->unit_name ?: '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Kode Alat / No. Polisi</dt>
                            <dd class="col-sm-9">
                                @if($spu->equipment_code)
                                    <span class="badge bg-light text-dark border">{{ $spu->equipment_code }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </dd>

                            <dt class="col-sm-3 text-muted">Dibuat Oleh</dt>
                            <dd class="col-sm-9">
                                {{ $spu->creator?->name ?? 'Sistem' }}
                                <small class="text-muted ms-1">({{ $spu->created_at->format('d M Y, H:i') }})</small>
                            </dd>

                            @if($spu->approved_by)
                                <dt class="col-sm-3 text-muted">Disetujui Oleh</dt>
                                <dd class="col-sm-9">
                                    {{ $spu->approver?->name ?? '-' }}
                                    <small class="text-muted ms-1">({{ $spu->approved_at?->format('d M Y, H:i') }})</small>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Spare Part & Cost details --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0"><i class="ti ti-tool me-1 text-warning"></i>Detail Suku Cadang</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Nama Spare Part</dt>
                            <dd class="col-sm-9 fw-bold text-dark fs-6">{{ $spu->part_name }}</dd>

                            <dt class="col-sm-3 text-muted">Part Number / Katalog</dt>
                            <dd class="col-sm-9 text-monospace">{{ $spu->part_number ?: '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Kategori</dt>
                            <dd class="col-sm-9">
                                @if($spu->part_category)
                                    <span class="badge bg-purple-subtle text-purple">{{ $spu->part_category }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </dd>

                            <dt class="col-sm-3 text-muted">Kuantitas &amp; Satuan</dt>
                            <dd class="col-sm-9">{{ number_format($spu->quantity, 2) }} {{ $spu->unit_of_measure }}</dd>

                            <dt class="col-sm-3 text-muted">Harga Satuan</dt>
                            <dd class="col-sm-9">
                                @if($spu->unit_price)
                                    Rp {{ number_format($spu->unit_price, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </dd>

                            <dt class="col-sm-3 text-muted">Total Nilai</dt>
                            <dd class="col-sm-9 fw-bold text-warning fs-5">
                                @if($spu->total_price)
                                    Rp {{ number_format($spu->total_price, 0, ',', '.') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                {{-- Purchasing and vendor info --}}
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0"><i class="ti ti-shopping-cart me-1 text-warning"></i>Informasi Pembelian / Vendor</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Vendor / Pemasok</dt>
                            <dd class="col-sm-9">{{ $spu->vendor_name ?: '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Nomor PO</dt>
                            <dd class="col-sm-9">{{ $spu->purchase_order_number ?: '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Keterangan / Alasan</dt>
                            <dd class="col-sm-9 text-muted small">
                                {!! nl2br(e($spu->description)) ?: '<i>Tidak ada catatan.</i>' !!}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Right Column: Summary Card / Actions --}}
            <div class="col-lg-4 d-print-none">
                <div class="card border-warning bg-warning-subtle text-dark">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ti ti-receipt fs-2 me-2"></i>
                            <h5 class="mb-0 fw-bold">Ringkasan Biaya</h5>
                        </div>
                        <div class="text-muted small">Total Pemakaian</div>
                        <h3 class="fw-bold mb-2">
                            @if($spu->total_price)
                                Rp {{ number_format($spu->total_price, 0, ',', '.') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </h3>
                        <div class="small text-muted mb-3">
                            Kuantitas: <strong>{{ number_format($spu->quantity, 2) }} {{ $spu->unit_of_measure }}</strong><br>
                            Harga: <strong>Rp {{ number_format($spu->unit_price ?? 0, 0, ',', '.') }} / {{ $spu->unit_of_measure }}</strong>
                        </div>
                        <hr class="border-dark opacity-10">
                        <div class="small">
                            Status data ini adalah <strong>{{ $sl }}</strong>.
                            @if($spu->canEdit())
                                Anda dapat merubah isi data ini kembali ke mode edit.
                            @else
                                Data sudah disetujui dan terkunci.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
@media print {
    .page-header, .sidebar, header, .d-print-none { display: none !important; }
    .card { border: 1px solid #ddd !important; box-shadow: none !important; }
    body { font-size: 12px; background: white !important; }
    .page-wrapper { margin-left: 0 !important; padding-top: 0 !important; }
}
</style>
@endpush
@endsection
