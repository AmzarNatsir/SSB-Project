<?php $page = 'project-category'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Project Categories</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Project Categories</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#add_category_offcanvas">
                            <i class="ti ti-plus-circle me-2"></i>Add Category
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Guardians of the Galaxy -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Project Category List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                <!-- AJAX DataTables -->
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Guardians of the Galaxy -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Category Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_category_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add Project Category</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('project-category.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add Category Offcanvas -->

    <!-- Edit Category Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_category_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit Project Category</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="edit_category_form" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="edit_code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit Category Offcanvas -->

    <!-- Hidden Delete Form -->
    <form id="delete_category_form" method="POST" style="display: none;">
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
                ajax: "{{ route('project-category.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Edit Category (Event delegation because elements are dynamic)
            $('body').on('click', '.edit-category-btn', function() {
                var id = $(this).data('id');
                var code = $(this).data('code');
                var name = $(this).data('name');
                
                $('#edit_code').val(code);
                $('#edit_name').val(name);
                $('#edit_category_form').attr('action', '/project-category/' + id);
            });

            // Delete Category
            $('body').on('click', '.delete-category-btn', function() {
                var id = $(this).data('id');
                var deleteForm = $('#delete_category_form');
                
                // Update form action
                deleteForm.attr('action', '/project-category/' + id);

                // SweetAlert2 Confirmation
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
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Notification for success/error
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
            // Loading Indicator on Form Submit
            $('form').on('submit', function() {
                var btn = $(this).find('button[type="submit"]');
                if (btn.length > 0) {
                    var originalText = btn.text();
                    btn.prop('disabled', true);
                    btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');
                }
            });
        });
    </script>
    @endpush

@endsection
