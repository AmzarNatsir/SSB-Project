<?php $page = 'project-sub-category'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Project Sub Categories</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Project Sub Categories</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#add_sub_category_offcanvas">
                            <i class="ti ti-plus-circle me-2"></i>Add Sub Category
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Guardians of the Galaxy -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Project Sub Category List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Code</th>
                                    <th>Name</th>
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
            <!-- /Guardians of the Galaxy -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Sub Category Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_sub_category_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add Project Sub Category</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('project-sub-category.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="select form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                    <button type="submit" class="btn btn-primary">Save Sub Category</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add Sub Category Offcanvas -->

    <!-- Edit Sub Category Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_sub_category_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit Project Sub Category</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="edit_sub_category_form" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="edit_category_id" class="select form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                    <button type="submit" class="btn btn-primary">Update Sub Category</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit Sub Category Offcanvas -->

    <!-- Hidden Delete Form -->
    <form id="delete_sub_category_form" method="POST" style="display: none;">
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
                ajax: "{{ route('project-sub-category.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'category_name', name: 'category.name'},
                    {data: 'code', name: 'code'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Edit Sub Category
            $('body').on('click', '.edit-sub-category-btn', function() {
                var id = $(this).data('id');
                var categoryId = $(this).data('category-id');
                var code = $(this).data('code');
                var name = $(this).data('name');
                
                $('#edit_code').val(code);
                $('#edit_name').val(name);
                
                // Select2 update (if using select2 class, trigger change)
                $('#edit_category_id').val(categoryId).trigger('change');
                
                $('#edit_sub_category_form').attr('action', '/project-sub-category/' + id);
            });

            // Delete Sub Category
            $('body').on('click', '.delete-sub-category-btn', function() {
                var id = $(this).data('id');
                var deleteForm = $('#delete_sub_category_form');
                
                deleteForm.attr('action', '/project-sub-category/' + id);

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
