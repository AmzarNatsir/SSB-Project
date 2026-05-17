@extends('layout.mainlayout')
@section('title', 'Edit Work Realization')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit Realisasi — {{ $realization->realization_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('work-realizations.index') }}">Work Realization</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('work-realizations.show', $realization->uid) }}">{{ $realization->realization_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <span class="badge bg-{{ $realization->status->color() }}-subtle text-{{ $realization->status->color() }} fs-12 text-uppercase">
                    {{ $realization->status->label() }}
                </span>
                <form action="{{ route('work-realizations.regenerate', $realization->uid) }}" method="POST" class="d-inline js-confirm-form"
                      data-title="Regenerate dari Timesheet?"
                      data-text="Items realisasi akan di-overwrite dengan data terbaru dari Timesheet APPROVED. Penyesuaian tarif yang sudah Anda set akan dipertahankan."
                      data-icon="warning" data-confirm-text="Ya, Regenerate" data-confirm-color="#f59e0b">
                    @csrf
                    <button class="btn btn-outline-warning btn-sm" type="submit">
                        <i class="ti ti-refresh me-1"></i> Regenerate dari Timesheet
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('work-realizations.update', $realization->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Header info read-only --}}
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Informasi Realisasi</h5></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3 text-muted">Proyek</dt>
                        <dd class="col-sm-9">{{ $realization->project->project_code }} — {{ $realization->project->project_name }}</dd>

                        <dt class="col-sm-3 text-muted">Lokasi Proyek</dt>
                        <dd class="col-sm-9">{{ $realization->project->project_location ?? '—' }}</dd>

                        @if($realization->contract)
                            <dt class="col-sm-3 text-muted">Kontrak</dt>
                            <dd class="col-sm-9">{{ $realization->contract->contract_number }}</dd>
                        @endif

                        <dt class="col-sm-3 text-muted">Periode</dt>
                        <dd class="col-sm-9">
                            {{ $realization->period_start?->format('d M Y') }} → {{ $realization->period_end?->format('d M Y') }}
                            <small class="text-muted">(tidak bisa diubah setelah generate)</small>
                        </dd>

                        <dt class="col-sm-3 text-muted">Catatan</dt>
                        <dd class="col-sm-9">
                            <textarea name="notes" rows="2" class="form-control">{{ old('notes', $realization->notes ?? '') }}</textarea>
                        </dd>
                    </dl>
                </div>
            </div>

            {{-- Items with rate adjustment --}}
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">Items Realisasi ({{ $realization->items->count() }})</h5>
                    <small class="text-muted">Penyesuaian tarif sewa per item. Total realisasi = HM × Tarif Disesuaikan.</small>
                </div>
                <div class="card-body">
                    @if($realization->items->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted mb-2">Belum ada item realisasi.</p>
                            <small class="text-muted">Tidak ada Timesheet APPROVED dalam periode ini. Coba regenerate setelah ada Timesheet baru di-approve.</small>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle small">
                                <thead class="table-light text-uppercase">
                                    <tr>
                                        <th style="width:18%">Unit</th>
                                        <th>Operator</th>
                                        <th class="text-end">Periode Operasi</th>
                                        <th class="text-end">Total HM</th>
                                        <th class="text-end">TS</th>
                                        <th class="text-end" style="width:11%">Tarif Kontrak (Rp/HM)</th>
                                        <th class="text-end" style="width:11%">Tarif Disesuaikan (Rp/HM)</th>
                                        <th style="width:14%">Alasan Penyesuaian</th>
                                        <th class="text-end" style="width:13%">Jumlah Realisasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($realization->items as $i => $item)
                                        <tr class="js-item-row" data-item-id="{{ $item->id }}">
                                            <td>
                                                <div class="fw-medium">{{ $item->unit_name }}</div>
                                                @if($item->equipment_code)
                                                    <div class="small text-muted">{{ $item->equipment_code }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $item->operator_name ?? '—' }}</td>
                                            <td class="text-end small">
                                                {{ $item->period_start?->format('d M Y') ?? '-' }}<br>
                                                <span class="text-muted">s/d</span><br>
                                                {{ $item->period_end?->format('d M Y') ?? '-' }}
                                            </td>
                                            <td class="text-end fw-semibold">{{ number_format($item->total_hm, 2, ',', '.') }}</td>
                                            <td class="text-end"><span class="badge bg-light text-dark">{{ $item->timesheet_count }}</span></td>
                                            <td class="text-end text-muted">{{ number_format($item->contract_rate, 0, ',', '.') }}</td>
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                       class="form-control form-control-sm text-end js-adjusted-rate"
                                                       name="items[{{ $item->id }}][adjusted_rate]"
                                                       value="{{ $item->adjusted_rate }}"
                                                       data-hm="{{ $item->total_hm }}"
                                                       data-contract-rate="{{ $item->contract_rate }}">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control form-control-sm"
                                                       name="items[{{ $item->id }}][rate_adjustment_reason]"
                                                       value="{{ $item->rate_adjustment_reason }}"
                                                       placeholder="Wajib jika beda dari tarif kontrak">
                                            </td>
                                            <td class="text-end fw-semibold js-realized-amount">
                                                Rp {{ number_format($item->realized_amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="8" class="text-end fw-bold">Total Realisasi:</td>
                                        <td class="text-end fw-bold fs-5" id="grand-total">Rp {{ number_format($realization->total_realized_amount, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Attachments --}}
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Lampiran</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        @php
                            $attachments = [
                                ['pa_ma_attachment', 'pa_ma_attachment_path', 'pa_ma', 'Laporan PA & MA (Workshop)', 'ti-tool'],
                                ['safety_attachment', 'safety_attachment_path', 'safety', 'Laporan Safety Plan (HSE)', 'ti-shield-check'],
                                ['berita_acara_attachment', 'berita_acara_attachment_path', 'berita_acara', 'Berita Acara', 'ti-file-certificate'],
                            ];
                        @endphp
                        @foreach($attachments as [$input, $dbField, $type, $label, $icon])
                            <div class="col-md-4">
                                <label class="form-label"><i class="ti {{ $icon }} me-1"></i>{{ $label }}</label>
                                <input type="file" name="{{ $input }}" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                                @if($realization->{$dbField})
                                    <small class="text-success d-block mt-1">
                                        <i class="ti ti-check"></i>
                                        <a href="{{ route('work-realizations.attachment', [$realization->uid, $type]) }}" class="link-success">
                                            File terupload — unduh
                                        </a>
                                    </small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('work-realizations.show', $realization->uid) }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function() {
    // Auto-calculate realized_amount per row dan grand total saat user ubah adjusted_rate
    function formatRp(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }

    function recalcRow($row) {
        const $input = $row.find('.js-adjusted-rate');
        const hm = parseFloat($input.data('hm')) || 0;
        const rate = parseFloat($input.val()) || 0;
        const amount = hm * rate;
        $row.find('.js-realized-amount').text(formatRp(amount));
        return amount;
    }

    function recalcGrandTotal() {
        let total = 0;
        $('.js-item-row').each(function() {
            total += recalcRow($(this));
        });
        $('#grand-total').text(formatRp(total));
    }

    $(document).on('input change', '.js-adjusted-rate', recalcGrandTotal);

    // Confirm regenerate via SweetAlert
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

    // Initial recalc
    recalcGrandTotal();
})();
</script>
@endpush
@endsection
