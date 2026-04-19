<?php $page = 'unit-returns'; ?>
@extends('layout.mainlayout')
@section('title', 'PPU ' . $unitReturn->ppu_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">{{ $unitReturn->ppu_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-returns.index') }}">Unit Returns</a></li>
                        <li class="breadcrumb-item active">{{ $unitReturn->ppu_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-returns.index') }}" class="btn btn-light d-flex align-items-center">
                    <i class="ti ti-arrow-left me-1"></i>Back to List
                </a>
                @if($unitReturn->attachment_path)
                <a href="{{ route('unit-returns.attachment', $unitReturn->uid) }}" class="btn btn-outline-info d-flex align-items-center">
                    <i class="ti ti-download me-1"></i>Download Attachment
                </a>
                @endif
            </div>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="row">
            <!-- Summary Sidebar -->
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h5 class="mb-0">PPU Summary</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Status</label>
                            <span class="badge bg-{{ $unitReturn->status->color() }} fs-13">{{ $unitReturn->status->label() }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">PPU Number</label>
                            <span class="fw-bold">{{ $unitReturn->ppu_number }}</span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="text-muted d-block small mb-1">Return Date</label>
                                <span class="fw-bold">{{ $unitReturn->return_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="col-6">
                                <label class="text-muted d-block small mb-1">Demob Date</label>
                                <span class="fw-bold">{{ $unitReturn->demobilization_date ? $unitReturn->demobilization_date->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-2">
                            <label class="text-muted d-block small mb-1">Created By</label>
                            <h6 class="mb-0 fs-13">{{ $unitReturn->creator->name ?? 'Unknown' }}</h6>
                            <span class="text-muted small">{{ $unitReturn->created_at->format('d M Y H:i') }}</span>
                        </div>
                        @if($unitReturn->approved_by)
                        <div class="mt-3">
                            <label class="text-muted d-block small mb-1">Approved By</label>
                            <h6 class="mb-0 fs-13">{{ $unitReturn->approver->name ?? 'Unknown' }}</h6>
                            <span class="text-muted small">{{ $unitReturn->approved_at ? $unitReturn->approved_at->format('d M Y H:i') : '' }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Project</h6></div>
                    <div class="card-body">
                        <label class="text-muted d-block small mb-1">Project Name</label>
                        <p class="fw-bold mb-2">{{ $unitReturn->project->project_name ?? '-' }}</p>
                        <label class="text-muted d-block small mb-1">Project Number</label>
                        <p class="fw-bold mb-0">{{ $unitReturn->project->project_number ?? '-' }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Actions</h6></div>
                    <div class="card-body d-grid gap-2">
                        @if($unitReturn->canEdit())
                        <a href="{{ route('unit-returns.edit', $unitReturn->uid) }}" class="btn btn-outline-secondary">
                            <i class="ti ti-edit me-1"></i> Edit PPU
                        </a>
                        @endif
                        @if($unitReturn->canSubmit())
                        <form action="{{ route('unit-returns.submit', $unitReturn->uid) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info w-100"><i class="ti ti-send me-1"></i> Submit for Approval</button>
                        </form>
                        @endif
                        @if($unitReturn->canApprove())
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="ti ti-circle-check me-1"></i> Approve / Reject
                        </button>
                        @endif
                        @if($unitReturn->canComplete())
                        <form action="{{ route('unit-returns.complete', $unitReturn->uid) }}" method="POST"
                            onsubmit="return confirm('Mark this PPU as completed?')">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100"><i class="ti ti-flag-check me-1"></i> Mark as Completed</button>
                        </form>
                        @endif
                        @if($unitReturn->status->value === 'DRAFT')
                        <form action="{{ route('unit-returns.destroy', $unitReturn->uid) }}" method="POST"
                            onsubmit="return confirm('Delete this PPU?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"><i class="ti ti-trash me-1"></i> Delete</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-header bg-light-200"><h5 class="mb-0">Return Items</h5></div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Project Unit ID</th>
                                        <th>Equipment ID</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitReturn->items as $i => $item)
                                    <tr>
                                        <td class="text-muted small">{{ $i + 1 }}</td>
                                        <td><span class="fw-medium text-danger">{{ $item->project_unit_id }}</span></td>
                                        <td><span class="fw-medium text-primary">{{ $item->equipment_id }}</span></td>
                                        <td class="text-muted small">{{ $item->notes ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No items found.</td></tr>
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

<!-- Modal Approval -->
@if($unitReturn->canApprove())
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('unit-returns.approve', $unitReturn->uid) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve / Reject PPU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Decision <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" value="approve" required>
                                <label class="form-check-label text-success fw-bold">Approve</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" value="reject">
                                <label class="form-check-label text-danger fw-bold">Reject</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" rows="3" class="form-control" placeholder="Optional remarks..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
