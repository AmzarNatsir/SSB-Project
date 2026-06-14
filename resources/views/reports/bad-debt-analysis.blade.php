@extends('layout.mainlayout')
@section('title', 'Laporan Bad Debt Analysis')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 no-print">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Bad Debt Analysis Report</h3>
                <p class="text-muted mb-0 small">Identifikasi invoices berisiko write-off dan tracking bad debt exposure.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Bad Debt Analysis</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('bad-debt-analysis.export', request()->query()) }}" class="btn btn-outline-success">
                    <i class="ti ti-file-export me-2"></i>Ekspor CSV
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ti ti-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Bad Debt Exposure</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title bg-danger-subtle text-danger rounded fs-3">
                                    <i class="ti ti-alert-triangle"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4 text-danger">Rp {{ number_format($kpiData['badDebtExposure'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"># At-Risk Invoices</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                    <i class="ti ti-exclamation-mark"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ $kpiData['numAtRisk'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Write-off Amount (365+)</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title bg-dark-subtle text-danger rounded fs-3">
                                    <i class="ti ti-x"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4 text-danger">Rp {{ number_format($kpiData['writeOffAmount'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">AFDA Reserve</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                    <i class="ti ti-receipt"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">Rp {{ number_format($kpiData['afda'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card no-print mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Data</h5>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-3">
                        <label for="dateFrom" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="dateFrom" name="date_from" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-3">
                        <label for="dateTo" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="dateTo" name="date_to" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-3">
                        <label for="projectId" class="form-label">Proyek</label>
                        <select class="form-select" id="projectId" name="project_id">
                            <option value="">-- Semua Proyek --</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}" {{ $projectId == $proj->id ? 'selected' : '' }}>
                                    {{ $proj->project_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="riskLevel" class="form-label">Risk Level</label>
                        <select class="form-select" id="riskLevel" name="risk_level">
                            @foreach($riskLevelOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $riskLevel == $opt['value'] ? 'selected' : '' }}>
                                    {{ $opt['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="agingCategory" class="form-label">Aging Category</label>
                        <select class="form-select" id="agingCategory" name="aging_category">
                            @foreach($agingCategoryOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $agingCategory == $opt['value'] ? 'selected' : '' }}>
                                    {{ $opt['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('bad-debt-analysis') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mb-4 no-print">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Bad Debt Aging Trend (12 Months)</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($badDebtTrend))
                            <div id="trendChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 no-print">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Bad Debt Aging Analysis</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($agingAnalysis))
                            <div id="agingChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Risk Level Distribution</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($riskDistribution))
                            <div id="riskChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 no-print">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top 10 Risk Customers</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($topRiskCustomers))
                            <div id="topRiskChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Tidak ada data</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="card no-print">
            <div class="card-header">
                <h5 class="card-title mb-0">At-Risk Invoices (90+ Days Overdue)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Tgl Invoice</th>
                                <th>Tgl Jatuh Tempo</th>
                                <th>Hari OD</th>
                                <th>Outstanding (Rp)</th>
                                <th>Risk Level</th>
                                <th>Aging Category</th>
                                <th>Reserve %</th>
                                <th>Reserve (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($atRiskInvoices->count() > 0)
                                @foreach($atRiskInvoices as $index => $inv)
                                    @php
                                        $daysOD = (int) $inv->days_overdue;
                                        $outstanding = (float) $inv->outstanding_amount;
                                        if ($daysOD > 365) {
                                            $aging = '365+ Days';
                                            $reserve = 100;
                                        } elseif ($daysOD > 180) {
                                            $aging = '181-365 Days';
                                            $reserve = 50;
                                        } else {
                                            $aging = '90-180 Days';
                                            $reserve = 10;
                                        }
                                        $reserveAmount = $outstanding * ($reserve / 100);

                                        if ($daysOD > 365) {
                                            $riskLevel = 'CRITICAL';
                                            $badgeClass = 'bg-danger';
                                        } elseif ($daysOD > 180) {
                                            $riskLevel = 'HIGH';
                                            $badgeClass = 'bg-warning';
                                        } else {
                                            $riskLevel = 'MEDIUM';
                                            $badgeClass = 'bg-info';
                                        }
                                    @endphp
                                    <tr class="table-{{ $riskLevel === 'CRITICAL' ? 'danger' : ($riskLevel === 'HIGH' ? 'warning' : 'info') }}">
                                        <td><small>{{ ($atRiskInvoices->currentPage() - 1) * 20 + $index + 1 }}</small></td>
                                        <td><small><strong>{{ $inv->invoice_number }}</strong></small></td>
                                        <td><small>{{ $inv->customer_name }}</small></td>
                                        <td><small>{{ \Carbon\Carbon::parse($inv->invoice_date)->format('d-m-Y') }}</small></td>
                                        <td><small>{{ \Carbon\Carbon::parse($inv->due_date)->format('d-m-Y') }}</small></td>
                                        <td><small class="text-center"><strong>{{ $daysOD }}</strong></small></td>
                                        <td><small class="text-end text-danger"><strong>{{ number_format($outstanding, 0, ',', '.') }}</strong></small></td>
                                        <td>
                                            <small>
                                                <span class="badge {{ $badgeClass }}">{{ $riskLevel }}</span>
                                            </small>
                                        </td>
                                        <td><small>{{ $aging }}</small></td>
                                        <td><small class="text-center">{{ $reserve }}%</small></td>
                                        <td><small class="text-end">{{ number_format($reserveAmount, 0, ',', '.') }}</small></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">Tidak ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if($atRiskInvoices->count() > 0)
                    <nav class="mt-4">
                        {{ $atRiskInvoices->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trend Chart
        const trendData = @json($badDebtTrend);
        if (trendData && trendData.length > 0) {
            const ctx = document.getElementById('trendChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'area',
                    data: {
                        labels: trendData.map(d => d.month),
                        datasets: [
                            {
                                label: '90-180 Days',
                                data: trendData.map(d => d.days_90_180),
                                borderColor: '#0dcaf0',
                                backgroundColor: 'rgba(13, 202, 240, 0.1)',
                            },
                            {
                                label: '181-365 Days',
                                data: trendData.map(d => d.days_181_365),
                                borderColor: '#fd7e14',
                                backgroundColor: 'rgba(253, 126, 20, 0.1)',
                            },
                            {
                                label: '365+ Days',
                                data: trendData.map(d => d.days_365_plus),
                                borderColor: '#dc3545',
                                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        }

        // Aging Chart
        const agingData = @json($agingAnalysis);
        if (agingData && agingData.length > 0) {
            const ctx = document.getElementById('agingChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: agingData.map(d => d.category),
                        datasets: [
                            {
                                label: 'Outstanding (Rp)',
                                data: agingData.map(d => d.outstanding),
                                backgroundColor: '#0d6efd',
                            },
                            {
                                label: 'Reserve Amount (Rp)',
                                data: agingData.map(d => d.reserve_amount),
                                backgroundColor: '#dc3545',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                    }
                });
            }
        }

        // Risk Chart
        const riskData = @json($riskDistribution);
        if (riskData && riskData.length > 0) {
            const ctx = document.getElementById('riskChart')?.getContext('2d');
            if (ctx) {
                const colors = ['#198754', '#0dcaf0', '#fd7e14', '#dc3545'];
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: riskData.map(d => d.level),
                        datasets: [{
                            data: riskData.map(d => d.percent),
                            backgroundColor: colors,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } }
                    }
                });
            }
        }

        // Top Risk Chart
        const topRiskData = @json($topRiskCustomers);
        if (topRiskData && topRiskData.length > 0) {
            const ctx = document.getElementById('topRiskChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: topRiskData.map(d => d.customer_name),
                        datasets: [{
                            label: 'Exposure (Rp)',
                            data: topRiskData.map(d => d.exposure),
                            backgroundColor: '#dc3545',
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        plugins: { legend: { display: true } },
                    }
                });
            }
        }
    });
</script>

<style>
    @media print {
        .no-print { display: none; }
        .card { break-inside: avoid; }
        .table { font-size: 10px; }
    }
</style>
@endsection
