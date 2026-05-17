@extends('layout.mainlayout')
@section('title', 'Buat Invoice')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Invoice</h3>
                <p class="text-muted small mb-0">Pilih Work Realization yang Disetujui. Subtotal otomatis di-pull dari realisasi, PPN/PPH terhitung otomatis.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoice</a></li>
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

        @if($availableWRs->isEmpty())
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="avatar-lg mx-auto mb-3">
                        <div class="avatar-title bg-light rounded-circle text-muted fs-1"><i class="ti ti-file-off"></i></div>
                    </div>
                    <h5>Tidak ada Work Realization yang siap di-invoice</h5>
                    <p class="text-muted">Pastikan ada Work Realization dengan status <strong>Disetujui</strong> dan belum memiliki Invoice.</p>
                    <a href="{{ route('work-realizations.index') }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-arrow-left me-1"></i>Ke Work Realization</a>
                </div>
            </div>
        @else
        <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data" id="invoiceForm">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-file-invoice me-1"></i>Data Tagihan</h5></div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Realisasi Pekerjaan <span class="text-danger">*</span></label>
                                    <select name="work_realization_id" id="work_realization_id" class="form-select" required>
                                        <option value="">-- Pilih Work Realization --</option>
                                        @foreach($availableWRs as $wr)
                                            <option value="{{ $wr->id }}"
                                                data-subtotal="{{ $wr->total_realized_amount }}"
                                                data-project="{{ $wr->project->project_name ?? '-' }}"
                                                data-customer="{{ $wr->project->user_name ?? '-' }}"
                                                data-customer-code="{{ $wr->project->user_code ?? '-' }}"
                                                data-period="{{ optional($wr->period_start)->format('d M Y') }} → {{ optional($wr->period_end)->format('d M Y') }}"
                                                @selected(old('work_realization_id', $preselectedWrId) == $wr->id)>
                                                {{ $wr->realization_number }} — {{ $wr->project->project_name ?? '-' }} (Rp {{ number_format($wr->total_realized_amount, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hanya tampil Work Realization dengan status Disetujui dan belum punya Invoice.</small>
                                </div>

                                <div class="col-md-12">
                                    <div class="alert alert-info-subtle border-info-subtle mb-0 d-none" id="wrPreview">
                                        <div class="row small">
                                            <div class="col-md-6"><strong>Proyek:</strong> <span data-field="project">-</span></div>
                                            <div class="col-md-6"><strong>Customer:</strong> <span data-field="customer">-</span></div>
                                            <div class="col-md-6"><strong>Kode Customer:</strong> <span data-field="customer-code">-</span></div>
                                            <div class="col-md-6"><strong>Periode:</strong> <span data-field="period">-</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Invoice <span class="text-danger">*</span></label>
                                    <input type="date" name="invoice_date" id="invoice_date" class="form-control"
                                           value="{{ old('invoice_date', now()->toDateString()) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jatuh Tempo</label>
                                    <input type="date" name="due_date" id="due_date" class="form-control"
                                           value="{{ old('due_date', now()->addDays(30)->toDateString()) }}">
                                    <small class="text-muted">Default 30 hari dari tanggal invoice.</small>
                                </div>

                                <div class="col-12"><hr class="my-2"></div>

                                <div class="col-md-4">
                                    <label class="form-label">PPN (%)</label>
                                    <input type="number" step="0.01" name="ppn_rate" id="ppn_rate" class="form-control"
                                           value="{{ old('ppn_rate', 11) }}" min="0" max="100">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">PPH (%)</label>
                                    <input type="number" step="0.01" name="pph_rate" id="pph_rate" class="form-control"
                                           value="{{ old('pph_rate', 2) }}" min="0" max="100">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. Faktur Pajak</label>
                                    <input type="text" name="faktur_pajak_number" class="form-control"
                                           value="{{ old('faktur_pajak_number') }}" placeholder="010.000-00.00000000">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Lampiran Faktur Pajak</label>
                                    <input type="file" name="faktur_pajak_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">PDF / JPG / PNG (max 10MB).</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
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
                                    <td class="text-end">Rp <span id="lbl_subtotal">0</span></td>
                                </tr>
                                <tr>
                                    <td>PPN (<span id="lbl_ppn_rate">11</span>%)</td>
                                    <td class="text-end text-success">+ Rp <span id="lbl_ppn">0</span></td>
                                </tr>
                                <tr>
                                    <td>PPH (<span id="lbl_pph_rate">2</span>%)</td>
                                    <td class="text-end text-danger">- Rp <span id="lbl_pph">0</span></td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold">Total Tagihan</td>
                                    <td class="text-end fw-bold fs-18 text-primary">Rp <span id="lbl_total">0</span></td>
                                </tr>
                            </table>
                            <small class="text-muted d-block mt-2"><i class="ti ti-info-circle me-1"></i>Total = Subtotal + PPN − PPH</small>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100"><i class="ti ti-device-floppy me-1"></i>Simpan Invoice</button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</div>

@push('scripts')
<script>
(function () {
    const $wr = $('#work_realization_id');
    const $preview = $('#wrPreview');

    function fmt(n) {
        return new Intl.NumberFormat('id-ID').format(Math.round(n));
    }

    function recalc() {
        const subtotal = parseFloat($wr.find(':selected').data('subtotal')) || 0;
        const ppnRate = parseFloat($('#ppn_rate').val()) || 0;
        const pphRate = parseFloat($('#pph_rate').val()) || 0;
        const ppn = subtotal * ppnRate / 100;
        const pph = subtotal * pphRate / 100;
        const total = subtotal + ppn - pph;

        $('#lbl_subtotal').text(fmt(subtotal));
        $('#lbl_ppn').text(fmt(ppn));
        $('#lbl_pph').text(fmt(pph));
        $('#lbl_total').text(fmt(total));
        $('#lbl_ppn_rate').text(ppnRate);
        $('#lbl_pph_rate').text(pphRate);
    }

    function updatePreview() {
        const sel = $wr.find(':selected');
        if (!sel.val()) {
            $preview.addClass('d-none');
            return;
        }
        $preview.removeClass('d-none');
        $preview.find('[data-field="project"]').text(sel.data('project') || '-');
        $preview.find('[data-field="customer"]').text(sel.data('customer') || '-');
        $preview.find('[data-field="customer-code"]').text(sel.data('customer-code') || '-');
        $preview.find('[data-field="period"]').text(sel.data('period') || '-');
    }

    $(function () {
        if ($wr.length && typeof $wr.select2 === 'function') {
            $wr.select2({ placeholder: '-- Pilih Work Realization --', allowClear: true, width: '100%' });
        }
        $wr.on('change', function () { updatePreview(); recalc(); });
        $('#ppn_rate, #pph_rate').on('input', recalc);
        updatePreview();
        recalc();

        $('#invoice_date').on('change', function () {
            const d = new Date($(this).val());
            if (!isNaN(d.getTime())) {
                d.setDate(d.getDate() + 30);
                $('#due_date').val(d.toISOString().slice(0, 10));
            }
        });
    });
})();
</script>
@endpush
@endsection
