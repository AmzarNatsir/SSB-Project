@extends('layout.mainlayout')
@section('title', 'Spare Part Usage')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h4 class="fw-bold mb-1"><i class="ti ti-tool text-warning me-2"></i>Pemakaian Spare Part</h4>
                <p class="text-muted small mb-0">Manajemen data pemakaian suku cadang</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('deal-reports') }}" class="btn btn-outline-warning btn-sm">
                    <i class="ti ti-chart-bar me-1"></i>Lihat Laporan
                </a>
                <a href="{{ route('spare-part-usages.create') }}" class="btn btn-warning btn-sm">
                    <i class="ti ti-plus me-1"></i>Input Baru
                </a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="card border-0 bg-warning-subtle">
                    <div class="card-body py-3 px-4 text-center">
                        <div class="h3 fw-bold text-warning mb-0">{{ $stats['total'] }}</div>
                        <small class="text-muted">Total Transaksi</small>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 bg-secondary-subtle">
                    <div class="card-body py-3 px-4 text-center">
                        <div class="h3 fw-bold text-secondary mb-0">{{ $stats['draft'] }}</div>
                        <small class="text-muted">Draft</small>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 bg-success-subtle">
                    <div class="card-body py-3 px-4 text-center">
                        <div class="h3 fw-bold text-success mb-0">{{ $stats['approved'] }}</div>
                        <small class="text-muted">Disetujui</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="card mb-3">
            <div class="card-body py-3">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label mb-1 small">Cari Nama / Nomor</label>
                        <input type="text" name="q" class="form-control form-control-sm"
                               placeholder="Part name, nomor…" value="{{ request('q') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label mb-1 small">Proyek</label>
                        <select name="project_id" class="form-select form-select-sm select2">
                            <option value="">— Semua —</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" @selected(request('project_id') == $p->id)>{{ $p->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1 small">Dari</label>
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1 small">Sampai</label>
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm flex-grow-1"><i class="ti ti-search me-1"></i>Cari</button>
                        <a href="{{ route('spare-part-usages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="ti ti-x"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pemakaian</th>
                            <th>Tanggal</th>
                            <th>Proyek</th>
                            <th>Nama Spare Part</th>
                            <th>Unit / Alat</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Total (Rp)</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $row)
                        <tr>
                            <td><a href="{{ route('spare-part-usages.show', $row->uid) }}" class="fw-semibold text-warning">{{ $row->usage_number }}</a></td>
                            <td class="text-nowrap small">{{ $row->usage_date?->format('d/m/Y') }}</td>
                            <td class="small">{{ $row->project?->project_name ?? '-' }}</td>
                            <td class="fw-semibold">{{ $row->part_name }}</td>
                            <td class="small text-muted">{{ $row->unit_name ?: '-' }}</td>
                            <td class="text-end">{{ number_format($row->quantity, 2) }} <span class="text-muted small">{{ $row->unit_of_measure }}</span></td>
                            <td class="text-end fw-semibold">
                                @if($row->total_price) {{ number_format($row->total_price, 0, ',', '.') }} @else <span class="text-muted">-</span> @endif
                            </td>
                            <td>
                                @php $sc = match($row->status) { 'APPROVED'=>'success','SUBMITTED'=>'warning','REJECTED'=>'danger',default=>'secondary' }; @endphp
                                <span class="badge bg-{{ $sc }}-subtle text-{{ $sc }}">{{ $row->status }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('spare-part-usages.show', $row->uid) }}" class="btn btn-outline-info btn-sm py-1 px-2"><i class="ti ti-eye fs-12"></i></a>
                                    @if($row->canEdit())
                                    <a href="{{ route('spare-part-usages.edit', $row->uid) }}" class="btn btn-outline-primary btn-sm py-1 px-2"><i class="ti ti-edit fs-12"></i></a>
                                    <button type="button" class="btn btn-outline-danger btn-sm py-1 px-2 btn-delete" data-uid="{{ $row->uid }}" data-number="{{ $row->usage_number }}"><i class="ti ti-trash fs-12"></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-5 text-muted"><i class="ti ti-mood-empty fs-1 d-block mb-2"></i>Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($items->hasPages())
                <div class="card-footer">{{ $items->links() }}</div>
            @endif
        </div>

    </div>
</div>

{{-- Delete form --}}
<form id="deleteForm" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>

@push('scripts')
<script>
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
        const uid = this.dataset.uid;
        const num = this.dataset.number;
        Swal.fire({
            title: 'Hapus ' + num + '?',
            text: 'Data draft akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
        }).then(r => {
            if (r.isConfirmed) {
                const f = document.getElementById('deleteForm');
                f.action = '/spare-part-usages/' + uid;
                f.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
