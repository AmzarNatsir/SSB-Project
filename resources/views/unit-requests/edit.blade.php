@extends('layout.mainlayout')
@section('title', 'Edit Permintaan Unit - ' . $unitRequest->request_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit Permintaan Unit</h3>
                <p class="text-muted small mb-0">Status: <span class="badge bg-{{ $unitRequest->status->color() }}-subtle text-{{ $unitRequest->status->color() }}">{{ $unitRequest->status->label() }}</span></p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-requests.index') }}">Permintaan Unit</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-requests.show', $unitRequest->uid) }}">{{ $unitRequest->request_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($unitRequest->status->value === 'REJECTED')
        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
            <i class="ti ti-alert-triangle me-3 fs-4"></i>
            <div>
                <strong>Permintaan ini ditolak.</strong>
                Lakukan revisi dan ajukan kembali. Lihat Riwayat Approval di halaman detail untuk umpan balik dari approver.
            </div>
        </div>
        @endif

        <form action="{{ route('unit-requests.update', $unitRequest->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Left: Items Editing -->
                <div class="col-lg-8">
                    <!-- Project Info (Read-only) -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-building me-2 text-primary"></i>Informasi Proyek</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Nomor Permintaan</label>
                                    <p class="fw-semibold mb-0">{{ $unitRequest->request_number }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Proyek</label>
                                    <p class="fw-semibold mb-0">{{ $unitRequest->project->project_name ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item Remarks Editing -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-list me-2 text-primary"></i>Daftar Unit</h5>
                            <p class="text-muted small mb-0 mt-1">Anda bisa memperbarui durasi dan keterangan untuk masing-masing unit.</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width:40px">#</th>
                                            <th>Nama Unit</th>
                                            <th class="text-center" style="width:80px">Qty</th>
                                            <th style="width:130px">Durasi (Hari)</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($unitRequest->items as $idx => $item)
                                        <tr>
                                            <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $item->id }}">
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td class="fw-medium">{{ $item->unit_name }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td>
                                                <input type="number" name="items[{{ $idx }}][duration_days]"
                                                    class="form-control form-control-sm"
                                                    value="{{ old("items.{$idx}.duration_days", $item->duration_days) }}"
                                                    min="1" placeholder="Hari">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $idx }}][remarks]"
                                                    class="form-control form-control-sm"
                                                    value="{{ old("items.{$idx}.remarks", $item->remarks) }}"
                                                    placeholder="Keterangan (opsional)">
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">Belum ada unit.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Dates + Attachment -->
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-calendar me-2 text-primary"></i>Detail Permintaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="request_date" class="form-label fw-semibold">Tanggal Permintaan <span class="text-danger">*</span></label>
                                <input type="date" id="request_date" name="request_date"
                                    class="form-control @error('request_date') is-invalid @enderror"
                                    value="{{ old('request_date', $unitRequest->request_date?->format('Y-m-d')) }}" required>
                                @error('request_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobilization_date" class="form-label fw-semibold">Tanggal Mobilisasi <span class="text-danger">*</span></label>
                                <input type="date" id="mobilization_date" name="mobilization_date"
                                    class="form-control @error('mobilization_date') is-invalid @enderror"
                                    value="{{ old('mobilization_date', $unitRequest->mobilization_date?->format('Y-m-d')) }}" required>
                                @error('mobilization_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-semibold">Catatan</label>
                                <textarea id="notes" name="notes" rows="4"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Catatan tambahan...">{{ old('notes', $unitRequest->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label fw-semibold">
                                    Lampiran Spesifikasi
                                    <span class="text-muted small">(PDF/DOCX, max 10MB)</span>
                                </label>
                                @if($unitRequest->attachment_path)
                                <div class="alert alert-info d-flex align-items-center py-2 mb-2 small">
                                    <i class="ti ti-file me-2"></i>
                                    Lampiran tersimpan.
                                    <a href="{{ route('unit-requests.attachment', $unitRequest->uid) }}" class="ms-auto text-info" target="_blank">
                                        <i class="ti ti-download me-1"></i>Unduh
                                    </a>
                                </div>
                                @endif
                                <input type="file" id="attachment" name="attachment"
                                    class="form-control @error('attachment') is-invalid @enderror"
                                    accept=".pdf,.doc,.docx">
                                @if($unitRequest->attachment_path)
                                    <small class="text-muted">Upload baru akan menimpa lampiran sebelumnya.</small>
                                @endif
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('unit-requests.show', $unitRequest->uid) }}" class="btn btn-outline-secondary">
                            <i class="ti ti-x me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const requestDate = document.getElementById('request_date');
    const mobilizationDate = document.getElementById('mobilization_date');

    requestDate.addEventListener('change', function() {
        mobilizationDate.min = this.value;
        if (mobilizationDate.value && mobilizationDate.value < this.value) {
            mobilizationDate.value = this.value;
        }
    });

    if (requestDate.value) {
        mobilizationDate.min = requestDate.value;
    }
});
</script>
@endpush
