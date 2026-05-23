<?php $page = 'unit-replacements'; ?>
@extends('layout.mainlayout')
@section('title', 'Edit ' . $unitReplacement->replacement_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit {{ $unitReplacement->replacement_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.index') }}">PTU</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.show', $unitReplacement->uid) }}">{{ $unitReplacement->replacement_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('unit-replacements.show', $unitReplacement->uid) }}" class="btn btn-light d-flex align-items-center">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-replacements.update', $unitReplacement->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Informasi PTU</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Project</label>
                                    <input type="text" class="form-control" value="{{ $unitReplacement->project->project_name ?? '-' }}" disabled>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Permintaan Unit</label>
                                    <input type="text" class="form-control" value="{{ $unitReplacement->unitRequest->request_number ?? '-' }}" disabled>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Penggantian <span class="text-danger">*</span></label>
                                    <input type="date" name="replacement_date" class="form-control"
                                        value="{{ old('replacement_date', $unitReplacement->replacement_date?->format('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mobilisasi</label>
                                    <input type="date" name="mobilization_date" class="form-control"
                                        value="{{ old('mobilization_date', $unitReplacement->mobilization_date?->format('Y-m-d')) }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Penyebab Penggantian <span class="text-danger">*</span></label>
                                    <textarea name="cause" rows="3" class="form-control">{{ old('cause', $unitReplacement->cause) }}</textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" rows="2" class="form-control">{{ old('notes', $unitReplacement->notes) }}</textarea>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Lampiran</label>
                                    @if($unitReplacement->attachment_path)
                                        <div class="mb-2">
                                            <i class="ti ti-paperclip me-1 text-muted"></i>
                                            <a href="{{ route('unit-replacements.attachment', $unitReplacement->uid) }}" class="small text-primary">Lampiran saat ini</a>
                                            <span class="text-muted small"> (upload baru untuk mengganti)</span>
                                        </div>
                                    @endif
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Daftar Unit yang Diganti</h5></div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Unit Lama</th>
                                            <th>Unit Pengganti</th>
                                            <th style="width:90px">Qty</th>
                                            <th style="width:110px">Durasi (hari)</th>
                                            <th>Alasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($unitReplacement->items as $i => $item)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $item->original_unit_name }}</div>
                                                <small class="text-muted">{{ $item->original_equipment_code ?? '' }}</small>
                                                <input type="hidden" name="items[{{ $i }}][original_unit_request_item_id]" value="{{ $item->original_unit_request_item_id }}">
                                                <input type="hidden" name="items[{{ $i }}][replacement_workshop_unit_id]" value="{{ $item->replacement_workshop_unit_id }}">
                                                <input type="hidden" name="items[{{ $i }}][replacement_unit_name]" value="{{ $item->replacement_unit_name }}">
                                                <input type="hidden" name="items[{{ $i }}][replacement_equipment_code]" value="{{ $item->replacement_equipment_code }}">
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $item->replacement_unit_name }}</div>
                                                <small class="text-muted">{{ $item->replacement_equipment_code ?? '' }}</small>
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" min="0.01" name="items[{{ $i }}][replacement_qty]"
                                                    class="form-control form-control-sm" value="{{ $item->replacement_qty }}" required>
                                            </td>
                                            <td>
                                                <input type="number" min="1" name="items[{{ $i }}][replacement_duration_days]"
                                                    class="form-control form-control-sm" value="{{ $item->replacement_duration_days }}">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $i }}][reason]" class="form-control form-control-sm"
                                                    value="{{ $item->reason }}" required>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-light-200"><h6 class="mb-0">Aksi</h6></div>
                        <div class="card-body d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('unit-replacements.show', $unitReplacement->uid) }}" class="btn btn-light">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
