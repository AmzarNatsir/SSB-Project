@extends('layout.mainlayout')
@section('title', 'Catat Penerimaan Dana')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Catat Penerimaan Dana</h3>
                <p class="text-muted small mb-0">Untuk Uang Muka, biarkan kolom Invoice kosong. Untuk pelunasan, pilih Invoice terkait.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('receivables.index') }}">Penerimaan Dana</a></li>
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

        <form action="{{ route('receivables.store') }}" method="POST" enctype="multipart/form-data" id="receivableForm">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-receipt me-1"></i>Data Penerimaan</h5></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Proyek <span class="text-danger">*</span></label>
                                    <select name="project_id" id="project_id" class="form-select" required>
                                        <option value="">-- Pilih Proyek --</option>
                                        @foreach($projects as $p)
                                            <option value="{{ $p->id }}"
                                                data-customer="{{ $p->user_name }}"
                                                @selected(old('project_id', $preselectedProjectId) == $p->id)>
                                                {{ $p->project_code }} — {{ $p->project_name }}
                                                @if($p->user_name) ({{ $p->user_name }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <div class="alert alert-info-subtle border-info-subtle mb-0 d-none" id="customerPreview">
                                        <i class="ti ti-user-circle me-1"></i>
                                        <strong>Customer:</strong> <span id="lbl_customer">-</span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Invoice Terkait <small class="text-muted">(opsional — untuk pelunasan Invoice)</small></label>
                                    <select name="invoice_id" id="invoice_id" class="form-select">
                                        <option value="">-- Tidak ada (Uang Muka) --</option>
                                    </select>
                                    <small class="text-muted">Daftar Invoice akan otomatis tampil setelah pilih proyek. Biarkan kosong untuk Uang Muka.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Penerimaan Dana <span class="text-danger">*</span></label>
                                    <input type="date" name="received_date" class="form-control"
                                           value="{{ old('received_date', now()->toDateString()) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                                    <input type="text" name="amount_display" id="amount_display" class="form-control rupiah-input"
                                           value="{{ old('amount') ? number_format((float) old('amount'), 0, ',', '.') : '' }}" placeholder="0" required>
                                    <input type="hidden" name="amount" id="amount" value="{{ old('amount') }}">
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
                                    <label class="form-label">No. Referensi <small class="text-muted">(opsional)</small></label>
                                    <input type="text" name="payment_reference" class="form-control"
                                           value="{{ old('payment_reference') }}" placeholder="Mis. No. Kwitansi / No. Transfer">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Penjelasan tentang penerimaan dana ini...">{{ old('description') }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Bukti Uang Muka (Kwitansi / Slip Transfer)</label>
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">PDF / JPG / PNG (max 10MB).</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted mb-2"><i class="ti ti-info-circle me-1"></i>Catatan</h6>
                            <ul class="small text-muted mb-0 ps-3">
                                <li>Penerimaan tanpa Invoice = <strong>Uang Muka (DP)</strong>.</li>
                                <li>Penerimaan dengan Invoice = <strong>Pelunasan</strong> atas invoice tsb.</li>
                                <li>Setelah disimpan, dokumen masuk status <em>Draft</em> dan perlu di-<em>Ajukan</em> untuk approval.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100"><i class="ti ti-device-floppy me-1"></i>Simpan Penerimaan</button>
                            <a href="{{ route('receivables.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
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
    const projectInvoicesUrl = "{{ url('api/receivables/project') }}";
    const preselectInvoice = {{ (int) ($preselectedInvoiceId ?? 0) }};

    function fmtRp(n) {
        if (!n && n !== 0) return '';
        return new Intl.NumberFormat('id-ID').format(n);
    }
    function parseRp(s) {
        if (!s) return 0;
        return parseInt(String(s).replace(/[^\d]/g, ''), 10) || 0;
    }

    // Format rupiah on input
    $(document).on('input', '.rupiah-input', function () {
        const $el = $(this);
        const cursorPos = $el[0].selectionStart;
        const oldLen = $el.val().length;
        const raw = parseRp($el.val());
        $el.val(fmtRp(raw));
        $('#amount').val(raw);
        const newLen = $el.val().length;
        const newPos = Math.max(0, cursorPos + (newLen - oldLen));
        $el[0].setSelectionRange(newPos, newPos);
    });

    function loadInvoices(projectId) {
        const $sel = $('#invoice_id');
        $sel.html('<option value="">-- Tidak ada (Uang Muka) --</option>');
        if (!projectId) return;
        $.get(projectInvoicesUrl + '/' + projectId + '/invoices', function (resp) {
            (resp.data || []).forEach(function (inv) {
                const lbl = inv.invoice_number + ' — ' + inv.invoice_date + ' — Rp ' + fmtRp(parseFloat(inv.total_amount));
                const $opt = $('<option>').val(inv.id).text(lbl);
                if (preselectInvoice && parseInt(preselectInvoice) === parseInt(inv.id)) {
                    $opt.attr('selected', 'selected');
                }
                $sel.append($opt);
            });
        });
    }

    function updateCustomer() {
        const $opt = $('#project_id option:selected');
        const customer = $opt.data('customer');
        if (customer) {
            $('#lbl_customer').text(customer);
            $('#customerPreview').removeClass('d-none');
        } else {
            $('#customerPreview').addClass('d-none');
        }
    }

    $(function () {
        if (typeof $.fn.select2 === 'function') {
            $('#project_id, #invoice_id, #payment_type').select2({ width: '100%' });
        }
        $('#project_id').on('change', function () {
            updateCustomer();
            loadInvoices($(this).val());
        });
        updateCustomer();
        if ($('#project_id').val()) loadInvoices($('#project_id').val());

        // Init amount field if old value present
        const old = parseRp($('#amount').val());
        if (old) $('#amount_display').val(fmtRp(old));
    });
})();
</script>
@endpush
@endsection
