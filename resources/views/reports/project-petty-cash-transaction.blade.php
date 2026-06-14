@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 no-print">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Project Petty Cash Transaction Report</h3>
                <p class="text-muted mb-0 small">Analisis penggunaan petty cash per proyek dan kategori untuk monitoring pengeluaran.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Petty Cash Transaction</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <form method="POST" action="{{ route('petty-cash-transaction.export') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                    <input type="hidden" name="date_to" value="{{ $dateTo }}">
                    <input type="hidden" name="project_id" value="{{ $projectId }}">
                    <input type="hidden" name="category_id" value="{{ $categoryId }}">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <button type="submit" class="btn btn-outline-success">
                        <i class="ti ti-file-export me-2"></i>Ekspor CSV
                    </button>
                </form>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ti ti-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Print-only Header -->
        <div class="d-none d-print-block mb-4 text-center header-print">
            <h2 class="mb-1">LAPORAN PROJECT PETTY CASH TRANSACTION</h2>
            <h5 class="text-muted mb-3">PT Sinar Sentosa Bahari</h5>
            <div class="d-flex justify-content-center gap-4 text-muted small flex-wrap">
                <span><strong>Periode:</strong> {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</span>
            </div>
            <hr class="my-4">
        </div>

        <!-- KPI Cards Row -->
        <div class="row mb-3">
            <div class="col-xl-2 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Dialokasikan</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-wallet"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-20 fw-semibold ff-secondary mt-3">Rp {{ number_format($kpiData['totalAllocated'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Terpakai</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ti ti-coin"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-20 fw-semibold ff-secondary mt-3">Rp {{ number_format($kpiData['totalUsed'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Saldo</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                        <i class="ti ti-check"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-20 fw-semibold ff-secondary mt-3 {{ $kpiData['availableBalance'] >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($kpiData['availableBalance'], 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"># Transaksi</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ti ti-stack"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-20 fw-semibold ff-secondary mt-3">{{ $kpiData['transactionCount'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"># Proyek</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded fs-3">
                                        <i class="ti ti-building"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-20 fw-semibold ff-secondary mt-3">{{ $kpiData['numProjects'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Utilisasi</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-secondary-subtle text-secondary rounded fs-3">
                                        <i class="ti ti-percent"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-20 fw-semibold ff-secondary mt-3">{{ $kpiData['utilizationPercent'] }}%</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('petty-cash-transaction.index') }}" class="row g-2">
                    <div class="col-md-2">
                        <label class="form-label small">Dari Tanggal</label>
                        <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Ke Tanggal</label>
                        <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo }}">
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <label class="form-label small">Kategori</label>
                        <select name="category_id" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            @foreach($statusOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $status == $opt['value'] ? 'selected' : '' }}>
                                    {{ $opt['label'] }}
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

        <!-- Charts Row 1 -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tren Saldo (12 Bulan)</h5>
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <canvas id="balanceTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Distribusi Status</h5>
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Penggunaan per Kategori</h5>
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <canvas id="usageByCategoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Penggunaan per Proyek</h5>
                    </div>
                    <div class="card-body" style="height: 350px;">
                        <canvas id="usageByProjectChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Transaksi</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover card-table">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Tanggal</th>
                            <th>Proyek</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-end">Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td class="fw-bold">{{ $tx->purchase_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($tx->purchase_date)->format('d M Y') }}</td>
                                <td>{{ $tx->project_name }}</td>
                                <td>{{ $tx->category_name ?? '-' }}</td>
                                <td class="text-truncate" title="{{ $tx->description }}">{{ Str::limit($tx->description, 40) }}</td>
                                <td class="text-end">Rp {{ number_format($tx->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $tx->status == 'approved' ? 'success' : ($tx->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($tx->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Tidak ada data transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <p class="text-muted m-0 small">Menampilkan {{ $transactions->count() }} dari {{ $transactions->total() }} transaksi</p>
                <ul class="pagination m-0 ms-auto">
                    @if ($transactions->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0)">Sebelumnya</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $transactions->previousPageUrl() }}">Sebelumnya</a>
                        </li>
                    @endif

                    @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($transactions->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $transactions->nextPageUrl() }}">Berikutnya</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript:void(0)">Berikutnya</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Balance Trend Chart
    const balanceTrendCtx = document.getElementById('balanceTrendChart').getContext('2d');
    new Chart(balanceTrendCtx, {
        type: 'line',
        data: {
            labels: @json(array_column($balanceTrend, 'month')),
            datasets: [
                {
                    label: 'Dialokasikan',
                    data: @json(array_column($balanceTrend, 'allocated')),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Terpakai',
                    data: @json(array_column($balanceTrend, 'used')),
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Saldo',
                    data: @json(array_column($balanceTrend, 'balance')),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K' } }
            }
        }
    });

    // Status Distribution Chart
    const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json(array_column($statusDistribution, 'status')),
            datasets: [{
                data: @json(array_column($statusDistribution, 'value')),
                backgroundColor: @json(array_column($statusDistribution, 'color'))
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // Usage by Category Chart
    const categoryCtx = document.getElementById('usageByCategoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: @json(array_column($usageByCategory, 'category')),
            datasets: [{
                label: 'Jumlah (Rp)',
                data: @json(array_column($usageByCategory, 'amount')),
                backgroundColor: '#0dcaf0',
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { x: { ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K' } } }
        }
    });

    // Usage by Project Chart
    const projectCtx = document.getElementById('usageByProjectChart').getContext('2d');
    new Chart(projectCtx, {
        type: 'bar',
        data: {
            labels: @json(array_column($usageByProject, 'project')),
            datasets: [{
                label: 'Jumlah (Rp)',
                data: @json(array_column($usageByProject, 'amount')),
                backgroundColor: '#fd7e14',
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { x: { ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K' } } }
        }
    });
</script>
@endpush

<style>
    @media print {
        .no-print { display: none !important; }
    }
</style>
