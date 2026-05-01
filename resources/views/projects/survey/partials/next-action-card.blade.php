@php
    use App\Domain\Survey\Services\SurveyWorkflowService;
    use App\Domain\Survey\Services\ScoringEngine;
    
    $workflowService = app(SurveyWorkflowService::class);
    $nextAction = $workflowService->getNextAction($survey);
    
    $actionButtons = [];
    $currentUser = auth()->user();
    $isSuperAdmin = $currentUser->hasRole('Super Admin');
    
    // Check if user has permission for any department (from $deptPermissions passed to view)
    $authorizedDepts = array_keys(array_filter($deptPermissions ?? [], fn($allowed) => $allowed));
    
    // Define action buttons based on status
    if ($survey->status === 'DRAFT') {
        // Typically Admin or Project Team can schedule
        $actionButtons[] = [
            'label' => 'Schedule Survey',
            'icon' => 'ti-calendar-event',
            'class' => 'btn-primary',
            'modal' => '#scheduleModal'
        ];
    }
    
    if ($survey->status === 'SURVEY_PLANNED') {
        // Only Manager can approve execution
        if ($currentUser->hasAnyRole(['Manager Operation', 'Super Admin'])) {
            $actionButtons[] = [
                'label' => 'Approve Survey',
                'icon' => 'ti-check',
                'class' => 'btn-success',
                'action' => 'approve-execution'
            ];
        }
    }
    
    if ($survey->status === 'APPROVED_TO_START') {
        // Any surveyor or admin can "Start" the survey process
        if (count($authorizedDepts) > 0 || $isSuperAdmin) {
            $actionButtons[] = [
                'label' => 'Start Survey',
                'icon' => 'ti-play',
                'class' => 'btn-success',
                'action' => 'start'
            ];
        }
    }
    
    if (in_array($survey->status, ['IN_PROGRESS', 'SCORING'])) {
        // Show submit button only if user is authorized for at least one DEPT
        if (count($authorizedDepts) > 0) {
            $actionButtons[] = [
                'label' => 'Submit Department Score',
                'icon' => 'ti-calculator',
                'class' => 'btn-success',
                'modal' => '#scoreModalSelect' // Changing this to a general selector button or logic
            ];
        }
    }
    
    if ($survey->status === 'PENDING_APPROVAL') {
        // Manager Project or Manager Ops
        if ($currentUser->hasAnyRole(['Manager Project', 'Manager Operation', 'Super Admin'])) {
            $actionButtons[] = [
                'label' => 'Approve Survey Result',
                'icon' => 'ti-check',
                'class' => 'btn-success',
                'modal' => '#approvalModal'
            ];
        }
    }
@endphp

<div class="card mb-3 border-primary">
    <div class="card-header bg-primary-transparent">
        <h5 class="card-title mb-0 text-primary">
            <i class="ti ti-bolt me-2"></i>Next Action Required
        </h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-3">
            <i class="ti ti-info-circle me-2"></i>
            <strong>{{ $nextAction }}</strong>
        </div>

        @if(count($actionButtons) > 0)
            <div class="d-grid gap-2">
                @foreach($actionButtons as $button)
                    @if(isset($button['modal']))
                        @if($button['modal'] === '#scoreModalSelect')
                            <a href="#scoring-section" class="btn {{ $button['class'] }}">
                                <i class="ti {{ $button['icon'] }} me-2"></i>{{ $button['label'] }}
                            </a>
                        @else
                            <button class="btn {{ $button['class'] }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="{{ $button['modal'] }}">
                                <i class="ti {{ $button['icon'] }} me-2"></i>{{ $button['label'] }}
                            </button>
                        @endif
                    @elseif(isset($button['action']) && $button['action'] === 'start')
                        <form action="{{ route('project-survey.start', $survey->uid) }}" method="POST" id="startSurveyForm">
                            @csrf
                            <button type="button" class="btn {{ $button['class'] }} w-100" onclick="confirmStartSurvey()">
                                <i class="ti {{ $button['icon'] }} me-2"></i>{{ $button['label'] }}
                            </button>
                        </form>
                    @elseif(isset($button['action']) && $button['action'] === 'approve-execution')
                        <button type="button" class="btn {{ $button['class'] }} w-100" onclick="showPreSurveyApprovalModal()">
                            <i class="ti {{ $button['icon'] }} me-2"></i>{{ $button['label'] }}
                        </button>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">
                <i class="ti ti-check-circle me-1"></i>No immediate action required
            </p>
        @endif

        <!-- Quick Stats -->
        <hr>
        <div class="row text-center">
            <div class="col-4">
                <div class="mb-1">
                    <i class="ti ti-users fs-20 text-primary"></i>
                </div>
                <h6 class="mb-0">{{ $survey->teams->count() }}</h6>
                <small class="text-muted">Team</small>
            </div>
            <div class="col-4">
                <div class="mb-1">
                    <i class="ti ti-calculator fs-20 text-success"></i>
                </div>
                <h6 class="mb-0">{{ $survey->scores->count() }}/{{ \App\Models\SurveyorFlow::active()->count() ?: 3 }}</h6>
                <small class="text-muted">Scores</small>
            </div>
            <div class="col-4">
                <div class="mb-1">
                    <i class="ti ti-check fs-20 text-info"></i>
                </div>
                <h6 class="mb-0">{{ $survey->approvals->count() }}</h6>
                <small class="text-muted">Approvals</small>
            </div>
        </div>
    </div>
</div>
