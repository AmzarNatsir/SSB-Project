@extends('layout.mainlayout')
@section('title', 'Master Jenis Biaya')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Master Jenis Biaya (Petty Cash)</h3>
                <p class="text-muted small mb-0">Kategori biaya untuk Pembayaran & Pembelian Kas Kecil.</p>
                <nav class="mt-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Jenis Biaya</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button class="btn btn-primary btn-label" data-bs-toggle="modal" data-bs-target="#categoryModal" data-mode="create">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i>Tambah Jenis Biaya
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header border-bottom-dashed">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode / nama...">
                    </div>
                    <div class="col-md-3">
                        <select name="is_active" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" @selected(request('is_active') === '1')>Aktif</option>
                            <option value="0" @selected(request('is_active') === '0')>Non-aktif</option>
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button class="btn btn-outline-primary"><i class="ti ti-search me-1"></i>Filter</button>
                        <a href="{{ route('petty-cash-categories.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-nowrap align-middle">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $cat)
                            <tr>
                                <td class="fw-medium">{{ $cat->code }}</td>
                                <td>{{ $cat->name }}</td>
                                <td><span class="text-muted">{{ \Illuminate\Support\Str::limit($cat->description, 80) }}</span></td>
                                <td>
                                    @if($cat->is_active)
                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Non-aktif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-soft-primary btn-sm js-edit"
                                        data-uid="{{ $cat->uid }}"
                                        data-code="{{ $cat->code }}"
                                        data-name="{{ $cat->name }}"
                                        data-description="{{ $cat->description }}"
                                        data-is-active="{{ $cat->is_active ? 1 : 0 }}">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <form action="{{ route('petty-cash-categories.destroy', $cat->uid) }}" method="POST" class="d-inline js-confirm-form"
                                          data-title="Hapus Jenis Biaya?" data-text="{{ $cat->code }} - {{ $cat->name }}" data-icon="warning"
                                          data-confirm-text="Ya, Hapus" data-confirm-color="#dc2626">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-soft-danger btn-sm" type="submit"><i class="ti ti-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada Jenis Biaya. Klik Tambah untuk membuat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="categoryForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST" id="formMethod">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalTitle">Tambah Jenis Biaya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="fld_code" class="form-control" required maxlength="30" placeholder="BBM / KONSUMSI / ATK">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="fld_name" class="form-control" required maxlength="150">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="fld_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="fld_is_active" value="1" checked>
                        <label class="form-check-label" for="fld_is_active">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i>Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const $modal = $('#categoryModal');
    const $form = $('#categoryForm');
    const storeUrl = "{{ route('petty-cash-categories.index') }}";

    $modal.on('show.bs.modal', function (e) {
        const trigger = e.relatedTarget;
        if (trigger && $(trigger).data('mode') === 'create') {
            $('#categoryModalTitle').text('Tambah Jenis Biaya');
            $form.attr('action', storeUrl);
            $('#formMethod').val('POST');
            $form[0].reset();
            $('#fld_is_active').prop('checked', true);
        }
    });

    $('.js-edit').on('click', function () {
        const $btn = $(this);
        $('#categoryModalTitle').text('Edit Jenis Biaya');
        $form.attr('action', storeUrl + '/' + $btn.data('uid'));
        $('#formMethod').val('PUT');
        $('#fld_code').val($btn.data('code'));
        $('#fld_name').val($btn.data('name'));
        $('#fld_description').val($btn.data('description'));
        $('#fld_is_active').prop('checked', $btn.data('is-active') === 1);
        $modal.modal('show');
    });

    $(document).on('submit', '.js-confirm-form', function(e) {
        const $form = $(this);
        if ($form.data('confirmed') === true) return true;
        e.preventDefault();
        Swal.fire({
            title: $form.data('title') || 'Konfirmasi',
            text:  $form.data('text')  || 'Lanjutkan?',
            icon:  $form.data('icon')  || 'question',
            showCancelButton: true,
            confirmButtonText: $form.data('confirm-text') || 'Ya',
            cancelButtonText:  'Batal',
            confirmButtonColor: $form.data('confirm-color') || '#3b82f6',
            cancelButtonColor:  '#6b7280',
            reverseButtons: true,
            focusCancel: true,
        }).then(function(result) {
            if (result.isConfirmed) { $form.data('confirmed', true); $form.trigger('submit'); }
        });
    });
})();
</script>
@endpush
@endsection
