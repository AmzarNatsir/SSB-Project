@extends('layout.mainlayout')
@section('title', 'Laporan Collection Performance')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 no-print">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Collection Performance Report</h3>
                <p class="text-muted mb-0 small">Analisis efektivitas dan kecepatan collection dari setiap customer.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Collection Performance</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('collection-performance.export', request()->query()) }}" class="btn btn-outline-success">
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
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Customers</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                    <i class="ti ti-users"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ $kpiData['numCustomers'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Avg Collection Days</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                    <i class="ti ti-hourglass"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ $kpiData['avgDaysToCollect'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">On-Time Payment %</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                    <i class="ti ti-check"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($kpiData['onTimeRate'], 2, ',', '.') }}%</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Payment Rate %</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="avatar-title {{ $kpiData['paymentRate'] >= 80 ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} rounded fs-3">
                                    <i class="ti ti-percent"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($kpiData['paymentRate'], 2, ',', '.') }}%</h4>
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
                        <label for="customerCode" class="form-label">Kode Pelanggan</label>
                        <input type="text" class="form-control" id="customerCode" name="customer_code" placeholder="Cari..." value="{{ $customerCode }}">
                    </div>
                    <div class="col-md-3">
                        <label for="paymentStatus" class="form-label">Payment Status</label>
                        <select class="form-select" id="paymentStatus" name="payment_status">
                            @foreach($paymentStatusOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $paymentStatus == $opt['value'] ? 'selected' : '' }}>
                                    {{ $opt['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="collectionSpeed" class="form-label">Collection Speed</label>
                        <select class="form-select" id="collectionSpeed" name="collection_speed">
                            <option value="">-- Semua Kecepatan --</option>
                            @foreach($speedOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $collectionSpeed == $opt['value'] ? 'selected' : '' }}>
                                    {{ $opt['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('collection-performance') }}" class="btn btn-secondary">
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
                        <h5 class="card-title mb-0">Collection Days Trend (12 Months)</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($collectionTrend))
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
                        <h5 class="card-title mb-0">Collection Speed Distribution</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($speedCategories))
                            <div id="speedChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment Method Distribution</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($paymentMethods))
                            <div id="methodChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="card no-print">
            <div class="card-header">
                <h5 class="card-title mb-0">Customer Performance Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Customer Name</th>
                                <th>Code</th>
                                <th># Invoices</th>
                                <th>Total Invoiced (Rp)</th>
                                <th>Total Paid (Rp)</th>
                                <th>Outstanding (Rp)</th>
                                <th>Payment %</th>
                                <th>Avg Days</th>
                                <th>Last Invoice</th>
                                <th>Last Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($customerDetails->count() > 0)
                                @foreach($customerDetails as $index => $detail)
                                    @php
                                        $totalInvoiced = (float) $detail->total_invoiced;
                                        $totalPaid = (float) $detail->total_paid;
                                        $outstanding = $totalInvoiced - $totalPaid;
                                        $paymentRate = $totalInvoiced > 0 ? ($totalPaid / $totalInvoiced) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td><small>{{ ($customerDetails->currentPage() - 1) * 20 + $index + 1 }}</small></td>
                                        <td><small><strong>{{ $detail->customer_name }}</strong></small></td>
                                        <td><small>{{ $detail->customer_code }}</small></td>
                                        <td><small class="text-center">{{ $detail->num_invoices }}</small></td>
                                        <td><small class="text-end">{{ number_format($totalInvoiced, 0, ',', '.') }}</small></td>
                                        <td><small class="text-end text-success">{{ number_format($totalPaid, 0, ',', '.') }}</small></td>
                                        <td><small class="text-end text-danger">{{ number_format($outstanding, 0, ',', '.') }}</small></td>
                                        <td>
                                            <small>
                                                <span class="badge {{ $paymentRate >= 90 ? 'bg-success' : ($paymentRate >= 70 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ number_format($paymentRate, 0) }}%
                                                </span>
                                            </small>
                                        </td>
                                        <td><small class="text-center">{{ round($detail->avg_days_to_collect ?? 0, 1) }}</small></td>
                                        <td><small>{{ $detail->last_invoice_date ? \Carbon\Carbon::parse($detail->last_invoice_date)->format('d-m-Y') : '-' }}</small></td>
                                        <td><small>{{ $detail->last_payment_date ? \Carbon\Carbon::parse($detail->last_payment_date)->format('d-m-Y') : '-' }}</small></td>
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

                @if($customerDetails->count() > 0)
                    <nav class="mt-4">
                        {{ $customerDetails->links('pagination::bootstrap-5') }}
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
        const trendData = @json($collectionTrend);
        if (trendData && trendData.length > 0) {
            const ctx1 = document.getElementById('trendChart')?.getContext('2d');
            if (ctx1) {
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: trendData.map(d => d.month),
                        datasets: [{
                            label: 'Rata-rata Hari Bayar',
                            data: trendData.map(d => d.days),
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        }

        // Speed Chart
        const speedData = @json($speedCategories);
        if (speedData && speedData.length > 0) {
            const ctx2 = document.getElementById('speedChart')?.getContext('2d');
            if (ctx2) {
                const colors = ['#198754', '#0dcaf0', '#ffc107', '#fd7e14', '#dc3545'];
                new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: speedData.map(d => d.label),
                        datasets: [{
                            label: 'Jumlah Invoice',
                            data: speedData.map(d => d.count),
                            backgroundColor: colors,
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

        // Payment Method Chart
        const methodData = @json($paymentMethods);
        if (methodData && methodData.length > 0) {
            const ctx3 = document.getElementById('methodChart')?.getContext('2d');
            if (ctx3) {
                new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: methodData.map(d => d.method),
                        datasets: [{
                            data: methodData.map(d => d.count),
                            backgroundColor: ['#0d6efd', '#198754', '#0dcaf0', '#ffc107'],
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: true } }
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
