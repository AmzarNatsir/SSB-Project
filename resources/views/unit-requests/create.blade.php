@extends('layout.mainlayout')
@section('title', 'Buat Permintaan Unit')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Buat Permintaan Unit</h3>
                <p class="text-muted small mb-0">Pilih proyek yang sudah memiliki kesepakatan harga (Negosiasi APPROVED). Daftar unit otomatis dari Penawaran Harga.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-requests.index') }}">Permintaan Unit</a></li>
                        <li class="breadcrumb-item active">Buat</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-requests.store') }}" method="POST" enctype="multipart/form-data" id="unitRequestForm">
            @csrf
            <div class="row">
                <!-- Left Column: Main Form -->
                <div class="col-lg-8">
                    <!-- Project & Contract Selection -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-building me-2 text-primary"></i>Pilih Proyek &amp; Kontrak</h5>
                        </div>
                        <div class="card-body">
                            @if($eligibleProjects->isEmpty())
                                <div class="alert alert-warning mb-0">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    Tidak ada proyek dengan <strong>Final Contract ACTIVE</strong> yang belum dipakai. Pastikan kontrak sudah dibuat & aktif sebelum membuat Permintaan Unit.
                                </div>
                            @else
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="project_id" class="form-label fw-semibold">Proyek <span class="text-danger">*</span></label>
                                        <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Proyek --</option>
                                            @foreach($eligibleProjects as $project)
                                                <option value="{{ $project->id }}"
                                                    {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                    {{ $project->project_name }}
                                                    ({{ $project->project_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Hanya proyek dengan Final Contract ACTIVE yang ditampilkan.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contract_id" class="form-label fw-semibold">Final Contract <span class="text-danger">*</span></label>
                                        <select name="contract_id" id="contract_id" class="form-select @error('contract_id') is-invalid @enderror" required disabled>
                                            <option value="">-- Pilih proyek dulu --</option>
                                        </select>
                                        @error('contract_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">1 kontrak = 1 Permintaan Unit aktif.</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Unit Items Preview -->
                    <div class="card mb-3" id="itemsCard" style="display:none !important;">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-list me-2 text-primary"></i>Daftar Unit (dari Final Contract)</h5>
                            <p class="text-muted small mb-0 mt-1">Items otomatis di-snapshot dari <code>contract_items</code> kontrak yang dipilih.</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width:40px">#</th>
                                            <th>Nama Unit</th>
                                            <th style="width:120px">Kode Alat</th>
                                            <th class="text-center" style="width:70px">Qty</th>
                                            <th class="text-end" style="width:140px">Harga Satuan</th>
                                            <th class="text-center" style="width:110px">Durasi</th>
                                            <th class="text-end" style="width:160px">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        <tr><td colspan="7" class="text-center text-muted py-3">Pilih proyek &amp; kontrak untuk menampilkan daftar unit.</td></tr>
                                    </tbody>
                                    <tfoot class="table-light fw-semibold" id="itemsTableFoot" style="display:none;">
                                        <tr>
                                            <td colspan="6" class="text-end">Total Nilai Kontrak:</td>
                                            <td class="text-end text-primary" id="itemsGrandTotal">Rp 0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Request Details -->
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-calendar me-2 text-primary"></i>Detail Permintaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="request_date" class="form-label fw-semibold">Tanggal Permintaan <span class="text-danger">*</span></label>
                                <input type="date" id="request_date" name="request_date"
                                    class="form-control @error('request_date') is-invalid @enderror"
                                    value="{{ old('request_date', date('Y-m-d')) }}" required>
                                @error('request_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobilization_date" class="form-label fw-semibold">Tanggal Mobilisasi <span class="text-danger">*</span></label>
                                <input type="date" id="mobilization_date" name="mobilization_date"
                                    class="form-control @error('mobilization_date') is-invalid @enderror"
                                    value="{{ old('mobilization_date') }}" required>
                                @error('mobilization_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Tidak boleh sebelum tanggal permintaan.</small>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-semibold">Catatan</label>
                                <textarea id="notes" name="notes" rows="4"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Catatan tambahan / kebutuhan khusus...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label fw-semibold">
                                    Lampiran Spesifikasi Kebutuhan
                                    <span class="text-muted small">(PDF/DOCX, max 10MB)</span>
                                </label>
                                <input type="file" id="attachment" name="attachment"
                                    class="form-control @error('attachment') is-invalid @enderror"
                                    accept=".pdf,.doc,.docx">
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn" {{ $eligibleProjects->isEmpty() ? 'disabled' : '' }}>
                            <i class="ti ti-device-floppy me-2"></i>Simpan sebagai Draft
                        </button>
                        <a href="{{ route('unit-requests.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-x me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    const oldContractId = "{{ old('contract_id') }}";
    let contractsCache = []; // cache items per contract dari last fetch

    const ELIGIBLE_CONTRACTS_URL = "{{ route('unit-requests.eligible-contracts') }}";

    function formatRupiah(num) {
        const n = Number(num) || 0;
        return 'Rp ' + n.toLocaleString('id-ID', { maximumFractionDigits: 0 });
    }

    function formatNumberId(num) {
        const n = Number(num) || 0;
        // Buang trailing .00 kalau bulat
        return Number.isInteger(n) ? n.toLocaleString('id-ID') : n.toLocaleString('id-ID', { maximumFractionDigits: 2 });
    }

    function renderItems(items) {
        const $body = $('#itemsTableBody');
        const $foot = $('#itemsTableFoot');
        if (!items || items.length === 0) {
            $body.html('<tr><td colspan="7" class="text-center text-muted py-3">Kontrak ini belum memiliki item.</td></tr>');
            $foot.hide();
            return;
        }

        let grandTotal = 0;
        $body.html(items.map((item, idx) => {
            const total = Number(item.total_price) || 0;
            grandTotal += total;
            return `
                <tr>
                    <td class="text-center">${idx + 1}</td>
                    <td>${item.unit_name ?? '-'}</td>
                    <td><span class="badge bg-light text-dark">${item.equipment_code ?? '-'}</span></td>
                    <td class="text-center">${formatNumberId(item.qty)}</td>
                    <td class="text-end">${formatRupiah(item.unit_price)}</td>
                    <td class="text-center">${formatNumberId(item.duration)} ${item.duration_unit ?? ''}</td>
                    <td class="text-end fw-semibold">${formatRupiah(total)}</td>
                </tr>
            `;
        }).join(''));

        $('#itemsGrandTotal').text(formatRupiah(grandTotal));
        $foot.show();
    }

    function resetItems(message) {
        $('#itemsCard').css('display', 'none');
        $('#itemsTableBody').html(`<tr><td colspan="7" class="text-center text-muted py-3">${message || 'Pilih proyek & kontrak untuk menampilkan daftar unit.'}</td></tr>`);
        $('#itemsTableFoot').hide();
    }

    function resetContractDropdown(placeholder) {
        $('#contract_id').html(`<option value="">${placeholder || '-- Pilih proyek dulu --'}</option>`).prop('disabled', true);
        contractsCache = [];
    }

    // PROJECT change → fetch eligible contracts
    $('#project_id').on('change', function () {
        const projectId = $(this).val();
        resetItems();
        resetContractDropdown();
        if (!projectId) return;

        $('#contract_id').html('<option value="">Memuat...</option>').prop('disabled', true);

        $.ajax({
            url: ELIGIBLE_CONTRACTS_URL,
            method: 'GET',
            data: { project_id: projectId },
            success: function (response) {
                const list = response.data || [];
                contractsCache = list;

                if (list.length === 0) {
                    $('#contract_id').html('<option value="">Tidak ada kontrak ACTIVE tersedia</option>').prop('disabled', true);
                    return;
                }

                let opts = '<option value="">-- Pilih Kontrak --</option>';
                list.forEach(c => {
                    const sel = (oldContractId && String(c.id) === String(oldContractId)) ? ' selected' : '';
                    opts += `<option value="${c.id}"${sel}>${c.contract_number} — ${c.start_date} s/d ${c.end_date}</option>`;
                });
                $('#contract_id').html(opts).prop('disabled', false);

                if (list.length === 1) {
                    $('#contract_id').val(list[0].id).trigger('change');
                } else if (oldContractId) {
                    $('#contract_id').trigger('change');
                }
            },
            error: function () {
                $('#contract_id').html('<option value="">Gagal memuat kontrak</option>').prop('disabled', true);
            }
        });
    });

    // CONTRACT change → render items dari cache
    $('#contract_id').on('change', function () {
        const contractId = $(this).val();
        if (!contractId) {
            resetItems();
            return;
        }
        const contract = contractsCache.find(c => String(c.id) === String(contractId));
        if (! contract) {
            resetItems('Data kontrak tidak ditemukan di cache.');
            return;
        }
        renderItems(contract.items || []);
        $('#itemsCard').css('display', 'block');
    });

    // Trigger on load (validation error scenario)
    if ($('#project_id').val()) {
        $('#project_id').trigger('change');
    }

    // Date constraint
    $('#request_date').on('change', function () {
        $('#mobilization_date').attr('min', this.value);
    }).trigger('change');
});
</script>
@endpush
