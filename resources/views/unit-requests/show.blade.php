@extends('layout.mainlayout')
@section('title', 'Detail Permintaan Unit - ' . $unitRequest->request_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    Permintaan Unit
                    <span class="badge bg-{{ $unitRequest->status->color() }}-subtle text-{{ $unitRequest->status->color() }} ms-2 fs-6 align-middle text-uppercase">
                        {{ $unitRequest->status->label() }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-requests.index') }}">Permintaan Unit</a></li>
                        <li class="breadcrumb-item active">{{ $unitRequest->request_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                {{-- Edit --}}
                @if($unitRequest->isEditable())
                <a href="{{ route('unit-requests.edit', $unitRequest->uid) }}" class="btn btn-outline-primary btn-sm">
                    <i class="ti ti-edit me-1"></i>Edit
                </a>
                @endif

                {{-- Submit --}}
                @if($unitRequest->canSubmit())
                    @if($hasApprovalMatrix)
                    <form action="{{ route('unit-requests.submit', $unitRequest->uid) }}" method="POST" class="d-inline js-confirm-form"
                          data-title="Ajukan Approval?"
                          data-text="Permintaan akan dikirim ke {{ $nextApproverLabel }} untuk diverifikasi."
                          data-icon="question" data-confirm-text="Ya, Ajukan" data-confirm-color="#3b82f6">
                        @csrf
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="ti ti-send me-1"></i>Ajukan Approval
                        </button>
                    </form>
                    @else
                    <button class="btn btn-primary btn-sm" disabled title="Matriks approval belum diatur.">
                        <i class="ti ti-send me-1"></i>Ajukan Approval <i class="ti ti-lock ms-1"></i>
                    </button>
                    @endif
                @endif

                {{-- Forward to Workshop (only if approved & authorized) --}}
                @if($unitRequest->canForward() && $canForward)
                <form action="{{ route('unit-requests.forward', $unitRequest->uid) }}" method="POST" class="d-inline js-confirm-form"
                      data-title="Teruskan ke Workshop?"
                      data-text="Permintaan Unit yang sudah disetujui akan diteruskan ke Workshop untuk persiapan unit."
                      data-icon="question" data-confirm-text="Ya, Teruskan" data-confirm-color="#06b6d4">
                    @csrf
                    <button type="submit" class="btn btn-info btn-sm text-white">
                        <i class="ti ti-arrow-right me-1"></i>Teruskan ke Workshop
                    </button>
                </form>
                @endif

                {{-- Attachment Download --}}
                @if($unitRequest->attachment_path)
                <a href="{{ route('unit-requests.attachment', $unitRequest->uid) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-download me-1"></i>Lampiran
                </a>
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

        {{-- Warning: matriks approval belum di-setup --}}
        @if($unitRequest->canSubmit() && ! $hasApprovalMatrix)
            <div class="alert alert-warning border-warning">
                <h6 class="alert-heading"><i class="ti ti-alert-triangle me-1"></i>Matriks Approval Belum Diatur</h6>
                <p class="mb-2">Tombol Ajukan dinonaktifkan karena belum ada konfigurasi level approver untuk <code>UnitRequest</code>.</p>
                <a href="{{ route('approval-flows.index') }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-settings me-1"></i> Buka Approval Matrix
                </a>
            </div>
        @endif

        <div class="row">
            <!-- Left: Request Info + Items -->
            <div class="col-lg-8">
                <!-- Request Info Card -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-info-circle me-2 text-primary"></i>Informasi Permintaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Nomor Permintaan</label>
                                <p class="fw-semibold mb-0">{{ $unitRequest->request_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Proyek</label>
                                <p class="fw-semibold mb-0">{{ $unitRequest->project->project_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Tanggal Permintaan</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->request_date ? $unitRequest->request_date->format('d F Y') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Tanggal Mobilisasi</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->mobilization_date ? $unitRequest->mobilization_date->format('d F Y') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Final Contract</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->contract->contract_number ?? '-' }}
                                    @if($unitRequest->contract)
                                        <small class="text-muted d-block">
                                            {{ $unitRequest->contract->start_date?->format('d M Y') }} s/d {{ $unitRequest->contract->end_date?->format('d M Y') }}
                                        </small>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Negosiasi / Quotation</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->negotiation->negotiation_number ?? '-' }}
                                    @if($unitRequest->quotation)
                                        <small class="text-muted d-block">Q: {{ $unitRequest->quotation->quotation_number ?? '-' }}</small>
                                    @endif
                                </p>
                            </div>
                            @if($unitRequest->notes)
                            <div class="col-12">
                                <label class="form-label text-muted small mb-1">Catatan</label>
                                <p class="mb-0">{{ $unitRequest->notes }}</p>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Dibuat Oleh</label>
                                <p class="fw-semibold mb-0">{{ $unitRequest->creator->name ?? '-' }}</p>
                            </div>
                            @if($unitRequest->approved_at)
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Disetujui Oleh</label>
                                <p class="fw-semibold mb-0">
                                    {{ $unitRequest->approver->name ?? '-' }}
                                    <small class="text-muted d-block">{{ $unitRequest->approved_at->format('d M Y, H:i') }}</small>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Unit Items Table -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-list me-2 text-primary"></i>Daftar Unit (dari Final Contract)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width:40px">#</th>
                                        <th>Nama Unit</th>
                                        <th class="text-center" style="width:80px">Qty</th>
                                        <th class="text-center" style="width:100px">Durasi (Hari)</th>
                                        <th>Keterangan</th>
                                        <th style="width:180px">Operator</th>
                                        <th class="text-center" style="width:120px">Status Workshop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitRequest->items as $idx => $item)
                                    <tr>
                                        <td class="text-center">{{ $idx + 1 }}</td>
                                        <td>{{ $item->unit_name }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-center">{{ $item->duration_days ?? '-' }}</td>
                                        <td>{{ $item->remarks ?? '-' }}</td>
                                        <td>
                                            @if($item->operator_name || $item->operator_id)
                                                @php
                                                    $opProfile = $operators[$item->operator_id] ?? null;
                                                    $opName    = $item->operator_name ?: ($opProfile['name'] ?? '-');
                                                    $opPos     = $opProfile['position'] ?? null;
                                                    $initials  = collect(explode(' ', trim($opName)))
                                                        ->filter()
                                                        ->take(2)
                                                        ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                                                        ->implode('');
                                                    $photoUrl  = $item->operator_id
                                                        ? route('employees.photo', ['id' => $item->operator_id])
                                                        : null;
                                                @endphp
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="position-relative" style="width:36px;height:36px;flex-shrink:0;">
                                                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-semibold position-absolute top-0 start-0"
                                                            style="width:36px;height:36px;font-size:13px;">
                                                            {{ $initials ?: '?' }}
                                                        </span>
                                                        @if($photoUrl)
                                                            <img src="{{ $photoUrl }}" alt="{{ $opName }}"
                                                                class="rounded-circle position-absolute top-0 start-0"
                                                                style="width:36px;height:36px;object-fit:cover;background:#fff;"
                                                                onerror="this.style.display='none'">
                                                        @endif
                                                    </div>
                                                    <div class="lh-sm">
                                                        <div class="fw-semibold">{{ $opName }}</div>
                                                        @if($opPos)
                                                            <small class="text-muted">{{ $opPos }}</small>
                                                        @elseif($item->operator_id)
                                                            <small class="text-muted">ID: {{ $item->operator_id }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted fst-italic">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(is_null($item->unit_ready))
                                                <span class="badge bg-secondary-subtle text-secondary">Menunggu</span>
                                            @elseif($item->unit_ready)
                                                <span class="badge bg-success-subtle text-success">Siap</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">Belum Siap</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">Belum ada unit.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Approval Actions + History -->
            <div class="col-lg-4">
                {{-- Approval Panel: muncul saat SUBMITTED dan user adalah approver level current --}}
                @if($unitRequest->canApprove() && $isApprover)
                <div class="card border border-warning mb-3">
                    <div class="card-header bg-warning-subtle">
                        <h5 class="card-title mb-0 text-warning">
                            <i class="ti ti-checks me-2"></i>Aksi Approval
                            @php
                                $currentApprovalLevel = $unitRequest->approvals->firstWhere('status', 'pending')?->level;
                            @endphp
                            @if($currentApprovalLevel)
                                <small class="text-muted">(Level {{ $currentApprovalLevel }} dari {{ $flowLevels->count() }})</small>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($nextApproverLabel)
                            <div class="alert alert-light border mb-3 py-2 px-3 small">
                                <i class="ti ti-user-check me-1 text-muted"></i>
                                Approver level ini: <strong>{{ $nextApproverLabel }}</strong>
                            </div>
                        @endif
                        <form action="{{ route('unit-requests.approve', $unitRequest->uid) }}" method="POST" id="approve-form">
                            @csrf
                            <input type="hidden" name="decision" id="approve-decision">
                            <div class="mb-3">
                                <label class="form-label">Catatan Approval</label>
                                <textarea name="remarks" class="form-control" rows="2" placeholder="Opsional, wajib jika menolak."></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success btn-sm flex-fill" data-approve-decision="approved">
                                    <i class="ti ti-check me-1"></i>Setujui
                                </button>
                                <button type="button" class="btn btn-danger btn-sm flex-fill" data-approve-decision="rejected">
                                    <i class="ti ti-x me-1"></i>Tolak
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @elseif($unitRequest->canApprove() && ! $isApprover)
                {{-- Non-approver melihat: tampilkan info siapa approver --}}
                <div class="card border-info mb-3">
                    <div class="card-header bg-info-subtle">
                        <h5 class="card-title mb-0 text-info">
                            <i class="ti ti-hourglass me-1"></i> Menunggu Approval
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">Permintaan menunggu persetujuan dari:</p>
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

                {{-- Info: sudah APPROVED, menunggu forward ke Workshop --}}
                @if($unitRequest->canForward())
                <div class="card border-success mb-3">
                    <div class="card-header bg-success-subtle">
                        <h5 class="card-title mb-0 text-success"><i class="ti ti-circle-check me-1"></i>Siap Diteruskan ke Workshop</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0 small">
                            Permintaan sudah disetujui. Klik tombol <strong>Teruskan ke Workshop</strong> di atas untuk meneruskan persiapan unit.
                            @if(! $canForward)
                                <span class="d-block mt-2 text-muted"><i class="ti ti-lock me-1"></i>Hanya pembuat permintaan atau tim Workshop yang dapat meneruskan.</span>
                            @endif
                        </p>
                    </div>
                </div>
                @endif

                <!-- Approval History -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-history me-2 text-primary"></i>Riwayat Approval</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($unitRequest->approvals->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="ti ti-clock fs-3 d-block mb-2"></i>
                            Belum ada riwayat approval.
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Level</th>
                                        <th>Approver</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unitRequest->approvals as $approval)
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">L{{ $approval->level }}</span>
                                        </td>
                                        <td>
                                            @if($approval->approver_id)
                                                {{ $approval->approver->name }}
                                            @else
                                                @php
                                                    $levelDef = $flowLevels[$approval->level] ?? null;
                                                    $target = 'Menunggu';
                                                    if ($levelDef) {
                                                        if ($levelDef->approver_type->value === 'USER') {
                                                            $target = \App\Models\User::find($levelDef->approver_user_id)?->name ?? 'User';
                                                        } elseif ($levelDef->approver_type->value === 'ROLE') {
                                                            $role = \Spatie\Permission\Models\Role::find($levelDef->approver_role_id);
                                                            $target = $role ? $role->name : 'Role';
                                                        } elseif ($levelDef->approver_type->value === 'DEPARTMENT') {
                                                            $target = 'Department Head';
                                                        }
                                                    }
                                                @endphp
                                                <span class="text-muted">{{ $target }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badgeColor = match($approval->status) {
                                                    'approved' => 'success',
                                                    'rejected' => 'danger',
                                                    default    => 'warning',
                                                };
                                                $statusLabel = match($approval->status) {
                                                    'approved' => 'Disetujui',
                                                    'rejected' => 'Ditolak',
                                                    'pending'  => 'Menunggu',
                                                    default    => ucfirst($approval->status),
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="small text-muted">
                                            {{ $approval->approved_at ? $approval->approved_at->format('d M Y') : '-' }}
                                        </td>
                                    </tr>
                                    @if($approval->remarks)
                                    <tr class="table-light">
                                        <td colspan="4" class="small text-muted fst-italic ps-4">
                                            <i class="ti ti-message me-1"></i>{{ $approval->remarks }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
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
            title: isReject ? 'Tolak Permintaan?' : 'Setujui Permintaan?',
            text:  isReject ? 'Pastikan catatan penolakan diisi sebagai dasar revisi.' : 'Permintaan akan diteruskan ke level berikutnya (jika ada) atau disetujui final.',
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
