@extends('layout.mainlayout')
@section('title', 'Detail SK Penetapan Unit')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    {{ $formation->formation_number }}
                    <span class="badge bg-{{ $formation->status->color() }}-subtle text-{{ $formation->status->color() }} fs-13 text-uppercase ms-2">
                        {{ $formation->status->label() }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-formations.index') }}">SK Penetapan Unit</a></li>
                        <li class="breadcrumb-item active">{{ $formation->formation_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @if($formation->canEdit())
                    <a href="{{ route('unit-formations.edit', $formation->uid) }}" class="btn btn-outline-primary btn-sm">
                        <i class="ti ti-edit me-1"></i> Edit
                    </a>
                @endif

                @if($formation->canSubmit())
                    @if($hasApprovalMatrix)
                        <form action="{{ route('unit-formations.submit', $formation->uid) }}" method="POST" class="d-inline js-confirm-form"
                              data-title="Ajukan untuk Approval?"
                              data-text="SK ini akan dikirim ke {{ $nextApproverLabel }} untuk diproses."
                              data-icon="question"
                              data-confirm-text="Ya, Ajukan"
                              data-confirm-color="#3b82f6">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="ti ti-send me-1"></i> Ajukan Approval
                            </button>
                        </form>
                    @else
                        <button class="btn btn-primary btn-sm" disabled
                                title="Matriks approval untuk SK Penetapan Unit belum diatur.">
                            <i class="ti ti-send me-1"></i> Ajukan Approval
                            <i class="ti ti-lock ms-1"></i>
                        </button>
                    @endif
                @endif

                @if($formation->canActivate())
                    <form action="{{ route('unit-formations.activate', $formation->uid) }}" method="POST" class="d-inline js-confirm-form"
                          data-title="Aktifkan SK?"
                          data-text="SK ini akan diaktifkan dan unit resmi mulai dioperasikan."
                          data-icon="success" data-confirm-text="Ya, Aktifkan" data-confirm-color="#10b981">
                        @csrf
                        <button class="btn btn-success btn-sm" type="submit">
                            <i class="ti ti-player-play me-1"></i> Aktifkan SK
                        </button>
                    </form>
                @endif

                @if($formation->canRevise())
                    <form action="{{ route('unit-formations.revise', $formation->uid) }}" method="POST" class="d-inline js-confirm-form"
                          data-title="Buat Revisi SK?"
                          data-text="SK aktif saat ini tetap berlaku sampai revisi disetujui."
                          data-icon="warning" data-confirm-text="Ya, Buat Revisi" data-confirm-color="#f59e0b">
                        @csrf
                        <button class="btn btn-warning btn-sm" type="submit">
                            <i class="ti ti-refresh me-1"></i> Buat Revisi
                        </button>
                    </form>
                @endif

                @if($formation->canEnd())
                    <form action="{{ route('unit-formations.end', $formation->uid) }}" method="POST" class="d-inline js-confirm-form"
                          data-title="Akhiri SK?"
                          data-text="Tindakan ini tidak dapat dibatalkan."
                          data-icon="warning" data-confirm-text="Ya, Akhiri" data-confirm-color="#dc2626">
                        @csrf
                        <button class="btn btn-dark btn-sm" type="submit">
                            <i class="ti ti-player-stop me-1"></i> Akhiri SK
                        </button>
                    </form>
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

        @if($formation->canSubmit() && ! $hasApprovalMatrix)
            <div class="alert alert-warning border-warning">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="ti ti-alert-triangle fs-3 text-warning"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="alert-heading mb-1">Matriks Approval Belum Diatur</h6>
                        <p class="mb-2">
                            Tombol <strong>Ajukan Approval</strong> dinonaktifkan karena belum ada konfigurasi level approver
                            untuk modul <code>SK Penetapan Unit</code>.
                        </p>
                        <a href="{{ route('approval-flows.index') }}" class="btn btn-sm btn-warning">
                            <i class="ti ti-settings me-1"></i> Buka Pengaturan Approval Matrix
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($formation->canSubmit() && $hasApprovalMatrix && $nextApproverLabel)
            <div class="alert alert-info border-info">
                <div class="d-flex align-items-center">
                    <i class="ti ti-info-circle fs-4 me-3"></i>
                    <div>
                        Saat diajukan, SK ini akan dikirim ke approver:
                        <strong>{{ $nextApproverLabel }}</strong>
                        (Level 1 dari {{ $flowLevels->count() }} level).
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi SK</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Proyek</dt>
                            <dd class="col-sm-9">{{ $formation->project->project_code ?? '-' }} — {{ $formation->project->project_name ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Kontrak</dt>
                            <dd class="col-sm-9">{{ $formation->contract->contract_number ?? '-' }}</dd>

                            @if($formation->unitRequest)
                                <dt class="col-sm-3 text-muted">Unit Request</dt>
                                <dd class="col-sm-9">{{ $formation->unitRequest->request_number }}</dd>
                            @endif

                            <dt class="col-sm-3 text-muted">Berlaku Mulai</dt>
                            <dd class="col-sm-9">{{ $formation->effective_date?->format('d M Y') ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Berlaku Sampai</dt>
                            <dd class="col-sm-9">{{ $formation->end_date?->format('d M Y') ?? '— (mengikuti kontrak)' }}</dd>

                            <dt class="col-sm-3 text-muted">Dibuat Oleh</dt>
                            <dd class="col-sm-9">{{ $formation->creator->name ?? '-' }} <small class="text-muted">({{ $formation->created_at->format('d M Y H:i') }})</small></dd>

                            @if($formation->approved_by)
                                <dt class="col-sm-3 text-muted">Disetujui Oleh</dt>
                                <dd class="col-sm-9">{{ $formation->approver->name ?? '-' }} <small class="text-muted">({{ $formation->approved_at?->format('d M Y H:i') }})</small></dd>
                            @endif

                            @if($formation->notes)
                                <dt class="col-sm-3 text-muted">Catatan</dt>
                                <dd class="col-sm-9">{{ $formation->notes }}</dd>
                            @endif

                            @if($formation->attachment_path)
                                <dt class="col-sm-3 text-muted">Dokumen SK</dt>
                                <dd class="col-sm-9">
                                    <a href="{{ route('unit-formations.attachment', $formation->uid) }}" class="link-primary">
                                        <i class="ti ti-download me-1"></i> Unduh Dokumen
                                    </a>
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Unit & Operator ({{ $formation->items->count() }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle">
                                <thead class="table-light text-uppercase small">
                                    <tr>
                                        <th>#</th>
                                        <th>Unit</th>
                                        <th>Operator</th>
                                        <th class="text-end">HM Awal</th>
                                        <th class="text-end">Target/Bulan</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($formation->items as $i => $item)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <div class="fw-medium">{{ $item->unit_name }}</div>
                                                @if($item->equipment_code)
                                                    <div class="small text-muted">{{ $item->equipment_code }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $item->operator_name ?? '—' }}</td>
                                            <td class="text-end">{{ number_format($item->hm_start, 0, ',', '.') }} HM</td>
                                            <td class="text-end">
                                                @if($item->hm_target_monthly)
                                                    {{ number_format($item->hm_target_monthly, 0, ',', '.') }} HM
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusBadge = match($item->status) {
                                                        'READY' => 'secondary',
                                                        'ACTIVE' => 'success',
                                                        'DOWN' => 'danger',
                                                        'RETURNED' => 'dark',
                                                        'REPLACED' => 'warning',
                                                        default => 'light',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusBadge }}-subtle text-{{ $statusBadge }}">{{ $item->status }}</span>
                                            </td>
                                            <td class="small text-muted">{{ $item->remarks ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada unit.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if($formation->canApprove() && $isCurrentApprover)
                    <div class="card border-warning">
                        <div class="card-header bg-warning-subtle">
                            <h5 class="card-title mb-0 text-warning">
                                <i class="ti ti-checks me-1"></i> Aksi Approval (Level {{ $formation->current_approval_level }} dari {{ $flowLevels->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($nextApproverLabel)
                                <div class="alert alert-light border mb-3 py-2 px-3 small">
                                    <i class="ti ti-user-check me-1 text-muted"></i>
                                    Approver level ini: <strong>{{ $nextApproverLabel }}</strong>
                                </div>
                            @endif
                            <form action="{{ route('unit-formations.approve', $formation->uid) }}" method="POST" id="approve-form">
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
                @elseif($formation->canApprove() && ! $isCurrentApprover)
                    <div class="card border-info">
                        <div class="card-header bg-info-subtle">
                            <h5 class="card-title mb-0 text-info">
                                <i class="ti ti-hourglass me-1"></i> Menunggu Approval (Level {{ $formation->current_approval_level }} dari {{ $flowLevels->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">SK sedang menunggu persetujuan dari:</p>
                            @if($nextApproverLabel)
                                <div class="d-flex align-items-center p-2 bg-light rounded">
                                    <i class="ti ti-user-circle fs-3 text-info me-2"></i>
                                    <div>
                                        <strong>{{ $nextApproverLabel }}</strong>
                                        <div class="small text-muted">Hanya user/role di atas yang dapat memproses approval.</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Riwayat Approval</h5>
                    </div>
                    <div class="card-body">
                        @forelse($formation->approvals as $appr)
                            @php
                                $level = $flowLevels->get($appr->level);
                                $statusColor = match($appr->status) {
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    default => 'warning',
                                };
                                $statusLabel = match($appr->status) {
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'pending'  => 'Menunggu',
                                    default    => ucfirst($appr->status),
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
            title: isReject ? 'Tolak SK ini?' : 'Setujui SK ini?',
            text:  isReject ? 'Pastikan catatan penolakan diisi.' : 'SK akan diteruskan ke level berikutnya (jika ada).',
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
