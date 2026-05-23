@php
    $p = $pettyCashPurchase ?? null;
    $isEdit = $p !== null;
    $lockRequest = $isEdit;
@endphp
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="ti ti-shopping-cart me-1"></i>Data Pembelian Tunai</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    @if(! $lockRequest)
                        <div class="col-md-12">
                            <label class="form-label">Permintaan Kas Kecil <span class="text-danger">*</span></label>
                            <select name="petty_cash_request_id" id="petty_cash_request_id" class="form-select select2" required>
                                <option value="">-- Pilih Permintaan --</option>
                                @foreach($availableRequests as $req)
                                    <option value="{{ $req->id }}"
                                        data-project="{{ $req->project->project_name ?? '-' }}"
                                        data-project-code="{{ $req->project->project_code ?? '-' }}"
                                        data-requested="{{ $req->requested_amount }}"
                                        data-used="{{ $req->used_amount }}"
                                        data-remaining="{{ $req->remaining_amount }}"
                                        @selected(old('petty_cash_request_id', $preselectedRequestId) == $req->id)>
                                        {{ $req->request_number }} — {{ $req->project->project_name ?? '-' }} (Sisa: Rp {{ number_format($req->remaining_amount, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hanya Permintaan dengan status Disetujui dan masih punya sisa saldo.</small>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info-subtle border-info-subtle mb-0 d-none" id="reqPreview">
                                <div class="row small">
                                    <div class="col-md-6"><strong>Proyek:</strong> <span data-field="project">-</span></div>
                                    <div class="col-md-6"><strong>Kode Proyek:</strong> <span data-field="project-code">-</span></div>
                                    <div class="col-md-4"><strong>Diminta:</strong> Rp <span data-field="requested">0</span></div>
                                    <div class="col-md-4"><strong>Terpakai:</strong> Rp <span data-field="used">0</span></div>
                                    <div class="col-md-4"><strong>Sisa:</strong> <span class="fw-bold text-success">Rp <span data-field="remaining">0</span></span></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12">
                            <label class="form-label text-muted">Permintaan Kas Kecil (terkunci)</label>
                            <div class="alert alert-info-subtle border-info-subtle mb-0">
                                <strong>{{ $p->request->request_number }}</strong> — {{ $p->request->project->project_name ?? '-' }}
                                <div class="small text-muted">Sisa saldo permintaan: Rp {{ number_format($p->request->remaining_amount, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pembelian <span class="text-danger">*</span></label>
                        <input type="date" name="purchase_date" class="form-control" required
                               value="{{ old('purchase_date', optional($p?->purchase_date)->format('Y-m-d') ?: now()->toDateString()) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Pesanan Pembelian (PO)</label>
                        <input type="text" name="purchase_order_number" class="form-control" maxlength="100"
                               value="{{ old('purchase_order_number', $p?->purchase_order_number) }}"
                               placeholder="Isi manual (modul Warehouse menyusul)">
                        <small class="text-muted">Opsional, akan menjadi FK ketika modul Warehouse aktif.</small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Uraian Pembelian <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $p?->description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Biaya (tambahan, jika ada)</label>
                        <select name="expense_category_id" class="form-select select2">
                            <option value="">— Tidak ada / pilih jika perlu —</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" @selected(old('expense_category_id', $p?->expense_category_id) == $c->id)>{{ $c->code }} — {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nominal Pembelian <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="amount" id="amount" class="form-control js-rupiah" required
                                   value="{{ old('amount', $p?->amount ? (int)$p->amount : '') }}">
                        </div>
                        <small class="text-muted" id="amount-warning"></small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">File Lampiran (Nota / Kwitansi)</label>
                        @if($isEdit && $p->attachment_path)
                            <div class="mb-1 small">
                                <a href="{{ route('petty-cash-purchases.attachment', $p->uid) }}" target="_blank" class="link-primary">
                                    <i class="ti ti-paperclip me-1"></i>Lihat lampiran saat ini
                                </a>
                                <span class="text-muted">— upload baru akan menimpa.</span>
                            </div>
                        @endif
                        <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary w-100"><i class="ti ti-device-floppy me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pembelian' }}</button>
                <a href="{{ $isEdit ? route('petty-cash-purchases.show', $p->uid) : route('petty-cash-purchases.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    function fmt(n) { return new Intl.NumberFormat('id-ID').format(Math.round(n)); }

    $(function () {
        if (typeof $.fn.select2 === 'function') $('.select2').select2({ width: '100%' });

        $('.js-rupiah').each(function () {
            const $i = $(this);
            const format = v => { const n = String(v).replace(/\D/g, ''); return n ? new Intl.NumberFormat('id-ID').format(n) : ''; };
            $i.val(format($i.val()));
            $i.on('input', function () {
                const pos = this.selectionStart, old = this.value, formatted = format(old);
                this.value = formatted;
                const diff = formatted.length - old.length;
                this.setSelectionRange(pos + diff, pos + diff);
                checkAmount();
            });
            $i.closest('form').on('submit', function () { $i.val(String($i.val()).replace(/\D/g, '')); });
        });

        const $req = $('#petty_cash_request_id');
        const $preview = $('#reqPreview');

        function updatePreview() {
            const sel = $req.find(':selected');
            if (!sel.val()) { $preview.addClass('d-none'); return; }
            $preview.removeClass('d-none');
            $preview.find('[data-field="project"]').text(sel.data('project') || '-');
            $preview.find('[data-field="project-code"]').text(sel.data('project-code') || '-');
            $preview.find('[data-field="requested"]').text(fmt(sel.data('requested') || 0));
            $preview.find('[data-field="used"]').text(fmt(sel.data('used') || 0));
            $preview.find('[data-field="remaining"]').text(fmt(sel.data('remaining') || 0));
        }
        function checkAmount() {
            const $w = $('#amount-warning');
            const sel = $req.find(':selected');
            const remaining = parseFloat(sel.data('remaining')) || 0;
            const amount = parseFloat(String($('#amount').val()).replace(/\D/g, '')) || 0;
            if (sel.val() && amount > remaining) {
                $w.text('Nominal melebihi sisa permintaan (Rp ' + fmt(remaining) + ')').addClass('text-danger').removeClass('text-muted');
            } else {
                $w.text('').removeClass('text-danger');
            }
        }
        if ($req.length) {
            $req.on('change', function () { updatePreview(); checkAmount(); });
            updatePreview();
            checkAmount();
        }
    });
})();
</script>
@endpush
