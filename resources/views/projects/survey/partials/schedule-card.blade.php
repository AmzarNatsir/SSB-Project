<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="ti ti-calendar-event me-2"></i>Survey Schedule
        </h5>
    </div>
    <div class="card-body">
        @if($survey->scheduled_at)
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2">
                        <strong><i class="ti ti-calendar me-1"></i>Scheduled Date:</strong><br>
                        <span class="text-muted">{{ $survey->scheduled_at->format('d M Y, H:i') }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2">
                        <strong><i class="ti ti-clock me-1"></i>Status:</strong><br>
                        @if($survey->scheduled_at->isPast())
                            <span class="badge bg-success">Executed</span>
                        @else
                            <span class="badge bg-warning">Upcoming</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($survey->teams->count() > 0)
                <hr>
                <h6 class="mb-3"><i class="ti ti-users me-2"></i>Survey Team</h6>
                <div class="row">
                    @foreach($survey->teams as $team)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-primary-transparent rounded-circle me-2">
                                    <i class="ti ti-user"></i>
                                </div>
                                <div>
                                    <div class="fw-medium">{{ $team->user->name ?? '-' }}</div>
                                    <small class="text-muted">{{ $team->department }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <div class="alert alert-warning mb-3">
                <i class="ti ti-alert-triangle me-2"></i>Schedule not yet set.
            </div>
            
            @if(in_array($survey->status, ['DRAFT', 'SCHEDULED']))
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                    <i class="ti ti-calendar-plus me-1"></i>Set Schedule
                </button>
            @endif
        @endif
    </div>
</div>
