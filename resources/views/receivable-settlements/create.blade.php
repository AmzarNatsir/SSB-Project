@extends('layout.mainlayout')
@section('title', 'Buat Settlement')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Settlement</h3>
                <p class="text-muted small mb-0">Pilih Proyek → Invoice → DP (opsional) → isi pembayaran baru. Total Settle = DP + Pembayaran Baru.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('receivable-settlements.index') }}">Pelunasan Piutang</a></li>
                        <li class="breadcrumb-item active">Buat</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('receivable-settlements.store') }}" method="POST" enctype="multipart/form-data" id="settlementForm">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-arrows-exchange me-1"></i>Data Settlement</h5></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Proyek <span class="text-danger">*</span></label>
                                    <select id="project_id" class="form-select">
                                        <option value="">-- Pilih Proyek --</option>
                                        @foreach($projects as $p)
                                            <option value="{{ $p->id }}" @selected(old('project_id', $preselectedProjectId) == $p->id)>
                                                {{ $p->project_code }} — {{ $p->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Pilih proyek dulu untuk memuat daftar Invoice & DP.</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Nomor Invoice <span class="text-danger">*</span></label>
                                    <select name="invoice_id" id="invoice_id" class="form-select" required>
                                        <option value="">-- Pilih Invoice (APPROVED & belum Lunas) --</option>
                                    </select>
                                    <div class="d-none" id="invoiceInfo">
                                        <div class="alert alert-info-subtle border-info-subtle mt-2 small mb-0">
                                            <div><strong>Total Invoice:</strong> Rp <span id="lbl_invoice_total">0</span></div>
                                            <div><strong>Sudah Disettle:</strong> Rp <span id="lbl_invoice_settled">0</span></div>
                                            <div><strong>Sisa Tagihan:</strong> <span class="fw-bold text-danger">Rp <span id="lbl_invoice_remaining">0</span></span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Uang Muka (Deposit) <small class="text-muted">(opsional)</small></label>
                                    <select name="deposit_receivable_id" id="deposit_receivable_id" class="form-select">
                                        <option value="">-- Tidak pakai DP --</option>
                                    </select>
                                    <small class="text-muted">Hanya Penerimaan Dana DP (tanpa invoice link), status Disetujui, dan belum dipakai di Settlement lain.</small>
                                </div>

                                <div class="col-12"><hr class="my-2"></div>
                                <div class="col-12">
                                    <h6 class="text-muted text-uppercase small mb-0"><i class="ti ti-receipt me-1"></i>Penerimaan Pembayaran Baru</h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Penerimaan Dana <span class="text-danger">*</span></label>
                                    <input type="date" name="payment_date" class="form-control"
                                           value="{{ old('payment_date', now()->toDateString()) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                                    <input type="text" id="payment_amount_display" class="form-control rupiah-input"
                                           value="{{ old('payment_amount') ? number_format((float) old('payment_amount'), 0, ',', '.') : '' }}" placeholder="0" required>
                                    <input type="hidden" name="payment_amount" id="payment_amount" value="{{ old('payment_amount', 0) }}">
                                    <small class="text-muted">Boleh 0 jika full pakai DP.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                    <select name="payment_type" id="payment_type" class="form-select" required>
                                        @foreach(\App\Enums\PaymentType::cases() as $pt)
                                            <option value="{{ $pt->value }}" @selected(old('payment_type') === $pt->value)>{{ $pt->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Referensi</label>
                                    <input type="text" name="payment_reference" class="form-control"
                                           value="{{ old('payment_reference') }}" placeholder="Mis. No. Kwitansi / No. Transfer">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Bukti Penerimaan (Kwitansi / Slip Transfer)</label>
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">PDF / JPG / PNG (max 10MB).</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-calculator me-1"></i>Ringkasan</h5></div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td>Total Invoice</td>
                                    <td class="text-end">Rp <span id="sm_invoice_total">0</span></td>
                                </tr>
                                <tr>
                                    <td>Sudah Disettle</td>
                                    <td class="text-end text-muted">- Rp <span id="sm_already">0</span></td>
                                </tr>
                                <tr>
                                    <td>DP Dialokasikan</td>
                                    <td class="text-end text-info">+ Rp <span id="sm_deposit">0</span></td>
                                </tr>
                                <tr>
                                    <td>Pembayaran Baru</td>
                                    <td class="text-end text-success">+ Rp <span id="sm_payment">0</span></td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold">Settlement Ini</td>
                                    <td class="text-end fw-bold text-primary">Rp <span id="sm_total">0</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Sisa Setelah Settle</td>
                                    <td class="text-end fw-bold" id="sm_remaining_wrap">Rp <span id="sm_remaining">0</span></td>
                                </tr>
                            </table>
                            <div class="alert alert-success-subtle border-success-subtle mt-2 mb-0 small d-none" id="willPayBadge">
                                <i class="ti ti-circle-check me-1"></i>Invoice akan otomatis ditandai <strong>Lunas</strong> setelah Settlement disetujui.
                            </div>
                            <div class="alert alert-warning-subtle border-warning-subtle mt-2 mb-0 small d-none" id="overLimitBadge">
                                <i class="ti ti-alert-triangle me-1"></i>Total settlement melebihi sisa tagihan. Kurangi nominal pembayaran.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn"><i class="ti ti-device-floppy me-1"></i>Simpan Settlement</button>
                            <a href="{{ route('receivable-settlements.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const invoicesUrl = "{{ url('api/receivable-settlements/project') }}";
    const depositsUrl = "{{ url('api/receivable-settlements/project') }}";
    const preselectInvoice = {{ (int) ($preselectedInvoiceId ?? 0) }};

    let currentInvoice = null;

    function fmtRp(n) { return new Intl.NumberFormat('id-ID').format(Math.round(n || 0)); }
    function parseRp(s) {
        if (!s) return 0;
        return parseInt(String(s).replace(/[^\d]/g, ''), 10) || 0;
    }

    $(document).on('input', '.rupiah-input', function () {
        const $el = $(this);
        const cursorPos = $el[0].selectionStart;
        const oldLen = $el.val().length;
        const raw = parseRp($el.val());
        $el.val(fmtRp(raw));
        $('#payment_amount').val(raw);
        const newLen = $el.val().length;
        $el[0].setSelectionRange(Math.max(0, cursorPos + (newLen - oldLen)), Math.max(0, cursorPos + (newLen - oldLen)));
        recalc();
    });

    function loadInvoices(projectId) {
        const $sel = $('#invoice_id');
        $sel.html('<option value="">-- Pilih Invoice (APPROVED & belum Lunas) --</option>');
        $('#invoiceInfo').addClass('d-none');
        currentInvoice = null;
        if (!projectId) { recalc(); return; }
        $.get(invoicesUrl + '/' + projectId + '/invoices', function (resp) {
            (resp.data || []).forEach(function (inv) {
                const lbl = inv.invoice_number + ' — ' + inv.invoice_date + ' — Sisa Rp ' + fmtRp(inv.remaining);
                const $opt = $('<option>').val(inv.id).text(lbl)
                    .attr('data-total', inv.total_amount)
                    .attr('data-settled', inv.settled)
                    .attr('data-remaining', inv.remaining);
                if (preselectInvoice && parseInt(preselectInvoice) === parseInt(inv.id)) $opt.attr('selected', 'selected');
                $sel.append($opt);
            });
            $sel.trigger('change.select2').trigger('change');
        });
    }

    function loadDeposits(projectId) {
        const $sel = $('#deposit_receivable_id');
        $sel.html('<option value="">-- Tidak pakai DP --</option>');
        if (!projectId) { recalc(); return; }
        $.get(depositsUrl + '/' + projectId + '/deposits', function (resp) {
            (resp.data || []).forEach(function (d) {
                const lbl = d.receivable_number + ' — ' + d.received_date + ' — ' + d.payment_type + ' — Rp ' + fmtRp(d.amount);
                $sel.append($('<option>').val(d.id).text(lbl).attr('data-amount', d.amount));
            });
            $sel.trigger('change.select2');
        });
    }

    function onInvoiceChange() {
        const $opt = $('#invoice_id option:selected');
        if (!$opt.val()) {
            currentInvoice = null;
            $('#invoiceInfo').addClass('d-none');
        } else {
            currentInvoice = {
                total:     parseFloat($opt.attr('data-total')) || 0,
                settled:   parseFloat($opt.attr('data-settled')) || 0,
                remaining: parseFloat($opt.attr('data-remaining')) || 0,
            };
            $('#lbl_invoice_total').text(fmtRp(currentInvoice.total));
            $('#lbl_invoice_settled').text(fmtRp(currentInvoice.settled));
            $('#lbl_invoice_remaining').text(fmtRp(currentInvoice.remaining));
            $('#invoiceInfo').removeClass('d-none');
        }
        recalc();
    }

    function recalc() {
        const deposit = parseFloat($('#deposit_receivable_id option:selected').attr('data-amount')) || 0;
        const payment = parseRp($('#payment_amount_display').val());
        const total   = deposit + payment;

        $('#sm_deposit').text(fmtRp(deposit));
        $('#sm_payment').text(fmtRp(payment));
        $('#sm_total').text(fmtRp(total));

        if (currentInvoice) {
            $('#sm_invoice_total').text(fmtRp(currentInvoice.total));
            $('#sm_already').text(fmtRp(currentInvoice.settled));
            const afterSettle = currentInvoice.remaining - total;
            $('#sm_remaining').text(fmtRp(afterSettle));

            const overLimit = afterSettle < -0.005;
            $('#overLimitBadge').toggleClass('d-none', !overLimit);
            $('#submitBtn').prop('disabled', overLimit || total <= 0);
            $('#willPayBadge').toggleClass('d-none', !(afterSettle <= 0.005 && total > 0 && !overLimit));
            $('#sm_remaining_wrap').toggleClass('text-success', afterSettle <= 0.005 && !overLimit).toggleClass('text-danger', overLimit);
        } else {
            $('#sm_invoice_total').text('0');
            $('#sm_already').text('0');
            $('#sm_remaining').text('0');
            $('#willPayBadge').addClass('d-none');
            $('#overLimitBadge').addClass('d-none');
            $('#submitBtn').prop('disabled', total <= 0);
        }
    }

    $(function () {
        if (typeof $.fn.select2 === 'function') {
            $('#project_id, #invoice_id, #deposit_receivable_id, #payment_type').select2({ width: '100%' });
        }
        $('#project_id').on('change', function () {
            const pid = $(this).val();
            loadInvoices(pid);
            loadDeposits(pid);
        });
        $('#invoice_id').on('change', onInvoiceChange);
        $('#deposit_receivable_id').on('change', recalc);

        if ($('#project_id').val()) $('#project_id').trigger('change');
        recalc();
    });
})();
</script>
@endpush
@endsection
