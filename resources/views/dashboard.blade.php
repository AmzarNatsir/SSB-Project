@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Executive Dashboard</h3>
                <p class="text-muted mb-0 small">Monitoring KPI utama: A/R, Collections, Bad Debt & Petty Cash</p>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ti ti-printer me-2"></i>Cetak
                </button>
            </div>
        </div>

        <!-- Alerts Section -->
        @if(count($alerts) > 0)
            <div class="row mb-3">
                @foreach($alerts as $alert)
                    <div class="col-12">
                        <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show" role="alert">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h5 class="alert-heading mb-1">{{ $alert['title'] }}</h5>
                                    <p class="mb-2">{{ $alert['message'] }}</p>
                                    <a href="{{ route($alert['route']) }}" class="btn btn-sm btn-{{ $alert['type'] }}">
                                        {{ $alert['action'] }}
                                    </a>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body py-2">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label small">Periode Dari</label>
                        <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Sampai</label>
                        <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Proyek</label>
                        <select name="project_id" class="form-select form-select-sm">
                            <option value="">Semua Proyek</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>
                                    {{ $project->project_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- KPI Cards Row 1: A/R Metrics -->
        <div class="row mb-3">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">Total Outstanding A/R</h6>
                                <h3 class="mb-0">Rp {{ number_format($kpiData['total_outstanding'], 0, ',', '.') }}</h3>
                            </div>
                            <i class="ti ti-wallet fs-4 text-primary"></i>
                        </div>
                        <small class="text-muted">dari {{ number_format($kpiData['total_invoiced'], 0, ',', '.') }} invoiced</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">Collection Rate</h6>
                                <h3 class="mb-0">{{ $kpiData['collection_rate'] }}%</h3>
                            </div>
                            <div class="badge bg-{{ $kpiData['collection_status'] == 'good' ? 'success' : ($kpiData['collection_status'] == 'warning' ? 'warning' : 'danger') }}">
                                {{ $kpiData['collection_rate'] >= $kpiData['collection_target'] ? '✓' : '✗' }}
                            </div>
                        </div>
                        <small class="text-muted">Target: {{ $kpiData['collection_target'] }}%</small>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-{{ $kpiData['collection_status'] == 'good' ? 'success' : ($kpiData['collection_status'] == 'warning' ? 'warning' : 'danger') }}"
                                 style="width: {{ min($kpiData['collection_rate'], 100) }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">Bad Debt Exposure</h6>
                                <h3 class="mb-0">{{ $kpiData['bad_debt_percent'] }}%</h3>
                            </div>
                            <div class="badge bg-{{ $kpiData['bad_debt_status'] == 'good' ? 'success' : ($kpiData['bad_debt_status'] == 'warning' ? 'warning' : 'danger') }}">
                                {{ $kpiData['bad_debt_percent'] <= $kpiData['bad_debt_target'] ? '✓' : '✗' }}
                            </div>
                        </div>
                        <small class="text-muted">Rp {{ number_format($kpiData['bad_debt_exposure'], 0, ',', '.') }}</small>
                        <small class="text-muted d-block">Target: ≤ {{ $kpiData['bad_debt_target'] }}%</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">DSO (Days)</h6>
                                <h3 class="mb-0">{{ $performanceData['dso'] }}</h3>
                            </div>
                            <i class="ti ti-calendar fs-4 text-info"></i>
                        </div>
                        <small class="text-muted">Target: {{ $performanceData['dso_target'] }} days</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards Row 2: Petty Cash & Performance -->
        <div class="row mb-3">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">Petty Cash Utilization</h6>
                                <h3 class="mb-0">{{ $kpiData['petty_cash_util'] }}%</h3>
                            </div>
                            <div class="badge bg-{{ $kpiData['petty_cash_status'] == 'good' ? 'success' : 'warning' }}">
                                {{ $kpiData['petty_cash_util'] <= $kpiData['petty_cash_target'] ? '✓' : '⚠' }}
                            </div>
                        </div>
                        <small class="text-muted">Rp {{ number_format($kpiData['petty_cash_used'], 0, ',', '.') }} dari Rp {{ number_format($kpiData['petty_cash_allocated'], 0, ',', '.') }}</small>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar bg-{{ $kpiData['petty_cash_status'] == 'good' ? 'success' : 'warning' }}"
                                 style="width: {{ min($kpiData['petty_cash_util'], 100) }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">On-Time Payment Rate</h6>
                                <h3 class="mb-0">{{ $performanceData['on_time_rate'] }}%</h3>
                            </div>
                            <i class="ti ti-check fs-4 text-success"></i>
                        </div>
                        <small class="text-muted">Target: {{ $performanceData['on_time_target'] }}%</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">Active Customers</h6>
                                <h3 class="mb-0">{{ $performanceData['customer_count'] }}</h3>
                            </div>
                            <i class="ti ti-users fs-4 text-warning"></i>
                        </div>
                        <small class="text-muted">dengan active A/R</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted text-uppercase small mb-1">Projects with A/R</h6>
                                <h3 class="mb-0">{{ $performanceData['project_count'] }}</h3>
                            </div>
                            <i class="ti ti-building fs-4 text-danger"></i>
                        </div>
                        <small class="text-muted">total projects</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trend Charts Row -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Collection Rate Trend (12 Bulan)</h5>
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <canvas id="collectionTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Bad Debt Trend (12 Bulan)</h5>
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <canvas id="badDebtTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links to Reports -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Navigation to Reports</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <a href="{{ route('accounts-receivable-aging') }}" class="d-block text-decoration-none p-3 rounded bg-light-primary mb-2">
                                    <i class="ti ti-calendar-time fs-1 text-primary mb-2"></i>
                                    <h6 class="mb-1">A/R Aging Report</h6>
                                    <small class="text-muted">Invoices aging analysis</small>
                                </a>
                            </div>
                            <div class="col-md-3 text-center">
                                <a href="{{ route('collection-performance') }}" class="d-block text-decoration-none p-3 rounded bg-light-success mb-2">
                                    <i class="ti ti-users-group fs-1 text-success mb-2"></i>
                                    <h6 class="mb-1">Collection Performance</h6>
                                    <small class="text-muted">Customer payment tracking</small>
                                </a>
                            </div>
                            <div class="col-md-3 text-center">
                                <a href="{{ route('bad-debt-analysis') }}" class="d-block text-decoration-none p-3 rounded bg-light-danger mb-2">
                                    <i class="ti ti-alert-circle fs-1 text-danger mb-2"></i>
                                    <h6 class="mb-1">Bad Debt Analysis</h6>
                                    <small class="text-muted">At-risk invoices & AFDA</small>
                                </a>
                            </div>
                            <div class="col-md-3 text-center">
                                <a href="{{ route('petty-cash-transaction.index') }}" class="d-block text-decoration-none p-3 rounded bg-light-info mb-2">
                                    <i class="ti ti-cash-banknote fs-1 text-info mb-2"></i>
                                    <h6 class="mb-1">Petty Cash Report</h6>
                                    <small class="text-muted">Project cash transactions</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Collection Rate Trend Chart
    const collectionCtx = document.getElementById('collectionTrendChart').getContext('2d');
    new Chart(collectionCtx, {
        type: 'line',
        data: {
            labels: @json(array_column($trendData, 'month')),
            datasets: [
                {
                    label: 'Actual Collection Rate',
                    data: @json(array_column($trendData, 'collection_rate')),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                },
                {
                    label: 'Target (85%)',
                    data: Array({{ count($trendData) }}).fill(85),
                    borderColor: '#ffc107',
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true } },
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    ticks: { callback: v => v + '%' }
                }
            }
        }
    });

    // Bad Debt Trend Chart
    const badDebtCtx = document.getElementById('badDebtTrendChart').getContext('2d');
    new Chart(badDebtCtx, {
        type: 'line',
        data: {
            labels: @json(array_column($trendData, 'month')),
            datasets: [
                {
                    label: 'Actual Bad Debt %',
                    data: @json(array_column($trendData, 'bad_debt_percent')),
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                },
                {
                    label: 'Target (≤10%)',
                    data: Array({{ count($trendData) }}).fill(10),
                    borderColor: '#28a745',
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true } },
            scales: {
                y: {
                    min: 0,
                    ticks: { callback: v => v + '%' }
                }
            }
        }
    });
</script>
@endpush

<style>
    .bg-light-primary { background-color: #f0f7ff; }
    .bg-light-success { background-color: #f0fdf4; }
    .bg-light-danger { background-color: #fef2f2; }
    .bg-light-info { background-color: #f0f9ff; }

    @media print {
        .card { page-break-inside: avoid; }
    }
</style>
