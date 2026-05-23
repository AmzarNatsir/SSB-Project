<?php $page = 'unit-replacements'; ?>
@extends('layout.mainlayout')
@section('title', 'Unit Replacements (PTU)')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Penggantian Unit (PTU)</h3>
                <p class="text-muted small mb-0">Penggantian unit yang sudah dimobilisasi pada project aktif.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Penggantian Unit</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-replacements.create') }}" class="btn btn-primary btn-label">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i>Buat PTU
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

        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total PTU</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-replace"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div><h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalCount }}</h4></div>
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
                            <div><h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $submittedCount }}</h4></div>
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
                            <div><h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $forwardedCount }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Selesai (Workshop)</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                        <i class="ti ti-flag-check"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div><h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $completedCount }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <h5 class="card-title mb-0">Daftar PTU</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>No. PTU</th>
                                        <th>Proyek</th>
                                        <th>UR Asal</th>
                                        <th>Tgl. Penggantian</th>
                                        <th>Tgl. Mobilisasi</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitReplacements as $ptu)
                                    <tr>
                                        <td>
                                            <a href="{{ route('unit-replacements.show', $ptu->uid) }}" class="fw-medium link-primary">
                                                {{ $ptu->replacement_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width:180px">
                                                {{ $ptu->project->project_name ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted small">
                                                {{ $ptu->unitRequest->request_number ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $ptu->replacement_date ? $ptu->replacement_date->format('d M Y') : '-' }}</td>
                                        <td>{{ $ptu->mobilization_date ? $ptu->mobilization_date->format('d M Y') : '-' }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                {{ $ptu->items()->count() }} item
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $ptu->status->color() }}-subtle text-{{ $ptu->status->color() }} text-uppercase">
                                                {{ $ptu->status->label() }}
                                            </span>
                                        </td>
                                        <td>{{ $ptu->creator->name ?? '-' }}</td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('unit-replacements.show', $ptu->uid) }}">
                                                            <i class="ti ti-eye align-bottom me-2 text-muted"></i> Lihat
                                                        </a>
                                                    </li>
                                                    @if($ptu->isEditable())
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('unit-replacements.edit', $ptu->uid) }}">
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
                                        <td colspan="9" class="text-center py-5">
                                            <div class="avatar-lg mx-auto mb-3">
                                                <div class="avatar-title bg-light rounded-circle text-muted fs-1">
                                                    <i class="ti ti-replace"></i>
                                                </div>
                                            </div>
                                            <h5>Belum ada PTU</h5>
                                            <p class="text-muted">Buat PTU dari Permintaan Unit yang sudah disetujui Workshop.</p>
                                            <a href="{{ route('unit-replacements.create') }}" class="btn btn-primary btn-sm">
                                                <i class="ti ti-plus me-1"></i> Buat PTU
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $unitReplacements->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
