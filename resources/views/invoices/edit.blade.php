@extends('layout.mainlayout')
@section('title', 'Edit Invoice')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit Invoice {{ $invoice->invoice_number }}</h3>
                <p class="text-muted small mb-0">Status: <span class="badge bg-{{ $invoice->status->color() }}-subtle text-{{ $invoice->status->color() }}">{{ $invoice->status->label() }}</span></p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoice</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('invoices.show', $invoice->uid) }}">{{ $invoice->invoice_number }}</a></li>
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

        <form action="{{ route('invoices.update', $invoice->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-file-invoice me-1"></i>Data Tagihan</h5></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info-subtle border-info-subtle mb-0">
                                        <div class="row small">
                                            <div class="col-md-6"><strong>Work Realization:</strong> {{ $invoice->workRealization->realization_number ?? '-' }}</div>
                                            <div class="col-md-6"><strong>Proyek:</strong> {{ $invoice->project->project_name ?? '-' }}</div>
                                            <div class="col-md-6"><strong>Customer:</strong> {{ $invoice->customer_name ?? '-' }}</div>
                                            <div class="col-md-6"><strong>Periode:</strong> {{ $invoice->period_start?->format('d M Y') }} → {{ $invoice->period_end?->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    <small class="text-muted">Sumber realisasi & customer di-lock setelah create.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Invoice <span class="text-danger">*</span></label>
                                    <input type="date" name="invoice_date" class="form-control"
                                           value="{{ old('invoice_date', $invoice->invoice_date?->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jatuh Tempo</label>
                                    <input type="date" name="due_date" class="form-control"
                                           value="{{ old('due_date', $invoice->due_date?->format('Y-m-d')) }}">
                                </div>

                                <div class="col-12"><hr class="my-2"></div>

                                <div class="col-md-4">
                                    <label class="form-label">PPN (%)</label>
                                    <input type="number" step="0.01" name="ppn_rate" id="ppn_rate" class="form-control"
                                           value="{{ old('ppn_rate', $invoice->ppn_rate) }}" min="0" max="100">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">PPH (%)</label>
                                    <input type="number" step="0.01" name="pph_rate" id="pph_rate" class="form-control"
                                           value="{{ old('pph_rate', $invoice->pph_rate) }}" min="0" max="100">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. Faktur Pajak</label>
                                    <input type="text" name="faktur_pajak_number" class="form-control"
                                           value="{{ old('faktur_pajak_number', $invoice->faktur_pajak_number) }}" placeholder="010.000-00.00000000">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Lampiran Faktur Pajak</label>
                                    @if($invoice->faktur_pajak_path)
                                        <div class="mb-1 small">
                                            <a href="{{ route('invoices.faktur-pajak', $invoice->uid) }}" target="_blank" class="link-primary">
                                                <i class="ti ti-paperclip me-1"></i>Lihat lampiran saat ini
                                            </a>
                                            <span class="text-muted">— upload baru akan menimpa file lama.</span>
                                        </div>
                                    @endif
                                    <input type="file" name="faktur_pajak_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-calculator me-1"></i>Ringkasan Nilai</h5></div>
                        <div class="card-body">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end">Rp <span id="lbl_subtotal" data-value="{{ $invoice->subtotal }}">{{ number_format($invoice->subtotal, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td>PPN (<span id="lbl_ppn_rate">{{ rtrim(rtrim(number_format($invoice->ppn_rate, 2, '.', ''), '0'), '.') }}</span>%)</td>
                                    <td class="text-end text-success">+ Rp <span id="lbl_ppn">{{ number_format($invoice->ppn_amount, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td>PPH (<span id="lbl_pph_rate">{{ rtrim(rtrim(number_format($invoice->pph_rate, 2, '.', ''), '0'), '.') }}</span>%)</td>
                                    <td class="text-end text-danger">- Rp <span id="lbl_pph">{{ number_format($invoice->pph_amount, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold">Total Tagihan</td>
                                    <td class="text-end fw-bold fs-18 text-primary">Rp <span id="lbl_total">{{ number_format($invoice->total_amount, 0, ',', '.') }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100"><i class="ti ti-device-floppy me-1"></i>Simpan Perubahan</button>
                            <a href="{{ route('invoices.show', $invoice->uid) }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
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
    function fmt(n) { return new Intl.NumberFormat('id-ID').format(Math.round(n)); }

    function recalc() {
        const subtotal = parseFloat($('#lbl_subtotal').data('value')) || 0;
        const ppnRate = parseFloat($('#ppn_rate').val()) || 0;
        const pphRate = parseFloat($('#pph_rate').val()) || 0;
        const ppn = subtotal * ppnRate / 100;
        const pph = subtotal * pphRate / 100;
        const total = subtotal + ppn - pph;
        $('#lbl_ppn').text(fmt(ppn));
        $('#lbl_pph').text(fmt(pph));
        $('#lbl_total').text(fmt(total));
        $('#lbl_ppn_rate').text(ppnRate);
        $('#lbl_pph_rate').text(pphRate);
    }
    $(function () { $('#ppn_rate, #pph_rate').on('input', recalc); recalc(); });
})();
</script>
@endpush
@endsection
