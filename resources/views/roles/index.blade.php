<?php $page = 'roles-permissions'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Roles & Permissions</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Roles</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#add_role_offcanvas">
                            <i class="ti ti-plus-circle me-2"></i>Add Role
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Role List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Role Name</th>
                                    <th>Permissions Count</th>
                                    <th style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AJAX DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Role Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_role_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add New Role</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('roles-permissions.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Role Name (e.g. Manager)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block mb-3">Sync Permissions</label>
                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                @foreach($permissions as $permission)
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                        <label class="form-check-label text-capitalize" for="perm_{{ $permission->id }}">
                                            {{ str_replace('_', ' ', $permission->name) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Role</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add Role Offcanvas -->

    <!-- Edit Role Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_role_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit Role</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="edit_role_form" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_role_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block mb-3">Sync Permissions</label>
                            <div class="row row-cols-1 row-cols-md-2 g-2" id="edit_permissions_container">
                                @foreach($permissions as $permission)
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input edit-perm-check" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="edit_perm_{{ $permission->id }}" data-name="{{ $permission->name }}">
                                        <label class="form-check-label text-capitalize" for="edit_perm_{{ $permission->id }}">
                                            {{ str_replace('_', ' ', $permission->name) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-4 pt-3 border-top">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Role</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit Role Offcanvas -->

    <form id="delete_role_form" method="POST" style="display: none;">
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
                ajax: "{{ route('roles-permissions.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'permissions_count', name: 'permissions_count'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Edit Role
            $('body').on('click', '.edit-role-btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var permissions = $(this).data('permissions').toString().split(',').filter(Boolean);
                
                $('#edit_role_name').val(name);
                $('#edit_role_form').attr('action', '/roles-permissions/' + id);
                
                // Clear and set checkboxes
                $('.edit-perm-check').prop('checked', false);
                permissions.forEach(function(permName) {
                    $('.edit-perm-check[data-name="' + permName + '"]').prop('checked', true);
                });
            });

            // Delete Role
            $('body').on('click', '.delete-role-btn', function() {
                var id = $(this).data('id');
                var deleteForm = $('#delete_role_form');
                
                deleteForm.attr('action', '/roles-permissions/' + id);

                Swal.fire({
                    title: "Delete role?",
                    text: "Users with this role will lose their associated permissions!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });

            // Notifications
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}'
                });
            @endif
        });
    </script>
    @endpush

@endsection
