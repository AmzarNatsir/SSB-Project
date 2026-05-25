<?php $page = 'unit-returns'; ?>
@extends('layout.mainlayout')
@section('title', 'Edit ' . $unitReturn->ppu_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit {{ $unitReturn->ppu_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-returns.index') }}">PPU</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-returns.show', $unitReturn->uid) }}">{{ $unitReturn->ppu_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('unit-returns.show', $unitReturn->uid) }}" class="btn btn-light d-flex align-items-center">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-returns.update', $unitReturn->uid) }}" method="POST" enctype="multipart/form-data" id="ppuForm">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Informasi PPU</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Project</label>
                                    <input type="text" class="form-control" value="{{ $unitReturn->project->project_name }} ({{ $unitReturn->project->project_number }})" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Permintaan Unit (UR)</label>
                                    <input type="text" class="form-control" value="{{ $unitReturn->unitRequest?->request_number ?? '-' }}" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Pengembalian <span class="text-danger">*</span></label>
                                    <input type="date" name="return_date" class="form-control"
                                        value="{{ old('return_date', $unitReturn->return_date->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Demobilisasi</label>
                                    <input type="date" name="demobilization_date" class="form-control"
                                        value="{{ old('demobilization_date', $unitReturn->demobilization_date?->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" rows="2" class="form-control">{{ old('notes', $unitReturn->notes) }}</textarea>
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Lampiran</label>
                                    @if($unitReturn->attachment_path)
                                        <div class="mb-2 small">
                                            <a href="{{ route('unit-returns.attachment', $unitReturn->uid) }}" class="text-primary">Lampiran saat ini</a>
                                        </div>
                                    @endif
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">PDF, JPG, PNG (max 5MB). Kosongkan jika tidak diubah.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light-200">
                            <h5 class="mb-0">Daftar Unit yang Dikembalikan</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 align-middle" style="min-width:900px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px"></th>
                                            <th>Unit (dari UR)</th>
                                            <th style="width:15%; min-width:110px">Qty</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        @foreach($unitReturn->items as $i => $item)
                                        <tr class="item-row">
                                            <td class="text-center align-middle">
                                                <input type="checkbox" class="form-check-input" checked disabled>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $item->unit_name }}</div>
                                                <small class="text-muted">Operator: {{ $item->operator_name ?: '-' }}</small>
                                                <input type="hidden" name="items[{{ $i }}][original_unit_request_item_id]" value="{{ $item->original_unit_request_item_id }}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0.01" name="items[{{ $i }}][qty]" class="form-control form-control-sm" value="{{ $item->qty }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $i }}][notes]" class="form-control form-control-sm" value="{{ $item->notes }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="px-3 py-2 small text-muted">
                                Untuk mengubah daftar unit, hapus PPU dan buat ulang dari UR yang sesuai.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-light-200"><h6 class="mb-0">Aksi</h6></div>
                        <div class="card-body d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Perubahan</button>
                            <a href="{{ route('unit-returns.show', $unitReturn->uid) }}" class="btn btn-light">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
