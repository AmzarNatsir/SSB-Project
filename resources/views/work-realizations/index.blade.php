@extends('layout.mainlayout')
@section('title', 'Work Realization')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Work Realization</h3>
                <p class="text-muted mb-0 small">Agregasi billing per periode dari Timesheet APPROVED. Realisasi = HM × Tarif (boleh disesuaikan).</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Work Realization</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('work-realizations.create') }}" class="btn btn-primary btn-label">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i>Generate Realisasi
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
                    ['label' => 'Total Realisasi',          'value' => $stats['total'],     'icon' => 'ti-file-invoice', 'class' => 'primary'],
                    ['label' => 'Draft',                    'value' => $stats['draft'],     'icon' => 'ti-pencil',       'class' => 'secondary'],
                    ['label' => 'Menunggu Approval',        'value' => $stats['submitted'], 'icon' => 'ti-clock',        'class' => 'warning'],
                    ['label' => 'Disetujui',                'value' => $stats['approved'],  'icon' => 'ti-circle-check', 'class' => 'success'],
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
            <div class="col-12">
                <div class="alert alert-info-subtle border-info-subtle mb-3">
                    <i class="ti ti-coin me-1 text-info"></i>
                    <strong>Total Nilai Realisasi Disetujui:</strong>
                    Rp {{ number_format($stats['approved_amount'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nomor / proyek...">
                            </div>
                            <div class="col-md-3">
                                <select name="project_id" class="form-select">
                                    <option value="">Semua Proyek</option>
                                    @foreach($projects as $p)
                                        <option value="{{ $p->id }}" @selected(request('project_id') == $p->id)>{{ $p->project_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    @foreach(\App\Enums\WorkRealizationStatus::cases() as $st)
                                        <option value="{{ $st->value }}" @selected(request('status') === $st->value)>{{ $st->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <button class="btn btn-outline-primary"><i class="ti ti-search me-1"></i>Filter</button>
                                <a href="{{ route('work-realizations.index') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>No. WR</th>
                                        <th>Proyek</th>
                                        <th>Periode</th>
                                        <th>Unit</th>
                                        <th class="text-end">Jumlah Realisasi</th>
                                        <th>Status</th>
                                        <th>Dibuat Oleh</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($realizations as $r)
                                    <tr>
                                        <td>
                                            <a href="{{ route('work-realizations.show', $r->uid) }}" class="fw-medium link-primary">
                                                {{ $r->realization_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width:160px">{{ $r->project->project_name ?? '-' }}</span>
                                        </td>
                                        <td class="small">
                                            {{ $r->period_start?->format('d M Y') }} →<br>
                                            {{ $r->period_end?->format('d M Y') }}
                                        </td>
                                        <td><span class="badge bg-secondary-subtle text-secondary">{{ $r->items_count }}</span></td>
                                        <td class="text-end fw-semibold">Rp {{ number_format($r->total_realized_amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $r->status->color() }}-subtle text-{{ $r->status->color() }} text-uppercase">
                                                {{ $r->status->label() }}
                                            </span>
                                        </td>
                                        <td>{{ $r->creator->name ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('work-realizations.show', $r->uid) }}"><i class="ti ti-eye me-2 text-muted"></i>Lihat</a></li>
                                                    @if($r->canEdit())
                                                        <li><a class="dropdown-item" href="{{ route('work-realizations.edit', $r->uid) }}"><i class="ti ti-edit me-2 text-muted"></i>Edit</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="avatar-lg mx-auto mb-3">
                                                <div class="avatar-title bg-light rounded-circle text-muted fs-1"><i class="ti ti-file-invoice"></i></div>
                                            </div>
                                            <h5>Belum ada Work Realization</h5>
                                            <p class="text-muted">Generate dari Timesheet APPROVED dalam periode tertentu.</p>
                                            <a href="{{ route('work-realizations.create') }}" class="btn btn-primary btn-sm"><i class="ti ti-plus me-1"></i>Generate Realisasi</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">{{ $realizations->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
