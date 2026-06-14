@extends('layout.mainlayout')

@section('title', 'Laporan Hasil Survey Proyek')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- ── Header ──────────────────────────────────────────────────────── --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h4 class="fw-bold mb-1"><i class="ti ti-report-analytics text-warning me-2"></i>Laporan Hasil Survey Proyek</h4>
                <p class="text-muted mb-0 small">Analisis kelayakan, status peninjauan, dan skor departemen proyek</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('survey-reports.export', request()->query()) }}"
                   class="btn btn-outline-success btn-sm d-print-none">
                    <i class="ti ti-file-spreadsheet me-1"></i>Ekspor CSV
                </a>
                <a href="{{ route('project-survey.create') }}"
                   class="btn btn-warning btn-sm d-print-none text-dark">
                    <i class="ti ti-plus me-1"></i>Mulai Survey
                </a>
                <button class="btn btn-outline-secondary btn-sm d-print-none" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i>Cetak
                </button>
            </div>
        </div>

        {{-- ── Filter Card ─────────────────────────────────────────────────── --}}
        <div class="card mb-4 d-print-none">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('survey-reports') }}" class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label mb-1 small fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control form-control-sm"
                               value="{{ $startDate }}">
                    </div>
                    <div class="col-md-2">
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
                            <option value="ALL" @selected($status === 'ALL')>Semua</option>
                            <option value="DRAFT" @selected($status === 'DRAFT')>Draft</option>
                            <option value="SURVEY_PLANNED" @selected($status === 'SURVEY_PLANNED')>Direncanakan</option>
                            <option value="SURVEY_IN_PROGRESS" @selected($status === 'SURVEY_IN_PROGRESS')>Dalam Proses</option>
                            <option value="SURVEY_SUBMITTED" @selected($status === 'SURVEY_SUBMITTED')>Diajukan</option>
                            <option value="PROJECT_FEASIBLE" @selected($status === 'PROJECT_FEASIBLE')>Layak</option>
                            <option value="COMPLETED" @selected($status === 'COMPLETED')>Selesai</option>
                            <option value="PROJECT_CANCELLED" @selected($status === 'PROJECT_CANCELLED')>Dibatalkan</option>
                            <option value="REJECTED" @selected($status === 'REJECTED')>Ditolak</option>
                            <option value="SURVEY_SKIPPED" @selected($status === 'SURVEY_SKIPPED')>Dilewati</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1 small fw-semibold">Kelayakan</label>
                        <select name="is_feasible" class="form-select form-select-sm">
                            <option value="ALL" @selected($isFeasible === 'ALL')>Semua</option>
                            <option value="FEASIBLE" @selected($isFeasible === 'FEASIBLE')>Layak (Feasible)</option>
                            <option value="NOT_FEASIBLE" @selected($isFeasible === 'NOT_FEASIBLE')>Tidak Layak</option>
                            <option value="PENDING" @selected($isFeasible === 'PENDING')>Tertunda / Proses</option>
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
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Total Survey</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-file-text text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($totalSurveys) }}</h3>
                        <small class="opacity-75">Proyek Survey</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #10b981, #047857);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Selesai (Completed)</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-checkbox text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($completedSurveys) }}</h3>
                        <small class="opacity-75">Survei Rampung</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #f59e0b, #b45309);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Proyek Layak</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-award text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($feasibleProjects) }}</h3>
                        <small class="opacity-75">Feasible</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
                    <div class="card-body p-3 text-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-12 fw-semibold opacity-75">Rata-rata Skor</span>
                            <span class="avatar avatar-sm bg-white bg-opacity-25 rounded">
                                <i class="ti ti-star text-white fs-16"></i>
                            </span>
                        </div>
                        <h3 class="fw-bold mb-0">{{ number_format($avgScore, 2) }}</h3>
                        <small class="opacity-75">Skor Penilaian</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Charts Row ───────────────────────────────────────────────────── --}}
        <div class="row g-3 mb-4 d-print-none">
            {{-- Average Score Trend --}}
            <div class="col-md-7">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0"><i class="ti ti-chart-line text-warning me-2"></i>Tren Rata-rata Skor</h5>
                        <small class="text-muted">{{ $startDate }} s/d {{ $endDate }}</small>
                    </div>
                    <div class="card-body">
                        <div id="chartScoreTrend" style="min-height:240px;"></div>
                    </div>
                </div>
            </div>
            {{-- Department Scores --}}
            <div class="col-md-5">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-chart-bar text-primary me-2"></i>Rata-rata Nilai per Departemen</h5>
                    </div>
                    <div class="card-body">
                        <div id="chartDeptScores" style="min-height:240px;"></div>
                    </div>
                </div>
            </div>
            {{-- Status Distribution --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-chart-donut text-info me-2"></i>Status Survey</h5>
                    </div>
                    <div class="card-body">
                        <div id="chartStatus" style="min-height:240px;"></div>
                    </div>
                </div>
            </div>
            {{-- Feasibility Ratio --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ti ti-pie-chart text-success me-2"></i>Status Kelayakan Proyek</h5>
                    </div>
                    <div class="card-body">
                        <div id="chartFeasibility" style="min-height:240px;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Data Table ───────────────────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0"><i class="ti ti-list me-2 text-warning"></i>Detail Hasil Survey Proyek</h5>
                <span class="badge bg-warning-subtle text-warning">{{ $entries->total() }} survey</span>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Survey</th>
                            <th>Nama Proyek</th>
                            <th>Tanggal Survey</th>
                            <th>Kelayakan</th>
                            <th>Tim Surveyor</th>
                            <th class="text-end">PROJECT (40%)</th>
                            <th class="text-end">WORKSHOP (30%)</th>
                            <th class="text-end">HSE (30%)</th>
                            <th class="text-end">Total Skor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $row)
                            <tr>
                                <td>
                                    <a href="{{ route('project-survey.show', $row->uid) }}"
                                       class="fw-semibold text-warning">{{ substr($row->uid, 0, 8) }}…</a>
                                </td>
                                <td class="small fw-semibold text-dark">{{ $row->project?->project_name ?? '-' }}</td>
                                <td class="text-nowrap small">
                                    @if($row->is_skipped)
                                        <span class="badge bg-dark-subtle text-dark">Dilewati</span>
                                    @else
                                        {{ $row->scheduled_at ? $row->scheduled_at->format('d/m/Y H:i') : '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if($row->is_skipped)
                                        <span class="text-muted small">-</span>
                                    @elseif($row->is_feasible === true)
                                        <span class="badge bg-success-subtle text-success">Feasible</span>
                                    @elseif($row->is_feasible === false)
                                        <span class="badge bg-danger-subtle text-danger">Not Feasible</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Pending</span>
                                    @endif
                                </td>
                                <td class="small text-muted" style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    @php
                                        $teamList = $row->teams->map(fn($t) => $t->user?->name)->implode(', ');
                                    @endphp
                                    {{ $teamList ?: '-' }}
                                </td>
                                <td class="text-end small">
                                    @php $pSc = $row->scores->firstWhere('department', 'PROJECT')?->score; @endphp
                                    {{ $pSc !== null ? number_format($pSc, 0) : '-' }}
                                </td>
                                <td class="text-end small">
                                    @php $wSc = $row->scores->firstWhere('department', 'WORKSHOP')?->score; @endphp
                                    {{ $wSc !== null ? number_format($wSc, 0) : '-' }}
                                </td>
                                <td class="text-end small">
                                    @php $hSc = $row->scores->firstWhere('department', 'HSE')?->score; @endphp
                                    {{ $hSc !== null ? number_format($hSc, 0) : '-' }}
                                </td>
                                <td class="text-end fw-bold {{ ($row->total_score >= 70) ? 'text-success' : 'text-danger' }}">
                                    {{ $row->total_score !== null ? number_format($row->total_score, 2) : '-' }}
                                </td>
                                <td>
                                    @php
                                        $badgeColor = match($row->status) {
                                            'DRAFT' => 'secondary',
                                            'SURVEY_PLANNED' => 'info',
                                            'SURVEY_IN_PROGRESS' => 'warning',
                                            'SURVEY_SUBMITTED' => 'info',
                                            'PROJECT_FEASIBLE' => 'success',
                                            'COMPLETED' => 'success',
                                            'PROJECT_CANCELLED' => 'danger',
                                            'REJECTED' => 'danger',
                                            'SURVEY_SKIPPED' => 'dark',
                                            default => 'secondary'
                                        };
                                        $statusLabel = str_replace('_', ' ', $row->status);
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}-subtle text-{{ $badgeColor }} text-uppercase fs-10">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="ti ti-mood-empty fs-1 d-block mb-2 text-warning"></i>
                                    Tidak ada data survei untuk periode &amp; filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
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

    const trendData = @json($scoreTrend);
    const deptScores = @json($deptScores);
    const statusData = @json($statusDist);
    const feasData = @json($feasibilityRatio);

    const baseOpts = { chart: { toolbar: { show: false }, fontFamily: 'inherit' } };

    // 1. Score Trend Chart
    if (trendData.length) {
        new ApexCharts(document.querySelector('#chartScoreTrend'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'area', height: 240 },
            series: [{ name: 'Rata-rata Skor', data: trendData.map(d => d.score) }],
            xaxis: { categories: trendData.map(d => d.date), labels: { style: { fontSize: '10px' } } },
            yaxis: { min: 0, max: 100 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05 } },
            colors: ['#3b82f6'],
            stroke: { curve: 'smooth', width: 2 },
            dataLabels: { enabled: false },
        }).render();
    } else {
        document.querySelector('#chartScoreTrend').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-chart-line fs-1 text-warning"></i><p class="mt-2 small">Tidak ada data peninjauan</p></div>';
    }

    // 2. Department Scores
    if (deptScores.length) {
        new ApexCharts(document.querySelector('#chartDeptScores'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'bar', height: 240 },
            plotOptions: { bar: { borderRadius: 4, columnWidth: '40%', distributed: true } },
            series: [{ name: 'Skor Rata-rata', data: deptScores.map(d => d.score) }],
            xaxis: { categories: deptScores.map(d => d.dept) },
            yaxis: { min: 0, max: 100 },
            colors: ['#8b5cf6', '#ec4899', '#10b981'],
            legend: { show: false },
            dataLabels: { enabled: true, formatter: v => v.toFixed(0) },
        }).render();
    } else {
        document.querySelector('#chartDeptScores').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-chart-bar fs-1 text-warning"></i><p class="mt-2 small">Belum ada skor departemen</p></div>';
    }

    // 3. Status Distribution
    if (statusData.length) {
        new ApexCharts(document.querySelector('#chartStatus'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'donut', height: 240 },
            series: statusData.map(d => d.qty),
            labels: statusData.map(d => d.status),
            legend: { position: 'bottom', fontSize: '11px' },
            plotOptions: { pie: { donut: { size: '60%' } } },
        }).render();
    } else {
        document.querySelector('#chartStatus').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-chart-donut fs-1 text-warning"></i><p class="mt-2 small">Tidak ada data status</p></div>';
    }

    // 4. Feasibility Ratio
    if (feasData.length) {
        new ApexCharts(document.querySelector('#chartFeasibility'), {
            ...baseOpts,
            chart: { ...baseOpts.chart, type: 'pie', height: 240 },
            series: feasData.map(d => d.qty),
            labels: feasData.map(d => d.label),
            colors: ['#10b981', '#ef4444', '#6b7280'],
            legend: { position: 'bottom', fontSize: '11px' },
        }).render();
    } else {
        document.querySelector('#chartFeasibility').innerHTML =
            '<div class="text-center text-muted py-5"><i class="ti ti-pie-chart fs-1 text-warning"></i><p class="mt-2 small">Tidak ada data kelayakan</p></div>';
    }
})();
</script>
@endpush

@push('styles')
<style>
@media print {
    .page-header, .sidebar, header, .d-print-none { display: none !important; }
    .card { border: 1px solid #ddd !important; box-shadow: none !important; }
    body { font-size: 11px; background: white !important; }
    .page-wrapper { margin-left: 0 !important; padding-top: 0 !important; }
}
</style>
@endpush
@endsection
