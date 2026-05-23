@extends('layout.mainlayout')
@section('title', 'Detail Permintaan Kas Kecil')
@section('content')
@php $r = $request; @endphp
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    {{ $r->request_number }}
                    <span class="badge bg-{{ $r->status->color() }}-subtle text-{{ $r->status->color() }} fs-13 text-uppercase ms-2">{{ $r->status->label() }}</span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('petty-cash-requests.index') }}">Permintaan Kas Kecil</a></li>
                        <li class="breadcrumb-item active">{{ $r->request_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @if($r->canEdit())
                    <a href="{{ route('petty-cash-requests.edit', $r->uid) }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-edit me-1"></i>Edit</a>
                @endif
                @if($r->canSubmit())
                    @if($hasApprovalMatrix)
                        <form action="{{ route('petty-cash-requests.submit', $r->uid) }}" method="POST" class="d-inline js-confirm-form"
                              data-title="Ajukan Approval?" data-text="Permintaan akan dikirim ke {{ $nextApproverLabel }}."
                              data-icon="question" data-confirm-text="Ya, Ajukan" data-confirm-color="#3b82f6">
                            @csrf<button class="btn btn-primary btn-sm" type="submit"><i class="ti ti-send me-1"></i>Ajukan Approval</button>
                        </form>
                    @else
                        <button class="btn btn-primary btn-sm" disabled title="Matriks approval belum diatur."><i class="ti ti-send me-1"></i>Ajukan Approval <i class="ti ti-lock ms-1"></i></button>
                    @endif
                @endif
                @if($r->status === \App\Enums\PettyCashRequestStatus::APPROVED)
                    <form action="{{ route('petty-cash-requests.close', $r->uid) }}" method="POST" class="d-inline js-confirm-form"
                          data-title="Tandai Selesai?" data-text="Permintaan akan ditandai selesai. Pastikan tidak ada lagi pemakaian." data-icon="warning"
                          data-confirm-text="Ya, Selesaikan" data-confirm-color="#6b7280">
                        @csrf<button class="btn btn-outline-dark btn-sm" type="submit"><i class="ti ti-flag-check me-1"></i>Tandai Selesai</button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif

        @if($r->canSubmit() && ! $hasApprovalMatrix)
            <div class="alert alert-warning border-warning">
                <h6 class="alert-heading"><i class="ti ti-alert-triangle me-1"></i>Matriks Approval Belum Diatur</h6>
                <p class="mb-2">Konfigurasi level approver untuk <code>PettyCashRequest</code> belum dibuat.</p>
                <a href="{{ route('approval-flows.index') }}" class="btn btn-sm btn-warning"><i class="ti ti-settings me-1"></i>Buka Approval Matrix</a>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Data Permintaan</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3 text-muted">Proyek</dt>
                            <dd class="col-sm-9">{{ $r->project->project_name ?? '-' }} <small class="text-muted">({{ $r->project->project_code ?? '-' }})</small></dd>

                            <dt class="col-sm-3 text-muted">Tanggal Permintaan</dt>
                            <dd class="col-sm-9">{{ $r->request_date?->format('d M Y') }}</dd>

                            <dt class="col-sm-3 text-muted">Nominal Diminta</dt>
                            <dd class="col-sm-9 fw-semibold fs-18 text-primary">Rp {{ number_format($r->requested_amount, 0, ',', '.') }}</dd>

                            <dt class="col-sm-3 text-muted">Uraian</dt>
                            <dd class="col-sm-9">{{ $r->description }}</dd>

                            <dt class="col-sm-3 text-muted">Dibuat oleh</dt>
                            <dd class="col-sm-9">{{ $r->creator->name ?? '-' }} <small class="text-muted">({{ $r->created_at->format('d M Y H:i') }})</small></dd>

                            @if($r->approved_by)
                                <dt class="col-sm-3 text-muted">Disetujui oleh</dt>
                                <dd class="col-sm-9">{{ $r->approver->name ?? '-' }} <small class="text-muted">({{ $r->approved_at?->format('d M Y H:i') }})</small></dd>
                            @endif

                            <dt class="col-sm-3 text-muted">Lampiran</dt>
                            <dd class="col-sm-9">
                                @if($r->attachment_path)
                                    <a href="{{ route('petty-cash-requests.attachment', $r->uid) }}" class="btn btn-soft-primary btn-sm"><i class="ti ti-download me-1"></i>Unduh</a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                {{-- Pemakaian (Pembayaran + Pembelian) --}}
                @if($r->status === \App\Enums\PettyCashRequestStatus::APPROVED || $r->payments->isNotEmpty() || $r->purchases->isNotEmpty())
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Pemakaian Kas</h5>
                        @if($r->canBeUsedForPayment())
                            <div>
                                <a href="{{ route('petty-cash-payments.create', ['petty_cash_request_id' => $r->id]) }}" class="btn btn-soft-primary btn-sm"><i class="ti ti-plus me-1"></i>Pembayaran</a>
                                <a href="{{ route('petty-cash-purchases.create', ['petty_cash_request_id' => $r->id]) }}" class="btn btn-soft-success btn-sm"><i class="ti ti-shopping-cart me-1"></i>Pembelian</a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @php
                            $usage = $r->payments->map(fn($p) => (object)[
                                'type' => 'Pembayaran', 'number' => $p->payment_number, 'date' => $p->payment_date,
                                'category' => $p->expenseCategory->name ?? '-', 'description' => $p->description,
                                'amount' => $p->amount, 'status' => $p->status, 'uid' => $p->uid, 'route' => 'petty-cash-payments.show',
                            ])->concat($r->purchases->map(fn($p) => (object)[
                                'type' => 'Pembelian', 'number' => $p->purchase_number, 'date' => $p->purchase_date,
                                'category' => $p->expenseCategory->name ?? ($p->purchase_order_number ? 'PO: '.$p->purchase_order_number : '-'),
                                'description' => $p->description, 'amount' => $p->amount, 'status' => $p->status, 'uid' => $p->uid, 'route' => 'petty-cash-purchases.show',
                            ]))->sortByDesc('date');
                        @endphp
                        @if($usage->isEmpty())
                            <p class="text-muted text-center py-3 mb-0">Belum ada pemakaian kas.</p>
                        @else
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead class="table-light text-uppercase small">
                                    <tr><th>Jenis</th><th>Nomor</th><th>Tanggal</th><th>Kategori / PO</th><th>Uraian</th><th class="text-end">Nominal</th><th>Status</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($usage as $u)
                                    <tr>
                                        <td><span class="badge bg-{{ $u->type === 'Pembayaran' ? 'primary' : 'success' }}-subtle text-{{ $u->type === 'Pembayaran' ? 'primary' : 'success' }}">{{ $u->type }}</span></td>
                                        <td><a href="{{ route($u->route, $u->uid) }}" class="link-primary">{{ $u->number }}</a></td>
                                        <td class="small">{{ $u->date?->format('d M Y') }}</td>
                                        <td class="small">{{ $u->category }}</td>
                                        <td class="small text-muted">{{ \Illuminate\Support\Str::limit($u->description, 50) }}</td>
                                        <td class="text-end fw-semibold">Rp {{ number_format($u->amount, 0, ',', '.') }}</td>
                                        <td><span class="badge bg-{{ $u->status->color() }}-subtle text-{{ $u->status->color() }} text-uppercase small">{{ $u->status->label() }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                {{-- Approval --}}
                @if($r->canApprove() && $isCurrentApprover)
                    <div class="card border-warning">
                        <div class="card-header bg-warning-subtle"><h5 class="card-title mb-0 text-warning"><i class="ti ti-checks me-1"></i>Aksi Approval (Level {{ $r->current_approval_level }} dari {{ $flowLevels->count() }})</h5></div>
                        <div class="card-body">
                            @if($nextApproverLabel)<div class="alert alert-light border mb-3 py-2 px-3 small"><i class="ti ti-user-check me-1 text-muted"></i>Approver level ini: <strong>{{ $nextApproverLabel }}</strong></div>@endif
                            <form action="{{ route('petty-cash-requests.approve', $r->uid) }}" method="POST" id="approve-form">
                                @csrf
                                <input type="hidden" name="decision" id="approve-decision">
                                <div class="mb-3">
                                    <label class="form-label">Catatan Approval</label>
                                    <textarea name="remarks" class="form-control" rows="2" placeholder="Opsional, wajib jika menolak."></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success btn-sm flex-fill" data-approve-decision="approved"><i class="ti ti-check me-1"></i>Setujui</button>
                                    <button type="button" class="btn btn-danger btn-sm flex-fill" data-approve-decision="rejected"><i class="ti ti-x me-1"></i>Tolak</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif($r->canApprove() && ! $isCurrentApprover)
                    <div class="card border-info">
                        <div class="card-header bg-info-subtle"><h5 class="card-title mb-0 text-info"><i class="ti ti-hourglass me-1"></i>Menunggu Approval</h5></div>
                        <div class="card-body">
                            <p class="mb-2">Permintaan menunggu persetujuan dari:</p>
                            @if($nextApproverLabel)<div class="d-flex align-items-center p-2 bg-light rounded"><i class="ti ti-user-circle fs-3 text-info me-2"></i><div><strong>{{ $nextApproverLabel }}</strong><div class="small text-muted">Hanya user/role di atas yang dapat memproses.</div></div></div>@endif
                        </div>
                    </div>
                @endif

                {{-- Saldo --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Saldo Permintaan</h5></div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr><td>Nominal Diminta</td><td class="text-end fw-semibold">Rp {{ number_format($r->requested_amount, 0, ',', '.') }}</td></tr>
                            <tr><td>Terpakai</td><td class="text-end text-danger">- Rp {{ number_format($r->used_amount, 0, ',', '.') }}</td></tr>
                            <tr class="border-top"><td class="fw-bold">Sisa</td><td class="text-end fw-bold fs-18 text-{{ $r->remaining_amount > 0 ? 'success' : 'secondary' }}">Rp {{ number_format($r->remaining_amount, 0, ',', '.') }}</td></tr>
                        </table>
                        @php
                            $usedPct = (float)$r->requested_amount > 0 ? min(100, ((float)$r->used_amount / (float)$r->requested_amount) * 100) : 0;
                        @endphp
                        <div class="progress mt-3" style="height:6px"><div class="progress-bar bg-warning" style="width: {{ $usedPct }}%"></div></div>
                        <small class="text-muted">{{ number_format($usedPct, 1) }}% terpakai</small>
                    </div>
                </div>

                {{-- Approval History --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Riwayat Approval</h5></div>
                    <div class="card-body">
                        @forelse($r->approvals as $appr)
                            @php
                                $level = $flowLevels->get($appr->level);
                                $sc = match($appr->status) { 'approved' => 'success', 'rejected' => 'danger', default => 'warning' };
                                $sl = match($appr->status) { 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'pending' => 'Menunggu', default => ucfirst($appr->status) };
                            @endphp
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0"><span class="avatar-xs"><span class="avatar-title bg-{{ $sc }}-subtle text-{{ $sc }} rounded-circle">{{ $appr->level }}</span></span></div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Level {{ $appr->level }} <span class="badge bg-{{ $sc }}-subtle text-{{ $sc }} ms-1">{{ $sl }}</span></h6>
                                    <p class="text-muted mb-0 small">{{ $appr->approver->name ?? ($level?->approver_type->label() ?? 'Menunggu approver') }}@if($appr->approved_at) • {{ $appr->approved_at->format('d M Y H:i') }}@endif</p>
                                    @if($appr->remarks)<p class="small mt-1 mb-0"><i>"{{ $appr->remarks }}"</i></p>@endif
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
            title: $form.data('title') || 'Konfirmasi', text: $form.data('text') || 'Lanjutkan?',
            icon: $form.data('icon') || 'question', showCancelButton: true,
            confirmButtonText: $form.data('confirm-text') || 'Ya', cancelButtonText: 'Batal',
            confirmButtonColor: $form.data('confirm-color') || '#3b82f6', cancelButtonColor: '#6b7280',
            reverseButtons: true, focusCancel: true,
        }).then(r => { if (r.isConfirmed) { $form.data('confirmed', true); $form.trigger('submit'); } });
    });

    $('button[data-approve-decision]').on('click', function() {
        const decision = $(this).data('approve-decision');
        const $form = $(this).closest('form');
        const $remarks = $form.find('textarea[name="remarks"]');
        const isReject = decision === 'rejected';
        Swal.fire({
            title: isReject ? 'Tolak Permintaan?' : 'Setujui Permintaan?',
            text: isReject ? 'Pastikan catatan penolakan diisi.' : 'Permintaan akan diteruskan ke level berikutnya (jika ada).',
            icon: isReject ? 'warning' : 'question', showCancelButton: true,
            confirmButtonText: isReject ? 'Ya, Tolak' : 'Ya, Setujui', cancelButtonText: 'Batal',
            confirmButtonColor: isReject ? '#dc2626' : '#10b981', cancelButtonColor: '#6b7280',
            reverseButtons: true, focusCancel: true,
            input: isReject ? 'textarea' : undefined, inputLabel: isReject ? 'Catatan Penolakan (wajib)' : undefined,
            inputValue: $remarks.val() || '',
            inputValidator: isReject ? (v) => !v && 'Catatan penolakan wajib diisi.' : undefined,
        }).then(r => {
            if (!r.isConfirmed) return;
            $form.find('#approve-decision').val(decision);
            if (isReject && r.value) $remarks.val(r.value);
            $form[0].submit();
        });
    });
})();
</script>
@endpush
@endsection
