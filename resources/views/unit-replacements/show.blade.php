<?php $page = 'unit-replacements'; ?>
@extends('layout.mainlayout')
@section('title', 'PTU ' . $unitReplacement->ptu_number)
@section('content')
<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">{{ $unitReplacement->ptu_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.index') }}">Unit Replacements</a></li>
                        <li class="breadcrumb-item active">{{ $unitReplacement->ptu_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-replacements.index') }}" class="btn btn-light d-flex align-items-center">
                    <i class="ti ti-arrow-left me-1"></i>Back to List
                </a>
                @if($unitReplacement->attachment_path)
                <a href="{{ route('unit-replacements.attachment', $unitReplacement->uid) }}" class="btn btn-outline-info d-flex align-items-center">
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
            <!-- Summary Sidebar -->
            <div class="col-xl-4 col-lg-5 mb-4">

                <!-- Status Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light-200">
                        <h5 class="mb-0">PTU Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Status</label>
                            <span class="badge bg-{{ $unitReplacement->status->color() }} fs-13">
                                {{ $unitReplacement->status->label() }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">PTU Number</label>
                            <span class="fw-bold">{{ $unitReplacement->ptu_number }}</span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="text-muted d-block small mb-1">Replacement Date</label>
                                <span class="fw-bold">{{ $unitReplacement->replacement_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="col-6">
                                <label class="text-muted d-block small mb-1">Mobilization Date</label>
                                <span class="fw-bold">{{ $unitReplacement->mobilization_date ? $unitReplacement->mobilization_date->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                        @if($unitReplacement->replacement_reason)
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Reason</label>
                            <p class="mb-0 small">{{ $unitReplacement->replacement_reason }}</p>
                        </div>
                        @endif
                        <hr>
                        <div class="mb-2">
                            <label class="text-muted d-block small mb-1">Created By</label>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width:26px;height:26px;font-size:11px;">
                                    {{ $unitReplacement->creator ? strtoupper(substr($unitReplacement->creator->name, 0, 1)) : '?' }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fs-13">{{ $unitReplacement->creator->name ?? 'Unknown' }}</h6>
                                    <span class="text-muted" style="font-size:11px;">{{ $unitReplacement->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        @if($unitReplacement->approved_by)
                        <div class="mt-3">
                            <label class="text-muted d-block small mb-1">Approved By</label>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2" style="width:26px;height:26px;font-size:11px;">
                                    {{ $unitReplacement->approver ? strtoupper(substr($unitReplacement->approver->name, 0, 1)) : '?' }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fs-13">{{ $unitReplacement->approver->name ?? 'Unknown' }}</h6>
                                    <span class="text-muted" style="font-size:11px;">{{ $unitReplacement->approved_at ? $unitReplacement->approved_at->format('d M Y H:i') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Project Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light-200">
                        <h6 class="mb-0">Project</h6>
                    </div>
                    <div class="card-body">
                        <label class="text-muted d-block small mb-1">Project Name</label>
                        <p class="fw-bold mb-2">{{ $unitReplacement->project->project_name ?? '-' }}</p>
                        <label class="text-muted d-block small mb-1">Project Number</label>
                        <p class="fw-bold mb-0">{{ $unitReplacement->project->project_number ?? '-' }}</p>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card">
                    <div class="card-header bg-light-200">
                        <h6 class="mb-0">Actions</h6>
                    </div>
                    <div class="card-body d-grid gap-2">
                        @if($unitReplacement->canEdit())
                        <a href="{{ route('unit-replacements.edit', $unitReplacement->uid) }}" class="btn btn-outline-secondary">
                            <i class="ti ti-edit me-1"></i> Edit PTU
                        </a>
                        @endif

                        @if($unitReplacement->canSubmit())
                        <form action="{{ route('unit-replacements.submit', $unitReplacement->uid) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="ti ti-send me-1"></i> Submit for Approval
                            </button>
                        </form>
                        @endif

                        @if($unitReplacement->canApprove())
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="ti ti-circle-check me-1"></i> Approve / Reject
                        </button>
                        @endif

                        @if($unitReplacement->canComplete())
                        <form action="{{ route('unit-replacements.complete', $unitReplacement->uid) }}" method="POST"
                            onsubmit="return confirm('Mark this PTU as completed?')">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-flag-check me-1"></i> Mark as Completed
                            </button>
                        </form>
                        @endif

                        @if($unitReplacement->status->value === 'DRAFT')
                        <form action="{{ route('unit-replacements.destroy', $unitReplacement->uid) }}" method="POST"
                            onsubmit="return confirm('Delete this PTU? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i> Delete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-header bg-light-200">
                        <h5 class="mb-0">Replacement Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Old Unit (Being Replaced)</th>
                                        <th>Replacement Unit</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitReplacement->items as $i => $item)
                                    <tr>
                                        <td class="text-muted small">{{ $i + 1 }}</td>
                                        <td>
                                            <span class="fw-medium text-danger">{{ $item->old_unit_name ?? '-' }}</span>
                                            @if($item->old_unit_id)
                                            <small class="d-block text-muted">ID: {{ $item->old_unit_id }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-medium text-success">{{ $item->replacement_unit_name ?? '-' }}</span>
                                            @if($item->replacement_unit_id)
                                            <small class="d-block text-muted">ID: {{ $item->replacement_unit_id }}</small>
                                            @endif
                                        </td>
                                        <td class="text-muted small">{{ $item->notes ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No items found.</td>
                                    </tr>
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

<!-- Approve / Reject Modal -->
@if($unitReplacement->canApprove())
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('unit-replacements.approve', $unitReplacement->uid) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve / Reject PTU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Decision <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" id="decApprove" value="approve" required>
                                <label class="form-check-label text-success fw-bold" for="decApprove">Approve</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" id="decReject" value="reject">
                                <label class="form-check-label text-danger fw-bold" for="decReject">Reject</label>
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
