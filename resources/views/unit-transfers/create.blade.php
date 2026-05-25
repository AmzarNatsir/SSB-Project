<?php $page = 'unit-transfers'; ?>
@extends('layout.mainlayout')
@section('title', 'Buat Unit Transfer')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Unit Transfer (UT)</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-transfers.index') }}">UT</a></li>
                        <li class="breadcrumb-item active">Buat</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('unit-transfers.index') }}" class="btn btn-light d-flex align-items-center">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-transfers.store') }}" method="POST" enctype="multipart/form-data" id="utForm">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    {{-- PILIH UNIT (Project Asal + UR + Items) --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Pilih Unit</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Project Asal <span class="text-danger">*</span></label>
                                    <select name="source_project_id" id="sourceProjectId" class="form-select" required>
                                        <option value="">-- Pilih Project Asal --</option>
                                        @foreach($sourceProjects as $p)
                                            <option value="{{ $p->id }}" data-number="{{ $p->project_number }}" data-name="{{ $p->project_name }}"
                                                {{ old('source_project_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->project_name }} ({{ $p->project_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Project dengan UR APPROVED_FROM_WORKSHOP yang masih punya unit aktif.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit Request (UR) <span class="text-danger">*</span></label>
                                    <select name="source_unit_request_id" id="sourceUnitRequestId" class="form-select" required disabled>
                                        <option value="">-- Pilih Project Asal dulu --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 border-top">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 align-middle" style="min-width:900px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px" class="text-center">
                                                <input type="checkbox" id="selectAllItems" class="form-check-input" title="Pilih semua">
                                            </th>
                                            <th>Kode Unit / Nama</th>
                                            <th>Driver/Operator</th>
                                            <th style="width:15%; min-width:110px">Qty</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <tr><td colspan="5" class="text-center text-muted py-3">Pilih Project & UR untuk menampilkan unit.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- INFO PROJECT BARU --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Info Project Baru (Tujuan)</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Project Tujuan <span class="text-danger">*</span></label>
                                    <select name="destination_project_id" id="destinationProjectId" class="form-select" required>
                                        <option value="">-- Pilih Project Tujuan --</option>
                                        @foreach($destinationProjects as $p)
                                            <option value="{{ $p->id }}"
                                                data-number="{{ $p->project_number }}"
                                                data-name="{{ $p->project_name }}"
                                                data-location="{{ $p->project_location }}"
                                                {{ old('destination_project_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->project_name }} ({{ $p->project_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nomor Project</label>
                                    <input type="text" id="destProjectNumber" class="form-control" value="-" disabled>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Project</label>
                                    <input type="text" id="destProjectName" class="form-control" value="-" disabled>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Lokasi Project</label>
                                    <input type="text" id="destProjectLocation" class="form-control" value="-" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- META --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Informasi UT</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Transfer <span class="text-danger">*</span></label>
                                    <input type="date" name="transfer_date" class="form-control"
                                        value="{{ old('transfer_date', date('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lampiran</label>
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">PDF, JPG, PNG (max 5MB)</div>
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" rows="3" class="form-control" placeholder="Opsional">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h6 class="mb-0">Aksi</h6></div>
                        <div class="card-body d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan UT
                            </button>
                            <a href="{{ route('unit-transfers.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted small mb-0">
                                <i class="ti ti-info-circle me-1 text-primary"></i>
                                UT disimpan sebagai <strong>DRAFT</strong>. Selesaikan dari halaman detail untuk menandai unit sebagai sudah ditransfer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const sourceProjectSel = document.getElementById('sourceProjectId');
    const urSel            = document.getElementById('sourceUnitRequestId');
    const itemsBody        = document.getElementById('itemsBody');
    const destSel          = document.getElementById('destinationProjectId');
    const destNumber       = document.getElementById('destProjectNumber');
    const destName         = document.getElementById('destProjectName');
    const destLocation     = document.getElementById('destProjectLocation');

    let urData = [];

    const eligibleUrUrl = "{{ route('unit-transfers.eligible-unit-requests') }}";

    function emptyRow(msg) {
        return `<tr><td colspan="5" class="text-center text-muted py-3">${msg}</td></tr>`;
    }

    function renderItems(urId) {
        const ur = urData.find(u => String(u.id) === String(urId));
        if (!ur || !ur.items.length) {
            itemsBody.innerHTML = emptyRow('Tidak ada unit aktif pada UR ini.');
            return;
        }

        itemsBody.innerHTML = ur.items.map((it, idx) => `
            <tr class="item-row table-active" data-row="${idx}">
                <td class="text-center align-middle">
                    <input type="checkbox" class="form-check-input row-check" data-row="${idx}">
                </td>
                <td>
                    <div class="fw-medium">${it.unit_name}</div>
                    ${it.equipment_code ? `<small class="text-muted d-block">Kode: ${it.equipment_code}</small>` : ''}
                    <small class="text-muted">Sisa: <strong>${it.remaining_qty}</strong> dari ${it.qty}</small>
                    <input type="hidden" name="items[${idx}][original_unit_request_item_id]" value="${it.id}" disabled>
                </td>
                <td>${it.operator_name || '-'}</td>
                <td>
                    <input type="number" step="0.01" min="0.01" max="${it.remaining_qty}" name="items[${idx}][qty]" class="form-control form-control-sm" value="${it.remaining_qty}" required disabled>
                </td>
                <td>
                    <input type="text" name="items[${idx}][notes]" class="form-control form-control-sm" placeholder="Opsional" disabled>
                </td>
            </tr>
        `).join('');

        const selectAll = document.getElementById('selectAllItems');
        selectAll.checked = false;
        selectAll.indeterminate = false;
    }

    function toggleRow(row, checked) {
        row.classList.toggle('table-active', !checked);
        row.querySelectorAll('input, select, textarea').forEach(el => {
            if (el.classList.contains('row-check')) return;
            el.disabled = !checked;
        });
    }

    sourceProjectSel.addEventListener('change', async function () {
        const pid = this.value;
        urSel.innerHTML = '<option value="">Loading...</option>';
        urSel.disabled = true;
        itemsBody.innerHTML = emptyRow('Pilih UR untuk menampilkan unit.');
        excludeFromDestination(pid);
        if (!pid) {
            urSel.innerHTML = '<option value="">-- Pilih Project Asal dulu --</option>';
            return;
        }
        try {
            const res = await fetch(`${eligibleUrUrl}?project_id=${pid}`).then(r => r.json());
            urData = res.data || [];
            if (!urData.length) {
                urSel.innerHTML = '<option value="">Tidak ada UR yang memenuhi syarat</option>';
                return;
            }
            urSel.innerHTML = '<option value="">-- Pilih UR --</option>' +
                urData.map(u => `<option value="${u.id}">${u.request_number}</option>`).join('');
            urSel.disabled = false;
        } catch (err) {
            console.error(err);
            urSel.innerHTML = '<option value="">Gagal memuat data</option>';
        }
    });

    urSel.addEventListener('change', function () {
        renderItems(this.value);
    });

    itemsBody.addEventListener('change', function (e) {
        if (e.target.classList.contains('row-check')) {
            const row = e.target.closest('tr');
            toggleRow(row, e.target.checked);
            const all = itemsBody.querySelectorAll('.row-check');
            const checked = itemsBody.querySelectorAll('.row-check:checked');
            const selectAll = document.getElementById('selectAllItems');
            selectAll.checked = checked.length === all.length;
            selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
        }
    });

    document.getElementById('selectAllItems').addEventListener('change', function () {
        const checked = this.checked;
        itemsBody.querySelectorAll('.row-check').forEach(cb => {
            cb.checked = checked;
            toggleRow(cb.closest('tr'), checked);
        });
        this.indeterminate = false;
    });

    function updateDestInfo() {
        const opt = destSel.options[destSel.selectedIndex];
        if (!opt || !opt.value) {
            destNumber.value = '-';
            destName.value = '-';
            destLocation.value = '-';
            return;
        }
        destNumber.value   = opt.dataset.number || '-';
        destName.value     = opt.dataset.name || '-';
        destLocation.value = opt.dataset.location || '-';
    }

    function excludeFromDestination(sourceId) {
        Array.from(destSel.options).forEach(opt => {
            if (!opt.value) return;
            opt.hidden = (sourceId && String(opt.value) === String(sourceId));
            opt.disabled = opt.hidden;
        });
        if (sourceId && String(destSel.value) === String(sourceId)) {
            destSel.value = '';
            updateDestInfo();
        }
    }

    destSel.addEventListener('change', updateDestInfo);
    updateDestInfo();
    if (sourceProjectSel.value) excludeFromDestination(sourceProjectSel.value);

    document.getElementById('utForm').addEventListener('submit', function (e) {
        const checked = itemsBody.querySelectorAll('.row-check:checked');
        if (!checked.length) {
            e.preventDefault();
            alert('Centang minimal 1 unit yang akan ditransfer.');
        }
    });
})();
</script>
@endpush
@endsection
