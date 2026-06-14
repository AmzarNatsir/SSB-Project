@extends('layout.mainlayout')
@section('title', 'Laporan Realisasi Proyek')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4 no-print">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Laporan Realisasi Proyek</h3>
                <p class="text-muted mb-0 small">Analisis perbandingan antara budget perencanaan dan realisasi pekerjaan aktual.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan Realisasi Proyek</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('project-realization-reports.export', request()->query()) }}" class="btn btn-outline-success">
                    <i class="ti ti-file-export me-2"></i>Ekspor CSV
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="ti ti-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Print-only Header -->
        <div class="d-none d-print-block mb-4 text-center header-print">
            <h2 class="mb-1">LAPORAN REALISASI PROYEK</h2>
            <h5 class="text-muted mb-3">PT Sinar Sentosa Bahari</h5>
            <div class="d-flex justify-content-center gap-4 text-muted small flex-wrap">
                <span><strong>Periode:</strong> {{ \Carbon\Carbon::parse($periodStart)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($periodEnd)->format('d M Y') }}</span>
                <span><strong>Status:</strong> {{ $status === 'ALL' ? 'Semua' : $status }}</span>
            </div>
            <hr class="my-4">
        </div>

        <!-- KPI Cards Row -->
        <div class="row mb-4">
            <!-- Card 1: Total Budget -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Budget</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-wallet"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">Rp {{ number_format($kpiData['totalBudget'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Realization -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Realisasi</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ti ti-check-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">Rp {{ number_format($kpiData['totalRealization'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Card 3: Realization Percentage -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">% Realisasi</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ti ti-percent"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ number_format($kpiData['realizationPercent'], 2, ',', '.') }}%</h4>
                    </div>
                </div>
            </div>

            <!-- Card 4: Budget Variance -->
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Varians Budget</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title {{ $kpiData['budgetVariance'] >= 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} rounded fs-3">
                                        <i class="ti {{ $kpiData['budgetVariance'] >= 0 ? 'ti-trending-up' : 'ti-trending-down' }}"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4 {{ $kpiData['budgetVariance'] >= 0 ? 'text-danger' : 'text-success' }}">
                            Rp {{ number_format(abs($kpiData['budgetVariance']), 0, ',', '.') }}
                        </h4>
                        <p class="text-muted small mt-2">{{ $kpiData['variancePercent'] >= 0 ? '+' : '' }}{{ number_format($kpiData['variancePercent'], 2, ',', '.') }}%</p>
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
                        <label for="periodStart" class="form-label">Periode Mulai</label>
                        <input type="date" class="form-control" id="periodStart" name="period_start" value="{{ $periodStart }}">
                    </div>
                    <div class="col-md-3">
                        <label for="periodEnd" class="form-label">Periode Selesai</label>
                        <input type="date" class="form-control" id="periodEnd" name="period_end" value="{{ $periodEnd }}">
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
                        <label for="budgetCategory" class="form-label">Kategori Budget</label>
                        <select class="form-select" id="budgetCategory" name="budget_category">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($budgetCategories as $cat)
                                <option value="{{ $cat['value'] }}" {{ $budgetCategory == $cat['value'] ? 'selected' : '' }}>
                                    {{ $cat['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status Realisasi</label>
                        <select class="form-select" id="status" name="status">
                            <option value="ALL" {{ $status == 'ALL' ? 'selected' : '' }}>-- Semua Status --</option>
                            @foreach($statusOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $status == $opt['value'] ? 'selected' : '' }}>
                                    {{ $opt['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('project-realization-reports') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Charts Row 1: Monthly Trend & Category Breakdown -->
        <div class="row mb-4 no-print">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Tren Realisasi per Bulan (Rp)</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($monthlyTrend))
                            <div id="monthlyTrendChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Realisasi per Kategori</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($categoryBreakdown))
                            <div id="categoryChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2: Budget vs Actual & Top Equipment -->
        <div class="row mb-4 no-print">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Budget vs Realisasi per Proyek (Top 10)</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($budgetVsActual))
                            <div id="budgetVsActualChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Top 5 Alat/Unit Terealisasi</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($topEquipment))
                            <div id="topEquipmentChart"></div>
                        @else
                            <div class="text-center py-5 text-muted">Belum ada data untuk periode ini</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="card no-print">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Item Realisasi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Proyek</th>
                                <th>No. Realisasi</th>
                                <th>Periode</th>
                                <th>Alat/Unit</th>
                                <th>Kategori</th>
                                <th>Total HM</th>
                                <th>Realisasi (Rp)</th>
                                <th>Budget (Rp)</th>
                                <th>Varians</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($detailItems->count() > 0)
                                @foreach($detailItems as $index => $item)
                                    @php
                                        $budgetAmount = (float) ($item->budget_amount ?? 0);
                                        $realizationAmount = (float) ($item->realized_amount ?? 0);
                                        $variance = $realizationAmount - $budgetAmount;
                                        $variancePercent = $budgetAmount > 0 ? ($variance / $budgetAmount) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ ($detailItems->currentPage() - 1) * 20 + $index + 1 }}</td>
                                        <td><small>{{ $item->project_name }}</small></td>
                                        <td><small><strong>{{ $item->realization_number }}</strong></small></td>
                                        <td><small>{{ \Carbon\Carbon::parse($item->period_start)->format('d M y') }} - {{ \Carbon\Carbon::parse($item->period_end)->format('d M y') }}</small></td>
                                        <td><small>{{ $item->unit_name ?? '-' }}</small></td>
                                        <td><small>{{ $item->category ? \App\Enums\BudgetCategory::tryFrom($item->category)?->label() : '-' }}</small></td>
                                        <td class="text-end"><small>{{ number_format($item->total_hm ?? 0, 2, ',', '.') }}</small></td>
                                        <td class="text-end"><small>Rp {{ number_format($realizationAmount, 0, ',', '.') }}</small></td>
                                        <td class="text-end"><small>Rp {{ number_format($budgetAmount, 0, ',', '.') }}</small></td>
                                        <td class="text-end">
                                            <small class="{{ $variance >= 0 ? 'text-danger' : 'text-success' }}">
                                                {{ $variance >= 0 ? '+' : '' }}Rp {{ number_format(abs($variance), 0, ',', '.') }}
                                            </small>
                                        </td>
                                        <td>
                                            @php
                                                $statusEnum = \App\Enums\WorkRealizationStatus::tryFrom($item->status);
                                                $badgeClass = match($statusEnum) {
                                                    \App\Enums\WorkRealizationStatus::DRAFT => 'badge-secondary',
                                                    \App\Enums\WorkRealizationStatus::SUBMITTED => 'badge-info',
                                                    \App\Enums\WorkRealizationStatus::APPROVED => 'badge-success',
                                                    \App\Enums\WorkRealizationStatus::REJECTED => 'badge-danger',
                                                    default => 'badge-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $statusEnum?->label() ?? $item->status }}</span>
                                        </td>
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
                @if($detailItems->count() > 0)
                    <nav class="mt-4">
                        {{ $detailItems->links('pagination::bootstrap-5') }}
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
        // Monthly Trend Chart
        const monthlyTrendData = @json($monthlyTrend);
        if (monthlyTrendData && monthlyTrendData.length > 0) {
            const ctx1 = document.getElementById('monthlyTrendChart')?.getContext('2d');
            if (ctx1) {
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: monthlyTrendData.map(d => d.month),
                        datasets: [{
                            label: 'Realisasi (Rp)',
                            data: monthlyTrendData.map(d => d.realization),
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
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // Category Breakdown Chart
        const categoryData = @json($categoryBreakdown);
        if (categoryData && categoryData.length > 0) {
            const ctx2 = document.getElementById('categoryChart')?.getContext('2d');
            if (ctx2) {
                const colors = ['#0d6efd', '#198754', '#fd7e14', '#dc3545', '#6f42c1', '#20c997'];
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: categoryData.map(d => d.category),
                        datasets: [{
                            data: categoryData.map(d => d.realization),
                            backgroundColor: colors.slice(0, categoryData.length),
                            borderColor: '#fff',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: true, position: 'bottom' }
                        }
                    }
                });
            }
        }

        // Budget vs Actual Chart
        const budgetData = @json($budgetVsActual);
        if (budgetData && budgetData.length > 0) {
            const ctx3 = document.getElementById('budgetVsActualChart')?.getContext('2d');
            if (ctx3) {
                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: budgetData.map(d => d.label),
                        datasets: [{
                            label: 'Budget (Rp)',
                            data: budgetData.map(d => d.budget),
                            backgroundColor: '#0d6efd',
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

        // Top Equipment Chart
        const equipmentData = @json($topEquipment);
        if (equipmentData && equipmentData.length > 0) {
            const ctx4 = document.getElementById('topEquipmentChart')?.getContext('2d');
            if (ctx4) {
                new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: equipmentData.map(d => d.unitName),
                        datasets: [{
                            label: 'Realisasi (Rp)',
                            data: equipmentData.map(d => d.realized),
                            backgroundColor: '#198754',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        indexAxis: 'y',
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
            font-size: 11px;
        }
    }
</style>
@endsection
