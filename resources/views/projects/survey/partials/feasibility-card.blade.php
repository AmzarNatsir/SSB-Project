@php
    $recommendation = $survey->metadata['feasibility_recommendation'] ?? 'No recommendation available';
    $isFeasible = $survey->is_feasible;
@endphp

<div class="card mb-3 border-{{ $isFeasible ? 'success' : 'danger' }}">
    <div class="card-header bg-{{ $isFeasible ? 'success' : 'danger' }}-transparent">
        <h5 class="card-title mb-0 text-{{ $isFeasible ? 'success' : 'danger' }}">
            <i class="ti ti-{{ $isFeasible ? 'check-circle' : 'x-circle' }} me-2"></i>
            Feasibility Assessment Result
        </h5>
    </div>
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl bg-{{ $isFeasible ? 'success' : 'danger' }}-transparent rounded me-3">
                        <i class="ti ti-{{ $isFeasible ? 'thumb-up' : 'thumb-down' }} fs-32"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Project Status</h6>
                        <h4 class="mb-0 text-{{ $isFeasible ? 'success' : 'danger' }}">
                            {{ $isFeasible ? 'FEASIBLE' : 'NOT FEASIBLE' }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <h6 class="mb-1">Total Score</h6>
                <h2 class="mb-0 text-{{ $isFeasible ? 'success' : 'danger' }}">
                    {{ number_format($survey->total_score, 2) }}
                    <small class="text-muted fs-6">/100</small>
                </h2>
            </div>
        </div>

        <div class="alert alert-{{ $isFeasible ? 'success' : 'danger' }} mb-0">
            <h6 class="alert-heading">
                <i class="ti ti-bulb me-2"></i>Recommendation
            </h6>
            <p class="mb-0">{{ $recommendation }}</p>
        </div>

        @if($isFeasible)
            <div class="mt-3 d-flex gap-2">
                @if(in_array($survey->status, ['PENDING_APPROVAL', 'APPROVED', 'COMPLETED', 'REJECTED']))
                    <button class="btn btn-secondary flex-fill" disabled>
                        <i class="ti ti-lock me-1"></i>
                        @if($survey->status === 'PENDING_APPROVAL')
                            Waiting for Approval
                        @elseif($survey->status === 'APPROVED')
                            Approved
                        @elseif($survey->status === 'COMPLETED')
                            Completed
                        @else
                            Rejected
                        @endif
                    </button>
                @else
                    @if(auth()->user()->hasAnyRole(['Admin', 'Super Admin']))
                        <button class="btn btn-success flex-fill" onclick="proceedToExecution()">
                            <i class="ti ti-rocket me-1"></i>Proceed to Execution
                        </button>
                    @else
                        <button class="btn btn-outline-secondary flex-fill disabled" title="Only administrators can proceed to execution">
                            <i class="ti ti-lock me-1"></i>
                            Waiting for Admin Approval
                        </button>
                    @endif
                @endif
            </div>
        @else
            <div class="mt-3">
                <p class="text-muted mb-2"><strong>Suggested Actions:</strong></p>
                <ul class="mb-0">
                    <li>Review and improve low-scoring areas</li>
                    <li>Request revision from relevant departments</li>
                    <li>Consider project redesign or cancellation</li>
                </ul>
            </div>
        @endif
    </div>
</div>
