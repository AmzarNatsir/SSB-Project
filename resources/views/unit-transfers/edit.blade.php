<?php $page = 'unit-transfers'; ?>
@extends('layout.mainlayout')
@section('title', 'Edit ' . $unitTransfer->transfer_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit {{ $unitTransfer->transfer_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-transfers.index') }}">UT</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-transfers.show', $unitTransfer->uid) }}">{{ $unitTransfer->transfer_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('unit-transfers.show', $unitTransfer->uid) }}" class="btn btn-light d-flex align-items-center">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-transfers.update', $unitTransfer->uid) }}" method="POST" enctype="multipart/form-data" id="utForm">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Project Asal & UR</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Project Asal</label>
                                    <input type="text" class="form-control" value="{{ $unitTransfer->sourceProject->project_name }} ({{ $unitTransfer->sourceProject->project_number }})" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit Request (UR)</label>
                                    <input type="text" class="form-control" value="{{ $unitTransfer->sourceUnitRequest?->request_number ?? '-' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Info Project Baru (Tujuan)</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Project Tujuan <span class="text-danger">*</span></label>
                                    <select name="destination_project_id" id="destinationProjectId" class="form-select" required>
                                        <option value="">-- Pilih Project Tujuan --</option>
                                        @foreach($destinationProjects as $p)
                                            <option value="{{ $p->id }}"
                                                data-number="{{ $p->project_number }}"
                                                data-name="{{ $p->project_name }}"
                                                data-location="{{ $p->project_location }}"
                                                {{ old('destination_project_id', $unitTransfer->destination_project_id) == $p->id ? 'selected' : '' }}
                                                {{ $p->id == $unitTransfer->source_project_id ? 'hidden disabled' : '' }}>
                                                {{ $p->project_name }} ({{ $p->project_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nomor Project</label>
                                    <input type="text" id="destProjectNumber" class="form-control" value="{{ $unitTransfer->destinationProject->project_number ?? '-' }}" disabled>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Project</label>
                                    <input type="text" id="destProjectName" class="form-control" value="{{ $unitTransfer->destinationProject->project_name ?? '-' }}" disabled>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Lokasi Project</label>
                                    <input type="text" id="destProjectLocation" class="form-control" value="{{ $unitTransfer->destinationProject->project_location ?? '-' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Informasi UT</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Transfer <span class="text-danger">*</span></label>
                                    <input type="date" name="transfer_date" class="form-control"
                                        value="{{ old('transfer_date', $unitTransfer->transfer_date->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lampiran</label>
                                    @if($unitTransfer->attachment_path)
                                        <div class="mb-2 small">
                                            <a href="{{ route('unit-transfers.attachment', $unitTransfer->uid) }}" class="text-primary">Lampiran saat ini</a>
                                        </div>
                                    @endif
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">PDF, JPG, PNG (max 5MB). Kosongkan jika tidak diubah.</div>
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" rows="3" class="form-control">{{ old('notes', $unitTransfer->notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light-200">
                            <h5 class="mb-0">Daftar Unit yang Ditransfer</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 align-middle" style="min-width:900px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Unit (dari UR)</th>
                                            <th>Driver/Operator</th>
                                            <th style="width:15%; min-width:110px">Qty</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($unitTransfer->items as $i => $item)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $item->unit_name }}</div>
                                                @if($item->equipment_code)
                                                    <small class="text-muted d-block">Kode: {{ $item->equipment_code }}</small>
                                                @endif
                                                <input type="hidden" name="items[{{ $i }}][original_unit_request_item_id]" value="{{ $item->original_unit_request_item_id }}">
                                            </td>
                                            <td>{{ $item->operator_name ?: '-' }}</td>
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
                                Untuk mengubah daftar unit, hapus UT dan buat ulang dari UR yang sesuai.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-light-200"><h6 class="mb-0">Aksi</h6></div>
                        <div class="card-body d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Perubahan</button>
                            <a href="{{ route('unit-transfers.show', $unitTransfer->uid) }}" class="btn btn-light">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const destSel      = document.getElementById('destinationProjectId');
    const destNumber   = document.getElementById('destProjectNumber');
    const destName     = document.getElementById('destProjectName');
    const destLocation = document.getElementById('destProjectLocation');

    function updateDestInfo() {
        const opt = destSel.options[destSel.selectedIndex];
        if (!opt || !opt.value) {
            destNumber.value = '-'; destName.value = '-'; destLocation.value = '-';
            return;
        }
        destNumber.value   = opt.dataset.number || '-';
        destName.value     = opt.dataset.name || '-';
        destLocation.value = opt.dataset.location || '-';
    }
    destSel.addEventListener('change', updateDestInfo);
})();
</script>
@endpush
@endsection
