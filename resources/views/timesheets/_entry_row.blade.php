{{--
    Card per entry. Required vars: $index, $entry (TimesheetEntry|null)
    Layout: 5 sections — Unit/Activity, HM, Operating, Idle, Breakdown, Production
--}}
<div class="card border mb-3 js-entry-card" data-index="{{ $index }}">
    <div class="card-header bg-light d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1 row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small mb-1">Unit <span class="text-danger">*</span></label>
                <select name="entries[{{ $index }}][unit_formation_item_id]" class="form-select form-select-sm js-unit-select" required>
                    @if($entry && $entry->unitFormationItem)
                        <option value="{{ $entry->unit_formation_item_id }}" selected>
                            {{ $entry->unit_name }}@if($entry->operator_name) — {{ $entry->operator_name }}@endif
                        </option>
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Aktivitas <span class="text-danger">*</span></label>
                <select name="entries[{{ $index }}][activity_code]" class="form-select form-select-sm" required>
                    @foreach(['HAULING','LOADING','IDLE','MAINTENANCE','STANDBY','BREAKDOWN'] as $a)
                        <option value="{{ $a }}" @selected(($entry?->activity_code ?? 'HAULING') === $a)>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-soft-danger btn-sm remove-entry-btn ms-2" title="Hapus entry">
            <i class="ti ti-trash"></i>
        </button>
    </div>
    <div class="card-body">
        {{-- Section 1: HM / KM --}}
        <h6 class="small text-muted text-uppercase mb-2 mt-0"><i class="ti ti-gauge me-1"></i> HM / KM</h6>
        <div class="row g-2 mb-3">
            <div class="col-md-3">
                <label class="form-label small mb-1">HM/KM Awal</label>
                <input type="number" step="0.01" min="0" class="form-control form-control-sm js-hm-start"
                       name="entries[{{ $index }}][hm_start]" value="{{ $entry?->hm_start ?? 0 }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">HM/KM Akhir</label>
                <input type="number" step="0.01" min="0" class="form-control form-control-sm js-hm-end"
                       name="entries[{{ $index }}][hm_end]" value="{{ $entry?->hm_end ?? 0 }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1 text-muted">Total HM/KM</label>
                <input type="text" class="form-control form-control-sm bg-light js-hm-total" readonly
                       value="{{ $entry ? number_format($entry->hm_total ?? 0, 2, '.', '') : '0.00' }}">
            </div>
        </div>

        {{-- Section 2: Operating --}}
        <h6 class="small text-muted text-uppercase mb-2"><i class="ti ti-clock-play me-1 text-success"></i> Operating</h6>
        <div class="row g-2 mb-3">
            <div class="col-md-3">
                <label class="form-label small mb-1">Jam Mulai</label>
                <input type="time" class="form-control form-control-sm js-time-input"
                       name="entries[{{ $index }}][operating_start_time]"
                       data-target="working_hours"
                       data-pair="entries[{{ $index }}][operating_end_time]"
                       value="{{ $entry?->operating_start_time }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Jam Selesai</label>
                <input type="time" class="form-control form-control-sm js-time-input"
                       name="entries[{{ $index }}][operating_end_time]"
                       data-target="working_hours"
                       data-pair="entries[{{ $index }}][operating_start_time]"
                       value="{{ $entry?->operating_end_time }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1 text-muted">Total Jam Operasi</label>
                <input type="number" step="0.01" min="0" max="24" class="form-control form-control-sm bg-light"
                       name="entries[{{ $index }}][working_hours]"
                       data-name="working_hours"
                       value="{{ $entry?->working_hours ?? 0 }}" readonly>
            </div>
        </div>

        {{-- Section 3: Idle/Standby --}}
        <h6 class="small text-muted text-uppercase mb-2"><i class="ti ti-clock-pause me-1 text-warning"></i> Idle / Standby</h6>
        <div class="row g-2 mb-3">
            <div class="col-md-3">
                <label class="form-label small mb-1">Jam Mulai</label>
                <input type="time" class="form-control form-control-sm js-time-input"
                       name="entries[{{ $index }}][idle_start_time]"
                       data-target="idle_hours"
                       data-pair="entries[{{ $index }}][idle_end_time]"
                       value="{{ $entry?->idle_start_time }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Jam Selesai</label>
                <input type="time" class="form-control form-control-sm js-time-input"
                       name="entries[{{ $index }}][idle_end_time]"
                       data-target="idle_hours"
                       data-pair="entries[{{ $index }}][idle_start_time]"
                       value="{{ $entry?->idle_end_time }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1 text-muted">Total Jam Idle</label>
                <input type="number" step="0.01" min="0" max="24" class="form-control form-control-sm bg-light"
                       name="entries[{{ $index }}][idle_hours]"
                       data-name="idle_hours"
                       value="{{ $entry?->idle_hours ?? 0 }}" readonly>
            </div>
            <div class="col-md-12">
                <label class="form-label small mb-1">Keterangan Standby/Idle</label>
                <input type="text" class="form-control form-control-sm"
                       name="entries[{{ $index }}][idle_reason]"
                       value="{{ $entry?->idle_reason }}"
                       placeholder="Misal: istirahat makan, tunggu material...">
            </div>
        </div>

        {{-- Section 4: Breakdown --}}
        <h6 class="small text-muted text-uppercase mb-2"><i class="ti ti-tool me-1 text-danger"></i> Breakdown</h6>
        <div class="row g-2 mb-3">
            <div class="col-md-3">
                <label class="form-label small mb-1">Jam Mulai</label>
                <input type="time" class="form-control form-control-sm js-time-input"
                       name="entries[{{ $index }}][breakdown_start_time]"
                       data-target="breakdown_hours"
                       data-pair="entries[{{ $index }}][breakdown_end_time]"
                       value="{{ $entry?->breakdown_start_time }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Jam Selesai</label>
                <input type="time" class="form-control form-control-sm js-time-input"
                       name="entries[{{ $index }}][breakdown_end_time]"
                       data-target="breakdown_hours"
                       data-pair="entries[{{ $index }}][breakdown_start_time]"
                       value="{{ $entry?->breakdown_end_time }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1 text-muted">Total Jam Breakdown</label>
                <input type="number" step="0.01" min="0" max="24" class="form-control form-control-sm bg-light"
                       name="entries[{{ $index }}][breakdown_hours]"
                       data-name="breakdown_hours"
                       value="{{ $entry?->breakdown_hours ?? 0 }}" readonly>
            </div>
            <div class="col-md-12">
                <label class="form-label small mb-1">Keterangan Breakdown</label>
                <input type="text" class="form-control form-control-sm"
                       name="entries[{{ $index }}][breakdown_reason]"
                       value="{{ $entry?->breakdown_reason }}"
                       placeholder="Misal: hose hidrolik bocor, ganti oli...">
            </div>
        </div>

        {{-- Section 5: Produksi --}}
        <h6 class="small text-muted text-uppercase mb-2"><i class="ti ti-droplet me-1 text-info"></i> Produksi & BBM</h6>
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small mb-1">BBM (Liter)</label>
                <input type="number" step="0.01" min="0" class="form-control form-control-sm"
                       name="entries[{{ $index }}][fuel_consumed_liter]" value="{{ $entry?->fuel_consumed_liter ?? 0 }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Trip</label>
                <input type="number" min="0" class="form-control form-control-sm"
                       name="entries[{{ $index }}][trip_count]" value="{{ $entry?->trip_count ?? 0 }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Tonase</label>
                <input type="number" step="0.01" min="0" class="form-control form-control-sm"
                       name="entries[{{ $index }}][tonnage]" value="{{ $entry?->tonnage ?? 0 }}">
            </div>
            <div class="col-md-12">
                <label class="form-label small mb-1">Catatan Lain</label>
                <input type="text" class="form-control form-control-sm"
                       name="entries[{{ $index }}][remarks]" value="{{ $entry?->remarks }}" placeholder="Opsional">
            </div>
        </div>
    </div>
</div>
