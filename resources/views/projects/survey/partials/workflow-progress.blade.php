@php
    $workflowSteps = [
        ['status' => 'DRAFT', 'label' => 'Draft', 'icon' => 'ti-file'],
        ['status' => 'SCHEDULED', 'label' => 'Scheduled', 'icon' => 'ti-calendar'],
        ['status' => 'IN_PROGRESS', 'label' => 'In Progress', 'icon' => 'ti-progress'],
        ['status' => 'SCORING', 'label' => 'Scoring', 'icon' => 'ti-calculator'],
        ['status' => 'PENDING_APPROVAL', 'label' => 'Approval', 'icon' => 'ti-hourglass'],
        ['status' => 'APPROVED', 'label' => 'Approved', 'icon' => 'ti-check'],
        ['status' => 'COMPLETED', 'label' => 'Completed', 'icon' => 'ti-check-circle'],
    ];
    
    $currentIndex = collect($workflowSteps)->search(function($step) use ($survey) {
        return $step['status'] === $survey->status;
    });
    
    if ($currentIndex === false) $currentIndex = 0;
@endphp

<div class="card mb-3">
    <div class="card-body py-3">
        <div class="workflow-progress">
            <div class="d-flex justify-content-between align-items-center">
                @foreach($workflowSteps as $index => $step)
                    <div class="workflow-step {{ $index <= $currentIndex ? 'active' : '' }} {{ $index < $currentIndex ? 'completed' : '' }}">
                        <div class="step-icon">
                            <i class="ti {{ $step['icon'] }}"></i>
                        </div>
                        <div class="step-label">{{ $step['label'] }}</div>
                    </div>
                    @if(!$loop->last)
                        <div class="workflow-connector {{ $index < $currentIndex ? 'completed' : '' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.workflow-progress {
    padding: 10px 0;
}

.workflow-step {
    text-align: center;
    flex: 1;
    position: relative;
}

.step-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
    font-size: 18px;
    transition: all 0.3s;
}

.workflow-step.active .step-icon {
    background: #0d6efd;
    color: white;
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
}

.workflow-step.completed .step-icon {
    background: #198754;
    color: white;
}

.step-label {
    font-size: 11px;
    color: #6c757d;
    font-weight: 500;
}

.workflow-step.active .step-label {
    color: #0d6efd;
    font-weight: 600;
}

.workflow-connector {
    height: 2px;
    background: #e9ecef;
    flex: 1;
    margin: 0 10px;
    margin-top: -30px;
}

.workflow-connector.completed {
    background: #198754;
}
</style>
