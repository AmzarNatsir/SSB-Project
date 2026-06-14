@extends('layout.mainlayout')

@section('title', 'Laporan Penggunaan Spare Part')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- ── Header ──────────────────────────────────────────────────────── --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h4 class="fw-bold mb-1"><i class="ti ti-tool text-warning me-2"></i>Laporan Penggunaan Spare Part</h4>
                <p class="text-muted mb-0 small">Rekap pemakaian suku cadang per proyek &amp; periode</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('deal-reports.export', request()->query()) }}"
                   class="btn btn-outline-success btn-sm d-print-none">
                    <i class="ti ti-file-spreadsheet me-1"></i>Ekspor CSV
                </a>
                <a href="{{ route('spare-part-usages.create') }}"
                   class="btn btn-warning btn-sm d-print-none">
                    <i class="ti ti-plus me-1"></i>Input Spare Part
                </a>
                <button class="btn btn-outline-secondary btn-sm d-print-none" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i>Cetak
                </button>
            </div>
        </div>

        {{-- ── Filter Card ─────────────────────────────────────────────────── --}}
        <div class="card mb-4 d-print-none">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('deal-reports') }}" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label mb-1 small fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control form-control-sm"
                               value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label mb-1 small fw-semibold">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control form-control-sm"
                               value="{{ $endDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label mb-1 small fw-semibold">Proyek</label>
                        <select name="project_id" class="form-select form-select-sm select2">
                            <option value="">— Semua Proyek —</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" @selected($projectId == $p->id)>{{ $p->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1 small fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="ALL"      @selected($status === 'ALL')>Semua</option>
                            <option value="DRAFT"    @selected($status === 'DRAFT')>Draft</option>
                            <option value="SUBMITTED" @selected($status === 'SUBMITTED')>Diajukan</option>
                            <option value="APPROVED" @selected($status === 'APPROVED')>Disetujui</option>
                            <option value="REJECTED" @selected($status === 'REJECTED')>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="ti ti-filter me-1"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── KPI Cards ───────────────────────────────────────────────────── --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg,#f59e0b,#d97706);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Total Pemakaian</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-tool text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($totalRecords) }}</h3>
                        <small class="opacity-75">Transaksi</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg,#8b5cf6,#7c3aed);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Total Qty</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-package text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($totalQty, 2) }}</h3>
                        <small class="opacity-75">Unit / PCS / dst.</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg,#ef4444,#dc2626);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Total Biaya</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-currency-dollar text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size:1.1rem;">
                            Rp {{ number_format($totalCost, 0, ',', '.') }}
                        </h3>
                        <small class="opacity-75">Akumulasi Nilai</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg,#10b981,#059669);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Proyek Terlibat</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-briefcase text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($totalProjects) }}</h3>
                        <small class="opacity-75">Proyek Aktif</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Charts Row ───────────────────────────────────────────────────── --}}
        <div class="row g-3 mb-4 d-print-none">
            {{-- Daily Cost Trend --}}
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0"><i class="ti ti-chart-line text-warning me-2"></i>Tren Biaya Harian</h5>
                        <small class="text-muted">{{ $startDate }} s/d {{ $endDate }}</small>
                    </div>
                    <div class="card-body">
                        <div id="chartDaily" style="min-height:240px;"></div>
                    </div>
                </div>
            </div>
            {{-- Category Donut --}}
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-chart-donut text-purple me-2"></i>Per Kategori</h5>
                    </div>
                    <div class="card-body">
                        <div id="chartCategory" style="min-height:240px;"></div>
                    </div>
                </div>
            </div>
            {{-- Top Parts --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-chart-bar text-danger me-2"></i>Top 8 Spare Part (Biaya)</h5>
                    </div>
                    <div class="card-body">
                        <div id="chartTopParts" style="min-height:260px;"></div>
                    </div>
                </div>
            </div>
            {{-- Project Cost --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-chart-bar text-primary me-2"></i>Biaya per Proyek</h5>
                    </div>
                    <div class="card-body">
                        <div id="chartProject" style="min-height:260px;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Data Table ───────────────────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><i class="ti ti-list me-2"></i>Detail Pemakaian Spare Part</h5>
                <span class="badge bg-warning-subtle text-warning">{{ $entries->total() }} transaksi</span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pemakaian</th>
                            <th>Tanggal</th>
                            <th>Proyek</th>
                            <th>Unit / Alat</th>
                            <th>Nama Spare Part</th>
                            <th>Kategori</th>
                            <th class="text-end">Qty</th>
                            <th>Satuan</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $row)
                            <tr>
                                <td>
                                    <a href="{{ route('spare-part-usages.show', $row->uid) }}"
                                       class="fw-semibold text-warning">{{ $row->usage_number }}</a>
                                </td>
                                <td class="text-nowrap">{{ $row->usage_date?->format('d/m/Y') }}</td>
                                <td class="small">{{ $row->project?->project_name ?? '-' }}</td>
                                <td class="small">{{ $row->unit_name ?: '-' }}</td>
                                <td class="fw-semibold small">{{ $row->part_name }}</td>
                                <td>
                                    @if($row->part_category)
                                        <span class="badge bg-purple-subtle text-purple">{{ $row->part_category }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ number_format($row->quantity, 2) }}</td>
                                <td class="small text-muted">{{ $row->unit_of_measure }}</td>
                                <td class="text-end small">
                                    @if($row->unit_price)
                                        Rp {{ number_format($row->unit_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end fw-semibold">
                                    @if($row->total_price)
                                        Rp {{ number_format($row->total_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $sc = match($row->status) {
                                            'APPROVED'  => 'success',
                                            'SUBMITTED' => 'warning',
                                            'REJECTED'  => 'danger',
                                            default     => 'secondary',
                                        };
                                        $sl = match($row->status) {
                                            'APPROVED'  => 'Disetujui',
                                            'SUBMITTED' => 'Diajukan',
                                            'REJECTED'  => 'Ditolak',
                                            default     => 'Draft',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $sc }}-subtle text-{{ $sc }}">{{ $sl }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="ti ti-mood-empty fs-1 d-block mb-2"></i>
                                    Tidak ada data untuk periode &amp; filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($entries->isNotEmpty())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="9" class="text-end">Total Halaman Ini:</td>
                            <td class="text-end">Rp {{ number_format($entries->sum('total_price'), 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
            @if($entries->hasPages())
                <div class="card-footer d-print-none">{{ $entries->links() }}</div>
            @endif
        </div>

    </div>{{-- /content --}}
</div>{{-- /page-wrapper --}}

@push('scripts')
<script src="{{ URL::asset('build/plugins/apexchart/apexcharts.min.js') }}"></script>
<script>
(function () {
    'use strict';

    const fmtRp = v => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(v || 0));

    const daily      = @json($dailyCost);
    const catData    = @json($categoryCost);
    const topParts   = @json($topParts);
    const projData   = @json($projectCost);

    const baseOpts = { chart: { toolbar: { show: false }, fontFamily: 'inherit' } };

    // 1 · Daily Trend
    if (daily.length) {
        new ApexCharts(document.querySelector('#chartDaily'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'area', height: 240 },
            series: [{ name: 'Biaya (Rp)', data: daily.map(d => d.cost) }],
            xaxis: { categories: daily.map(d => d.date), labels: { rotate: -30, style: { fontSize: '10px' } } },
            yaxis: { labels: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
            tooltip: { y: { formatter: fmtRp } },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05 } },
            colors: ['#f59e0b'],
            stroke: { curve: 'smooth', width: 2 },
            dataLabels: { enabled: false },
        }).render();
    } else {
        document.querySelector('#chartDaily').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-chart-line fs-1"></i><p class="mt-2">Tidak ada data</p></div>';
    }

    // 2 · Category Donut
    if (catData.length) {
        new ApexCharts(document.querySelector('#chartCategory'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'donut', height: 240 },
            series: catData.map(d => d.cost),
            labels: catData.map(d => d.category),
            tooltip: { y: { formatter: fmtRp } },
            legend: { position: 'bottom', fontSize: '11px' },
            plotOptions: { pie: { donut: { size: '60%' } } },
        }).render();
    } else {
        document.querySelector('#chartCategory').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-chart-donut fs-1"></i><p class="mt-2">Tidak ada data</p></div>';
    }

    // 3 · Top Parts horizontal bar
    if (topParts.length) {
        new ApexCharts(document.querySelector('#chartTopParts'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'bar', height: 260 },
            plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
            series: [{ name: 'Biaya (Rp)', data: topParts.map(d => d.cost) }],
            xaxis: { categories: topParts.map(d => d.name), labels: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
            tooltip: { y: { formatter: fmtRp } },
            colors: ['#ef4444'],
            dataLabels: { enabled: false },
        }).render();
    } else {
        document.querySelector('#chartTopParts').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-chart-bar fs-1"></i><p class="mt-2">Tidak ada data</p></div>';
    }

    // 4 · Project bar
    if (projData.length) {
        new ApexCharts(document.querySelector('#chartProject'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'bar', height: 260 },
            plotOptions: { bar: { borderRadius: 4, distributed: true } },
            series: [{ name: 'Biaya (Rp)', data: projData.map(d => d.cost) }],
            xaxis: { categories: projData.map(d => d.name), labels: { rotate: -25, style: { fontSize: '10px' } } },
            yaxis: { labels: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
            tooltip: { y: { formatter: fmtRp } },
            legend: { show: false },
            dataLabels: { enabled: false },
        }).render();
    } else {
        document.querySelector('#chartProject').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-briefcase fs-1"></i><p class="mt-2">Tidak ada data</p></div>';
    }
})();
</script>
@endpush

@push('styles')
<style>
@media print {
    .page-header, .sidebar, header, .d-print-none { display: none !important; }
    .card { border: 1px solid #ddd !important; box-shadow: none !important; }
    body { font-size: 11px; }
}
</style>
@endpush
@endsection
