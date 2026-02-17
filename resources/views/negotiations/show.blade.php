@extends('layout.mainlayout')
@section('title', 'Negotiation Details')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Negotiation Details</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('negotiations.index') }}">Negotiations</a></li>
                        <li class="breadcrumb-item active">{{ $negotiation->negotiation_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                @if($negotiation->status === \App\Enums\NegotiationStatus::APPROVED)
                <a href="{{ route('negotiations.letter', $negotiation->uid) }}" target="_blank" class="btn btn-outline-danger btn-label">
                    <i class="ri-file-pdf-line label-icon align-middle fs-16 me-2"></i> Download Letter
                </a>
                <!-- Stub for contract creation -->
                <button class="btn btn-success btn-label" disabled>
                     <i class="ri-file-shield-2-line label-icon align-middle fs-16 me-2"></i> Contract Created
                </button>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <!-- Negotiation Timeline -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Negotiation History</h4>
                    </div>
                    <div class="card-body">
                        <div class="acitivity-timeline py-3">
                            <!-- Initial Quote -->
                            <div class="acitivity-item d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs acitivity-avatar">
                                        <div class="avatar-title rounded-circle bg-secondary-subtle text-secondary">
                                            <i class="ri-file-list-3-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Initial Quotation Submitted</h6>
                                    <p class="text-muted mb-2">Quotation #{{ substr($negotiation->quotation->uid, 0, 8) }}</p>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="badge bg-light text-body border border-dashed p-2 text-start">
                                            <span class="text-muted fs-11">Company Offer</span>
                                            <h6 class="mb-0 fs-13">Rp {{ number_format($negotiation->quotation->selling_price, 0, ',', '.') }}</h6>
                                        </div>
                                    </div>
                                    <small class="mb-0 text-muted">{{ $negotiation->quotation->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>

                            <!-- Rounds -->
                            @foreach($negotiation->rounds as $round)
                            <div class="acitivity-item py-3 d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs acitivity-avatar">
                                        <div class="avatar-title rounded-circle bg-info-subtle text-info">
                                            {{ $round->round_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Round {{ $round->round_number }} Negotiation</h6>
                                    <p class="text-muted mb-2">Meeting on {{ $round->meeting_date->format('d M Y') }}</p>
                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-6">
                                            <div class="badge bg-danger-subtle text-danger border border-danger-subtle p-2 text-start w-100">
                                                <span class="fs-11 text-uppercase">Client Offer</span>
                                                <h6 class="mb-0 fs-14">Rp {{ number_format($round->client_offer_value, 0, ',', '.') }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="badge bg-success-subtle text-success border border-success-subtle p-2 text-start w-100">
                                                <span class="fs-11 text-uppercase">Company Counter</span>
                                                <h6 class="mb-0 fs-14">Rp {{ number_format($round->company_counter_offer, 0, ',', '.') }}</h6>
                                            </div>
                                        </div>
                                    </div>

                                    @if($round->summary_notes)
                                    <div class="alert alert-light border-0 mb-2">
                                        <strong>Notes:</strong> {{ $round->summary_notes }}
                                    </div>
                                    @endif
                                    
                                    @if($round->attachment_path)
                                    <a href="{{ asset('storage/' . $round->attachment_path) }}" target="_blank" class="btn btn-sm btn-soft-primary">
                                        <i class="ri-attachment-line me-1"></i> View Attachment
                                    </a>
                                    @endif
                                    
                                    <div class="mt-2">
                                        <small class="text-muted">Recorded by {{ $round->creator->name }} on {{ $round->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- Final Status -->
                             <div class="acitivity-item py-3 d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs acitivity-avatar">
                                        <div class="avatar-title rounded-circle bg-{{ $negotiation->status->color() }}-subtle text-{{ $negotiation->status->color() }}">
                                            <i class="ri-flag-2-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Current Status: <span class="text-{{ $negotiation->status->color() }}">{{ $negotiation->status->label() }}</span></h6>
                                    @if($negotiation->status === \App\Enums\NegotiationStatus::APPROVED)
                                        <p class="text-muted">Final Agreed Price: <strong>Rp {{ number_format($negotiation->final_agreed_value, 0, ',', '.') }}</strong></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approval History Timeline -->
                @if($negotiation->approvals->count() > 0)
                <div class="card">
                    <div class="card-header bg-white border-bottom-dashed d-flex align-items-center">
                        <i class="ri-history-line fs-18 text-primary me-2"></i>
                        <h5 class="card-title mb-0 flex-grow-1">Approval History</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="acitivity-timeline">
                            @foreach($negotiation->approvals as $approval)
                            <div class="acitivity-item d-flex mb-4">
                                <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                    <div class="avatar-title rounded-circle {{ $approval->status === 'APPROVED' ? 'bg-success' : ($approval->status === 'REJECTED' ? 'bg-danger' : 'bg-warning') }} text-white">
                                        <i class="{{ $approval->status === 'APPROVED' ? 'ri-check-line' : ($approval->status === 'REJECTED' ? 'ri-close-line' : 'ri-edit-line') }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <h6 class="mb-0">
                                            @if($approval->status === 'APPROVED') Approved @elseif($approval->status === 'REJECTED') Rejected @else Revision Requested @endif - Level {{ $approval->level }}
                                        </h6>
                                        <span class="text-muted small">{{ $approval->decided_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <p class="text-muted mb-1">By <span class="fw-medium text-dark">{{ $approval->approver->name }}</span></p>
                                    @if($approval->remarks)
                                    <div class="p-2 bg-light rounded mt-2">
                                        <p class="text-muted mb-0 small">"{{ $approval->remarks }}"</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-xl-4">
                <!-- Overview Card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Project Details</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="ri-building-line text-muted fs-24"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1">{{ $negotiation->project->project_name }}</h6>
                                <p class="text-muted mb-0">{{ $negotiation->project->project_number }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ri-user-line text-muted fs-24"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1">Client</h6>
                                <p class="text-muted mb-0">{{ $negotiation->project->customer_name ?? 'Unknown Client' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Round Form -->
                @if($negotiation->canAddRound())
                <div class="card border-primary border-top border-3 border-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Record Negotiation Round</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('negotiations.update', $negotiation->uid) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label">Client Offer (Rp)</label>
                                <input type="text" name="client_offer_value" class="form-control currency-input" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Company Counter Offer (Rp)</label>
                                <input type="text" name="company_counter_offer" class="form-control currency-input" required>
                                <div class="form-text">Previous Latest: Rp {{ number_format($negotiation->company_offer_value, 0, ',', '.') }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Meeting Date</label>
                                <input type="date" name="meeting_date" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Summary / Notes</label>
                                <textarea name="summary_notes" class="form-control" rows="3"></textarea>
                            </div>
                             
                            <div class="mb-3">
                                <label class="form-label">Supporting Document (PDF/Image)</label>
                                <input type="file" name="attachment" class="form-control">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Save Round</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                @if($negotiation->rounds->count() > 0)
                <div class="card bg-light border-0">
                    <div class="card-body">
                         <form action="{{ route('negotiations.submit', $negotiation->uid) }}" method="POST">
                            @csrf
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">Submit for Approval</button>
                            </div>
                            <p class="text-muted small mt-2 text-center mb-0">Once submitted, you cannot add more rounds until approved or revised.</p>
                        </form>
                    </div>
                </div>
                @endif
                
                @endif
                
                <!-- Approval Status & Actions -->
                @if($negotiation->status === \App\Enums\NegotiationStatus::SUBMITTED)
                <div class="card border-warning border-top border-3 border-0">
                    <div class="card-header bg-warning-subtle">
                        <h5 class="card-title mb-0 text-warning-emphasis">
                            <i class="ri-shield-user-line me-1"></i> Approval Required (Level {{ $negotiation->current_approval_level }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-xs">
                                    <div class="avatar-title rounded-circle bg-warning-subtle text-warning">
                                        <i class="ri-user-star-line"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1">Current Approver</h6>
                                <p class="text-muted mb-0 fw-medium">{{ $approverName }}</p>
                            </div>
                        </div>
                        
                        @if($isApprover)
                        <form action="{{ route('negotiations.approve', $negotiation->uid) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Remarks / Notes</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="decision" value="APPROVED" class="btn btn-success">
                                    <i class="ri-check-line align-bottom me-1"></i> Approve
                                </button>
                                <button type="submit" name="decision" value="REVISION" class="btn btn-soft-warning">
                                    <i class="ri-edit-circle-line align-bottom me-1"></i> Request Revision
                                </button>
                                <button type="submit" name="decision" value="REJECTED" class="btn btn-soft-danger">
                                    <i class="ri-close-line align-bottom me-1"></i> Reject
                                </button>
                            </div>
                        </form>
                        @else
                        <div class="alert alert-soft-warning border-0 mb-0 d-flex align-items-center">
                            <i class="ri-lock-2-line me-2"></i>
                            <div>Waiting for approval from <strong>{{ $approverName }}</strong></div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currencyInputs = document.querySelectorAll('.currency-input');

        currencyInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                // Remove non-digit characters
                let value = this.value.replace(/\D/g, '');
                
                // Format with dots
                if (value) {
                    value = new Intl.NumberFormat('id-ID').format(value);
                }
                
                this.value = value;
            });
        });
    });
</script>
@endpush
