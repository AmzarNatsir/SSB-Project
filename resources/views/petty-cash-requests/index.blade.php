@extends('layout.mainlayout')
@section('title', 'Permintaan Kas Kecil')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Permintaan Kas Kecil</h3>
                <p class="text-muted mb-0 small">Pengajuan dana kas kecil per project. Format nomor: <code>PCR/2026/001</code>.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Permintaan Kas Kecil</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('petty-cash-requests.create') }}" class="btn btn-primary btn-label">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i>Buat Permintaan
                </a>
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif

        <div class="row">
            @php
                $kpis = [
                    ['Total Permintaan',     $stats['total'],     'ti-file-invoice', 'primary'],
                    ['Draft',                $stats['draft'],     'ti-pencil',       'secondary'],
                    ['Menunggu Approval',    $stats['submitted'], 'ti-clock',        'warning'],
                    ['Disetujui',            $stats['approved'],  'ti-circle-check', 'success'],
                ];
            @endphp
            @foreach($kpis as [$label, $value, $icon, $color])
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden"><p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ $label }}</p></div>
                            <div class="flex-shrink-0"><div class="avatar-sm"><span class="avatar-title bg-{{ $color }}-subtle text-{{ $color }} rounded fs-3"><i class="ti {{ $icon }}"></i></span></div></div>
                        </div>
                        <h4 class="fs-22 fw-semibold ff-secondary mt-4">{{ $value }}</h4>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-12">
                <div class="alert alert-info-subtle border-info-subtle mb-3">
                    <i class="ti ti-coin me-1 text-info"></i><strong>Total Nilai Disetujui:</strong> Rp {{ number_format($stats['approved_amount'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom-dashed">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-md-3"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nomor / uraian..."></div>
                    <div class="col-md-3">
                        <select name="project_id" class="form-select">
                            <option value="">Semua Proyek</option>
                            @foreach($projects as $p)<option value="{{ $p->id }}" @selected(request('project_id') == $p->id)>{{ $p->project_name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach(\App\Enums\PettyCashRequestStatus::cases() as $st)<option value="{{ $st->value }}" @selected(request('status') === $st->value)>{{ $st->label() }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button class="btn btn-outline-primary"><i class="ti ti-search me-1"></i>Filter</button>
                        <a href="{{ route('petty-cash-requests.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-nowrap align-middle">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>No. Permintaan</th>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Uraian</th>
                                <th class="text-end">Nominal</th>
                                <th class="text-end">Terpakai</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $r)
                            <tr>
                                <td><a href="{{ route('petty-cash-requests.show', $r->uid) }}" class="fw-medium link-primary">{{ $r->request_number }}</a></td>
                                <td class="small">{{ $r->request_date?->format('d M Y') }}</td>
                                <td><span class="text-truncate d-inline-block" style="max-width:160px">{{ $r->project->project_name ?? '-' }}</span></td>
                                <td><span class="text-truncate d-inline-block text-muted small" style="max-width:200px">{{ \Illuminate\Support\Str::limit($r->description, 60) }}</span></td>
                                <td class="text-end fw-semibold">Rp {{ number_format($r->requested_amount, 0, ',', '.') }}</td>
                                <td class="text-end small">
                                    Rp {{ number_format($r->used_amount, 0, ',', '.') }}
                                    @if((float)$r->used_amount > 0)
                                        <div class="text-muted">Sisa: Rp {{ number_format($r->remaining_amount, 0, ',', '.') }}</div>
                                    @endif
                                </td>
                                <td><span class="badge bg-{{ $r->status->color() }}-subtle text-{{ $r->status->color() }} text-uppercase">{{ $r->status->label() }}</span></td>
                                <td class="text-end">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('petty-cash-requests.show', $r->uid) }}"><i class="ti ti-eye me-2 text-muted"></i>Lihat</a></li>
                                            @if($r->canEdit())<li><a class="dropdown-item" href="{{ route('petty-cash-requests.edit', $r->uid) }}"><i class="ti ti-edit me-2 text-muted"></i>Edit</a></li>@endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-5">
                                <div class="avatar-lg mx-auto mb-3"><div class="avatar-title bg-light rounded-circle text-muted fs-1"><i class="ti ti-cash"></i></div></div>
                                <h5>Belum ada Permintaan Kas Kecil</h5>
                                <a href="{{ route('petty-cash-requests.create') }}" class="btn btn-primary btn-sm"><i class="ti ti-plus me-1"></i>Buat Permintaan</a>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
