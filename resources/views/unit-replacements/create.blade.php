<?php $page = 'unit-replacements'; ?>
@extends('layout.mainlayout')
@section('title', 'Buat PTU')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Penggantian Unit (PTU)</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.index') }}">PTU</a></li>
                        <li class="breadcrumb-item active">Buat</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('unit-replacements.index') }}" class="btn btn-light d-flex align-items-center">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-replacements.store') }}" method="POST" enctype="multipart/form-data" id="ptuForm">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">Informasi PTU</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Project <span class="text-danger">*</span></label>
                                    <select name="project_id" id="projectId" class="form-select" required>
                                        <option value="">-- Pilih Project --</option>
                                        @foreach($eligibleProjects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->project_name }} ({{ $project->project_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Permintaan Unit (UR) <span class="text-danger">*</span></label>
                                    <select name="unit_request_id" id="unitRequestId" class="form-select" required disabled>
                                        <option value="">-- Pilih Project terlebih dahulu --</option>
                                    </select>
                                    <div class="form-text">Hanya UR berstatus <em>Approved by Workshop</em> dengan unit aktif yang ditampilkan. Unit pengganti diambil dari <strong>master alat berat Workshop</strong>.</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Penggantian <span class="text-danger">*</span></label>
                                    <input type="date" name="replacement_date" class="form-control"
                                        value="{{ old('replacement_date', date('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Mobilisasi</label>
                                    <input type="date" name="mobilization_date" class="form-control"
                                        value="{{ old('mobilization_date') }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Penyebab Penggantian <span class="text-danger">*</span></label>
                                    <textarea name="cause" rows="3" class="form-control"
                                        placeholder="Misal: unit rusak berat, breakdown engine, dll.">{{ old('cause') }}</textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="notes" rows="2" class="form-control" placeholder="Opsional">{{ old('notes') }}</textarea>
                                </div>

                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Lampiran</label>
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">PDF, JPG, PNG (max 5MB)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light-200 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Unit yang Diganti</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 align-middle" id="itemsTable" style="min-width: 1020px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px; min-width:50px" class="text-center">
                                                <input type="checkbox" id="selectAllItems" class="form-check-input" title="Pilih semua">
                                            </th>
                                            <th style="width:22%">Unit Lama (dari UR)</th>
                                            <th style="width:22%">Unit Pengganti (Master Workshop)</th>
                                            <th style="width:11%; min-width:100px">Qty</th>
                                            <th style="width:12%; min-width:115px">Durasi (hari)</th>
                                            <th style="width:23%">Alasan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                Pilih Project & UR untuk menampilkan unit yang dapat diganti.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h6 class="mb-0">Aksi</h6></div>
                        <div class="card-body d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Simpan PTU
                            </button>
                            <a href="{{ route('unit-replacements.index') }}" class="btn btn-light">Batal</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted small mb-0">
                                <i class="ti ti-info-circle me-1 text-primary"></i>
                                PTU disimpan sebagai <strong>DRAFT</strong>. Submit untuk approval dari halaman detail.
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
    const projectSel = document.getElementById('projectId');
    const urSel = document.getElementById('unitRequestId');
    const itemsBody = document.getElementById('itemsBody');

    let urData = [];
    let candidates = [];

    const eligibleUrUrl = "{{ route('unit-replacements.eligible-unit-requests') }}";
    const candidatesUrl = "{{ route('unit-replacements.replacement-candidates') }}";

    function emptyRow(msg) {
        return `<tr><td colspan="6" class="text-center text-muted py-3">${msg}</td></tr>`;
    }

    function renderItems(urId) {
        const ur = urData.find(u => String(u.id) === String(urId));
        if (!ur || !ur.items.length) {
            itemsBody.innerHTML = emptyRow('Tidak ada unit aktif pada UR ini.');
            return;
        }

        const candOptions = candidates.map(c => {
            const label = `${c.name}${c.equipment_code ? ' / ' + c.equipment_code : ''}` +
                          `${c.type ? ' — ' + c.type : ''}` +
                          `${c.status ? ' (' + c.status + ')' : ''}`;
            return `<option value="${c.id}" data-name="${c.name}" data-code="${c.equipment_code || ''}">${label}</option>`;
        }).join('');

        itemsBody.innerHTML = ur.items.map((it, idx) => `
            <tr class="item-row" data-row="${idx}">
                <td class="text-center align-middle">
                    <input type="checkbox" class="form-check-input row-check" data-row="${idx}" checked>
                </td>
                <td>
                    <div class="fw-medium">${it.unit_name}</div>
                    <small class="text-muted">Qty UR: ${it.qty} • Operator: ${it.operator_name || '-'}</small>
                    <input type="hidden" name="items[${idx}][original_unit_request_item_id]" value="${it.id}">
                </td>
                <td>
                    <select name="items[${idx}][replacement_workshop_unit_id]" class="form-select form-select-sm replacement-select" data-row="${idx}">
                        <option value="">-- Pilih unit pengganti --</option>
                        ${candOptions}
                    </select>
                    <input type="hidden" name="items[${idx}][replacement_unit_name]" class="replacement-name" value="">
                    <input type="hidden" name="items[${idx}][replacement_equipment_code]" class="replacement-code" value="">
                </td>
                <td>
                    <input type="number" step="0.01" min="0.01" name="items[${idx}][replacement_qty]" class="form-control form-control-sm" value="${it.qty}" required>
                </td>
                <td>
                    <input type="number" min="1" name="items[${idx}][replacement_duration_days]" class="form-control form-control-sm" value="${it.duration_days || ''}">
                </td>
                <td>
                    <input type="text" name="items[${idx}][reason]" class="form-control form-control-sm" placeholder="Alasan" required>
                </td>
            </tr>
        `).join('');
    }

    function toggleRow(row, checked) {
        row.classList.toggle('table-active', !checked);
        row.querySelectorAll('input, select, textarea').forEach(el => {
            if (el.classList.contains('row-check')) return;
            el.disabled = !checked;
        });
    }

    projectSel.addEventListener('change', async function () {
        const pid = this.value;
        urSel.innerHTML = '<option value="">Loading...</option>';
        urSel.disabled = true;
        itemsBody.innerHTML = emptyRow('Pilih UR untuk menampilkan unit.');
        if (!pid) {
            urSel.innerHTML = '<option value="">-- Pilih Project terlebih dahulu --</option>';
            return;
        }

        try {
            const [urRes, candRes] = await Promise.all([
                fetch(`${eligibleUrUrl}?project_id=${pid}`).then(r => r.json()),
                fetch(`${candidatesUrl}?project_id=${pid}`).then(r => r.json()),
            ]);
            urData = urRes.data || [];
            candidates = candRes.data || [];

            if (!urData.length) {
                urSel.innerHTML = '<option value="">Tidak ada UR yang memenuhi syarat</option>';
                return;
            }

            urSel.innerHTML = '<option value="">-- Pilih UR --</option>' +
                urData.map(u => `<option value="${u.id}">${u.request_number}${u.contract_number ? ' • ' + u.contract_number : ''}</option>`).join('');
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
        if (e.target.classList.contains('replacement-select')) {
            const opt = e.target.options[e.target.selectedIndex];
            const row = e.target.closest('tr');
            row.querySelector('.replacement-name').value = opt.dataset.name || '';
            row.querySelector('.replacement-code').value = opt.dataset.code || '';
        }

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

    document.getElementById('ptuForm').addEventListener('submit', function (e) {
        const checked = itemsBody.querySelectorAll('.row-check:checked');
        if (!checked.length) {
            e.preventDefault();
            alert('Centang minimal 1 unit yang akan diganti.');
        }
    });
})();
</script>
@endpush
@endsection
