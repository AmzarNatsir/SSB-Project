@extends('layout.mainlayout')
@section('title', 'Detail Invoice')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">
                    {{ $invoice->invoice_number }}
                    <span class="badge bg-{{ $invoice->status->color() }}-subtle text-{{ $invoice->status->color() }} fs-13 text-uppercase ms-2">
                        {{ $invoice->status->label() }}
                    </span>
                </h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoice</a></li>
                        <li class="breadcrumb-item active">{{ $invoice->invoice_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @if($invoice->canEdit())
                    <a href="{{ route('invoices.edit', $invoice->uid) }}" class="btn btn-outline-primary btn-sm">
                        <i class="ti ti-edit me-1"></i> Edit
                    </a>
                @endif

                @if($invoice->canSubmit())
                    @if($hasApprovalMatrix)
                        <form action="{{ route('invoices.submit', $invoice->uid) }}" method="POST" class="d-inline js-confirm-form"
                              data-title="Ajukan Approval?"
                              data-text="Invoice akan dikirim ke {{ $nextApproverLabel }} untuk diperiksa."
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

                @if($invoice->canMarkPaid())
                    <form action="{{ route('invoices.mark-paid', $invoice->uid) }}" method="POST" class="d-inline js-confirm-form"
                          data-title="Tandai Lunas?"
                          data-text="Invoice akan ditandai sebagai Lunas. Pastikan pembayaran sudah diterima."
                          data-icon="question" data-confirm-text="Ya, Lunas" data-confirm-color="#10b981">
                        @csrf
                        <button class="btn btn-success btn-sm" type="submit">
                            <i class="ti ti-cash me-1"></i> Tandai Lunas
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

        @if($invoice->canSubmit() && ! $hasApprovalMatrix)
            <div class="alert alert-warning border-warning">
                <h6 class="alert-heading"><i class="ti ti-alert-triangle me-1"></i>Matriks Approval Belum Diatur</h6>
                <p class="mb-2">Tombol Ajukan dinonaktifkan karena belum ada konfigurasi level approver untuk <code>Invoice</code>.</p>
                <a href="{{ route('approval-flows.index') }}" class="btn btn-sm btn-warning">
                    <i class="ti ti-settings me-1"></i> Buka Approval Matrix
                </a>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                {{-- Info Invoice & Customer --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-file-invoice me-1"></i>Data Invoice & Customer</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted text-uppercase small mb-2">Detail Tagihan</h6>
                                <dl class="row mb-0">
                                    <dt class="col-sm-5 text-muted">Nomor Invoice</dt>
                                    <dd class="col-sm-7"><strong>{{ $invoice->invoice_number }}</strong></dd>

                                    <dt class="col-sm-5 text-muted">Tanggal Invoice</dt>
                                    <dd class="col-sm-7">{{ $invoice->invoice_date?->format('d M Y') }}</dd>

                                    <dt class="col-sm-5 text-muted">Jatuh Tempo</dt>
                                    <dd class="col-sm-7">{{ $invoice->due_date?->format('d M Y') ?? '—' }}</dd>

                                    <dt class="col-sm-5 text-muted">Sumber Realisasi</dt>
                                    <dd class="col-sm-7">
                                        <a href="{{ route('work-realizations.show', $invoice->workRealization->uid ?? '') }}" class="link-primary">
                                            {{ $invoice->workRealization->realization_number ?? '-' }}
                                        </a>
                                    </dd>

                                    <dt class="col-sm-5 text-muted">Periode</dt>
                                    <dd class="col-sm-7">{{ $invoice->period_start?->format('d M Y') }} → {{ $invoice->period_end?->format('d M Y') }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted text-uppercase small mb-2">Customer</h6>
                                <dl class="row mb-0">
                                    <dt class="col-sm-5 text-muted">Nama</dt>
                                    <dd class="col-sm-7">{{ $invoice->customer_name ?? '—' }}</dd>

                                    <dt class="col-sm-5 text-muted">Kode</dt>
                                    <dd class="col-sm-7">{{ $invoice->customer_code ?? '—' }}</dd>

                                    <dt class="col-sm-5 text-muted">NPWP</dt>
                                    <dd class="col-sm-7">{{ $invoice->customer_taxpayer_id ?? '—' }}</dd>

                                    <dt class="col-sm-5 text-muted">Alamat</dt>
                                    <dd class="col-sm-7">{{ $invoice->customer_address ?? '—' }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-12 mt-3">
                                <dl class="row mb-0">
                                    <dt class="col-sm-3 text-muted">Proyek</dt>
                                    <dd class="col-sm-9">{{ $invoice->project->project_name ?? '-' }} ({{ $invoice->project->project_code ?? '-' }})</dd>

                                    @if($invoice->contract)
                                        <dt class="col-sm-3 text-muted">Kontrak</dt>
                                        <dd class="col-sm-9">{{ $invoice->contract->contract_number }}</dd>
                                    @endif

                                    @if($invoice->notes)
                                        <dt class="col-sm-3 text-muted">Catatan</dt>
                                        <dd class="col-sm-9">{{ $invoice->notes }}</dd>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Items dari Work Realization --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Detail Realisasi per Unit ({{ $invoice->workRealization->items->count() ?? 0 }})</h5></div>
                    <div class="card-body">
                        @if(! $invoice->workRealization || $invoice->workRealization->items->isEmpty())
                            <p class="text-muted text-center py-4 mb-0">Tidak ada detail realisasi.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle small">
                                    <thead class="table-light text-uppercase">
                                        <tr>
                                            <th>Unit / Operator</th>
                                            <th class="text-end">Total HM</th>
                                            <th class="text-end">Tarif</th>
                                            <th class="text-end">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->workRealization->items as $item)
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
                                                <td class="text-end fw-semibold">{{ number_format($item->total_hm, 2, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($item->adjusted_rate, 0, ',', '.') }}</td>
                                                <td class="text-end fw-semibold">Rp {{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Lampiran Faktur Pajak --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Lampiran Faktur Pajak</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row mb-0">
                                    <dt class="col-sm-5 text-muted">No. Faktur Pajak</dt>
                                    <dd class="col-sm-7">{{ $invoice->faktur_pajak_number ?? '—' }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6 text-md-end">
                                @if($invoice->faktur_pajak_path)
                                    <a href="{{ route('invoices.faktur-pajak', $invoice->uid) }}" class="btn btn-soft-primary btn-sm">
                                        <i class="ti ti-download me-1"></i> Unduh Faktur Pajak
                                    </a>
                                @else
                                    <span class="text-muted small"><i class="ti ti-file-off"></i> Lampiran belum diupload</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Pembayaran (jika sudah lunas) --}}
                @if($invoice->status === \App\Enums\InvoiceStatus::PAID)
                    <div class="card border-success">
                        <div class="card-header bg-success-subtle">
                            <h5 class="card-title mb-0 text-success"><i class="ti ti-cash me-1"></i>Invoice Lunas</h5>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-3 text-muted">Tanggal Bayar</dt>
                                <dd class="col-sm-9">{{ $invoice->paid_date?->format('d M Y') ?? '—' }}</dd>
                                @if($invoice->payment_notes)
                                    <dt class="col-sm-3 text-muted">Catatan Pembayaran</dt>
                                    <dd class="col-sm-9">{{ $invoice->payment_notes }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                {{-- Approval Action --}}
                @if($invoice->canApprove() && $isCurrentApprover)
                    <div class="card border-warning">
                        <div class="card-header bg-warning-subtle">
                            <h5 class="card-title mb-0 text-warning">
                                <i class="ti ti-checks me-1"></i> Aksi Approval (Level {{ $invoice->current_approval_level }} dari {{ $flowLevels->count() }})
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($nextApproverLabel)
                                <div class="alert alert-light border mb-3 py-2 px-3 small">
                                    <i class="ti ti-user-check me-1 text-muted"></i>
                                    Approver level ini: <strong>{{ $nextApproverLabel }}</strong>
                                </div>
                            @endif
                            <form action="{{ route('invoices.approve', $invoice->uid) }}" method="POST" id="approve-form">
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
                @elseif($invoice->canApprove() && ! $isCurrentApprover)
                    <div class="card border-info">
                        <div class="card-header bg-info-subtle">
                            <h5 class="card-title mb-0 text-info">
                                <i class="ti ti-hourglass me-1"></i> Menunggu Approval
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Invoice menunggu persetujuan dari:</p>
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

                {{-- Ringkasan Nilai --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-calculator me-1"></i>Ringkasan Nilai</h5></div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-end">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>PPN ({{ rtrim(rtrim(number_format($invoice->ppn_rate, 2, '.', ''), '0'), '.') }}%)</td>
                                <td class="text-end text-success">+ Rp {{ number_format($invoice->ppn_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>PPH ({{ rtrim(rtrim(number_format($invoice->pph_rate, 2, '.', ''), '0'), '.') }}%)</td>
                                <td class="text-end text-danger">- Rp {{ number_format($invoice->pph_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold">Total Tagihan</td>
                                <td class="text-end fw-bold fs-18 text-primary">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Metadata --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Riwayat</h5></div>
                    <div class="card-body">
                        <dl class="row mb-0 small">
                            <dt class="col-5 text-muted">Dibuat oleh</dt>
                            <dd class="col-7">{{ $invoice->creator->name ?? '-' }}<br><span class="text-muted">{{ $invoice->created_at->format('d M Y H:i') }}</span></dd>

                            @if($invoice->approved_by)
                                <dt class="col-5 text-muted">Disetujui oleh</dt>
                                <dd class="col-7">{{ $invoice->approver->name ?? '-' }}<br><span class="text-muted">{{ $invoice->approved_at?->format('d M Y H:i') }}</span></dd>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Approval History --}}
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Riwayat Approval</h5></div>
                    <div class="card-body">
                        @forelse($invoice->approvals as $appr)
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
            title: isReject ? 'Tolak Invoice?' : 'Setujui Invoice?',
            text:  isReject ? 'Pastikan catatan penolakan diisi.' : 'Invoice akan diteruskan ke level berikutnya (jika ada).',
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
