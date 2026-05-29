<?php $page = 'manage-users'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">User Management</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#add_user_offcanvas">
                            <i class="ti ti-user-plus me-2"></i>Add User
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">User List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
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

    <!-- Add User Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_user_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add New User</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('manage-users.store') }}" method="POST" id="add_user_form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Pilih Karyawan <span class="text-danger">*</span></label>
                            <select name="employee_id" id="add_employee_id" class="form-control employee-select" required data-placeholder="Cari karyawan dari HRD..."></select>
                            <small class="text-muted">Sumber data: master karyawan HRD</small>
                        </div>

                        <div class="card border bg-light mb-3 d-none" id="add_employee_preview">
                            <div class="card-body p-3">
                                <h6 class="mb-2 text-primary"><i class="ti ti-user-check me-1"></i>Informasi Karyawan</h6>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td width="30%"><strong>NIK</strong></td><td>: <span class="emp-nik">-</span></td></tr>
                                    <tr><td><strong>Nama</strong></td><td>: <span class="emp-name">-</span></td></tr>
                                    <tr><td><strong>Email</strong></td><td>: <span class="emp-email">-</span></td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="mb-3 d-none" id="add_email_manual_wrap">
                            <label class="form-label">Email Manual <span class="text-danger">*</span></label>
                            <input type="email" name="email_manual" class="form-control" placeholder="email@example.com">
                            <small class="text-danger">Karyawan ini tidak memiliki email di HRD, isi manual.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Min 8 karakter" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign Roles</label>
                            <select name="roles[]" class="form-control select2-roles" multiple data-placeholder="Choose Roles">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add User Offcanvas -->

    <!-- Edit User Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_user_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit User</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="edit_user_form" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Pilih Karyawan <span class="text-danger">*</span></label>
                            <select name="employee_id" id="edit_employee_id" class="form-control employee-select" required data-placeholder="Cari karyawan dari HRD..."></select>
                            <small class="text-muted">Sumber data: master karyawan HRD</small>
                        </div>

                        <div class="card border bg-light mb-3 d-none" id="edit_employee_preview">
                            <div class="card-body p-3">
                                <h6 class="mb-2 text-primary"><i class="ti ti-user-check me-1"></i>Informasi Karyawan</h6>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr><td width="30%"><strong>NIK</strong></td><td>: <span class="emp-nik">-</span></td></tr>
                                    <tr><td><strong>Nama</strong></td><td>: <span class="emp-name">-</span></td></tr>
                                    <tr><td><strong>Email</strong></td><td>: <span class="emp-email">-</span></td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="mb-3 d-none" id="edit_email_manual_wrap">
                            <label class="form-label">Email Manual <span class="text-danger">*</span></label>
                            <input type="email" name="email_manual" class="form-control" placeholder="email@example.com">
                            <small class="text-danger">Karyawan ini tidak memiliki email di HRD, isi manual.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <small class="text-muted">(Kosongkan untuk tidak ganti)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="Password baru">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign Roles</label>
                            <select name="roles[]" id="edit_roles" class="form-control select2-roles" multiple data-placeholder="Choose Roles">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit User Offcanvas -->

    <form id="delete_user_form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <style>
        .select2-container--default .select2-results > .select2-results__options {
            background-color: #ffffff !important;
            color: #333333 !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b71ca !important;
            color: #ffffff !important;
        }
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            border: 1px solid #dcdcdc !important;
            min-height: 40px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }
        .select2-dropdown {
            border: 1px solid #dcdcdc !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 1100;
        }
    </style>

    @push('scripts')
    <script>
        $(document).ready(function() {
            const employeeSearchUrl = "{{ route('employees.search') }}";
            const employeeShowUrlTpl = "{{ url('api/v1/employees') }}/__ID__";

            function initEmployeeSelect($select, $offcanvas) {
                $select.select2({
                    placeholder: $select.data('placeholder'),
                    allowClear: false,
                    width: '100%',
                    dropdownParent: $offcanvas,
                    ajax: {
                        url: employeeSearchUrl,
                        dataType: 'json',
                        delay: 250,
                        data: params => ({ q: params.term || '', limit: 50 }),
                        processResults: function(data) {
                            return {
                                results: (data.data || []).map(e => ({
                                    id: e.id,
                                    text: e.text,
                                    name: e.name,
                                    nik: e.employee_number,
                                    email: e.email,
                                }))
                            };
                        }
                    }
                });
            }

            function applyPreview(scope, data) {
                const $preview = $(scope).find('[id$="_employee_preview"]');
                const $manualWrap = $(scope).find('[id$="_email_manual_wrap"]');
                $preview.removeClass('d-none');
                $preview.find('.emp-nik').text(data.nik || '-');
                $preview.find('.emp-name').text(data.name || '-');
                $preview.find('.emp-email').text(data.email || '(tidak ada)');

                if (!data.email) {
                    $manualWrap.removeClass('d-none').find('input').attr('required', true);
                } else {
                    $manualWrap.addClass('d-none').find('input').removeAttr('required').val('');
                }
            }

            function resetPreview(scope) {
                $(scope).find('[id$="_employee_preview"]').addClass('d-none');
                $(scope).find('[id$="_email_manual_wrap"]').addClass('d-none')
                    .find('input').removeAttr('required').val('');
            }

            // Fetch full profile (incl. nmemail) after picking employee.
            // The search endpoint returns minimal fields; email only available via /api/v1/employees/{id}.
            function enrichFromProfile(scope, employeeId) {
                if (!employeeId) return;
                const $preview = $(scope).find('[id$="_employee_preview"]');
                $preview.find('.emp-email').text('memuat...');
                $.get(employeeShowUrlTpl.replace('__ID__', employeeId))
                    .done(function(resp) {
                        const data = resp.data || {};
                        applyPreview(scope, {
                            nik: data.employee_number,
                            name: data.name,
                            email: data.email,
                        });
                    })
                    .fail(function() {
                        $preview.find('.emp-email').text('(gagal memuat)');
                    });
            }

            // Init Add form
            initEmployeeSelect($('#add_employee_id'), $('#add_user_offcanvas'));
            $('#add_employee_id').on('select2:select', function(e) {
                applyPreview('#add_user_offcanvas', e.params.data);
                enrichFromProfile('#add_user_offcanvas', e.params.data.id);
            });

            // Init Edit form
            initEmployeeSelect($('#edit_employee_id'), $('#edit_user_offcanvas'));
            $('#edit_employee_id').on('select2:select', function(e) {
                applyPreview('#edit_user_offcanvas', e.params.data);
                enrichFromProfile('#edit_user_offcanvas', e.params.data.id);
            });

            // Roles select2
            $('.select2-roles').each(function() {
                const $this = $(this);
                $this.select2({
                    width: '100%',
                    placeholder: $this.data('placeholder'),
                    dropdownParent: $this.closest('.offcanvas')
                });
            });

            // Reset Add form on close
            $('#add_user_offcanvas').on('hidden.bs.offcanvas', function() {
                $('#add_user_form')[0].reset();
                $('#add_employee_id').val(null).trigger('change');
                $('#add_user_form .select2-roles').val(null).trigger('change');
                resetPreview('#add_user_offcanvas');
            });

            // DataTable
            var table = $('.ajax-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('manage-users.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'roles', name: 'roles', orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Edit User — preload employee from existing record
            $('body').on('click', '.edit-user-btn', function() {
                var id = $(this).data('id');
                var employeeId = $(this).data('employee-id');
                var nik = $(this).data('nik');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var roles = $(this).data('roles').toString().split(',').filter(Boolean);

                $('#edit_user_form').attr('action', '/manage-users/' + id);

                // Reset preview/manual
                resetPreview('#edit_user_offcanvas');
                $('#edit_employee_id').empty().trigger('change');

                if (employeeId) {
                    // Pre-fill select2 with existing employee snapshot
                    const opt = new Option(`${name} (NIK: ${nik || '-'})`, employeeId, true, true);
                    $('#edit_employee_id').append(opt).trigger('change');
                    applyPreview('#edit_user_offcanvas', { nik: nik, name: name, email: email });
                }

                $('#edit_roles').val(roles).trigger('change');
            });

            // Delete User
            $('body').on('click', '.delete-user-btn', function() {
                var id = $(this).data('id');
                var deleteForm = $('#delete_user_form');

                deleteForm.attr('action', '/manage-users/' + id);

                Swal.fire({
                    title: "Delete user?",
                    text: "You won't be able to revert this!",
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
                Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
            @endif

            @if(session('error'))
                Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session('error') }}' });
            @endif
        });
    </script>
    @endpush

@endsection
