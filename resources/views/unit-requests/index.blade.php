@extends('layout.mainlayout')
@section('title', 'Permintaan Unit')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Permintaan Unit</h3>
                <p class="text-muted small mb-0">Permintaan unit untuk proyek yang sudah disepakati harganya. Items otomatis dari Penawaran Harga.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Permintaan Unit</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-requests.create') }}" class="btn btn-primary btn-label">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i>Buat Permintaan
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- KPI Cards -->
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Permintaan</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-tools"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Menunggu Approval</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ti ti-clock"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $submittedCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Disetujui</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                        <i class="ti ti-circle-check"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $approvedCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Diteruskan ke Workshop</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ti ti-send"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $forwardedCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unit Requests Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="unitRequestList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Daftar Permintaan Unit</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>No. Permintaan</th>
                                        <th>Proyek</th>
                                        <th>Tgl. Permintaan</th>
                                        <th>Tgl. Mobilisasi</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitRequests as $ur)
                                    <tr>
                                        <td>
                                            <a href="{{ route('unit-requests.show', $ur->uid) }}" class="fw-medium link-primary">
                                                {{ $ur->request_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2 rounded-circle bg-light d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-building text-primary"></i>
                                                </div>
                                                <span class="text-truncate d-inline-block" style="max-width:180px">
                                                    {{ $ur->project->project_name ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ $ur->request_date ? $ur->request_date->format('d M Y') : '-' }}</td>
                                        <td>{{ $ur->mobilization_date ? $ur->mobilization_date->format('d M Y') : '-' }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                {{ $ur->items_count ?? $ur->items()->count() }} unit
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $ur->status->color() }}-subtle text-{{ $ur->status->color() }} text-uppercase">
                                                {{ $ur->status->label() }}
                                            </span>
                                        </td>
                                        <td>{{ $ur->creator->name ?? '-' }}</td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('unit-requests.show', $ur->uid) }}">
                                                            <i class="ti ti-eye align-bottom me-2 text-muted"></i> Lihat
                                                        </a>
                                                    </li>
                                                    @if($ur->isEditable())
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('unit-requests.edit', $ur->uid) }}">
                                                            <i class="ti ti-edit align-bottom me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="avatar-lg mx-auto mb-3">
                                                <div class="avatar-title bg-light rounded-circle text-muted fs-1">
                                                    <i class="ti ti-tools"></i>
                                                </div>
                                            </div>
                                            <h5>Belum ada Permintaan Unit</h5>
                                            <p class="text-muted">Buat dari proyek yang sudah memiliki Negosiasi & Penawaran Harga yang Disetujui.</p>
                                            <a href="{{ route('unit-requests.create') }}" class="btn btn-primary btn-sm">
                                                <i class="ti ti-plus me-1"></i> Buat Permintaan
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $unitRequests->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
