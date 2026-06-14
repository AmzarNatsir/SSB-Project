@extends('layout.mainlayout')
@section('title', 'Laporan Anggaran Proyek')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 no-print">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Laporan Anggaran Proyek</h3>
                <p class="text-muted mb-0 small">Ringkasan anggaran, HPP, dan harga jual seluruh proyek berdasarkan tahun anggaran.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan Anggaran Proyek</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('company-reports.export', request()->query()) }}" class="btn btn-outline-success">
                    <i class="ti ti-file-export me-2"></i>Ekspor CSV
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ti ti-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>

        {{-- Print-only Header --}}
        <div class="d-none d-print-block mb-4 text-center header-print">
            <h2 class="mb-1">LAPORAN ANGGARAN PROYEK</h2>
            <h5 class="text-muted mb-3">PT Sinar Sentosa Bahari</h5>
            <div class="d-flex justify-content-center gap-4 text-muted small">
                <span><strong>Tahun:</strong> {{ $year }}</span>
                @if($projectId)
                <span><strong>Proyek:</strong> {{ $projects->firstWhere('id', $projectId)?->project_name }}</span>
                @endif
                <span><strong>Status:</strong> {{ $status === 'ALL' ? 'Semua' : \App\Enums\BudgetStatus::from($status)->label() }}</span>
            </div>
            <hr class="my-4">
        </div>

        {{-- KPI Cards --}}
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Anggaran</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-files"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($totalCount, 0, ',', '.') }} Dokumen</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total HPP</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ti ti-coins"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">Rp {{ number_format($totalHpp, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Harga Jual</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                        <i class="ti ti-receipt-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">Rp {{ number_format($totalSellingPrice, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Rata-rata Margin</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ti ti-trending-up"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($avgMargin, 2, ',', '.') }}%</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 1: Monthly Trend + Status Distribution --}}
        <div class="row mb-4 no-print">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Tren HPP Bulanan (Rp Juta) – Tahun {{ $year }}</h5>
                    </div>
                    <div class="card-body">
                        <div id="monthlyTrendChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Distribusi Status Anggaran</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        @if($statusDist->isNotEmpty())
                            <div id="statusDistChart" style="width:100%"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 2: Category Breakdown + Per-Project HPP --}}
        <div class="row mb-4 no-print">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Rincian Biaya per Kategori (Rp Juta)</h5>
                    </div>
                    <div class="card-body">
                        <div id="categoryChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Top 10 Proyek – HPP vs Harga Jual (Rp Juta)</h5>
                    </div>
                    <div class="card-body">
                        @if($projectBudget->isNotEmpty())
                            <div id="projectBudgetChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Form --}}
        <div class="card mb-4 no-print">
            <div class="card-header bg-white border-bottom-dashed">
                <h5 class="card-title mb-0"><i class="ti ti-adjustments-horizontal me-2"></i>Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('company-reports') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small">Tahun Anggaran</label>
                        <select name="year" class="form-select">
                            @foreach($years as $y)
                                <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Proyek</label>
                        <select name="project_id" class="form-select select2">
                            <option value="">Semua Proyek</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" @selected($projectId == $p->id)>{{ $p->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Status Anggaran</label>
                        <select name="status" class="form-select">
                            <option value="ALL" @selected($status === 'ALL')>Semua Status</option>
                            @foreach(\App\Enums\BudgetStatus::cases() as $st)
                                <option value="{{ $st->value }}" @selected($status === $st->value)>{{ $st->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary px-4 flex-grow-1">
                            <i class="ti ti-search me-1"></i>Terapkan
                        </button>
                        <a href="{{ route('company-reports') }}" class="btn btn-outline-secondary px-3">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Detail Table --}}
        <div class="card">
            <div class="card-header bg-white border-bottom-dashed d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="card-title mb-0">Rincian Dokumen Anggaran</h5>
                <span class="badge bg-light text-dark small no-print">
                    Menampilkan {{ $budgets->firstItem() ?? 0 }} - {{ $budgets->lastItem() ?? 0 }} dari {{ $budgets->total() }} dokumen
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-nowrap align-middle">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>No</th>
                                <th>Proyek</th>
                                <th class="text-center">Ver.</th>
                                <th class="text-center no-print">Status</th>
                                <th class="text-end">Total HPP</th>
                                <th class="text-end">Margin</th>
                                <th class="text-end">Harga Jual</th>
                                <th class="no-print">Dibuat Oleh</th>
                                <th class="no-print">Tanggal</th>
                                <th class="text-center no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($budgets as $i => $budget)
                            @php $st = $budget->status; @endphp
                            <tr>
                                <td>{{ $budgets->firstItem() + $i }}</td>
                                <td>
                                    <span class="text-truncate d-inline-block fw-medium" style="max-width:220px">
                                        {{ $budget->project->project_name ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">v{{ $budget->version }}</span>
                                </td>
                                <td class="text-center no-print">
                                    <span class="badge bg-{{ $st->color() }}-subtle text-{{ $st->color() }} text-uppercase">
                                        {{ $st->label() }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-semibold text-warning">Rp {{ number_format($budget->total_hpp, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-semibold text-info">{{ number_format($budget->profit_margin_percent, 2, ',', '.') }}%</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-semibold text-success">Rp {{ number_format($budget->selling_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="no-print text-muted small">{{ $budget->creator->name ?? '-' }}</td>
                                <td class="no-print text-muted small">{{ $budget->created_at?->format('d M Y') }}</td>
                                <td class="text-center no-print">
                                    <a href="{{ route('budgets.show', $budget->uid) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-1">
                                            <i class="ti ti-wallet"></i>
                                        </div>
                                    </div>
                                    <h5>Tidak ada data anggaran</h5>
                                    <p class="text-muted">Sesuaikan filter tahun, proyek, atau status untuk menampilkan data.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3 no-print">
                    {{ $budgets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body { background: #fff !important; color: #000 !important; font-family: 'Inter', sans-serif !important; }
    .page-wrapper { margin: 0 !important; padding: 0 !important; }
    .content { padding: 0 !important; }
    .no-print, .sidebar, .sidebar-inner, .header, #toggle_btn, footer, .components-footer, .breadcrumb, .btn, form, .pagination { display: none !important; }
    .card { border: none !important; box-shadow: none !important; margin-bottom: 0 !important; }
    .card-body { padding: 0 !important; }
    .table-responsive { overflow: visible !important; }
    table { width: 100% !important; border-collapse: collapse !important; }
    th, td { border: 1px solid #ddd !important; padding: 6px 8px !important; font-size: 11px !important; white-space: normal !important; }
    th { background-color: #f8f9fa !important; color: #000 !important; }
}
</style>
@endsection

@push('scripts')
<script src="{{ URL::asset('build/plugins/apexchart/apexcharts.min.js') }}"></script>
<script>
$(document).ready(function () {
    if ($.fn.select2) {
        $('.select2').select2({ width: '100%' });
    }

    var toMillion = function (val) { return Math.round(val / 1000000); };
    var fmtMillion = function (val) { return 'Rp ' + (val / 1000000).toLocaleString('id-ID', {maximumFractionDigits: 1}) + ' Jt'; };

    // ─── 1. Monthly Trend (Area) ────────────────────────────────────────
    var monthlyHpp   = {!! json_encode($months->pluck('hpp')->map(fn($v) => round($v / 1000000, 1))->values()) !!};
    var monthLabels  = {!! json_encode($months->pluck('label')->values()) !!};
    var monthlyCount = {!! json_encode($months->pluck('count')->values()) !!};

    new ApexCharts(document.querySelector("#monthlyTrendChart"), {
        series: [
            { name: 'Total HPP (Jt)', data: monthlyHpp },
            { name: 'Jumlah Dokumen', data: monthlyCount, type: 'line' }
        ],
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        colors: ['#f7c94b', '#0d6efd'],
        stroke: { curve: 'smooth', width: [2, 2] },
        dataLabels: { enabled: false },
        xaxis: { categories: monthLabels },
        yaxis: [
            { title: { text: 'Rp Juta' }, labels: { formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + ' Jt'; } } },
            { opposite: true, title: { text: 'Dokumen' }, labels: { formatter: function(v) { return v + ' dok'; } } }
        ],
        fill: { type: ['gradient', 'solid'], gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.05, stops: [0, 100] } },
        tooltip: { y: [{ formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + ' Jt'; } }, { formatter: function(v) { return v + ' dok'; } }] }
    }).render();

    // ─── 2. Status Distribution (Donut) ────────────────────────────────
    @if($statusDist->isNotEmpty())
    var colorMap = { primary: '#0d6efd', success: '#198754', warning: '#ffc107', danger: '#dc3545', info: '#0dcaf0', secondary: '#6c757d' };
    var statusColors = {!! json_encode($statusDist->pluck('color')) !!}.map(function(c) { return colorMap[c] || '#adb5bd'; });
    new ApexCharts(document.querySelector("#statusDistChart"), {
        series: {!! json_encode($statusDist->pluck('count')->values()) !!},
        chart: { type: 'donut', height: 280 },
        labels: {!! json_encode($statusDist->pluck('label')->values()) !!},
        colors: statusColors,
        legend: { position: 'bottom', fontSize: '11px' },
        dataLabels: { enabled: true, formatter: function(val, opts) { return opts.w.globals.series[opts.seriesIndex] + ' dok'; } }
    }).render();
    @endif

    // ─── 3. Category Breakdown (Bar) ───────────────────────────────────
    @php
        $cats = [
            ['Tenaga Kerja',  round(($categoryBreakdown->labor ?? 0) / 1000000, 1)],
            ['Alat Berat',    round(($categoryBreakdown->equipment ?? 0) / 1000000, 1)],
            ['Pemeliharaan',  round(($categoryBreakdown->maintenance ?? 0) / 1000000, 1)],
            ['Operasional',   round(($categoryBreakdown->operational ?? 0) / 1000000, 1)],
            ['Mobilisasi',    round(($categoryBreakdown->mobilization ?? 0) / 1000000, 1)],
            ['Lainnya',       round(($categoryBreakdown->other_cost ?? 0) / 1000000, 1)],
        ];
    @endphp
    new ApexCharts(document.querySelector("#categoryChart"), {
        series: [{ name: 'Biaya (Jt)', data: {!! json_encode(array_column($cats, 1)) !!} }],
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        colors: ['#0d6efd'],
        plotOptions: { bar: { horizontal: false, columnWidth: '50%', borderRadius: 4, distributed: true } },
        dataLabels: { enabled: false },
        xaxis: { categories: {!! json_encode(array_column($cats, 0)) !!} },
        yaxis: { labels: { formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + ' Jt'; } } },
        tooltip: { y: { formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + ' Jt'; } } }
    }).render();

    // ─── 4. Per-Project HPP vs Selling Price (Grouped Bar) ─────────────
    @if($projectBudget->isNotEmpty())
    new ApexCharts(document.querySelector("#projectBudgetChart"), {
        series: [
            { name: 'HPP (Jt)',       data: {!! json_encode($projectBudget->pluck('hpp')->map(fn($v) => round($v / 1000000, 1))->values()) !!} },
            { name: 'Harga Jual (Jt)', data: {!! json_encode($projectBudget->pluck('sp')->map(fn($v) => round($v / 1000000, 1))->values()) !!} }
        ],
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        colors: ['#f7c94b', '#198754'],
        plotOptions: { bar: { horizontal: true, barHeight: '65%', borderRadius: 3 } },
        dataLabels: { enabled: false },
        xaxis: { labels: { formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + ' Jt'; } } },
        yaxis: { categories: {!! json_encode($projectBudget->pluck('name')->values()) !!}, labels: { style: { fontSize: '11px' }, maxWidth: 180 } },
        tooltip: { y: { formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + ' Jt'; } } },
        legend: { position: 'top' }
    }).render();
    @endif
});
</script>
@endpush
