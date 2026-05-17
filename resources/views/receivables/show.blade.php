@extends('layout.mainlayout')
@section('title', 'Detail Penerimaan Dana')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    {{ $receivable->receivable_number }}
                    <span class="badge bg-{{ $receivable->status->color() }}-subtle text-{{ $receivable->status->color() }} fs-13 text-uppercase ms-2">
                        {{ $receivable->status->label() }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('receivables.index') }}">Penerimaan Dana</a></li>
                        <li class="breadcrumb-item active">{{ $receivable->receivable_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @if($receivable->canEdit())
                    <a href="{{ route('receivables.edit', $receivable->uid) }}" class="btn btn-outline-primary btn-sm">
                        <i class="ti ti-edit me-1"></i> Edit
                    </a>
                @endif

                @if($receivable->canSubmit())
                    @if($hasApprovalMatrix)
                        <form action="{{ route('receivables.submit', $receivable->uid) }}" method="POST" class="d-inline js-confirm-form"
                              data-title="Ajukan Approval?"
                              data-text="Penerimaan akan dikirim ke {{ $nextApproverLabel }} untuk diperiksa."
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

        @if($receivable->canSubmit() && ! $hasApprovalMatrix)
            <div class="alert alert-warning border-warning">
                <h6 class="alert-heading"><i class="ti ti-alert-triangle me-1"></i>Matriks Approval Belum Diatur</h6>
                <p class="mb-2">Tombol Ajukan dinonaktifkan karena belum ada konfigurasi level approver untuk <code>Receivable</code>.</p>
                <a href="{{ route('approval-flows.index') }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-settings me-1"></i> Buka Approval Matrix
                </a>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                {{-- Info Penerimaan --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-receipt me-1"></i>Data Penerimaan</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Proyek</dt>
                            <dd class="col-sm-9">{{ $receivable->project->project_name ?? '-' }} ({{ $receivable->project->project_code ?? '-' }})</dd>

                            <dt class="col-sm-3 text-muted">Customer</dt>
                            <dd class="col-sm-9">{{ $receivable->customer_name ?? '-' }}</dd>

                            <dt class="col-sm-3 text-muted">Invoice Terkait</dt>
                            <dd class="col-sm-9">
                                @if($receivable->invoice)
                                    <a href="{{ route('invoices.show', $receivable->invoice->uid) }}" class="link-primary">
                                        {{ $receivable->invoice->invoice_number }}
                                    </a>
                                    <small class="text-muted">— Rp {{ number_format($receivable->invoice->total_amount, 0, ',', '.') }}</small>
                                @else
                                    <span class="badge bg-info-subtle text-info">Uang Muka (tanpa Invoice)</span>
                                @endif
                            </dd>

                            <dt class="col-sm-3 text-muted">Tanggal Penerimaan</dt>
                            <dd class="col-sm-9"><i class="ti ti-calendar me-1"></i>{{ $receivable->received_date?->format('d M Y') }}</dd>

                            <dt class="col-sm-3 text-muted">Nominal</dt>
                            <dd class="col-sm-9 fw-semibold fs-5 text-success">Rp {{ number_format($receivable->amount, 0, ',', '.') }}</dd>

                            <dt class="col-sm-3 text-muted">Jenis Pembayaran</dt>
                            <dd class="col-sm-9">
                                <span class="badge bg-{{ $receivable->payment_type === \App\Enums\PaymentType::TUNAI ? 'warning' : 'info' }}-subtle text-{{ $receivable->payment_type === \App\Enums\PaymentType::TUNAI ? 'warning' : 'info' }} fs-13">
                                    <i class="ti {{ $receivable->payment_type->icon() }} me-1"></i>{{ $receivable->payment_type->label() }}
                                </span>
                            </dd>

                            @if($receivable->payment_reference)
                                <dt class="col-sm-3 text-muted">No. Referensi</dt>
                                <dd class="col-sm-9"><code>{{ $receivable->payment_reference }}</code></dd>
                            @endif

                            @if($receivable->description)
                                <dt class="col-sm-3 text-muted">Keterangan</dt>
                                <dd class="col-sm-9">{{ $receivable->description }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Lampiran --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Bukti Penerimaan</h5></div>
                    <div class="card-body">
                        @if($receivable->attachment_path)
                            <div class="d-flex align-items-center">
                                <i class="ti ti-file-text fs-1 text-primary me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Bukti Uang Muka (Kwitansi / Slip Transfer)</h6>
                                    <p class="text-muted small mb-2">File lampiran tersimpan.</p>
                                    <a href="{{ route('receivables.attachment', $receivable->uid) }}" class="btn btn-soft-primary btn-sm">
                                        <i class="ti ti-download me-1"></i> Unduh Bukti
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="text-muted text-center py-3 mb-0">
                                <i class="ti ti-file-off fs-2 d-block mb-2"></i>
                                Belum ada lampiran bukti.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Approval Action --}}
                @if($receivable->canApprove() && $isCurrentApprover)
                    <div class="card border-warning">
                        <div class="card-header bg-warning-subtle">
                            <h5 class="card-title mb-0 text-warning">
                                <i class="ti ti-checks me-1"></i> Aksi Approval (Level {{ $receivable->current_approval_level }} dari {{ $flowLevels->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($nextApproverLabel)
                                <div class="alert alert-light border mb-3 py-2 px-3 small">
                                    <i class="ti ti-user-check me-1 text-muted"></i>
                                    Approver level ini: <strong>{{ $nextApproverLabel }}</strong>
                                </div>
                            @endif
                            <form action="{{ route('receivables.approve', $receivable->uid) }}" method="POST" id="approve-form">
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
                @elseif($receivable->canApprove() && ! $isCurrentApprover)
                    <div class="card border-info">
                        <div class="card-header bg-info-subtle">
                            <h5 class="card-title mb-0 text-info">
                                <i class="ti ti-hourglass me-1"></i> Menunggu Approval
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Penerimaan menunggu persetujuan dari:</p>
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

                {{-- Metadata --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Riwayat</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0 small">
                            <dt class="col-5 text-muted">Dibuat oleh</dt>
                            <dd class="col-7">{{ $receivable->creator->name ?? '-' }}<br><span class="text-muted">{{ $receivable->created_at->format('d M Y H:i') }}</span></dd>

                            @if($receivable->approved_by)
                                <dt class="col-5 text-muted">Disetujui oleh</dt>
                                <dd class="col-7">{{ $receivable->approver->name ?? '-' }}<br><span class="text-muted">{{ $receivable->approved_at?->format('d M Y H:i') }}</span></dd>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Approval History --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Riwayat Approval</h5></div>
                    <div class="card-body">
                        @forelse($receivable->approvals as $appr)
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
            title: isReject ? 'Tolak Penerimaan?' : 'Setujui Penerimaan?',
            text:  isReject ? 'Pastikan catatan penolakan diisi.' : 'Penerimaan akan diteruskan ke level berikutnya (jika ada).',
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
