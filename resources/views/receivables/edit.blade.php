@extends('layout.mainlayout')
@section('title', 'Edit Penerimaan Dana')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit {{ $receivable->receivable_number }}</h3>
                <p class="text-muted small mb-0">Status: <span class="badge bg-{{ $receivable->status->color() }}-subtle text-{{ $receivable->status->color() }}">{{ $receivable->status->label() }}</span></p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('receivables.index') }}">Penerimaan Dana</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('receivables.show', $receivable->uid) }}">{{ $receivable->receivable_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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

        <form action="{{ route('receivables.update', $receivable->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-receipt me-1"></i>Data Penerimaan</h5></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info-subtle border-info-subtle mb-0">
                                        <div class="row small">
                                            <div class="col-md-6"><strong>Proyek:</strong> {{ $receivable->project->project_name ?? '-' }}</div>
                                            <div class="col-md-6"><strong>Customer:</strong> {{ $receivable->customer_name ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Proyek di-lock setelah create.</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Invoice Terkait <small class="text-muted">(opsional — untuk pelunasan Invoice)</small></label>
                                    <select name="invoice_id" id="invoice_id" class="form-select">
                                        <option value="">-- Tidak ada (Uang Muka) --</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Penerimaan Dana <span class="text-danger">*</span></label>
                                    <input type="date" name="received_date" class="form-control"
                                           value="{{ old('received_date', $receivable->received_date?->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                                    <input type="text" id="amount_display" class="form-control rupiah-input"
                                           value="{{ number_format((float) $receivable->amount, 0, ',', '.') }}" placeholder="0" required>
                                    <input type="hidden" name="amount" id="amount" value="{{ $receivable->amount }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                    <select name="payment_type" id="payment_type" class="form-select" required>
                                        @foreach(\App\Enums\PaymentType::cases() as $pt)
                                            <option value="{{ $pt->value }}" @selected(old('payment_type', $receivable->payment_type?->value) === $pt->value)>{{ $pt->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Referensi</label>
                                    <input type="text" name="payment_reference" class="form-control"
                                           value="{{ old('payment_reference', $receivable->payment_reference) }}" placeholder="Mis. No. Kwitansi / No. Transfer">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $receivable->description) }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Bukti Uang Muka (Kwitansi / Slip Transfer)</label>
                                    @if($receivable->attachment_path)
                                        <div class="mb-1 small">
                                            <a href="{{ route('receivables.attachment', $receivable->uid) }}" target="_blank" class="link-primary">
                                                <i class="ti ti-paperclip me-1"></i>Lihat lampiran saat ini
                                            </a>
                                            <span class="text-muted">— upload baru akan menimpa file lama.</span>
                                        </div>
                                    @endif
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100"><i class="ti ti-device-floppy me-1"></i>Simpan Perubahan</button>
                            <a href="{{ route('receivables.show', $receivable->uid) }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
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
    const projectId = {{ (int) $receivable->project_id }};
    const currentInvoiceId = {{ (int) ($receivable->invoice_id ?? 0) }};
    const apiUrl = "{{ url('api/receivables/project') }}/" + projectId + "/invoices";

    function fmtRp(n) {
        if (!n && n !== 0) return '';
        return new Intl.NumberFormat('id-ID').format(n);
    }
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
        $('#amount').val(raw);
        const newLen = $el.val().length;
        const newPos = Math.max(0, cursorPos + (newLen - oldLen));
        $el[0].setSelectionRange(newPos, newPos);
    });

    $(function () {
        if (typeof $.fn.select2 === 'function') {
            $('#invoice_id, #payment_type').select2({ width: '100%' });
        }
        $.get(apiUrl, function (resp) {
            const $sel = $('#invoice_id');
            (resp.data || []).forEach(function (inv) {
                const lbl = inv.invoice_number + ' — ' + inv.invoice_date + ' — Rp ' + fmtRp(parseFloat(inv.total_amount));
                const $opt = $('<option>').val(inv.id).text(lbl);
                if (currentInvoiceId && parseInt(currentInvoiceId) === parseInt(inv.id)) $opt.attr('selected', 'selected');
                $sel.append($opt);
            });
            $sel.trigger('change.select2');
        });
    });
})();
</script>
@endpush
@endsection
