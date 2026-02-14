@php
    $statusConfig = [
        'DRAFT' => ['class' => 'bg-secondary', 'icon' => 'ti-file', 'label' => 'Draft'],
        'SCHEDULED' => ['class' => 'bg-info', 'icon' => 'ti-calendar', 'label' => 'Scheduled'],
        'IN_PROGRESS' => ['class' => 'bg-warning', 'icon' => 'ti-progress', 'label' => 'In Progress'],
        'SCORING' => ['class' => 'bg-primary', 'icon' => 'ti-calculator', 'label' => 'Scoring'],
        'PENDING_APPROVAL' => ['class' => 'bg-info', 'icon' => 'ti-hourglass', 'label' => 'Pending Approval'],
        'APPROVED' => ['class' => 'bg-success', 'icon' => 'ti-check', 'label' => 'Approved'],
        'COMPLETED' => ['class' => 'bg-success', 'icon' => 'ti-check-circle', 'label' => 'Completed'],
        'REJECTED' => ['class' => 'bg-danger', 'icon' => 'ti-x', 'label' => 'Rejected'],
        'SKIPPED' => ['class' => 'bg-dark', 'icon' => 'ti-player-skip-forward', 'label' => 'Skipped']
    ];
    
    $config = $statusConfig[$status] ?? ['class' => 'bg-secondary', 'icon' => 'ti-help', 'label' => $status];
@endphp

<span class="badge {{ $config['class'] }} fs-6">
    <i class="ti {{ $config['icon'] }} me-1"></i>{{ $config['label'] }}
</span>
