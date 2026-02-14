<?php $page = 'scoring'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Scoring Reference</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Scoring</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#add_scoring_offcanvas">
                            <i class="ti ti-plus-circle me-2"></i>Add Scoring
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Scoring List -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Scoring List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kebutuhan</th>
                                    <th>Skor Min</th>
                                    <th>Skor Max</th>
                                    <th>Bobot</th>
                                    <th>Departemen</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AJAX DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Scoring List -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Scoring Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_scoring_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add Scoring Reference</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('scoring.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Kebutuhan <span class="text-danger">*</span></label>
                            <input type="text" name="kebutuhan" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Skor Min <span class="text-danger">*</span></label>
                                    <input type="number" name="skor_min" class="form-control numeric-input" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Skor Max <span class="text-danger">*</span></label>
                                    <input type="number" name="skor_max" class="form-control numeric-input" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Bobot (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="bobot" class="form-control numeric-input" min="0" max="100" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan Skor</label>
                            <textarea name="keterangan_skor" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Departemen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_departemen" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-3">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Scoring</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add Scoring Offcanvas -->

    <!-- Edit Scoring Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_scoring_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit Scoring Reference</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="edit_scoring_form" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Kebutuhan <span class="text-danger">*</span></label>
                            <input type="text" name="kebutuhan" id="edit_kebutuhan" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Skor Min <span class="text-danger">*</span></label>
                                    <input type="number" name="skor_min" id="edit_skor_min" class="form-control numeric-input" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Skor Max <span class="text-danger">*</span></label>
                                    <input type="number" name="skor_max" id="edit_skor_max" class="form-control numeric-input" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Bobot (%) <span class="text-danger">*</span></label>
                                    <input type="number" name="bobot" id="edit_bobot" class="form-control numeric-input" min="0" max="100" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan Skor</label>
                            <textarea name="keterangan_skor" id="edit_keterangan_skor" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Departemen <span class="text-danger">*</span></label>
                            <input type="text" name="nama_departemen" id="edit_nama_departemen" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-3">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Scoring</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit Scoring Offcanvas -->

    <!-- Hidden Delete Form -->
    <form id="delete_scoring_form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('.ajax-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('scoring.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'kebutuhan', name: 'kebutuhan'},
                    {data: 'skor_min', name: 'skor_min'},
                    {data: 'skor_max', name: 'skor_max'},
                    {data: 'bobot', name: 'bobot'},
                    {data: 'nama_departemen', name: 'nama_departemen'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Edit Scoring (Event delegation)
            $('body').on('click', '.edit-scoring-btn', function() {
                var id = $(this).data('id');
                var kebutuhan = $(this).data('kebutuhan');
                var skor_min = $(this).data('skor_min');
                var skor_max = $(this).data('skor_max');
                var bobot = $(this).data('bobot');
                var keterangan_skor = $(this).data('keterangan_skor');
                var nama_departemen = $(this).data('nama_departemen');
                
                $('#edit_kebutuhan').val(kebutuhan);
                $('#edit_skor_min').val(skor_min);
                $('#edit_skor_max').val(skor_max);
                $('#edit_bobot').val(bobot);
                $('#edit_keterangan_skor').val(keterangan_skor);
                $('#edit_nama_departemen').val(nama_departemen);
                $('#edit_scoring_form').attr('action', '/scoring/' + id);
            });

            // Delete Scoring
            $('body').on('click', '.delete-scoring-btn', function() {
                var id = $(this).data('id');
                var deleteForm = $('#delete_scoring_form');
                
                deleteForm.attr('action', '/scoring/' + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });

            // Toast Configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            @if($errors->any())
                Toast.fire({
                    icon: 'error',
                    title: '{{ $errors->first() }}'
                });
            @endif

            // Loading Indicator
            $('form').on('submit', function() {
                var btn = $(this).find('button[type="submit"]');
                if (btn.length > 0) {
                    btn.prop('disabled', true);
                    btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');
                }
            });

            // Numeric-only validation
            $('.numeric-input').on('keydown', function(e) {
                // Allow backspace, tab, enter, escape, delete
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        return;
                }
                // Ensure it is a number and stop the keydown
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });
    </script>
    @endpush

@endsection
