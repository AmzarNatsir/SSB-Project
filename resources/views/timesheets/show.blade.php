@extends('layout.mainlayout')
@section('title', 'Detail Timesheet')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    {{ $journal->journal_number }}
                    <span class="badge bg-{{ $journal->status->color() }}-subtle text-{{ $journal->status->color() }} fs-13 text-uppercase ms-2">
                        {{ $journal->status->label() }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('timesheets.index') }}">Timesheet Journal</a></li>
                        <li class="breadcrumb-item active">{{ $journal->journal_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @if($journal->canEdit())
                    <a href="{{ route('timesheets.edit', $journal->uid) }}" class="btn btn-outline-primary btn-sm">
                        <i class="ti ti-edit me-1"></i> Edit
                    </a>
                @endif

                @if($journal->canSubmit())
                    @if($hasApprovalMatrix)
                        <form action="{{ route('timesheets.submit', $journal->uid) }}" method="POST" class="d-inline js-confirm-form"
                              data-title="Ajukan Timesheet untuk Approval?"
                              data-text="Timesheet akan dikirim ke {{ $nextApproverLabel }} untuk diperiksa."
                              data-icon="question" data-confirm-text="Ya, Ajukan" data-confirm-color="#3b82f6">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="ti ti-send me-1"></i> Ajukan Approval
                            </button>
                        </form>
                    @else
                        <button class="btn btn-primary btn-sm" disabled
                                title="Matriks approval untuk Timesheet belum diatur.">
                            <i class="ti ti-send me-1"></i> Ajukan Approval
                            <i class="ti ti-lock ms-1"></i>
                        </button>
                    @endif
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($journal->canSubmit() && ! $hasApprovalMatrix)
            <div class="alert alert-warning border-warning">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="ti ti-alert-triangle fs-3 text-warning"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="alert-heading mb-1">Matriks Approval Belum Diatur</h6>
                        <p class="mb-2">Tombol Ajukan Approval dinonaktifkan karena belum ada konfigurasi level approver untuk <code>TimesheetJournal</code>.</p>
                        <a href="{{ route('approval-flows.index') }}" class="btn btn-sm btn-warning">
                            <i class="ti ti-settings me-1"></i> Buka Pengaturan Approval Matrix
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Informasi Jurnal</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Nama Proyek</dt>
                            <dd class="col-sm-9">{{ $journal->project->project_name ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Nomor Proyek</dt>
                            <dd class="col-sm-9">{{ $journal->project->project_code ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Lokasi Proyek</dt>
                            <dd class="col-sm-9">
                                @if($journal->project?->project_location)
                                    <i class="ti ti-map-pin me-1 text-muted"></i>{{ $journal->project->project_location }}
                                    @if($journal->project->project_coordinates)
                                        <small class="text-muted ms-2">({{ $journal->project->project_coordinates }})</small>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </dd>

                            <dt class="col-sm-3 text-muted">Tanggal & Shift</dt>
                            <dd class="col-sm-9">
                                {{ $journal->journal_date?->format('d M Y') ?? '-' }}
                                <span class="badge bg-light text-dark ms-2">Shift {{ $journal->shift }}</span>
                            </dd>

                            @if($journal->contract)
                                <dt class="col-sm-3 text-muted">Kontrak</dt>
                                <dd class="col-sm-9">{{ $journal->contract->contract_number }}</dd>
                            @endif

                            {{-- Formasi Alat/Unit Aktif --}}
                            <dt class="col-sm-3 text-muted">Formasi Alat/Unit</dt>
                            <dd class="col-sm-9">
                                @if($activeUnitFormation->isNotEmpty())
                                    @php $totalUnits = $activeUnitFormation->sum(fn($f) => $f->items->count()); @endphp
                                    <span class="badge bg-primary-subtle text-primary">{{ $totalUnits }} unit aktif</span>
                                    @foreach($activeUnitFormation as $uf)
                                        <a href="{{ route('unit-formations.show', $uf->uid) }}" class="link-primary small ms-2" target="_blank">
                                            <i class="ti ti-external-link"></i> {{ $uf->formation_number }}
                                        </a>
                                    @endforeach
                                @else
                                    <span class="text-muted small">Belum ada SK Penetapan Unit aktif untuk proyek ini pada tanggal jurnal.</span>
                                @endif
                            </dd>

                            {{-- Formasi Tenaga Kerja Aktif --}}
                            <dt class="col-sm-3 text-muted">Formasi Tenaga Kerja</dt>
                            <dd class="col-sm-9">
                                @if($activeWorkforce->isNotEmpty())
                                    @php $totalMembers = $activeWorkforce->sum(fn($f) => $f->members->count()); @endphp
                                    <span class="badge bg-success-subtle text-success">{{ $totalMembers }} anggota aktif</span>
                                    @foreach($activeWorkforce as $wf)
                                        <a href="{{ route('workforce-formations.show', $wf->uid) }}" class="link-primary small ms-2" target="_blank">
                                            <i class="ti ti-external-link"></i> {{ $wf->formation_number }}
                                        </a>
                                    @endforeach
                                @else
                                    <span class="text-muted small">Belum ada SK Penugasan Tim aktif untuk proyek ini pada tanggal jurnal.</span>
                                @endif
                            </dd>

                            @if($journal->submitter)
                                <dt class="col-sm-3 text-muted">Diajukan Oleh</dt>
                                <dd class="col-sm-9">{{ $journal->submitter->name }} <small class="text-muted">({{ $journal->submitted_at?->format('d M Y H:i') }})</small></dd>
                            @endif

                            @if($journal->approved_by)
                                <dt class="col-sm-3 text-muted">Disetujui Oleh</dt>
                                <dd class="col-sm-9">{{ $journal->approver->name ?? '-' }} <small class="text-muted">({{ $journal->approved_at?->format('d M Y H:i') }})</small></dd>
                            @endif

                            @if($journal->notes)
                                <dt class="col-sm-3 text-muted">Catatan Umum</dt>
                                <dd class="col-sm-9">{{ $journal->notes }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Ringkasan</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            @php
                                $summary = [
                                    ['HM Total', number_format($totals['hm_total'], 2, ',', '.') . ' HM', 'ti-engine', 'primary'],
                                    ['Jam Kerja', number_format($totals['working_hours'], 2, ',', '.'), 'ti-clock-play', 'success'],
                                    ['Idle', number_format($totals['idle_hours'], 2, ',', '.'), 'ti-clock-pause', 'warning'],
                                    ['Breakdown', number_format($totals['breakdown_hours'], 2, ',', '.'), 'ti-tool', 'danger'],
                                    ['BBM (L)', number_format($totals['fuel'], 2, ',', '.'), 'ti-droplet', 'info'],
                                    ['Trip', $totals['trips'], 'ti-truck-loading', 'secondary'],
                                    ['Tonase', number_format($totals['tonnage'], 2, ',', '.'), 'ti-weight', 'dark'],
                                    ['Entries', $totals['entries'], 'ti-list-numbers', 'primary'],
                                ];
                            @endphp
                            @foreach($summary as $s)
                                <div class="col-md-3 col-6">
                                    <div class="border rounded p-2 d-flex align-items-center">
                                        <i class="ti {{ $s[2] }} fs-3 me-2 text-{{ $s[3] }}"></i>
                                        <div>
                                            <div class="text-muted small">{{ $s[0] }}</div>
                                            <div class="fw-semibold">{{ $s[1] }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Entries — card-based detail per unit --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Detail Entries ({{ $journal->entries->count() }})</h5></div>
                    <div class="card-body">
                        @php
                            $fmtTime = fn ($t) => $t ? \Illuminate\Support\Str::substr($t, 0, 5) : '—';
                        @endphp
                        @forelse($journal->entries as $i => $e)
                            <div class="border rounded mb-3">
                                <div class="d-flex align-items-center justify-content-between bg-light px-3 py-2 border-bottom flex-wrap gap-2">
                                    <div>
                                        <span class="text-muted small">#{{ $i + 1 }}</span>
                                        <span class="fw-semibold ms-1">{{ $e->unit_name }}</span>
                                        @if($e->operator_name)
                                            <span class="text-muted small">— Operator: {{ $e->operator_name }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="badge bg-light text-dark border">{{ $e->activity_code }}</span>
                                    </div>
                                </div>
                                <div class="row g-0">
                                    {{-- HM/KM --}}
                                    <div class="col-md-3 border-end p-3">
                                        <div class="small text-muted text-uppercase mb-2"><i class="ti ti-gauge me-1"></i> HM / KM</div>
                                        <table class="table table-sm mb-0 small">
                                            <tr><td class="text-muted">Awal</td><td class="text-end">{{ number_format($e->hm_start, 2, ',', '.') }}</td></tr>
                                            <tr><td class="text-muted">Akhir</td><td class="text-end">{{ number_format($e->hm_end, 2, ',', '.') }}</td></tr>
                                            <tr><td class="text-muted">Total</td><td class="text-end fw-semibold">{{ number_format($e->hm_total, 2, ',', '.') }}</td></tr>
                                        </table>
                                    </div>

                                    {{-- Operating --}}
                                    <div class="col-md-3 border-end p-3">
                                        <div class="small text-success text-uppercase mb-2"><i class="ti ti-clock-play me-1"></i> Operating</div>
                                        <table class="table table-sm mb-0 small">
                                            <tr><td class="text-muted">Mulai</td><td class="text-end">{{ $fmtTime($e->operating_start_time) }}</td></tr>
                                            <tr><td class="text-muted">Selesai</td><td class="text-end">{{ $fmtTime($e->operating_end_time) }}</td></tr>
                                            <tr><td class="text-muted">Total Jam</td><td class="text-end fw-semibold">{{ number_format($e->working_hours, 2, ',', '.') }}</td></tr>
                                        </table>
                                    </div>

                                    {{-- Idle --}}
                                    <div class="col-md-3 border-end p-3">
                                        <div class="small text-warning text-uppercase mb-2"><i class="ti ti-clock-pause me-1"></i> Idle / Standby</div>
                                        <table class="table table-sm mb-2 small">
                                            <tr><td class="text-muted">Mulai</td><td class="text-end">{{ $fmtTime($e->idle_start_time) }}</td></tr>
                                            <tr><td class="text-muted">Selesai</td><td class="text-end">{{ $fmtTime($e->idle_end_time) }}</td></tr>
                                            <tr><td class="text-muted">Total Jam</td><td class="text-end fw-semibold">{{ number_format($e->idle_hours, 2, ',', '.') }}</td></tr>
                                        </table>
                                        @if($e->idle_reason)
                                            <div class="small"><span class="text-muted">Keterangan:</span> <i>"{{ $e->idle_reason }}"</i></div>
                                        @endif
                                    </div>

                                    {{-- Breakdown --}}
                                    <div class="col-md-3 p-3">
                                        <div class="small text-danger text-uppercase mb-2"><i class="ti ti-tool me-1"></i> Breakdown</div>
                                        <table class="table table-sm mb-2 small">
                                            <tr><td class="text-muted">Mulai</td><td class="text-end">{{ $fmtTime($e->breakdown_start_time) }}</td></tr>
                                            <tr><td class="text-muted">Selesai</td><td class="text-end">{{ $fmtTime($e->breakdown_end_time) }}</td></tr>
                                            <tr><td class="text-muted">Total Jam</td><td class="text-end fw-semibold">{{ number_format($e->breakdown_hours, 2, ',', '.') }}</td></tr>
                                        </table>
                                        @if($e->breakdown_reason)
                                            <div class="small"><span class="text-muted">Keterangan:</span> <i>"{{ $e->breakdown_reason }}"</i></div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Production strip --}}
                                <div class="border-top px-3 py-2 d-flex flex-wrap gap-3 small bg-light">
                                    <div><i class="ti ti-droplet text-info me-1"></i><span class="text-muted">BBM:</span> <strong>{{ number_format($e->fuel_consumed_liter, 2, ',', '.') }} L</strong></div>
                                    <div><i class="ti ti-truck-loading text-secondary me-1"></i><span class="text-muted">Trip:</span> <strong>{{ $e->trip_count }}</strong></div>
                                    <div><i class="ti ti-weight text-dark me-1"></i><span class="text-muted">Tonase:</span> <strong>{{ number_format($e->tonnage, 2, ',', '.') }}</strong></div>
                                    @if($e->remarks)
                                        <div class="ms-auto text-muted"><i class="ti ti-note me-1"></i>"{{ $e->remarks }}"</div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted py-4 mb-0">Belum ada entry.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if($journal->canApprove() && $isCurrentApprover)
                    <div class="card border-warning">
                        <div class="card-header bg-warning-subtle">
                            <h5 class="card-title mb-0 text-warning">
                                <i class="ti ti-checks me-1"></i> Aksi Approval (Level {{ $journal->current_approval_level }} dari {{ $flowLevels->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($nextApproverLabel)
                                <div class="alert alert-light border mb-3 py-2 px-3 small">
                                    <i class="ti ti-user-check me-1 text-muted"></i>
                                    Approver level ini: <strong>{{ $nextApproverLabel }}</strong>
                                </div>
                            @endif
                            <form action="{{ route('timesheets.approve', $journal->uid) }}" method="POST" id="approve-form">
                                @csrf
                                <input type="hidden" name="decision" id="approve-decision">
                                <div class="mb-3">
                                    <label class="form-label">Catatan Approval</label>
                                    <textarea name="remarks" class="form-control" rows="2" placeholder="Opsional, wajib jika menolak."></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success btn-sm flex-fill" data-approve-decision="approved">
                                        <i class="ti ti-check me-1"></i> Setujui
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm flex-fill" data-approve-decision="rejected">
                                        <i class="ti ti-x me-1"></i> Tolak
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif($journal->canApprove() && ! $isCurrentApprover)
                    <div class="card border-info">
                        <div class="card-header bg-info-subtle">
                            <h5 class="card-title mb-0 text-info">
                                <i class="ti ti-hourglass me-1"></i> Menunggu Approval
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Timesheet menunggu persetujuan dari:</p>
                            @if($nextApproverLabel)
                                <div class="d-flex align-items-center p-2 bg-light rounded">
                                    <i class="ti ti-user-circle fs-3 text-info me-2"></i>
                                    <div>
                                        <strong>{{ $nextApproverLabel }}</strong>
                                        <div class="small text-muted">Hanya user/role di atas yang dapat memproses.</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    $(document).on('submit', '.js-confirm-form', function(e) {
        const $form = $(this);
        if ($form.data('confirmed') === true) return true;
        e.preventDefault();
        Swal.fire({
            title: $form.data('title') || 'Konfirmasi',
            text:  $form.data('text')  || 'Lanjutkan?',
            icon:  $form.data('icon')  || 'question',
            showCancelButton: true,
            confirmButtonText: $form.data('confirm-text') || 'Ya',
            cancelButtonText:  'Batal',
            confirmButtonColor: $form.data('confirm-color') || '#3b82f6',
            cancelButtonColor:  '#6b7280',
            reverseButtons: true,
            focusCancel: true,
        }).then(function(result) {
            if (result.isConfirmed) {
                $form.data('confirmed', true);
                $form.trigger('submit');
            }
        });
    });

    $('button[data-approve-decision]').on('click', function() {
        const decision = $(this).data('approve-decision');
        const $form = $(this).closest('form');
        const $remarks = $form.find('textarea[name="remarks"]');
        const isReject = decision === 'rejected';

        Swal.fire({
            title: isReject ? 'Tolak Timesheet?' : 'Setujui Timesheet?',
            text:  isReject ? 'Pastikan catatan penolakan diisi.' : 'Timesheet akan diteruskan ke level berikutnya (jika ada).',
            icon:  isReject ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonText: isReject ? 'Ya, Tolak' : 'Ya, Setujui',
            cancelButtonText:  'Batal',
            confirmButtonColor: isReject ? '#dc2626' : '#10b981',
            cancelButtonColor:  '#6b7280',
            reverseButtons: true,
            focusCancel: true,
            input: isReject ? 'textarea' : undefined,
            inputLabel: isReject ? 'Catatan Penolakan (wajib)' : undefined,
            inputValue: $remarks.val() || '',
            inputValidator: isReject ? (v) => !v && 'Catatan penolakan wajib diisi.' : undefined,
        }).then(function(result) {
            if (! result.isConfirmed) return;
            $form.find('#approve-decision').val(decision);
            if (isReject && result.value) $remarks.val(result.value);
            $form[0].submit();
        });
    });
})();
</script>
@endpush
@endsection
