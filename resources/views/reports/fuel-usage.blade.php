@extends('layout.mainlayout')
@section('title', 'Laporan Penggunaan BBM')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 no-print">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Laporan Penggunaan BBM</h3>
                <p class="text-muted mb-0 small">Analisis konsumsi dan efisiensi bahan bakar minyak (BBM) unit operasional.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan Penggunaan BBM</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('lead-reports.export', request()->query()) }}" class="btn btn-outline-success">
                    <i class="ti ti-file-export me-2"></i>Ekspor CSV
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ti ti-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Print-only Header -->
        <div class="d-none d-print-block mb-4 text-center header-print">
            <h2 class="mb-1">LAPORAN PENGGUNAAN BBM (FUEL USAGE)</h2>
            <h5 class="text-muted mb-3">PT Sinar Sentosa Bahari</h5>
            <div class="d-flex justify-content-center gap-4 text-muted small">
                <span><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
                <span><strong>Status Jurnal:</strong> {{ $status === 'ALL' ? 'Semua' : $status }}</span>
            </div>
            <hr class="my-4">
        </div>

        <!-- KPI Cards Row -->
        <div class="row">
            <!-- Card 1: Total BBM -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total BBM Terpakai</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-droplet"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($totalFuel, 2, ',', '.') }} L</h4>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Working Hours -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Jam Kerja</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ti ti-clock"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($totalWorkingHours, 2, ',', '.') }} Jam</h4>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total HM -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total HM Operasional</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ti ti-gauge"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($totalHm, 2, ',', '.') }} HM</h4>
                    </div>
                </div>
            </div>

            <!-- Card 4: Average Fuel per Hour -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Rata-rata Konsumsi</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                        <i class="ti ti-flame"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($avgLitersPerHour, 2, ',', '.') }} L/Jam</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1: Trends & Project Distribution -->
        <div class="row mb-4 no-print">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Tren Penggunaan BBM Harian (Liter)</h5>
                    </div>
                    <div class="card-body">
                        @if($dailyFuel->isNotEmpty())
                            <div id="dailyFuelChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">BBM per Proyek</h5>
                    </div>
                    <div class="card-body">
                        @if($projectFuel->isNotEmpty())
                            <div id="projectFuelChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2: Top Units & Activity Breakdown -->
        <div class="row mb-4 no-print">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Top 5 Unit dengan Konsumsi Tertinggi (Liter)</h5>
                    </div>
                    <div class="card-body">
                        @if($unitFuel->isNotEmpty())
                            <div id="unitFuelChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Distribusi Penggunaan per Aktivitas</h5>
                    </div>
                    <div class="card-body">
                        @if($activityFuel->isNotEmpty())
                            <div id="activityFuelChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form Section -->
        <div class="card mb-4 no-print">
            <div class="card-header bg-white border-bottom-dashed">
                <h5 class="card-title mb-0"><i class="ti ti-adjustments-horizontal me-2"></i>Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('lead-reports') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Proyek</label>
                        <select name="project_id" class="form-select select2">
                            <option value="">Semua Proyek</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" @selected($projectId == $p->id)>{{ $p->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Status Timesheet</label>
                        <select name="status" class="form-select">
                            <option value="ALL" @selected($status === 'ALL')>Semua Status</option>
                            @foreach(\App\Enums\TimesheetJournalStatus::cases() as $st)
                                <option value="{{ $st->value }}" @selected($status === $st->value)>{{ $st->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Nama Unit</label>
                        <select name="unit_name" class="form-select select2">
                            <option value="">Semua Unit</option>
                            @foreach($units as $u)
                                <option value="{{ $u }}" @selected($unitName === $u)>{{ $u }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Nama Operator</label>
                        <select name="operator_name" class="form-select select2">
                            <option value="">Semua Operator</option>
                            @foreach($operators as $o)
                                <option value="{{ $o }}" @selected($operatorName === $o)>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4"><i class="ti ti-search me-1"></i>Terapkan Filter</button>
                        <a href="{{ route('lead-reports') }}" class="btn btn-outline-secondary px-3">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Detailed Log Data Table -->
        <div class="card">
            <div class="card-header bg-white border-bottom-dashed d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="card-title mb-0">Rincian Log Konsumsi Bahan Bakar</h5>
                <span class="badge bg-light text-dark small no-print">Menampilkan {{ $entries->firstItem() ?? 0 }} - {{ $entries->lastItem() ?? 0 }} dari {{ $entries->total() }} log</span>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-nowrap align-middle">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>No. Jurnal</th>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Unit / Alat</th>
                                <th>Operator</th>
                                <th>Aktivitas</th>
                                <th class="text-end">Jam Kerja</th>
                                <th class="text-end">HM Total</th>
                                <th class="text-end">BBM (Liter)</th>
                                <th class="text-end">Efisiensi</th>
                                <th class="text-center no-print">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($entries as $e)
                            @php
                                $efficiency = $e->working_hours > 0 ? ($e->fuel_consumed_liter / $e->working_hours) : 0;
                                $jStatus = $e->timesheetJournal->status ?? \App\Enums\TimesheetJournalStatus::DRAFT;
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('timesheets.show', $e->timesheetJournal->uid ?? '#') }}" class="fw-medium link-primary">
                                        {{ $e->timesheetJournal->journal_number ?? '-' }}
                                    </a>
                                </td>
                                <td>{{ $e->timesheetJournal->journal_date?->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width:180px">
                                        {{ $e->timesheetJournal->project->project_name ?? '-' }}
                                    </span>
                                </td>
                                <td><strong>{{ $e->unit_name }}</strong></td>
                                <td>{{ $e->operator_name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $e->activity_code }}</span>
                                </td>
                                <td class="text-end">{{ number_format($e->working_hours, 2, ',', '.') }} Jam</td>
                                <td class="text-end">{{ number_format($e->hm_total, 2, ',', '.') }} HM</td>
                                <td class="text-end text-info"><strong>{{ number_format($e->fuel_consumed_liter, 2, ',', '.') }} L</strong></td>
                                <td class="text-end">
                                    <span class="fw-semibold">{{ number_format($efficiency, 2, ',', '.') }}</span> <small class="text-muted">L/Jam</small>
                                </td>
                                <td class="text-center no-print">
                                    <span class="badge bg-{{ $jStatus->color() }}-subtle text-{{ $jStatus->color() }} text-uppercase">
                                        {{ $jStatus->label() }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div class="avatar-title bg-light rounded-circle text-muted fs-1"><i class="ti ti-droplet"></i></div>
                                    </div>
                                    <h5>Data penggunaan BBM tidak ditemukan</h5>
                                    <p class="text-muted">Pastikan log timesheet sudah diisi dan disetujui pada periode filter yang dipilih.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3 no-print">
                    {{ $entries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print-specific CSS styles -->
<style>
@media print {
    body {
        background: #fff !important;
        color: #000 !important;
        font-family: 'Inter', sans-serif !important;
    }
    .page-wrapper {
        margin: 0 !important;
        padding: 0 !important;
    }
    .content {
        padding: 0 !important;
    }
    .no-print, .sidebar, .sidebar-inner, .header, #toggle_btn, footer, .components-footer, .breadcrumb, .btn, form, .pagination {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
        margin-bottom: 0 !important;
    }
    .card-body {
        padding: 0 !important;
    }
    .table-responsive {
        overflow: visible !important;
    }
    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    th, td {
        border: 1px solid #ddd !important;
        padding: 8px !important;
        font-size: 11px !important;
        white-space: normal !important;
    }
    th {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }
}
</style>
@endsection

@push('scripts')
<script src="{{ URL::asset('build/plugins/apexchart/apexcharts.min.js') }}"></script>
<script>
$(document).ready(function () {
    // Select2 Initialization if available
    if ($.fn.select2) {
        $('.select2').select2({
            width: '100%'
        });
    }

    // Chart 1: Daily Fuel Trend (Area Chart)
    @if($dailyFuel->isNotEmpty())
    var dailyFuelOptions = {
        series: [{
            name: 'BBM Terpakai',
            data: {!! json_encode($dailyFuel->pluck('fuel')) !!}
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: false }
        },
        colors: ['#0d6efd'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: {!! json_encode($dailyFuel->pluck('date')) !!},
            labels: {
                rotate: -45,
                style: { fontSize: '11px' }
            }
        },
        yaxis: {
            title: { text: 'Liter' }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 100]
            }
        }
    };
    var dailyFuelChart = new ApexCharts(document.querySelector("#dailyFuelChart"), dailyFuelOptions);
    dailyFuelChart.render();
    @endif

    // Chart 2: BBM per Project (Column Chart)
    @if($projectFuel->isNotEmpty())
    var projectFuelOptions = {
        series: [{
            name: 'BBM Terpakai',
            data: {!! json_encode($projectFuel->pluck('fuel')) !!}
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        colors: ['#198754'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                borderRadius: 4
            },
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: {!! json_encode($projectFuel->pluck('name')) !!},
            labels: {
                trim: true,
                style: { fontSize: '11px' }
            }
        },
        yaxis: {
            title: { text: 'Liter' }
        }
    };
    var projectFuelChart = new ApexCharts(document.querySelector("#projectFuelChart"), projectFuelOptions);
    projectFuelChart.render();
    @endif

    // Chart 3: Top 5 Units (Horizontal Bar Chart)
    @if($unitFuel->isNotEmpty())
    var unitFuelOptions = {
        series: [{
            name: 'BBM Terpakai',
            data: {!! json_encode($unitFuel->pluck('fuel')) !!}
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false }
        },
        colors: ['#fd7e14'],
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '55%',
                borderRadius: 4
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toLocaleString('id-ID') + ' L';
            }
        },
        xaxis: {
            categories: {!! json_encode($unitFuel->pluck('name')) !!},
        }
    };
    var unitFuelChart = new ApexCharts(document.querySelector("#unitFuelChart"), unitFuelOptions);
    unitFuelChart.render();
    @endif

    // Chart 4: Activity Distribution (Donut Chart)
    @if($activityFuel->isNotEmpty())
    var activityFuelOptions = {
        series: {!! json_encode($activityFuel->pluck('fuel')) !!},
        chart: {
            type: 'donut',
            height: 300
        },
        labels: {!! json_encode($activityFuel->pluck('activity')) !!},
        colors: ['#0d6efd', '#20c997', '#ffc107', '#dc3545', '#6c757d', '#6f42c1'],
        legend: {
            position: 'bottom',
            fontSize: '11px'
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                return opts.w.globals.series[opts.seriesIndex].toLocaleString('id-ID') + ' L';
            }
        }
    };
    var activityFuelChart = new ApexCharts(document.querySelector("#activityFuelChart"), activityFuelOptions);
    activityFuelChart.render();
    @endif
});
</script>
@endpush
