@extends('layout.mainlayout')
@section('title', 'Quotation Detail')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Quotation Details</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quotations.index') }}">Quotations</a></li>
                        <li class="breadcrumb-item active">View Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('quotations.pdf', $quotation->uid) }}" target="_blank" class="btn btn-soft-danger btn-label">
                    <i class="ri-file-pdf-fill label-icon align-middle fs-16 me-2"></i> Print PDF
                </a>
                @if(!$quotation->isLocked())
                <a href="{{ route('quotations.edit', $quotation->uid) }}" class="btn btn-warning btn-label">
                    <i class="ri-edit-line label-icon align-middle fs-16 me-2"></i> Edit
                </a>
                @endif
                <a href="{{ route('quotations.index') }}" class="btn btn-light btn-label">
                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="card overflow-hidden shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="p-4 bg-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="text-white mb-1">QUOTATION #{{ strtoupper(substr($quotation->uid, 0, 8)) }}</h4>
                                    <p class="mb-0 opacity-75">Created on {{ $quotation->created_at->format('d M, Y') }}</p>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    @php
                                        $statusClass = match($quotation->status) {
                                            'DRAFT' => 'bg-secondary',
                                            'SUBMITTED' => 'bg-warning text-dark',
                                            'APPROVED' => 'bg-success',
                                            'SENT' => 'bg-info',
                                            'REVISION_REQUIRED' => 'bg-danger',
                                            default => 'bg-light text-muted'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} fs-14 text-uppercase p-2 shadow-sm">{{ str_replace('_', ' ', $quotation->status) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4">
                            <!-- Project Information -->
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Project Information</h6>
                                    <h5 class="mb-1 text-primary">{{ $quotation->project->project_name ?? 'N/A' }}</h5>
                                    <p class="text-muted mb-2"><i class="ri-hashtag me-1"></i> {{ $quotation->project->project_number ?? 'N/A' }}</p>
                                    @if($quotation->project->location)
                                    <p class="text-muted mb-0"><i class="ri-map-pin-line me-1"></i> {{ $quotation->project->location }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6 text-md-end mt-4 mt-md-0">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Client Relationship</h6>
                                    <p class="mb-1 fw-medium text-dark">Sinar Solo Barokah (SSB)</p>
                                    <p class="text-muted small">Quotation Valid Until:<br><span class="text-dark">{{ $quotation->valid_until ? $quotation->valid_until->format('d M, Y') : 'N/A' }}</span></p>
                                </div>
                            </div>

                            <!-- Items Table -->
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Unit Selection & Rate Breakdown</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-nowrap align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 40%;">Unit / Equipment</th>
                                            <th scope="col" class="text-end">Rate (Rp)</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">Duration</th>
                                            <th scope="col" class="text-end">Total (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quotation->items as $item)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $item->unit_name }}</div>
                                            </td>
                                            <td class="text-end">Rp {{ number_format($item->rate, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-center">{{ $item->duration }}</td>
                                            <td class="text-end fw-semibold">Rp {{ number_format($item->rate * $item->quantity * $item->duration, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="4" class="text-end fw-bold">Total Project Value</td>
                                            <td class="text-end fw-bold fs-16 text-primary">Rp {{ number_format($quotation->selling_price, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Terms and Conditions -->
                            @if($quotation->terms_conditions)
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="text-muted text-uppercase fw-semibold mb-2 fs-11">Terms & Conditions</h6>
                                <p class="text-muted mb-0" style="white-space: pre-wrap;">{{ $quotation->terms_conditions }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Approval History Timeline -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white border-bottom-dashed d-flex align-items-center">
                        <i class="ri-history-line fs-18 text-primary me-2"></i>
                        <h5 class="card-title mb-0 flex-grow-1">Approval History</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="acitivity-timeline">
                            @forelse($quotation->approvals as $approval)
                            <div class="acitivity-item d-flex mb-4">
                                <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                    <div class="avatar-title rounded-circle {{ $approval->decision->value === 'APPROVED' ? 'bg-success' : ($approval->decision->value === 'REJECTED' ? 'bg-danger' : 'bg-warning') }} text-white">
                                        <i class="{{ $approval->decision->value === 'APPROVED' ? 'ri-check-line' : ($approval->decision->value === 'REJECTED' ? 'ri-close-line' : 'ri-edit-line') }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <h6 class="mb-0">{{ $approval->decision->label() }} - Level {{ $approval->level }}</h6>
                                        <span class="text-muted small">{{ $approval->decided_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <p class="text-muted mb-1">By <span class="fw-medium text-dark">{{ $approval->approver->name }}</span></p>
                                    @if($approval->notes)
                                    <div class="p-2 bg-light rounded mt-2">
                                        <p class="text-muted mb-0 small">"{{ $approval->notes }}"</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <div class="avatar-md mx-auto mb-3">
                                    <div class="avatar-title bg-light text-muted rounded-circle fs-24">
                                        <i class="ri-history-line"></i>
                                    </div>
                                </div>
                                <h6 class="text-muted">No approval history found.</h6>
                                <p class="text-muted small mb-0">Once the quota is submitted, the history will appear here.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <!-- Financial Analysis Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom-dashed">
                        <h5 class="card-title mb-0">Financial Analysis</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted mb-1">Total HPP</label>
                            <h6>Rp {{ number_format($quotation->budget->total_hpp ?? 0, 0, ',', '.') }}</h6>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted mb-1">Profit Margin (%)</label>
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">{{ $quotation->profit_margin_percent }}%</h6>
                                <span class="badge {{ $quotation->profit_margin_percent >= 20 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} ms-2">
                                    {{ $quotation->profit_margin_percent >= 20 ? 'Optimal' : 'Standard' }}
                                </span>
                            </div>
                        </div>
                        <div class="pt-3 border-top border-top-dashed">
                            <label class="text-muted mb-1">Target Selling Price</label>
                            <h5 class="text-primary">Rp {{ number_format($quotation->selling_price, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Actions if Draft -->
                @if($quotation->status === 'DRAFT' || $quotation->status === 'REVISION_REQUIRED')
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="avatar-md mx-auto mb-3">
                            <div class="avatar-title bg-info-subtle text-info rounded-circle fs-24">
                                <i class="ri-send-plane-fill"></i>
                            </div>
                        </div>
                        <h5 class="card-title mb-2">Submit Order</h5>
                        <p class="text-muted small mb-4">Ready to proceed? Submit this quotation to start the formal approval process.</p>
                        <form action="{{ route('quotations.submit', $quotation->uid) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 btn-label rounded-pill">
                                <i class="ri-send-plane-fill label-icon align-middle fs-16 me-2"></i> Submit for Approval
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Approval Actions if Pending -->
                @if($quotation->status === 'SUBMITTED')
                <div class="card shadow-sm border-0 border-top border-4 border-warning">
                    <div class="card-body p-4 text-center">
                        <div class="avatar-md mx-auto mb-3">
                            <div class="avatar-title bg-warning-subtle text-warning rounded-circle fs-24">
                                <i class="ri-shield-user-line"></i>
                            </div>
                        </div>
                        <h5 class="card-title mb-1">Pending Approval</h5>
                        <p class="text-muted small mb-0">Current Level: <strong>Level {{ $quotation->current_approval_level }}</strong></p>
                        @if($currentApprover)
                        <p class="text-muted small">Current Approver: <strong class="text-primary">{{ $currentApprover }}</strong></p>
                        @endif

                        @if($canApprove)
                        <form action="{{ route('quotations.approve', $quotation->uid) }}" method="POST" class="text-start mt-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small text-muted">Approval Notes</label>
                                <textarea name="notes" class="form-control border-light" rows="3" placeholder="Add your comments here..."></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="decision" value="APPROVED" class="btn btn-success btn-label">
                                    <i class="ri-check-line label-icon align-middle fs-16 me-2"></i> Approve
                                </button>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button type="submit" name="decision" value="REVISION" class="btn btn-soft-warning w-100">
                                            <i class="ri-edit-line me-1"></i> Revision
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="decision" value="REJECTED" class="btn btn-soft-danger w-100">
                                            <i class="ri-close-line me-1"></i> Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-info border-0 rounded-pill mb-0 mt-3 p-2 small">
                            <i class="ri-information-line me-1"></i> You are not an authorized approver for this level.
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
