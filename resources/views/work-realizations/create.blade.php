@extends('layout.mainlayout')
@section('title', 'Generate Work Realization')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Generate Work Realization</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('work-realizations.index') }}">Work Realization</a></li>
                        <li class="breadcrumb-item active">Generate</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-info-subtle border-info-subtle">
            <i class="ti ti-info-circle me-1"></i>
            Generate akan menarik data otomatis dari <strong>Timesheet berstatus Disetujui</strong> dalam periode yang dipilih. Item per unit di-agregasi (sum HM), tarif baseline diambil dari Contract Item. Setelah generate, Anda bisa edit penyesuaian tarif & upload lampiran.
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('work-realizations.store') }}" method="POST" enctype="multipart/form-data" id="generate-form">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Proyek <span class="text-danger">*</span></label>
                            <select name="project_id" id="project_id" class="form-select" required>
                                <option value="">-- Pilih Proyek --</option>
                                @foreach($projects as $p)
                                    <option value="{{ $p->id }}" @selected(old('project_id', $preselectedProjectId) == $p->id)>
                                        {{ $p->project_code }} — {{ $p->project_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kontrak (opsional)</label>
                            <select name="contract_id" id="contract_id" class="form-select">
                                <option value="">-- Pilih Kontrak --</option>
                            </select>
                            <small class="text-muted">Auto-load setelah pilih proyek. Bisa dikosongkan kalau tidak relevan.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Periode Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="period_start" class="form-control" value="{{ old('period_start', $defaultStart) }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Periode Sampai <span class="text-danger">*</span></label>
                            <input type="date" name="period_end" class="form-control" value="{{ old('period_end', $defaultEnd) }}" required>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <small class="text-muted">Default: bulan berjalan. Bisa disesuaikan untuk periode mingguan, bulanan, atau custom.</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" rows="2" class="form-control" placeholder="Opsional, misal: penjelasan periode atau referensi BA.">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Lampiran (Opsional saat Generate, bisa upload setelah)</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Laporan PA &amp; MA <small class="text-muted">(Workshop)</small></label>
                            <input type="file" name="pa_ma_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Laporan Safety Plan <small class="text-muted">(HSE)</small></label>
                            <input type="file" name="safety_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Berita Acara</label>
                            <input type="file" name="berita_acara_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-bolt me-1"></i> Generate &amp; Buat Draft
                        </button>
                        <a href="{{ route('work-realizations.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const projectContractsUrl = "{{ url('api/work-realizations/project') }}";

    function loadContracts(projectId, selectedId) {
        const $c = $('#contract_id');
        $c.html('<option value="">Loading...</option>');
        if (!projectId) {
            $c.html('<option value="">-- Pilih Proyek dulu --</option>');
            return;
        }
        $.getJSON(`${projectContractsUrl}/${projectId}/contracts`)
            .done(function(resp) {
                $c.html('<option value="">-- Pilih Kontrak --</option>');
                (resp.data || []).forEach(function(c) {
                    const sel = c.id == selectedId ? 'selected' : '';
                    $c.append(`<option value="${c.id}" ${sel}>${c.contract_number} (${c.status})</option>`);
                });
            })
            .fail(function() { $c.html('<option value="">Gagal load kontrak</option>'); });
    }

    $('#project_id').on('change', function() { loadContracts($(this).val(), null); });

    @if($preselectedProjectId)
        loadContracts({{ $preselectedProjectId }}, null);
    @endif
})();
</script>
@endpush
@endsection
