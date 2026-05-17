@extends('layout.mainlayout')
@section('title', 'Invoice')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Invoice</h3>
                <p class="text-muted mb-0 small">Tagihan ke customer berdasarkan Work Realization yang Disetujui. Format nomor: <code>001/SSB/V/2026</code>.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-label">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i>Buat Invoice
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
                    ['label' => 'Total Invoice',     'value' => $stats['total'],     'icon' => 'ti-file-invoice', 'class' => 'primary'],
                    ['label' => 'Draft',             'value' => $stats['draft'],     'icon' => 'ti-pencil',       'class' => 'secondary'],
                    ['label' => 'Menunggu Approval', 'value' => $stats['submitted'], 'icon' => 'ti-clock',        'class' => 'warning'],
                    ['label' => 'Disetujui',         'value' => $stats['approved'],  'icon' => 'ti-circle-check', 'class' => 'success'],
                    ['label' => 'Lunas',             'value' => $stats['paid'],      'icon' => 'ti-cash',         'class' => 'info'],
                ];
            @endphp
            @foreach($kpis as $kpi)
            <div class="col-xl col-md-4 col-sm-6">
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
                <div class="alert alert-success-subtle border-success-subtle mb-3">
                    <i class="ti ti-cash me-1 text-success"></i>
                    <strong>Total Nilai Invoice Lunas:</strong>
                    Rp {{ number_format($stats['paid_total'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nomor / customer / proyek...">
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
                                    @foreach(\App\Enums\InvoiceStatus::cases() as $st)
                                        <option value="{{ $st->value }}" @selected(request('status') === $st->value)>{{ $st->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-auto">
                                <button class="btn btn-outline-primary"><i class="ti ti-search me-1"></i>Filter</button>
                                <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th>No. Invoice</th>
                                        <th>Tgl. Invoice</th>
                                        <th>Proyek</th>
                                        <th>Customer</th>
                                        <th class="text-end">Subtotal</th>
                                        <th class="text-end">Total</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoices as $inv)
                                    <tr>
                                        <td>
                                            <a href="{{ route('invoices.show', $inv->uid) }}" class="fw-medium link-primary">
                                                {{ $inv->invoice_number }}
                                            </a>
                                            <div class="text-muted small">WR: {{ $inv->workRealization->realization_number ?? '-' }}</div>
                                        </td>
                                        <td class="small">
                                            {{ $inv->invoice_date?->format('d M Y') }}
                                            @if($inv->due_date)
                                                <div class="text-muted">Due: {{ $inv->due_date->format('d M Y') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width:160px">{{ $inv->project->project_name ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width:160px">{{ $inv->customer_name ?? '-' }}</span>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($inv->subtotal, 0, ',', '.') }}</td>
                                        <td class="text-end fw-semibold">Rp {{ number_format($inv->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $inv->status->color() }}-subtle text-{{ $inv->status->color() }} text-uppercase">
                                                {{ $inv->status->label() }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('invoices.show', $inv->uid) }}"><i class="ti ti-eye me-2 text-muted"></i>Lihat</a></li>
                                                    @if($inv->canEdit())
                                                        <li><a class="dropdown-item" href="{{ route('invoices.edit', $inv->uid) }}"><i class="ti ti-edit me-2 text-muted"></i>Edit</a></li>
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
                                            <h5>Belum ada Invoice</h5>
                                            <p class="text-muted">Buat Invoice dari Work Realization yang sudah Disetujui.</p>
                                            <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm"><i class="ti ti-plus me-1"></i>Buat Invoice</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">{{ $invoices->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
