{{--
    Shared form partial for create & edit Timesheet.
    Required vars: $projects. Optional: $journal, $preselectedProjectId, $preselectedDate
--}}
@php
    $journal = $journal ?? null;
    $preselectedProjectId = $preselectedProjectId ?? null;
    $preselectedDate = $preselectedDate ?? null;
    $isEdit = $journal !== null;
    $action = $isEdit
        ? route('timesheets.update', $journal->uid)
        : route('timesheets.store');
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

<form action="{{ $action }}" method="POST" id="timesheet-form">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-5">
            <label class="form-label">Proyek <span class="text-danger">*</span></label>
            <select name="project_id" id="project_id" class="form-select" required @if($isEdit) disabled @endif>
                <option value="">-- Pilih Proyek --</option>
                @foreach($projects as $p)
                    <option value="{{ $p->id }}"
                        @selected(old('project_id', $journal?->project_id ?? $preselectedProjectId) == $p->id)>
                        {{ $p->project_code }} — {{ $p->project_name }}
                    </option>
                @endforeach
            </select>
            @if($isEdit)
                <input type="hidden" name="project_id" value="{{ $journal->project_id }}">
                <small class="text-muted">Proyek tidak bisa diubah setelah jurnal dibuat.</small>
            @endif
        </div>

        <div class="col-md-3">
            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
            <input type="date" name="journal_date" id="journal_date" class="form-control"
                   value="{{ old('journal_date', $journal?->journal_date?->format('Y-m-d') ?? $preselectedDate) }}"
                   required @if($isEdit) readonly @endif>
        </div>

        <div class="col-md-2">
            <label class="form-label">Shift <span class="text-danger">*</span></label>
            <select name="shift" id="shift" class="form-select" required @if($isEdit) disabled @endif>
                <option value="DAY" @selected(old('shift', $journal?->shift ?? 'DAY') === 'DAY')>Day</option>
                <option value="NIGHT" @selected(old('shift', $journal?->shift ?? '') === 'NIGHT')>Night</option>
            </select>
            @if($isEdit)
                <input type="hidden" name="shift" value="{{ $journal->shift }}">
            @endif
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <div class="text-muted small">
                Combo unik: Proyek + Tanggal + Shift
            </div>
        </div>

        <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="2" class="form-control" placeholder="Misal: kondisi cuaca, kejadian khusus.">{{ old('notes', $journal?->notes ?? '') }}</textarea>
        </div>
    </div>

    <hr class="my-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="mb-0">Entries <small class="text-muted">(1 baris = 1 unit, minimal 1 untuk diajukan)</small></h5>
            <small class="text-muted">Hanya unit dari SK Penetapan Unit AKTIF di proyek ini yang muncul. Unit tidak boleh duplikat.</small>
        </div>
        <button type="button" class="btn btn-soft-primary btn-sm" id="add-entry-btn">
            <i class="ti ti-plus me-1"></i> Tambah Entry
        </button>
    </div>

    <div id="entries-body">
        @php $existingEntries = $isEdit ? $journal->entries : collect(); @endphp
        @forelse($existingEntries as $idx => $entry)
            @include('timesheets._entry_row', ['index' => $idx, 'entry' => $entry])
        @empty
        @endforelse
    </div>

    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i> Simpan Draft
        </button>
        <a href="{{ route('timesheets.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>

<template id="entry-row-template">
    @include('timesheets._entry_row', ['index' => '__INDEX__', 'entry' => null])
</template>

@push('scripts')
<script>
(function() {
    const availableUnitsUrl = "{{ route('timesheets.available-units') }}";

    // Cache unit options dari server (refresh saat project/date berubah)
    let availableUnits = [];

    function reloadAvailableUnits() {
        const projectId = $('#project_id').val();
        const date = $('#journal_date').val();
        if (!projectId || !date) return;

        $.getJSON(availableUnitsUrl, { project_id: projectId, date: date })
            .done(function(resp) {
                availableUnits = resp.data || [];
                // Re-render dropdown di semua row
                $('#entries-body select.js-unit-select').each(function() {
                    refreshUnitOptions($(this));
                });
            })
            .fail(function() {
                availableUnits = [];
            });
    }

    function getSelectedUnitIdsExcept($currentSelect) {
        const currentId = parseInt($currentSelect.val()) || null;
        return $('#entries-body select.js-unit-select')
            .map(function() { return parseInt($(this).val()) || null; })
            .get()
            .filter(id => id && id !== currentId);
    }

    function refreshUnitOptions($select) {
        const currentVal = $select.val();
        const excluded = getSelectedUnitIdsExcept($select);

        $select.empty().append('<option value="">-- Pilih Unit --</option>');
        availableUnits.forEach(function(u) {
            if (excluded.includes(u.id) && u.id != currentVal) return;
            const sel = u.id == currentVal ? 'selected' : '';
            $select.append(`<option value="${u.id}" ${sel}>${u.text}</option>`);
        });
    }

    // Saat user buka dropdown, refresh option (exclude unit yang sudah dipilih di row lain)
    $(document).on('focus', '#entries-body select.js-unit-select', function() {
        refreshUnitOptions($(this));
    });

    $('#project_id, #journal_date').on('change', function() {
        reloadAvailableUnits();
    });

    // ===== Entry cards =====
    let entryIndex = {{ $existingEntries->count() }};
    const tmpl = document.getElementById('entry-row-template').innerHTML;

    function addEntryRow() {
        const html = tmpl.replaceAll('__INDEX__', entryIndex);
        $('#entries-body').append(html);
        const $newSelect = $('#entries-body .js-entry-card').last().find('select.js-unit-select');
        refreshUnitOptions($newSelect);
        entryIndex++;
    }

    $('#add-entry-btn').on('click', addEntryRow);

    $(document).on('click', '.remove-entry-btn', function() {
        $(this).closest('.js-entry-card').remove();
    });

    // ===== Auto-calculate hours from start/end time =====
    // Logic: hitung selisih jam (end - start). Handle kasus overnight (end < start) →
    // anggap end di hari berikutnya, tambah 24 jam.
    function diffHours(startStr, endStr) {
        if (!startStr || !endStr) return 0;
        const [sh, sm] = startStr.split(':').map(Number);
        const [eh, em] = endStr.split(':').map(Number);
        let mins = (eh * 60 + em) - (sh * 60 + sm);
        if (mins < 0) mins += 24 * 60; // overnight shift
        return +(mins / 60).toFixed(2);
    }

    $(document).on('change input', '.js-time-input', function() {
        const $card = $(this).closest('.js-entry-card');
        const targetName = $(this).data('target'); // working_hours / idle_hours / breakdown_hours
        if (!targetName) return;

        // Cari kedua input start & end di card ini berdasarkan data-target sama
        const $inputs = $card.find(`.js-time-input[data-target="${targetName}"]`);
        const start = $inputs.eq(0).val();
        const end = $inputs.eq(1).val();

        const hours = diffHours(start, end);
        $card.find(`input[data-name="${targetName}"]`).val(hours.toFixed(2));
    });

    // ===== Auto-calculate HM total =====
    $(document).on('change input', '.js-hm-start, .js-hm-end', function() {
        const $card = $(this).closest('.js-entry-card');
        const start = parseFloat($card.find('.js-hm-start').val()) || 0;
        const end = parseFloat($card.find('.js-hm-end').val()) || 0;
        const total = Math.max(0, end - start);
        $card.find('.js-hm-total').val(total.toFixed(2));
    });

    // Initial load
    reloadAvailableUnits();
    @if(!$isEdit)
        setTimeout(addEntryRow, 100);
    @endif
})();
</script>
@endpush
