@extends('layout.mainlayout')
@section('title', 'Detail Work Realization')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    {{ $realization->realization_number }}
                    <span class="badge bg-{{ $realization->status->color() }}-subtle text-{{ $realization->status->color() }} fs-13 text-uppercase ms-2">
                        {{ $realization->status->label() }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('work-realizations.index') }}">Work Realization</a></li>
                        <li class="breadcrumb-item active">{{ $realization->realization_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @if($realization->canEdit())
                    <a href="{{ route('work-realizations.edit', $realization->uid) }}" class="btn btn-outline-primary btn-sm">
                        <i class="ti ti-edit me-1"></i> Edit
                    </a>
                @endif

                @if($realization->canSubmit())
                    @if($hasApprovalMatrix)
                        <form action="{{ route('work-realizations.submit', $realization->uid) }}" method="POST" class="d-inline js-confirm-form"
                              data-title="Ajukan Approval?"
                              data-text="Work Realization akan dikirim ke {{ $nextApproverLabel }} untuk diperiksa."
                              data-icon="question" data-confirm-text="Ya, Ajukan" data-confirm-color="#3b82f6">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="ti ti-send me-1"></i> Ajukan Approval
                            </button>
                        </form>
                    @else
                        <button class="btn btn-primary btn-sm" disabled title="Matriks approval belum diatur.">
                            <i class="ti ti-send me-1"></i> Ajukan Approval <i class="ti ti-lock ms-1"></i>
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

        @if($realization->canSubmit() && ! $hasApprovalMatrix)
            <div class="alert alert-warning border-warning">
                <h6 class="alert-heading"><i class="ti ti-alert-triangle me-1"></i>Matriks Approval Belum Diatur</h6>
                <p class="mb-2">Tombol Ajukan dinonaktifkan karena belum ada konfigurasi level approver untuk <code>WorkRealization</code>.</p>
                <a href="{{ route('approval-flows.index') }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-settings me-1"></i> Buka Approval Matrix
                </a>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                {{-- Info Realisasi --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Data Proyek &amp; Realisasi</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Nama Proyek</dt>
                            <dd class="col-sm-9">{{ $realization->project->project_name ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Nomor Proyek</dt>
                            <dd class="col-sm-9">{{ $realization->project->project_code ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Lokasi Proyek</dt>
                            <dd class="col-sm-9">
                                @if($realization->project?->project_location)
                                    <i class="ti ti-map-pin me-1 text-muted"></i>{{ $realization->project->project_location }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </dd>

                            @if($realization->contract)
                                <dt class="col-sm-3 text-muted">Kontrak</dt>
                                <dd class="col-sm-9">{{ $realization->contract->contract_number }}</dd>
                            @endif

                            <dt class="col-sm-3 text-muted">Periode Realisasi</dt>
                            <dd class="col-sm-9">
                                <i class="ti ti-calendar me-1"></i>
                                {{ $realization->period_start?->format('d M Y') }} → {{ $realization->period_end?->format('d M Y') }}
                            </dd>

                            <dt class="col-sm-3 text-muted">Dibuat Oleh</dt>
                            <dd class="col-sm-9">{{ $realization->creator->name ?? '-' }} <small class="text-muted">({{ $realization->created_at->format('d M Y H:i') }})</small></dd>

                            @if($realization->approved_by)
                                <dt class="col-sm-3 text-muted">Disetujui Oleh</dt>
                                <dd class="col-sm-9">{{ $realization->approver->name ?? '-' }} <small class="text-muted">({{ $realization->approved_at?->format('d M Y H:i') }})</small></dd>
                            @endif

                            @if($realization->notes)
                                <dt class="col-sm-3 text-muted">Catatan</dt>
                                <dd class="col-sm-9">{{ $realization->notes }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Items Detail --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Detail Realisasi per Unit ({{ $realization->items->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if($realization->items->isEmpty())
                            <p class="text-muted text-center py-4 mb-0">Belum ada item realisasi.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle small">
                                    <thead class="table-light text-uppercase">
                                        <tr>
                                            <th>Unit / Operator</th>
                                            <th class="text-end">Periode</th>
                                            <th class="text-end">Total HM</th>
                                            <th class="text-end">TS</th>
                                            <th class="text-end">Tarif Kontrak</th>
                                            <th class="text-end">Tarif Sesuai</th>
                                            <th class="text-end">Jumlah Realisasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($realization->items as $item)
                                            @php
                                                $isAdjusted = (float) $item->adjusted_rate !== (float) $item->contract_rate;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="fw-medium">{{ $item->unit_name }}</div>
                                                    @if($item->equipment_code)
                                                        <div class="small text-muted">{{ $item->equipment_code }}</div>
                                                    @endif
                                                    @if($item->operator_name)
                                                        <div class="small text-muted"><i class="ti ti-user me-1"></i>{{ $item->operator_name }}</div>
                                                    @endif
                                                </td>
                                                <td class="text-end small">
                                                    {{ $item->period_start?->format('d M') }} → {{ $item->period_end?->format('d M Y') }}
                                                </td>
                                                <td class="text-end fw-semibold">{{ number_format($item->total_hm, 2, ',', '.') }}</td>
                                                <td class="text-end"><span class="badge bg-light text-dark">{{ $item->timesheet_count }}</span></td>
                                                <td class="text-end text-muted">{{ number_format($item->contract_rate, 0, ',', '.') }}</td>
                                                <td class="text-end">
                                                    {{ number_format($item->adjusted_rate, 0, ',', '.') }}
                                                    @if($isAdjusted)
                                                        <i class="ti ti-arrow-{{ $item->adjusted_rate > $item->contract_rate ? 'up text-success' : 'down text-warning' }}" title="Disesuaikan"></i>
                                                    @endif
                                                </td>
                                                <td class="text-end fw-semibold">Rp {{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                            </tr>
                                            @if($item->rate_adjustment_reason || $item->notes)
                                                <tr>
                                                    <td colspan="7" class="bg-light small">
                                                        @if($item->rate_adjustment_reason)
                                                            <div><i class="ti ti-info-circle text-warning me-1"></i><strong>Alasan Penyesuaian:</strong> {{ $item->rate_adjustment_reason }}</div>
                                                        @endif
                                                        @if($item->notes)
                                                            <div><i class="ti ti-note text-muted me-1"></i>{{ $item->notes }}</div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <td colspan="6" class="text-end fw-bold fs-6">TOTAL JUMLAH REALISASI</td>
                                            <td class="text-end fw-bold fs-5">Rp {{ number_format($realization->total_realized_amount, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Attachments --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Lampiran</h5></div>
                    <div class="card-body">
                        @php
                            $attachments = [
                                ['pa_ma_attachment_path', 'pa_ma', 'Laporan PA & MA (Workshop)', 'ti-tool', 'primary'],
                                ['safety_attachment_path', 'safety', 'Laporan Safety Plan (HSE)', 'ti-shield-check', 'success'],
                                ['berita_acara_attachment_path', 'berita_acara', 'Berita Acara', 'ti-file-certificate', 'warning'],
                            ];
                        @endphp
                        <div class="row g-3">
                            @foreach($attachments as [$dbField, $type, $label, $icon, $color])
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <div class="d-flex align-items-start">
                                            <i class="ti {{ $icon }} fs-2 text-{{ $color }} me-2"></i>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $label }}</h6>
                                                @if($realization->{$dbField})
                                                    <a href="{{ route('work-realizations.attachment', [$realization->uid, $type]) }}" class="btn btn-sm btn-soft-{{ $color }}">
                                                        <i class="ti ti-download me-1"></i> Unduh
                                                    </a>
                                                @else
                                                    <span class="text-muted small"><i class="ti ti-file-off"></i> Belum diupload</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Approval Action --}}
                @if($realization->canApprove() && $isCurrentApprover)
                    <div class="card border-warning">
                        <div class="card-header bg-warning-subtle">
                            <h5 class="card-title mb-0 text-warning">
                                <i class="ti ti-checks me-1"></i> Aksi Approval (Level {{ $realization->current_approval_level }} dari {{ $flowLevels->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($nextApproverLabel)
                                <div class="alert alert-light border mb-3 py-2 px-3 small">
                                    <i class="ti ti-user-check me-1 text-muted"></i>
                                    Approver level ini: <strong>{{ $nextApproverLabel }}</strong>
                                </div>
                            @endif
                            <form action="{{ route('work-realizations.approve', $realization->uid) }}" method="POST" id="approve-form">
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
                @elseif($realization->canApprove() && ! $isCurrentApprover)
                    <div class="card border-info">
                        <div class="card-header bg-info-subtle">
                            <h5 class="card-title mb-0 text-info">
                                <i class="ti ti-hourglass me-1"></i> Menunggu Approval
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Realisasi menunggu persetujuan dari:</p>
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

                {{-- Summary --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Ringkasan</h5></div>
                    <div class="card-body">
                        @php
                            $totalHm = $realization->items->sum('total_hm');
                            $totalTimesheets = $realization->items->sum('timesheet_count');
                            $adjustedCount = $realization->items->filter(fn($i) => (float)$i->adjusted_rate !== (float)$i->contract_rate)->count();
                        @endphp
                        <dl class="row mb-0">
                            <dt class="col-7 text-muted">Total Unit</dt>
                            <dd class="col-5 text-end">{{ $realization->items->count() }}</dd>

                            <dt class="col-7 text-muted">Total HM Periode</dt>
                            <dd class="col-5 text-end">{{ number_format($totalHm, 2, ',', '.') }}</dd>

                            <dt class="col-7 text-muted">Total Timesheet</dt>
                            <dd class="col-5 text-end">{{ $totalTimesheets }}</dd>

                            <dt class="col-7 text-muted">Item Disesuaikan</dt>
                            <dd class="col-5 text-end">
                                @if($adjustedCount > 0)
                                    <span class="badge bg-warning-subtle text-warning">{{ $adjustedCount }}</span>
                                @else
                                    —
                                @endif
                            </dd>

                            <dt class="col-7 fw-bold border-top pt-2">Total Realisasi</dt>
                            <dd class="col-5 text-end fw-bold border-top pt-2 fs-6">Rp {{ number_format($realization->total_realized_amount, 0, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>

                {{-- Approval History --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Riwayat Approval</h5></div>
                    <div class="card-body">
                        @forelse($realization->approvals as $appr)
                            @php
                                $level = $flowLevels->get($appr->level);
                                $statusColor = match($appr->status) {
                                    'approved' => 'success', 'rejected' => 'danger', default => 'warning',
                                };
                                $statusLabel = match($appr->status) {
                                    'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'pending' => 'Menunggu',
                                    default => ucfirst($appr->status),
                                };
                            @endphp
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <span class="avatar-xs">
                                        <span class="avatar-title bg-{{ $statusColor }}-subtle text-{{ $statusColor }} rounded-circle">
                                            {{ $appr->level }}
                                        </span>
                                    </span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Level {{ $appr->level }}
                                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} ms-1">{{ $statusLabel }}</span>
                                    </h6>
                                    <p class="text-muted mb-0 small">
                                        {{ $appr->approver->name ?? ($level?->approver_type->label() ?? 'Menunggu approver') }}
                                        @if($appr->approved_at)
                                            • {{ $appr->approved_at->format('d M Y H:i') }}
                                        @endif
                                    </p>
                                    @if($appr->remarks)
                                        <p class="small mt-1 mb-0"><i>"{{ $appr->remarks }}"</i></p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0">Belum diajukan approval.</p>
                        @endforelse
                    </div>
                </div>
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
            title: isReject ? 'Tolak Realisasi?' : 'Setujui Realisasi?',
            text:  isReject ? 'Pastikan catatan penolakan diisi.' : 'Realisasi akan diteruskan ke level berikutnya (jika ada).',
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
