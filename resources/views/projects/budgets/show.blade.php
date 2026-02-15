@extends('layout.mainlayout')
@section('content')

<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h3 class="page-title mb-0">Budget Details</h3>
                    <span class="badge bg-{{ $budget->status->color() }}-transparent fs-12">{{ $budget->status->label() }}</span>
                    @if($budget->isLocked())
                        <span class="badge bg-danger-transparent fs-12"><i class="ti ti-lock me-1"></i>Locked</span>
                    @endif
                </div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('budgets.index') }}">Budgets</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $budget->project->project_number }} (v{{ $budget->version }})</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                @if(!$budget->isLocked())
                    <a href="{{ route('budgets.edit', $budget) }}" class="btn btn-warning btn-sm d-flex align-items-center">
                        <i class="ti ti-edit me-1"></i>Edit
                    </a>
                @endif
                
                @if($budget->status == \App\Enums\BudgetStatus::DRAFT || $budget->status == \App\Enums\BudgetStatus::REVISION_REQUIRED)
                    <form action="{{ route('budgets.submit', $budget) }}" method="POST" class="d-inline ajax-action-form">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm d-flex align-items-center">
                            <i class="ti ti-send me-1"></i>Submit
                        </button>
                    </form>
                @endif

                @can('approve', $budget)
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="ti ti-check me-1"></i>Approve
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item text-success approve-btn" href="#" data-decision="APPROVED"><i class="ti ti-circle-check me-2"></i>Approve</a></li>
                        <li><a class="dropdown-item text-warning approve-btn" href="#" data-decision="REVISION"><i class="ti ti-refresh me-2"></i>Request Revision</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger approve-btn" href="#" data-decision="REJECTED"><i class="ti ti-circle-x me-2"></i>Reject</a></li>
                    </ul>
                </div>
                @endcan

                @if($budget->isLocked())
                    <button class="btn btn-outline-secondary btn-sm d-flex align-items-center revise-btn">
                        <i class="ti ti-copy me-1"></i>Revise
                    </button>
                @endif
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Financial Metric Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 bg-primary-transparent overflow-hidden">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fw-medium fs-13">Total HPP (COGS)</p>
                                <h4 class="mb-0 fw-bold">Rp {{ number_format($budget->total_hpp, 0, ',', '.') }}</h4>
                            </div>
                            <div class="bg-primary text-white p-2 rounded">
                                <i class="ti ti-calculator fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-success-transparent overflow-hidden">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fw-medium fs-13">Profit Margin ({{ $budget->profit_margin_percent }}%)</p>
                                <h4 class="mb-0 fw-bold text-success">Rp {{ number_format($budget->selling_price - $budget->total_hpp, 0, ',', '.') }}</h4>
                            </div>
                            <div class="bg-success text-white p-2 rounded">
                                <i class="ti ti-chart-pie fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-info-transparent overflow-hidden">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fw-medium fs-13">Selling Price</p>
                                <h4 class="mb-0 fw-bold text-info">Rp {{ number_format($budget->selling_price, 0, ',', '.') }}</h4>
                            </div>
                            <div class="bg-info text-white p-2 rounded">
                                <i class="ti ti-currency-dollar fs-20"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Financial Metric Cards -->

        <div class="row">
            <div class="col-md-4">
                 <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title mb-0 d-flex align-items-center">
                            <i class="ti ti-info-circle me-2 text-primary"></i>Project Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-2 border-0">
                                <span class="text-muted fs-13 d-block">Project Name</span>
                                <span class="fw-semibold text-dark">{{ $budget->project->project_name ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 py-2 border-0">
                                <span class="text-muted fs-13 d-block">Project Number</span>
                                <span class="fw-semibold text-dark">{{ $budget->project->project_number ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 py-2 border-0">
                                <span class="text-muted fs-13 d-block">Created By</span>
                                <span class="fw-semibold text-dark">{{ $budget->creator->name ?? '-' }}</span>
                            </li>
                            <li class="list-group-item px-0 py-2 border-0">
                                <span class="text-muted fs-13 d-block">Creation Date</span>
                                <span class="fw-semibold text-dark">{{ $budget->created_at->format('d M Y') }}</span>
                            </li>
                        </ul>
                    </div>
                 </div>
            </div>

            <div class="col-md-8">
                 <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 d-flex align-items-center">
                            <i class="ti ti-list-check me-2 text-primary"></i>Cost Items
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill mb-3 p-1 bg-light rounded" role="tablist">
                            @foreach(App\Enums\BudgetCategory::cases() as $category)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }} d-flex align-items-center justify-content-center gap-1 py-2 fs-13" href="#tab_{{ $category->value }}" data-bs-toggle="pill" role="tab">
                                        <i class="ti {{ $category->icon() }} fs-16"></i>
                                        <span class="d-none d-lg-inline">{{ $category->label() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="tab-content pt-2">
                            @foreach(App\Enums\BudgetCategory::cases() as $category)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab_{{ $category->value }}" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover border-top-0">
                                            <thead class="bg-light-500">
                                                <tr>
                                                    <th class="border-0">Item Description</th>
                                                    <th class="text-end border-0">Qty</th>
                                                    <th class="border-0 text-center">Unit</th>
                                                    <th class="text-end border-0">Unit Cost</th>
                                                    <th class="text-end border-0">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="border-0">
                                                @php
                                                    $categoryItems = $budget->items->where('category', $category);
                                                    $categoryTotal = 0;
                                                @endphp
                                                @forelse($categoryItems as $item)
                                                    @php $categoryTotal += $item->total_cost; @endphp
                                                    <tr>
                                                        <td class="fw-medium text-dark">{{ $item->item_name }}</td>
                                                        <td class="text-end">{{ number_format($item->qty, 2) }}</td>
                                                        <td class="text-center"><span class="badge bg-light text-dark border">{{ $item->units }}</span></td>
                                                        <td class="text-end">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                                                        <td class="text-end fw-bold text-primary">Rp {{ number_format($item->total_cost, 0, ',', '.') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-5 text-muted">
                                                            <i class="ti ti-clipboard-x fs-32 mb-2 d-block opacity-50"></i>
                                                            No items found for this category
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            @if($categoryItems->count() > 0)
                                            <tfoot class="bg-light-500">
                                                <tr>
                                                    <th colspan="4" class="text-end border-0 px-3 py-2">Subtotal:</th>
                                                    <th class="text-end border-0 px-3 py-2 fs-15 text-primary">Rp {{ number_format($categoryTotal, 0, ',', '.') }}</th>
                                                </tr>
                                            </tfoot>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 d-flex align-items-center">
                            <i class="ti ti-history me-2 text-primary"></i>Approval Matrix & History
                        </h5>
                        @php
                            $flowService = app(\App\Services\ApprovalFlowService::class);
                            $levels = $flowService->getLevels('PROJECT_BUDGET');
                        @endphp
                        @if($levels->count() > 0)
                            <span class="badge bg-primary-transparent">Configured: {{ $levels->count() }} Levels</span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                         <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Level</th>
                                        <th>Configured Approver</th>
                                        <th>Status / Decision</th>
                                        <th>Date & Time</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $approvals = $budget->approvals->keyBy('level');
                                    @endphp
                                    @forelse($levels as $level)
                                        @php
                                            $approval = $approvals->get($level->level_number);
                                            $isCurrent = $budget->current_approval_level == $level->level_number;
                                            $approver = $flowService->resolveApprover($level);
                                        @endphp
                                        <tr class="align-middle {{ $isCurrent ? 'bg-primary-light-transparent' : '' }}">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    @if($approval)
                                                        <i class="ti ti-circle-check-filled text-success me-2 fs-18"></i>
                                                    @elseif($isCurrent)
                                                        <i class="ti ti-clock-filled text-primary me-2 fs-18"></i>
                                                    @else
                                                        <i class="ti ti-circle text-muted me-2 fs-18"></i>
                                                    @endif
                                                    <span class="fw-bold">Level {{ $level->level_number }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xs me-2">
                                                        <img src="{{ URL::asset('build/img/profiles/avatar-01.jpg') }}" class="rounded-circle" alt="user">
                                                    </div>
                                                    <div>
                                                        <span class="d-block text-dark fw-medium">{{ $approver->name ?? 'Role: ' . ($level->approver_role_id ?: 'Unknown') }}</span>
                                                        <small class="text-muted">{{ $level->approver_type->label() }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($approval)
                                                    @php
                                                        $decisionColor = match($approval->decision->value) {
                                                            'APPROVED' => 'success',
                                                            'REJECTED' => 'danger',
                                                            'REVISION' => 'warning',
                                                            default => 'secondary'
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $decisionColor }}-transparent d-inline-flex align-items-center">
                                                        <i class="ti ti-{{ $approval->decision->value === 'APPROVED' ? 'circle-check' : ($approval->decision->value === 'REJECTED' ? 'circle-x' : 'refresh') }} me-1"></i>
                                                        {{ $approval->decision->value }}
                                                    </span>
                                                @elseif($isCurrent)
                                                    <span class="badge bg-primary-transparent">Pending Action</span>
                                                @else
                                                    <span class="text-muted fs-12">Waiting</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($approval)
                                                    <span class="d-block fw-medium text-dark fs-12">{{ $approval->decided_at->format('d M Y') }}</span>
                                                    <small class="text-muted">{{ $approval->decided_at->format('H:i') }}</small>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-wrap" style="min-width: 200px;">
                                                <p class="mb-0 fs-13">{{ $approval->notes ?? '-' }}</p>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="ti ti-info-circle fs-32 mb-2 d-block opacity-50"></i>
                                                This budget hasn't been through an approval process yet.
                                            </td>
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

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('budgets.approve', $budget) }}" method="POST" id="approvalForm" class="ajax-form">
            @csrf
            <input type="hidden" name="decision" id="approvalDecision">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="approvalText">Are you sure?</p>
                    <div class="mb-3">
                        <label class="form-label">Notes (Optional/Required for Rejection)</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Revision Modal -->
<div class="modal fade" id="revisionModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('budgets.revise', $budget) }}" method="POST" id="revisionForm" class="ajax-form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Revision</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-triangle me-1"></i> Creating a revision will create a new draft version of this budget. The current version will remain locked.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Revision <span class="text-danger">*</span></label>
                        <textarea name="reasons" class="form-control" rows="3" required minlength="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Revision</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Submit budget
        $('.ajax-action-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('button[type="submit"]');
            
             Swal.fire({
                title: 'Are you sure?',
                text: "You can't undo this action",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                     btn.prop('disabled', true);
                     $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            Swal.fire('Success', response.message, 'success').then(() => location.reload());
                        },
                        error: function(xhr) {
                            btn.prop('disabled', false);
                            Swal.fire('Error', xhr.responseJSON?.message || 'Action failed', 'error');
                        }
                    });
                }
            });
        });
        
        // Approval Modal Trigger
        $('.approve-btn').click(function(e) {
            e.preventDefault();
            var decision = $(this).data('decision');
            $('#approvalDecision').val(decision);
            $('#approvalText').text('You are about to submit a decision: ' + decision);
            $('#approvalModal').modal('show');
        });
        
        // Approval Form Submit
        $('#approvalForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
             $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#approvalModal').modal('hide');
                    Swal.fire('Success', response.message, 'success').then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Action failed', 'error');
                }
            });
        });
        
        // Revise Modal
        $('.revise-btn').click(function() {
            $('#revisionModal').modal('show');
        });
        
        // Revision Form Submit
        $('#revisionForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
             $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#revisionModal').modal('hide');
                    Swal.fire('Success', response.message, 'success').then(() => {
                        window.location.href = "/budgets/" + response.data.uid + "/edit";
                    });
                },
                error: function(xhr) {
                     var msg = xhr.responseJSON?.message || 'Action failed';
                     if(xhr.responseJSON?.errors) {
                         msg = Object.values(xhr.responseJSON.errors)[0][0];
                     }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });
</script>
@endpush
@endsection
