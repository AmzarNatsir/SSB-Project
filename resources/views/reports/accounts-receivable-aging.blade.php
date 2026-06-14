@extends('layout.mainlayout')
@section('title', 'Laporan Accounts Receivable Aging')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 no-print">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Accounts Receivable Aging Report</h3>
                <p class="text-muted mb-0 small">Analisis status piutang dan identifikasi invoices yang overdue untuk keperluan collection.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">AR Aging Report</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('accounts-receivable-aging.export', request()->query()) }}" class="btn btn-outline-success">
                    <i class="ti ti-file-export me-2"></i>Ekspor CSV
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ti ti-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Print-only Header -->
        <div class="d-none d-print-block mb-4 text-center header-print">
            <h2 class="mb-1">LAPORAN ACCOUNTS RECEIVABLE AGING</h2>
            <h5 class="text-muted mb-3">PT Sinar Sentosa Bahari</h5>
            <div class="d-flex justify-content-center gap-4 text-muted small flex-wrap">
                <span><strong>Periode:</strong> {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</span>
            </div>
            <hr class="my-4">
        </div>

        <!-- KPI Cards Row -->
        <div class="row mb-4">
            <!-- Card 1: Total Outstanding A/R -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Outstanding A/R</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-wallet"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">Rp {{ number_format($kpiData['totalOutstanding'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Overdue -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Overdue</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded fs-3">
                                        <i class="ti ti-alert-triangle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4 text-danger">Rp {{ number_format($kpiData['totalOverdue'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Card 3: DSO (Days Sales Outstanding) -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">DSO (Days)</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ti ti-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ $kpiData['dso'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Card 4: Collection Rate -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Collection Rate</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title {{ $kpiData['collectionRate'] >= 75 ? 'bg-success-subtle text-success' : ($kpiData['collectionRate'] >= 50 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }} rounded fs-3">
                                        <i class="ti ti-percent"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($kpiData['collectionRate'], 2, ',', '.') }}%</h4>
                    </div>
                </div>
            </div>

            <!-- Card 5: Overdue Percentage (Additional) -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Overdue %</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title {{ $kpiData['overduePercent'] > 30 ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning' }} rounded fs-3">
                                        <i class="ti ti-trending-up"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($kpiData['overduePercent'], 2, ',', '.') }}%</h4>
                    </div>
                </div>
            </div>

            <!-- Card 6: Total Invoices -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Invoices</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-secondary-subtle text-secondary rounded fs-3">
                                        <i class="ti ti-receipt-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ $kpiData['numInvoices'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
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
                        <input type="text" class="form-control" id="customerCode" name="customer_code" placeholder="Cari kode pelanggan..." value="{{ $customerCode }}">
                    </div>
                    <div class="col-md-3">
                        <label for="agingBucket" class="form-label">Kategori Usia Piutang</label>
                        <select class="form-select" id="agingBucket" name="aging_bucket">
                            <option value="">-- Semua Kategori --</option>
                            <option value="current" {{ $agingBucket == 'current' ? 'selected' : '' }}>Current (0-30 hari)</option>
                            <option value="1_30" {{ $agingBucket == '1_30' ? 'selected' : '' }}>1-30 Hari</option>
                            <option value="31_60" {{ $agingBucket == '31_60' ? 'selected' : '' }}>31-60 Hari</option>
                            <option value="61_90" {{ $agingBucket == '61_90' ? 'selected' : '' }}>61-90 Hari</option>
                            <option value="91_120" {{ $agingBucket == '91_120' ? 'selected' : '' }}>91-120 Hari</option>
                            <option value="121_plus" {{ $agingBucket == '121_plus' ? 'selected' : '' }}>121+ Hari</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="paymentStatus" class="form-label">Status Pembayaran</label>
                        <select class="form-select" id="paymentStatus" name="payment_status">
                            @foreach($paymentStatusOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $paymentStatus == $opt['value'] ? 'selected' : '' }}>
                                    {{ $opt['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('accounts-receivable-aging') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row mb-4 no-print">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Distribusi Piutang per Kategori Usia</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($agingBuckets))
                            <div id="agingBucketsChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Tren DSO (12 Bulan)</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($dsoTrend))
                            <div id="dsoTrendChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row mb-4 no-print">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Top 10 Pelanggan dengan Piutang Tertua</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($topOverdueCustomers))
                            <div id="topOverdueChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Tidak ada piutang overdue</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="card no-print">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Piutang - Aging Schedule</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 table-sm">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="12%">Proyek</th>
                                <th width="12%">No. Invoice</th>
                                <th width="12%">Pelanggan</th>
                                <th width="10%">Tgl Invoice</th>
                                <th width="10%">Tgl Jatuh Tempo</th>
                                <th width="8%">Hari OD</th>
                                <th width="10%">Kategori Usia</th>
                                <th width="10%">Jumlah (Rp)</th>
                                <th width="10%">Terbayar (Rp)</th>
                                <th width="10%">Sisa (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($agingDetails->count() > 0)
                                @foreach($agingDetails as $index => $item)
                                    @php
                                        $daysOverdue = (int) $item->days_overdue;
                                        $bucketName = match(true) {
                                            $daysOverdue <= 0 => 'Current',
                                            $daysOverdue <= 30 => '1-30 Days',
                                            $daysOverdue <= 60 => '31-60 Days',
                                            $daysOverdue <= 90 => '61-90 Days',
                                            $daysOverdue <= 120 => '91-120 Days',
                                            default => '121+ Days',
                                        };

                                        $rowClass = match(true) {
                                            $daysOverdue > 120 => 'table-danger',
                                            $daysOverdue > 90 => 'table-danger',
                                            $daysOverdue > 60 => 'table-warning',
                                            $daysOverdue > 30 => 'table-info',
                                            default => 'table-success',
                                        };
                                    @endphp
                                    <tr class="{{ $rowClass }}">
                                        <td><small>{{ ($agingDetails->currentPage() - 1) * 20 + $index + 1 }}</small></td>
                                        <td><small><strong>{{ $item->project_name }}</strong></small></td>
                                        <td><small><strong>{{ $item->invoice_number }}</strong></small></td>
                                        <td><small>{{ $item->customer_name }}</small></td>
                                        <td><small>{{ \Carbon\Carbon::parse($item->invoice_date)->format('d-m-Y') }}</small></td>
                                        <td><small>{{ \Carbon\Carbon::parse($item->due_date)->format('d-m-Y') }}</small></td>
                                        <td><small class="text-center">{{ max(0, $daysOverdue) }}</small></td>
                                        <td>
                                            <small>
                                                @if($daysOverdue <= 0)
                                                    <span class="badge badge-success">Current</span>
                                                @elseif($daysOverdue <= 30)
                                                    <span class="badge badge-info">1-30</span>
                                                @elseif($daysOverdue <= 60)
                                                    <span class="badge badge-warning">31-60</span>
                                                @elseif($daysOverdue <= 90)
                                                    <span class="badge badge-warning">61-90</span>
                                                @elseif($daysOverdue <= 120)
                                                    <span class="badge badge-danger">91-120</span>
                                                @else
                                                    <span class="badge badge-danger">121+</span>
                                                @endif
                                            </small>
                                        </td>
                                        <td class="text-end"><small>{{ number_format($item->total_amount, 0, ',', '.') }}</small></td>
                                        <td class="text-end"><small class="text-success">{{ number_format($item->paid_amount, 0, ',', '.') }}</small></td>
                                        <td class="text-end"><small class="text-danger"><strong>{{ number_format($item->outstanding_amount, 0, ',', '.') }}</strong></small></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        Tidak ada data untuk periode dan filter yang dipilih
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($agingDetails->count() > 0)
                    <nav class="mt-4">
                        {{ $agingDetails->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Aging Buckets Chart
        const agingBucketsData = @json($agingBuckets);
        if (agingBucketsData && agingBucketsData.length > 0) {
            const ctx1 = document.getElementById('agingBucketsChart')?.getContext('2d');
            if (ctx1) {
                const colors = ['#198754', '#0dcaf0', '#0d6efd', '#fd7e14', '#dc3545', '#721c24'];
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: agingBucketsData.map(d => d.label),
                        datasets: [{
                            label: 'Piutang (Rp)',
                            data: agingBucketsData.map(d => d.amount),
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: true, position: 'top' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // DSO Trend Chart
        const dsoTrendData = @json($dsoTrend);
        if (dsoTrendData && dsoTrendData.length > 0) {
            const ctx2 = document.getElementById('dsoTrendChart')?.getContext('2d');
            if (ctx2) {
                new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: dsoTrendData.map(d => d.month),
                        datasets: [{
                            label: 'DSO (Hari)',
                            data: dsoTrendData.map(d => d.dso),
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: '#0d6efd',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: true, position: 'top' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + ' hari';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // Top Overdue Customers Chart
        const topOverdueData = @json($topOverdueCustomers);
        if (topOverdueData && topOverdueData.length > 0) {
            const ctx3 = document.getElementById('topOverdueChart')?.getContext('2d');
            if (ctx3) {
                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: topOverdueData.map(d => d.customer_name + ' (' + d.customer_code + ')'),
                        datasets: [{
                            label: 'Piutang Overdue (Rp)',
                            data: topOverdueData.map(d => d.overdue_amount),
                            backgroundColor: '#dc3545',
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: true }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>

<style>
    @media print {
        .no-print {
            display: none;
        }
        .page-wrapper {
            padding: 0;
        }
        .card {
            border: 1px solid #dee2e6;
            break-inside: avoid;
        }
        .table {
            font-size: 10px;
        }
        .table-sm td {
            padding: 0.25rem;
        }
    }
</style>
@endsection
