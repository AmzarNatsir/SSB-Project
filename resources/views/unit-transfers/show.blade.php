<?php $page = 'unit-transfers'; ?>
@extends('layout.mainlayout')
@section('title', 'UT ' . $unitTransfer->transfer_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">{{ $unitTransfer->transfer_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-transfers.index') }}">Unit Transfers</a></li>
                        <li class="breadcrumb-item active">{{ $unitTransfer->transfer_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-transfers.index') }}" class="btn btn-light d-flex align-items-center">
                    <i class="ti ti-arrow-left me-1"></i>Back to List
                </a>
                @if($unitTransfer->attachment_path)
                <a href="{{ route('unit-transfers.attachment', $unitTransfer->uid) }}" class="btn btn-outline-info d-flex align-items-center">
                    <i class="ti ti-download me-1"></i>Download Attachment
                </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="row">
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h5 class="mb-0">UT Summary</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Status</label>
                            <span class="badge bg-{{ $unitTransfer->status->color() }} fs-13">{{ $unitTransfer->status->label() }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">UT Number</label>
                            <span class="fw-bold">{{ $unitTransfer->transfer_number }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Transfer Date</label>
                            <span class="fw-bold">{{ $unitTransfer->transfer_date->format('d/m/Y') }}</span>
                        </div>
                        <hr>
                        <div class="mb-2">
                            <label class="text-muted d-block small mb-1">Created By</label>
                            <h6 class="mb-0 fs-13">{{ $unitTransfer->creator->name ?? 'Unknown' }}</h6>
                            <span class="text-muted small">{{ $unitTransfer->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Project Asal</h6></div>
                    <div class="card-body">
                        <label class="text-muted d-block small mb-1">Project</label>
                        <p class="fw-bold mb-2">{{ $unitTransfer->sourceProject->project_name ?? '-' }}</p>
                        <label class="text-muted d-block small mb-1">Nomor Project</label>
                        <p class="fw-bold mb-2">{{ $unitTransfer->sourceProject->project_number ?? '-' }}</p>
                        <label class="text-muted d-block small mb-1">Unit Request (UR)</label>
                        <p class="fw-bold mb-0">{{ $unitTransfer->sourceUnitRequest?->request_number ?? '-' }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Project Tujuan</h6></div>
                    <div class="card-body">
                        <label class="text-muted d-block small mb-1">Project</label>
                        <p class="fw-bold mb-2">{{ $unitTransfer->destinationProject->project_name ?? '-' }}</p>
                        <label class="text-muted d-block small mb-1">Nomor Project</label>
                        <p class="fw-bold mb-2">{{ $unitTransfer->destinationProject->project_number ?? '-' }}</p>
                        <label class="text-muted d-block small mb-1">Lokasi</label>
                        <p class="fw-bold mb-0">{{ $unitTransfer->destinationProject->project_location ?? '-' }}</p>
                        @if($unitTransfer->notes)
                        <hr>
                        <label class="text-muted d-block small mb-1">Catatan</label>
                        <p class="mb-0 small">{{ $unitTransfer->notes }}</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Actions</h6></div>
                    <div class="card-body d-grid gap-2">
                        @if($unitTransfer->canEdit())
                        <a href="{{ route('unit-transfers.edit', $unitTransfer->uid) }}" class="btn btn-outline-secondary">
                            <i class="ti ti-edit me-1"></i> Edit UT
                        </a>
                        @endif
                        @if($unitTransfer->canComplete())
                        <form id="completeUtForm" action="{{ route('unit-transfers.complete', $unitTransfer->uid) }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-primary w-100" onclick="confirmCompleteUt()"><i class="ti ti-flag-check me-1"></i> Selesaikan Transfer</button>
                        </form>
                        @endif
                        @if($unitTransfer->status->value === 'DRAFT')
                        <form id="deleteUtForm" action="{{ route('unit-transfers.destroy', $unitTransfer->uid) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-outline-danger w-100" onclick="confirmDeleteUt()"><i class="ti ti-trash me-1"></i> Delete</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-7">
                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h5 class="mb-0">Transfer Items</h5></div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:40px">#</th>
                                        <th>Unit</th>
                                        <th style="width:120px">Qty</th>
                                        <th>Driver/Operator</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitTransfer->items as $i => $item)
                                    <tr>
                                        <td class="text-muted small">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="fw-medium">{{ $item->unit_name }}</div>
                                            @if($item->equipment_code)
                                                <small class="text-muted">{{ $item->equipment_code }}</small>
                                            @endif
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($item->qty, 2, '.', ''), '0'), '.') }}</td>
                                        <td>{{ $item->operator_name ?: '-' }}</td>
                                        <td class="text-muted small">{{ $item->notes ?: '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-4 text-muted">No items found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function confirmCompleteUt() {
    Swal.fire({
        title: 'Selesaikan Transfer?',
        text: 'Unit akan ditandai sebagai sudah ditransfer ke project tujuan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, selesaikan',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('completeUtForm').submit();
        }
    });
}

function confirmDeleteUt() {
    Swal.fire({
        title: 'Hapus UT ini?',
        text: 'Tindakan ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteUtForm').submit();
        }
    });
}
</script>
@endpush
@endsection
