{{--
    Shared form partial for create & edit.
    Required vars: $projects, $formation (nullable on create)
--}}
@php
    $formation = $formation ?? null;
    $isEdit = $formation !== null;
    $action = $isEdit
        ? route('workforce-formations.update', $formation->uid)
        : route('workforce-formations.store');
@endphp

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="formation-form">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Proyek <span class="text-danger">*</span></label>
            <select name="project_id" id="project_id" class="form-select" required>
                <option value="">-- Pilih Proyek --</option>
                @foreach($projects as $p)
                    <option value="{{ $p->id }}"
                        @selected(old('project_id', $formation?->project_id ?? '') == $p->id)>
                        {{ $p->project_code }} — {{ $p->project_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Kontrak Aktif <span class="text-danger">*</span></label>
            <select name="contract_id" id="contract_id" class="form-select" required>
                <option value="">-- Pilih Proyek dulu --</option>
                @if($isEdit && $formation->contract)
                    <option value="{{ $formation->contract->id }}" selected>
                        {{ $formation->contract->contract_number }}
                    </option>
                @endif
            </select>
            <small class="text-muted">Hanya kontrak berstatus AKTIF yang muncul. Penugasan tim mengacu ke kontrak ini sebagai dasar legal.</small>
        </div>

        <div class="col-md-4">
            <label class="form-label">Berlaku Mulai <span class="text-danger">*</span></label>
            <input type="date" name="effective_date" class="form-control"
                   value="{{ old('effective_date', $formation?->effective_date?->format('Y-m-d')) }}" required>
            <small class="text-muted">Tanggal SK ini efektif berlaku.</small>
        </div>

        <div class="col-md-4">
            <label class="form-label">Berlaku Sampai</label>
            <input type="date" name="end_date" class="form-control"
                   value="{{ old('end_date', $formation?->end_date?->format('Y-m-d')) }}">
            <small class="text-muted">Kosongkan kalau mengikuti durasi kontrak.</small>
        </div>

        <div class="col-md-4">
            <label class="form-label">Dokumen SK</label>
            <input type="file" name="attachment" class="form-control"
                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            @if($isEdit && $formation->attachment_path)
                <small class="text-success"><i class="ti ti-check me-1"></i>Dokumen sudah terupload. Upload baru untuk mengganti.</small>
            @else
                <small class="text-muted">SK / surat tugas / MOU (PDF, gambar, dokumen).</small>
            @endif
        </div>

        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="2" class="form-control" placeholder="Misal: alasan dibuat SK, instruksi khusus, dll.">{{ old('notes', $formation?->notes ?? '') }}</textarea>
        </div>
    </div>

    {{-- Anggota Tim --}}
    <hr class="my-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="mb-0">Anggota Tim <small class="text-muted">(minimal 1 untuk diajukan)</small></h5>
            <small class="text-muted">Daftar personel yang ditetapkan dalam SK ini. Tidak boleh ada karyawan duplikat.</small>
        </div>
        <button type="button" class="btn btn-soft-primary btn-sm" id="add-member-btn">
            <i class="ti ti-plus me-1"></i> Tambah Anggota
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="members-table" style="min-width: 1200px;">
            <thead class="table-light">
                <tr class="text-uppercase small">
                    <th style="min-width:280px;">Karyawan</th>
                    <th style="min-width:160px;">Posisi</th>
                    <th style="min-width:170px;">Upah Harian</th>
                    <th style="min-width:170px;">Tunjangan</th>
                    <th style="min-width:120px;">Shift</th>
                    <th style="min-width:160px;">Mulai Tugas</th>
                    <th style="min-width:160px;">Selesai Tugas</th>
                    <th style="width:60px;"></th>
                </tr>
            </thead>
            <tbody id="members-body">
                @php
                    $existingMembers = $isEdit ? $formation->members : collect();
                @endphp
                @forelse($existingMembers as $idx => $m)
                    @include('workforce-formations._member_row', ['index' => $idx, 'member' => $m])
                @empty
                    {{-- empty; JS will add one row on load --}}
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i> Simpan Draft
        </button>
        <a href="{{ route('workforce-formations.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>

{{-- Template untuk baris baru (dipakai JS) --}}
<template id="member-row-template">
    @include('workforce-formations._member_row', ['index' => '__INDEX__', 'member' => null])
</template>

@push('scripts')
<script>
(function() {
    const employeeSearchUrl = "{{ route('employees.search') }}";
    const projectContractsUrl = "{{ url('api/projects') }}";

    // ===== Contract dropdown — load on project change =====
    function loadContracts(projectId, selectedId) {
        const $contract = $('#contract_id');
        $contract.html('<option value="">Loading...</option>');
        if (!projectId) {
            $contract.html('<option value="">-- Pilih Project dulu --</option>');
            return;
        }
        $.getJSON(`${projectContractsUrl}/${projectId}/active-contracts`)
            .done(function(resp) {
                $contract.html('<option value="">-- Pilih Contract --</option>');
                (resp.data || []).forEach(function(c) {
                    const sel = c.id == selectedId ? 'selected' : '';
                    $contract.append(`<option value="${c.id}" ${sel}>${c.contract_number} (${c.start_date} → ${c.end_date})</option>`);
                });
            })
            .fail(function() {
                $contract.html('<option value="">Gagal load contracts</option>');
            });
    }

    $('#project_id').on('change', function() {
        loadContracts($(this).val(), null);
    });

    // Initial load if editing
    @if($isEdit)
        // Already pre-selected; refresh full list anyway
        loadContracts({{ $formation->project_id }}, {{ $formation->contract_id }});
    @endif

    // ===== Member rows =====
    let memberIndex = {{ $existingMembers->count() }};
    const tmpl = document.getElementById('member-row-template').innerHTML;

    function addMemberRow() {
        const html = tmpl.replaceAll('__INDEX__', memberIndex);
        $('#members-body').append(html);
        initSelect2ForRow(memberIndex);
        memberIndex++;
    }

    // Helper: kumpulkan semua employee_id yang sudah dipilih di SEMUA row,
    // kecuali row yang sedang dibuka (supaya selection sendiri tetap visible).
    function getSelectedEmployeeIdsExcept($currentSelect) {
        const currentId = parseInt($currentSelect.val()) || null;
        return $('#members-body select[name*="[employee_id]"]')
            .map(function() { return parseInt($(this).val()) || null; })
            .get()
            .filter(id => id && id !== currentId);
    }

    function initSelect2ForRow(idx) {
        const $select = $(`select[name="members[${idx}][employee_id]"]`);
        $select.select2({
            placeholder: 'Cari karyawan...',
            ajax: {
                url: employeeSearchUrl,
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term || '', limit: 50 }), // ambil lebih banyak karena di-filter client-side
                processResults: function(data) {
                    const excluded = getSelectedEmployeeIdsExcept($select);
                    return {
                        results: (data.data || [])
                            .filter(e => !excluded.includes(e.id))
                            .map(e => ({
                                id: e.id,
                                text: e.text,
                                name: e.name,
                                position: e.position,
                            }))
                    };
                }
            },
            width: '100%'
        }).on('select2:select', function(e) {
            const sel = e.params.data;
            const $row = $(this).closest('tr');
            $row.find('input[name$="[employee_name]"]').val(sel.name || '');
            $row.find('input[name$="[position_name]"]').val(sel.position || '');
            $row.find('.position-display').text(sel.position || '-');
        });
    }

    // ===== Rupiah formatter (daily_rate & allowance) =====
    // Format: 1000000 → 1.000.000  (integer-only, thousand separator titik)
    function formatRupiah(value) {
        const digits = String(value).replace(/\D/g, '');
        if (!digits) return '';
        // Strip leading zeros (kecuali kalau hasilnya "0")
        const trimmed = digits.replace(/^0+/, '') || '0';
        return trimmed.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function parseRupiah(value) {
        return String(value).replace(/\D/g, '') || '0';
    }

    // Auto-format saat user mengetik (preserve cursor position berdasarkan jumlah digit raw)
    $(document).on('input', '.js-rupiah-input', function() {
        const el = this;
        const oldValue = el.value;
        const oldCursor = el.selectionStart;

        // Hitung berapa digit raw yang ada sebelum kursor di nilai lama
        const rawDigitsBefore = oldValue.slice(0, oldCursor).replace(/\D/g, '').length;

        const formatted = formatRupiah(oldValue);
        el.value = formatted;

        // Cari posisi setelah ke-N digit raw di nilai baru
        let newCursor = formatted.length;
        let count = 0;
        for (let i = 0; i < formatted.length; i++) {
            if (/\d/.test(formatted[i])) count++;
            if (count >= rawDigitsBefore) {
                newCursor = i + 1;
                break;
            }
        }
        el.setSelectionRange(newCursor, newCursor);
    });

    // Format saat blur (handle kosong → "0")
    $(document).on('blur', '.js-rupiah-input', function() {
        const raw = parseRupiah($(this).val());
        $(this).val(formatRupiah(raw));
    });

    // Strip titik sebelum submit supaya backend terima angka mentah
    $('#formation-form').on('submit', function() {
        $(this).find('.js-rupiah-input').each(function() {
            $(this).val(parseRupiah($(this).val()));
        });
    });

    // Format value awal — handle case value dari DB datang sebagai "1000000.00" (decimal cast)
    function formatExistingRupiahInputs() {
        $('.js-rupiah-input').each(function() {
            const val = $(this).val();
            if (!val) { $(this).val('0'); return; }
            const num = parseFloat(val);
            $(this).val(isNaN(num) ? '0' : formatRupiah(Math.round(num)));
        });
    }
    formatExistingRupiahInputs();

    // Init existing rows on page load (edit mode)
    $('#members-body select[name*="[employee_id]"]').each(function() {
        const idx = $(this).attr('name').match(/members\[(\d+)\]/)[1];
        initSelect2ForRow(idx);
    });

    $('#add-member-btn').on('click', addMemberRow);

    $(document).on('click', '.remove-member-btn', function() {
        $(this).closest('tr').remove();
    });

    // Add 1 row on load if create mode
    @if(!$isEdit)
        addMemberRow();
    @endif
})();
</script>
@endpush
