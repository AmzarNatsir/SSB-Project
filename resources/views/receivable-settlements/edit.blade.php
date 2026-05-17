@extends('layout.mainlayout')
@section('title', 'Edit Settlement')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit {{ $settlement->settlement_number }}</h3>
                <p class="text-muted small mb-0">Status: <span class="badge bg-{{ $settlement->status->color() }}-subtle text-{{ $settlement->status->color() }}">{{ $settlement->status->label() }}</span></p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('receivable-settlements.index') }}">Pelunasan Piutang</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('receivable-settlements.show', $settlement->uid) }}">{{ $settlement->settlement_number }}</a></li>
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

        <form action="{{ route('receivable-settlements.update', $settlement->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-arrows-exchange me-1"></i>Data Settlement</h5></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info-subtle border-info-subtle mb-0 small">
                                        <div class="row">
                                            <div class="col-md-6"><strong>Proyek:</strong> {{ $settlement->project->project_name ?? '-' }}</div>
                                            <div class="col-md-6"><strong>Customer:</strong> {{ $settlement->customer_name ?? '-' }}</div>
                                            <div class="col-md-6"><strong>Invoice:</strong>
                                                <a href="{{ route('invoices.show', $settlement->invoice->uid ?? '') }}" class="link-primary">{{ $settlement->invoice->invoice_number ?? '-' }}</a>
                                                <span class="text-muted">(Rp {{ number_format($settlement->invoice_total, 0, ',', '.') }})</span>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Invoice & Proyek di-lock setelah create.</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Uang Muka (Deposit) <small class="text-muted">(opsional)</small></label>
                                    <select name="deposit_receivable_id" id="deposit_receivable_id" class="form-select">
                                        <option value="">-- Tidak pakai DP --</option>
                                    </select>
                                </div>

                                <div class="col-12"><hr class="my-2"></div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Penerimaan Dana <span class="text-danger">*</span></label>
                                    <input type="date" name="payment_date" class="form-control"
                                           value="{{ old('payment_date', $settlement->payment_date?->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nominal Pembayaran Baru (Rp)</label>
                                    <input type="text" id="payment_amount_display" class="form-control rupiah-input"
                                           value="{{ number_format((float) $settlement->payment_amount, 0, ',', '.') }}" placeholder="0">
                                    <input type="hidden" name="payment_amount" id="payment_amount" value="{{ $settlement->payment_amount }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                                    <select name="payment_type" id="payment_type" class="form-select" required>
                                        @foreach(\App\Enums\PaymentType::cases() as $pt)
                                            <option value="{{ $pt->value }}" @selected(old('payment_type', $settlement->payment_type?->value) === $pt->value)>{{ $pt->label() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Referensi</label>
                                    <input type="text" name="payment_reference" class="form-control"
                                           value="{{ old('payment_reference', $settlement->payment_reference) }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $settlement->description) }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Bukti Penerimaan</label>
                                    @if($settlement->attachment_path)
                                        <div class="mb-1 small">
                                            <a href="{{ route('receivable-settlements.attachment', $settlement->uid) }}" target="_blank" class="link-primary">
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
                            <a href="{{ route('receivable-settlements.show', $settlement->uid) }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
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
    const projectId = {{ (int) $settlement->project_id }};
    const currentDepositId = {{ (int) ($settlement->deposit_receivable_id ?? 0) }};
    const apiUrl = "{{ url('api/receivable-settlements/project') }}/" + projectId + "/deposits";

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
    });

    $(function () {
        if (typeof $.fn.select2 === 'function') {
            $('#deposit_receivable_id, #payment_type').select2({ width: '100%' });
        }
        $.get(apiUrl, function (resp) {
            const $sel = $('#deposit_receivable_id');
            (resp.data || []).forEach(function (d) {
                const lbl = d.receivable_number + ' — ' + d.received_date + ' — ' + d.payment_type + ' — Rp ' + fmtRp(d.amount);
                $sel.append($('<option>').val(d.id).text(lbl));
            });
            // Tambah opsi DP yang sedang dipakai (kalau tidak ada di list available)
            @if($settlement->depositReceivable)
                if (!$sel.find('option[value="{{ $settlement->deposit_receivable_id }}"]').length) {
                    $sel.append($('<option>').val('{{ $settlement->deposit_receivable_id }}').text(
                        '{{ $settlement->depositReceivable->receivable_number }} — {{ optional($settlement->depositReceivable->received_date)->format('d M Y') }} — Rp {{ number_format($settlement->deposit_amount, 0, ',', '.') }}'
                    ));
                }
            @endif
            if (currentDepositId) $sel.val(currentDepositId);
            $sel.trigger('change.select2');
        });
    });
})();
</script>
@endpush
@endsection
