@extends('layout.mainlayout')
@section('title', 'Unit Request - ' . $unitRequest->request_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    Unit Request
                    <span class="badge bg-{{ $unitRequest->status->color() }}-subtle text-{{ $unitRequest->status->color() }} ms-2 fs-6 align-middle">
                        {{ $unitRequest->status->label() }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-requests.index') }}">Unit Requests</a></li>
                        <li class="breadcrumb-item active">{{ $unitRequest->request_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                {{-- Edit --}}
                @if($unitRequest->isEditable())
                <a href="{{ route('unit-requests.edit', $unitRequest->uid) }}" class="btn btn-warning btn-label">
                    <i class="ti ti-edit label-icon align-middle fs-16 me-2"></i>Edit
                </a>
                @endif

                {{-- Submit --}}
                @if($unitRequest->canSubmit())
                <form action="{{ route('unit-requests.submit', $unitRequest->uid) }}" method="POST" class="d-inline" id="form-submit-approval">
                    @csrf
                    <button type="button" class="btn btn-primary btn-label btn-confirm-submit" 
                        data-title="Submit for Approval?" 
                        data-text="Are you sure you want to submit this request for approval?">
                        <i class="ti ti-send label-icon align-middle fs-16 me-2"></i>Submit for Approval
                    </button>
                </form>
                @endif

                {{-- Forward to Workshop --}}
                @if($unitRequest->canForward())
                <form action="{{ route('unit-requests.forward', $unitRequest->uid) }}" method="POST" class="d-inline" id="form-forward-workshop">
                    @csrf
                    <button type="button" class="btn btn-info btn-label text-white btn-confirm-submit"
                        data-title="Forward to Workshop?"
                        data-text="Are you sure you want to forward this request to the workshop?">
                        <i class="ti ti-arrow-right label-icon align-middle fs-16 me-2"></i>Forward to Workshop
                    </button>
                </form>
                @endif

                {{-- Attachment Download --}}
                @if($unitRequest->attachment_path)
                <a href="{{ route('unit-requests.attachment', $unitRequest->uid) }}" class="btn btn-outline-secondary btn-label">
                    <i class="ti ti-download label-icon align-middle fs-16 me-2"></i>Attachment
                </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Left: Request Info + Items -->
            <div class="col-lg-8">
                <!-- Request Info Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-info-circle me-2 text-primary"></i>Request Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Request Number</label>
                                <p class="fw-semibold mb-0">{{ $unitRequest->request_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Project</label>
                                <p class="fw-semibold mb-0">{{ $unitRequest->project->project_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Request Date</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->request_date ? $unitRequest->request_date->format('d F Y') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Mobilization Date</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->mobilization_date ? $unitRequest->mobilization_date->format('d F Y') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Negotiation</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->negotiation->negotiation_number ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Quotation</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->quotation->quotation_number ?? '-' }}
                                </p>
                            </div>
                            @if($unitRequest->notes)
                            <div class="col-12">
                                <label class="form-label text-muted small mb-1">Notes</label>
                                <p class="mb-0">{{ $unitRequest->notes }}</p>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Created By</label>
                                <p class="fw-semibold mb-0">{{ $unitRequest->creator->name ?? '-' }}</p>
                            </div>
                            @if($unitRequest->approved_at)
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Approved By</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->approver->name ?? '-' }}
                                    <small class="text-muted d-block">{{ $unitRequest->approved_at->format('d M Y, H:i') }}</small>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Unit Items Table -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-list me-2 text-primary"></i>Unit Request Items</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width:40px">#</th>
                                        <th>Unit Name</th>
                                        <th class="text-center" style="width:80px">Qty</th>
                                        <th class="text-center" style="width:100px">Duration (Days)</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitRequest->items as $idx => $item)
                                    <tr>
                                        <td class="text-center">{{ $idx + 1 }}</td>
                                        <td>{{ $item->unit_name }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-center">{{ $item->duration_days ?? '-' }}</td>
                                        <td>{{ $item->remarks ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No items.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Approval Actions + History -->
            <div class="col-lg-4">
                {{-- Approval Panel (show only when SUBMITTED) --}}
                @if($unitRequest->status->value === 'SUBMITTED' && $isApprover)
                <div class="card border border-warning mb-3">
                    <div class="card-header bg-warning-subtle">
                        <h5 class="card-title mb-0 text-warning">
                            <i class="ti ti-thumb-up me-2"></i>Approval Action
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Review the unit request and record your decision.</p>
                        <form action="{{ route('unit-requests.approve', $unitRequest->uid) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Decision <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="decision"
                                            id="decisionApproved" value="approved" required>
                                        <label class="form-check-label text-success" for="decisionApproved">
                                            <i class="ti ti-circle-check me-1"></i>Approve
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="decision"
                                            id="decisionRejected" value="rejected">
                                        <label class="form-check-label text-danger" for="decisionRejected">
                                            <i class="ti ti-circle-x me-1"></i>Reject
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="remarks" class="form-label fw-semibold">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control" rows="3"
                                    placeholder="Optional remarks..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-send me-2"></i>Submit Decision
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Approval History -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-history me-2 text-primary"></i>Approval History</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($unitRequest->approvals->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="ti ti-clock fs-3 d-block mb-2"></i>
                            No approval records yet.
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Level</th>
                                        <th>Approver</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unitRequest->approvals as $approval)
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">L{{ $approval->level }}</span>
                                        </td>
                                        <td>
                                            @if($approval->approver_id)
                                                {{ $approval->approver->name }}
                                            @else
                                                @php
                                                    $levelDef = $flowLevels[$approval->level] ?? null;
                                                    $target = 'Pending';
                                                    if ($levelDef) {
                                                        if ($levelDef->approver_type->value === 'USER') {
                                                            $target = $levelDef->user->name ?? 'User';
                                                        } elseif ($levelDef->approver_type->value === 'ROLE') {
                                                            // For simplicity show the role name if we can resolve it, 
                                                            // or just show "Role: ID" or similar.
                                                            // Assuming we can get role from service or helper.
                                                            $role = \Spatie\Permission\Models\Role::find($levelDef->approver_role_id);
                                                            $target = $role ? $role->name : 'Role';
                                                        }
                                                    }
                                                @endphp
                                                <span class="text-muted">{{ $target }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badgeColor = match($approval->status) {
                                                    'approved' => 'success',
                                                    'rejected' => 'danger',
                                                    default    => 'warning',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} text-capitalize">
                                                {{ $approval->status }}
                                            </span>
                                        </td>
                                        <td class="small text-muted">
                                            {{ $approval->approved_at ? $approval->approved_at->format('d M Y') : '-' }}
                                        </td>
                                    </tr>
                                    @if($approval->remarks)
                                    <tr class="table-light">
                                        <td colspan="4" class="small text-muted fst-italic ps-4">
                                            <i class="ti ti-message me-1"></i>{{ $approval->remarks }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-confirm-submit').on('click', function() {
        const button = $(this);
        const form = button.closest('form');
        const title = button.data('title') || 'Are you sure?';
        const text = button.data('text') || "You won't be able to revert this!";

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@endsection

