{{--
    Shared form partial for create & edit Unit Formation.
    Required vars: $projects, $formation (nullable on create), $preselectedProjectId (nullable)
--}}
@php
    $formation = $formation ?? null;
    $preselectedProjectId = $preselectedProjectId ?? null;
    $isEdit = $formation !== null;
    $action = $isEdit
        ? route('unit-formations.update', $formation->uid)
        : route('unit-formations.store');
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
                        @selected(old('project_id', $formation?->project_id ?? $preselectedProjectId) == $p->id)>
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
            <small class="text-muted">Hanya kontrak berstatus AKTIF yang muncul. Unit yang dipilih mengacu ke baseline kontrak ini.</small>
        </div>

        <div class="col-md-4">
            <label class="form-label">Berlaku Mulai <span class="text-danger">*</span></label>
            <input type="date" name="effective_date" class="form-control"
                   value="{{ old('effective_date', $formation?->effective_date?->format('Y-m-d')) }}" required>
            <small class="text-muted">Tanggal SK efektif berlaku.</small>
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
                <small class="text-muted">SK / surat tugas / berita acara.</small>
            @endif
        </div>

        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="2" class="form-control" placeholder="Misal: rencana mobilisasi, instruksi khusus.">{{ old('notes', $formation?->notes ?? '') }}</textarea>
        </div>
    </div>

    {{-- Items --}}
    <hr class="my-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="mb-0">Unit & Operator <small class="text-muted">(minimal 1 untuk diajukan)</small></h5>
            <small class="text-muted">Daftar unit yang ditetapkan beroperasi di SK ini. Unit tidak boleh dipilih lebih dari sekali.</small>
        </div>
        <button type="button" class="btn btn-soft-primary btn-sm" id="add-item-btn">
            <i class="ti ti-plus me-1"></i> Tambah Unit
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="items-table">
            <thead class="table-light">
                <tr class="text-uppercase small">
                    <th style="width:24%">Unit</th>
                    <th style="width:20%">Operator</th>
                    <th style="width:13%">HM Awal</th>
                    <th style="width:13%">Target HM/Bulan</th>
                    <th style="width:10%">Status</th>
                    <th>Catatan</th>
                    <th style="width:5%"></th>
                </tr>
            </thead>
            <tbody id="items-body">
                @php
                    $existingItems = $isEdit ? $formation->items : collect();
                @endphp
                @forelse($existingItems as $idx => $item)
                    @include('unit-formations._item_row', ['index' => $idx, 'item' => $item])
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i> Simpan Draft
        </button>
        <a href="{{ route('unit-formations.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>

<template id="item-row-template">
    @include('unit-formations._item_row', ['index' => '__INDEX__', 'item' => null])
</template>

@push('scripts')
<script>
(function() {
    const employeeSearchUrl = "{{ route('employees.search') }}";
    const unitSearchUrl     = "{{ route('units.search') }}";
    const projectContractsUrl = "{{ url('api/projects') }}";

    // ===== Contract dropdown =====
    function loadContracts(projectId, selectedId) {
        const $c = $('#contract_id');
        $c.html('<option value="">Loading...</option>');
        if (!projectId) {
            $c.html('<option value="">-- Pilih Proyek dulu --</option>');
            return;
        }
        $.getJSON(`${projectContractsUrl}/${projectId}/active-contracts`)
            .done(function(resp) {
                $c.html('<option value="">-- Pilih Kontrak --</option>');
                (resp.data || []).forEach(function(c) {
                    const sel = c.id == selectedId ? 'selected' : '';
                    $c.append(`<option value="${c.id}" ${sel}>${c.contract_number} (${c.start_date} → ${c.end_date})</option>`);
                });
            })
            .fail(function() { $c.html('<option value="">Gagal load kontrak</option>'); });
    }
    $('#project_id').on('change', function() { loadContracts($(this).val(), null); });

    @if($isEdit)
        loadContracts({{ $formation->project_id }}, {{ $formation->contract_id }});
    @elseif($preselectedProjectId)
        loadContracts({{ $preselectedProjectId }}, null);
    @endif

    // ===== Helpers =====
    function getSelectedUnitIdsExcept($currentSelect) {
        const currentId = parseInt($currentSelect.val()) || null;
        return $('#items-body select.js-unit-select')
            .map(function() { return parseInt($(this).val()) || null; })
            .get()
            .filter(id => id && id !== currentId);
    }

    function initUnitSelect2(idx) {
        const $select = $(`select[name="items[${idx}][equipment_unit_id]"]`);
        $select.select2({
            placeholder: 'Cari unit...',
            ajax: {
                url: unitSearchUrl,
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term || '', limit: 50 }),
                processResults: function(data) {
                    const excluded = getSelectedUnitIdsExcept($select);
                    return {
                        results: (data.data || [])
                            .filter(u => !excluded.includes(u.id))
                            .map(u => ({
                                id: u.id,
                                text: u.text || u.name,
                                name: u.name,
                                equipment_code: u.equipment_code,
                            }))
                    };
                }
            },
            width: '100%'
        }).on('select2:select', function(e) {
            const sel = e.params.data;
            const $row = $(this).closest('tr');
            $row.find('input[name$="[unit_name]"]').val(sel.name || '');
            $row.find('input[name$="[equipment_code]"]').val(sel.equipment_code || '');
        });
    }

    function initOperatorSelect2(idx) {
        const $select = $(`select[name="items[${idx}][assigned_operator_id]"]`);
        $select.select2({
            placeholder: 'Cari operator (opsional)...',
            allowClear: true,
            ajax: {
                url: employeeSearchUrl,
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term || '', limit: 50 }),
                processResults: function(data) {
                    return {
                        results: (data.data || []).map(e => ({
                            id: e.id, text: e.text, name: e.name,
                        }))
                    };
                }
            },
            width: '100%'
        }).on('select2:select', function(e) {
            const $row = $(this).closest('tr');
            $row.find('input[name$="[operator_name]"]').val(e.params.data.name || '');
        }).on('select2:clear', function() {
            const $row = $(this).closest('tr');
            $row.find('input[name$="[operator_name]"]').val('');
        });
    }

    // ===== Items repeater =====
    let itemIndex = {{ $existingItems->count() }};
    const tmpl = document.getElementById('item-row-template').innerHTML;

    function addItemRow() {
        const html = tmpl.replaceAll('__INDEX__', itemIndex);
        $('#items-body').append(html);
        initUnitSelect2(itemIndex);
        initOperatorSelect2(itemIndex);
        itemIndex++;
    }

    // Init existing rows
    $('#items-body select.js-unit-select').each(function() {
        const idx = $(this).attr('name').match(/items\[(\d+)\]/)[1];
        initUnitSelect2(idx);
        initOperatorSelect2(idx);
    });

    $('#add-item-btn').on('click', addItemRow);

    $(document).on('click', '.remove-item-btn', function() {
        $(this).closest('tr').remove();
    });

    @if(!$isEdit)
        addItemRow();
    @endif

    // ===== Numeric formatter (HM input — no thousand separator, integer only) =====
    function formatNumeric(value) {
        const digits = String(value).replace(/\D/g, '');
        return digits.replace(/^0+/, '') || '0';
    }
    function parseNumeric(value) {
        return String(value).replace(/\D/g, '') || '0';
    }

    $(document).on('input', '.js-rupiah-input', function() {
        const el = this;
        const cursor = el.selectionStart;
        el.value = formatNumeric(el.value);
        try { el.setSelectionRange(cursor, cursor); } catch(e) {}
    });

    $(document).on('blur', '.js-rupiah-input', function() {
        $(this).val(formatNumeric(parseNumeric($(this).val())));
    });

    $('#formation-form').on('submit', function() {
        $(this).find('.js-rupiah-input').each(function() {
            $(this).val(parseNumeric($(this).val()));
        });
    });

    // Format initial values (handle decimal from DB)
    $('.js-rupiah-input').each(function() {
        const val = $(this).val();
        if (!val) { $(this).val('0'); return; }
        const num = parseFloat(val);
        $(this).val(isNaN(num) ? '0' : Math.round(num).toString());
    });
})();
</script>
@endpush
