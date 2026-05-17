@extends('layout.mainlayout')
@section('title', 'SK Penetapan Unit')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">SK Penetapan Unit & Operator</h3>
                <p class="text-muted mb-0 small">Penetapan unit alat berat & operator yang dioperasikan di proyek (period-based, multi-level approval).</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">SK Penetapan Unit</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-formations.create') }}" class="btn btn-primary btn-label">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i>Buat SK Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @php
                $kpis = [
                    ['label' => 'Total SK',          'value' => $stats['total'],     'icon' => 'ti-truck',        'class' => 'primary'],
                    ['label' => 'Draft',             'value' => $stats['draft'],     'icon' => 'ti-pencil',       'class' => 'secondary'],
                    ['label' => 'Menunggu Approval', 'value' => $stats['submitted'], 'icon' => 'ti-clock',        'class' => 'warning'],
                    ['label' => 'SK Aktif',          'value' => $stats['active'],    'icon' => 'ti-circle-check', 'class' => 'success'],
                ];
            @endphp
            @foreach($kpis as $kpi)
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ $kpi['label'] }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-{{ $kpi['class'] }}-subtle text-{{ $kpi['class'] }} rounded fs-3">
                                        <i class="ti {{ $kpi['icon'] }}"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ $kpi['value'] }}</h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <input type="text" name="q" value="{{ request('q') }}"
                                       class="form-control" placeholder="Cari nomor SK / proyek...">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    @foreach(\App\Enums\UnitFormationStatus::cases() as $st)
                                        <option value="{{ $st->value }}" @selected(request('status') === $st->value)>
                                            {{ $st->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <button class="btn btn-outline-primary">
                                    <i class="ti ti-search me-1"></i> Filter
                                </button>
                                <a href="{{ route('unit-formations.index') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>No. SK</th>
                                        <th>Proyek</th>
                                        <th>Kontrak</th>
                                        <th>Berlaku Mulai</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Dibuat Oleh</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($formations as $f)
                                    <tr>
                                        <td>
                                            <a href="{{ route('unit-formations.show', $f->uid) }}" class="fw-medium link-primary">
                                                {{ $f->formation_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width:180px">
                                                {{ $f->project->project_name ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $f->contract->contract_number ?? '-' }}</td>
                                        <td>{{ $f->effective_date?->format('d M Y') ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary">{{ $f->items_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $f->status->color() }}-subtle text-{{ $f->status->color() }} text-uppercase">
                                                {{ $f->status->label() }}
                                            </span>
                                        </td>
                                        <td>{{ $f->creator->name ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('unit-formations.show', $f->uid) }}">
                                                            <i class="ti ti-eye me-2 text-muted"></i> Lihat Detail
                                                        </a>
                                                    </li>
                                                    @if($f->canEdit())
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('unit-formations.edit', $f->uid) }}">
                                                            <i class="ti ti-edit me-2 text-muted"></i> Edit
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
                                                    <i class="ti ti-truck"></i>
                                                </div>
                                            </div>
                                            <h5>Belum ada SK Penetapan Unit</h5>
                                            <p class="text-muted">Buat SK dari proyek yang memiliki kontrak AKTIF.</p>
                                            <a href="{{ route('unit-formations.create') }}" class="btn btn-primary btn-sm">
                                                <i class="ti ti-plus me-1"></i> Buat SK Baru
                                            </a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $formations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
