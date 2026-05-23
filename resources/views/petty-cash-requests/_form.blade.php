@php
    $r = $pettyCashRequest ?? null;
    $isEdit = $r !== null;
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-cash me-1"></i>Data Permintaan</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Proyek <span class="text-danger">*</span></label>
                        <select name="project_id" class="form-select select2" required @if($isEdit && !$r->canEdit()) disabled @endif>
                            <option value="">-- Pilih Proyek --</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}" @selected(old('project_id', $r?->project_id ?? ($preselectedProjectId ?? null)) == $p->id)>{{ $p->project_code }} — {{ $p->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Permintaan <span class="text-danger">*</span></label>
                        <input type="date" name="request_date" class="form-control" required
                               value="{{ old('request_date', optional($r?->request_date)->format('Y-m-d') ?: now()->toDateString()) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Uraian Permintaan <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $r?->description) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nominal Permintaan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="requested_amount" id="requested_amount" class="form-control js-rupiah" required
                                   value="{{ old('requested_amount', $r?->requested_amount ? (int)$r->requested_amount : '') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">File Lampiran Permintaan</label>
                        @if($isEdit && $r->attachment_path)
                            <div class="mb-1 small">
                                <a href="{{ route('petty-cash-requests.attachment', $r->uid) }}" target="_blank" class="link-primary">
                                    <i class="ti ti-paperclip me-1"></i>Lihat lampiran saat ini
                                </a>
                                <span class="text-muted">— upload baru akan menimpa.</span>
                            </div>
                        @endif
                        <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                        <small class="text-muted">PDF / Gambar / Word / Excel (max 10MB).</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary w-100"><i class="ti ti-device-floppy me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Permintaan' }}</button>
                <a href="{{ $isEdit ? route('petty-cash-requests.show', $r->uid) : route('petty-cash-requests.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    $(function () {
        if (typeof $.fn.select2 === 'function') {
            $('.select2').select2({ width: '100%' });
        }
        // Rupiah formatter
        $('.js-rupiah').each(function () {
            const $i = $(this);
            const format = v => {
                const n = String(v).replace(/\D/g, '');
                return n ? new Intl.NumberFormat('id-ID').format(n) : '';
            };
            $i.val(format($i.val()));
            $i.on('input', function () {
                const pos = this.selectionStart;
                const old = this.value;
                const formatted = format(old);
                this.value = formatted;
                const diff = formatted.length - old.length;
                this.setSelectionRange(pos + diff, pos + diff);
            });
            // Strip non-digits on submit
            $i.closest('form').on('submit', function () {
                $i.val(String($i.val()).replace(/\D/g, ''));
            });
        });
    });
})();
</script>
@endpush
