<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">
            <i class="ti ti-calendar-event me-2"></i>Survey Schedule
        </h5>
        @if($survey->scheduled_at && in_array($survey->status, ['DRAFT', 'SCHEDULED', 'SURVEY_PLANNED']))
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                <i class="ti ti-edit me-1"></i>Edit Schedule
            </button>
        @endif
    </div>
    <div class="card-body">
        @if($survey->scheduled_at)
            {{-- ── Schedule Info ──────────────────────────────────────────── --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm bg-primary-transparent text-primary rounded">
                            <i class="ti ti-calendar fs-16"></i>
                        </div>
                        <div>
                            <div class="fs-12 text-muted">Tanggal Survey</div>
                            <div class="fw-semibold">{{ $survey->scheduled_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm bg-info-transparent text-info rounded">
                            <i class="ti ti-clock fs-16"></i>
                        </div>
                        <div>
                            <div class="fs-12 text-muted">Waktu</div>
                            <div class="fw-semibold">{{ $survey->scheduled_at->format('H:i') }} WIB</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm {{ $survey->scheduled_at->isPast() ? 'bg-success-transparent text-success' : 'bg-warning-transparent text-warning' }} rounded">
                            <i class="ti ti-{{ $survey->scheduled_at->isPast() ? 'check' : 'clock-hour-4' }} fs-16"></i>
                        </div>
                        <div>
                            <div class="fs-12 text-muted">Status Jadwal</div>
                            <span class="badge {{ $survey->scheduled_at->isPast() ? 'badge-soft-success' : 'badge-soft-warning' }}">
                                {{ $survey->scheduled_at->isPast() ? 'Sudah Dilaksanakan' : 'Upcoming — ' . $survey->scheduled_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm bg-secondary-transparent text-secondary rounded">
                            <i class="ti ti-users fs-16"></i>
                        </div>
                        <div>
                            <div class="fs-12 text-muted">Jumlah Tim Surveyor</div>
                            <div class="fw-semibold">{{ $survey->teams->count() }} orang</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Survey Team Members ────────────────────────────────────── --}}
            @if($survey->teams->count() > 0)
                <div class="border-top pt-3">
                    <h6 class="fw-semibold mb-3">
                        <i class="ti ti-users-group me-1 text-primary"></i>Tim Surveyor
                    </h6>
                    <div class="row g-2">
                        @php
                            $deptColors = [
                                'HSE'       => ['bg' => 'bg-success-transparent', 'text' => 'text-success',   'badge' => 'badge-soft-success'],
                                'OPERATION' => ['bg' => 'bg-warning-transparent', 'text' => 'text-warning',   'badge' => 'badge-soft-warning'],
                                'PROJECT'   => ['bg' => 'bg-primary-transparent', 'text' => 'text-primary',   'badge' => 'badge-soft-primary'],
                                'WORKSHOP'  => ['bg' => 'bg-info-transparent',    'text' => 'text-info',      'badge' => 'badge-soft-info'],
                                'FINANCE'   => ['bg' => 'bg-danger-transparent',  'text' => 'text-danger',    'badge' => 'badge-soft-danger'],
                                'HRD'       => ['bg' => 'bg-purple-transparent',  'text' => 'text-purple',    'badge' => 'badge-soft-purple'],
                            ];
                        @endphp
                        @foreach($survey->teams as $team)
                            @php
                                $dept   = strtoupper($team->department ?? '');
                                $color  = $deptColors[$dept] ?? ['bg' => 'bg-secondary-transparent', 'text' => 'text-secondary', 'badge' => 'badge-soft-secondary'];
                                $name   = $team->user->name ?? '-';
                                // Generate initials from name
                                $parts    = explode(' ', $name);
                                $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                            @endphp
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 p-2 rounded bg-light">
                                    <div class="avatar avatar-sm {{ $color['bg'] }} {{ $color['text'] }} rounded-circle fw-bold fs-12 flex-shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fw-medium text-truncate">{{ $name }}</div>
                                        @if($team->department)
                                            <span class="badge {{ $color['badge'] }} fs-10">
                                                {{ $team->department }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="border-top pt-3">
                    <div class="text-center text-muted py-2">
                        <i class="ti ti-users-off fs-24 d-block mb-1"></i>
                        <small>Belum ada tim surveyor yang ditentukan</small>
                    </div>
                </div>
            @endif

        @else
            {{-- ── Not yet scheduled ─────────────────────────────────────── --}}
            <div class="alert alert-warning mb-0 d-flex align-items-center gap-2">
                <i class="ti ti-alert-triangle fs-18 flex-shrink-0"></i>
                <div>
                    <strong>Jadwal belum diset.</strong>
                    <div class="fs-12 mt-1">Tentukan tanggal dan tim surveyor untuk memulai proses survey.</div>
                </div>
            </div>

            @if(in_array($survey->status, ['DRAFT', 'SCHEDULED', 'SURVEY_PLANNED']))
                <div class="mt-3">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                        <i class="ti ti-calendar-plus me-1"></i>Set Schedule & Tim
                    </button>
                </div>
            @endif
        @endif
    </div>
</div>
