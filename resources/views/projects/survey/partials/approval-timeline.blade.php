<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="ti ti-checklist me-2"></i>Approval Timeline
        </h5>
    </div>
    <div class="card-body">
        @if($survey->approvals && $survey->approvals->count() > 0)
            <div class="approval-timeline">
                @foreach($survey->approvals as $approval)
                    <div class="approval-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">
                                    @if($approval->step === 'PRE_SURVEY_APPROVAL')
                                        <i class="ti ti-calendar-check me-1"></i>Survey Execution Approval
                                    @elseif($approval->step === 'MANAGER_OPS')
                                        <i class="ti ti-user-check me-1"></i>Manager Operations
                                    @else
                                        <i class="ti ti-briefcase me-1"></i>Manager Project
                                    @endif
                                </h6>
                                <small class="text-muted">
                                    @if($approval->status === 'PENDING')
                                        Waiting for approval
                                    @elseif($approval->status === 'APPROVED')
                                        Approved by {{ $approval->approver->name ?? 'Unknown' }}
                                        <br>{{ $approval->approved_at?->format('d M Y H:i') }}
                                    @else
                                        Rejected by {{ $approval->approver->name ?? 'Unknown' }}
                                        <br>{{ $approval->approved_at?->format('d M Y H:i') }}
                                    @endif
                                </small>
                            </div>
                            <div>
                                @if($approval->status === 'PENDING')
                                    <span class="badge bg-warning">
                                        <i class="ti ti-clock me-1"></i>Pending
                                    </span>
                                @elseif($approval->status === 'APPROVED')
                                    <span class="badge bg-success">
                                        <i class="ti ti-check me-1"></i>Approved
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="ti ti-x me-1"></i>Rejected
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($approval->notes)
                            <div class="alert alert-light mb-2">
                                <small><strong>Notes:</strong> {{ $approval->notes }}</small>
                            </div>
                        @endif

                        {{-- Post-Survey Approval Buttons --}}
                        @if($approval->status === 'PENDING' && $survey->status === 'PENDING_APPROVAL')
                            <div class="d-flex gap-2 mt-2">
                                <button class="btn btn-sm btn-success flex-fill" 
                                        onclick="showApprovalModal('{{ $approval->step }}', 'approve')">
                                    <i class="ti ti-check me-1"></i>Approve
                                </button>
                                <button class="btn btn-sm btn-danger flex-fill" 
                                        onclick="showApprovalModal('{{ $approval->step }}', 'reject')">
                                    <i class="ti ti-x me-1"></i>Reject
                                </button>
                            </div>
                        @endif

                        {{-- Pre-Survey Approval Buttons --}}
                        @if($approval->step === 'PRE_SURVEY_APPROVAL' && $approval->status === 'PENDING' && $survey->status === 'SURVEY_PLANNED')
                            <div class="d-flex gap-2 mt-2">
                                <button class="btn btn-sm btn-success flex-fill" 
                                        onclick="showPreSurveyApprovalModal()">
                                    <i class="ti ti-check me-1"></i>Approve
                                </button>
                                <button class="btn btn-sm btn-danger flex-fill" 
                                        onclick="showPreSurveyApprovalModal()"> {{-- Reusing check inside modal logic or better pass action --}}
                                    <i class="ti ti-x me-1"></i>Reject
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-3">
                <i class="ti ti-mail-opened fs-48 text-muted mb-2 d-block"></i>
                <p class="text-muted mb-0">No approvals yet</p>
            </div>
        @endif
    </div>
</div>
