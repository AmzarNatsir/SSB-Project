<?php $page = 'scoring_plan_project'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Scoring Plan Project</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Scoring Plan Project</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <button class="btn btn-info d-flex align-items-center" id="viewAllDataBtn">
                            <i class="ti ti-eye me-2"></i>View All Data
                        </button>
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('scoring-plan-project.export-pdf') }}" target="_blank" class="btn btn-danger d-flex align-items-center">
                            <i class="ti ti-file-type-pdf me-2"></i>Export PDF
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('scoring-plan-project.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="ti ti-plus-circle me-2"></i>Add Scoring Plan Project
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- List -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Scoring Plan Project List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kriteria (Name)</th>
                                    <th>Bobot (Weighting)</th>
                                    <th>Jumlah Opsi Detail</th>
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
            <!-- /List -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Full View Modal -->
    <div class="modal fade" id="fullViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold text-center w-100 fs-4">SCORING PLAN PROJECT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive" id="fullViewContent">
                        <div class="text-center p-5"><span class="spinner-border text-primary"></span></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('.ajax-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('scoring-plan-project.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'weighting', name: 'weighting'},
                    {data: 'options_count', name: 'options_count', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Delete confirmation
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data Scoring Plan Project ini akan dihapus permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
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

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            @endif

            // View All Data Modal
            $('#viewAllDataBtn').click(function() {
                $('#fullViewModal').modal('show');
                $('#fullViewContent').html('<div class="text-center p-5"><span class="spinner-border text-primary"></span> Loading data...</div>');
                
                $.get("{{ route('scoring-plan-project.full-view') }}", function(data) {
                    $('#fullViewContent').html(data);
                }).fail(function() {
                    $('#fullViewContent').html('<div class="alert alert-danger m-3 text-center">Failed to load data. Please try again.</div>');
                });
            });
        });
    </script>
    @endpush

@endsection
