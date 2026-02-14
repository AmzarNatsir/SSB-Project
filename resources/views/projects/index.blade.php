<?php $page = 'projects'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Projects</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Projects</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#add_project_offcanvas">
                            <i class="ti ti-plus-circle me-2"></i>Add Project
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Project List -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Project List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Project Number</th>
                                    <th>Project Name</th>
                                    <th>User Name</th>
                                    <th>Project Value</th>
                                    <th>Duration (Days)</th>
                                    <th>Status</th>
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
            <!-- /Project List -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Project Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_project_offcanvas" style="width: 60%;">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add New Project</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('projects.store') }}" method="POST" class="ajax-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Request Date <span class="text-danger">*</span></label>
                            <input type="date" name="request_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Category <span class="text-danger">*</span></label>
                            <select name="project_categories_id" class="select form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Sub Category</label>
                            <select name="project_sub_categories_id" id="add_project_sub_categories_id" class="select form-control">
                                <option value="">Select Sub Category</option>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Name <span class="text-danger">*</span></label>
                            <input type="text" name="project_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">User Name <span class="text-danger">*</span></label>
                            <input type="text" name="user_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">User Code</label>
                            <input type="text" name="user_code" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">User Address</label>
                            <textarea name="user_address" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Location</label>
                            <input type="text" name="project_location" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Coordinates</label>
                            <input type="text" name="project_coordinates" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Job Type</label>
                            <input type="text" name="job_type" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Taxpayer ID</label>
                            <input type="text" name="taxpayer_id" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">PIC</label>
                            <select name="pic_id" class="select form-control">
                                <option value="">Select PIC</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Equipment Rental Rate</label>
                            <select name="equipment_rental_rates_hm_id" class="select form-control">
                                <option value="">Select Equipment Rate</option>
                                @foreach($equipmentRates as $rate)
                                    <option value="{{ $rate->id }}">{{ $rate->jenis_alat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" id="add_start_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" id="add_end_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Value</label>
                            <input type="text" name="project_value" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Bank Account</label>
                            <input type="text" name="bank_account" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Scope of Work</label>
                            <textarea name="scope_of_work" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit">Save Project</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add Project Offcanvas -->

    <!-- Edit Project Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_project_offcanvas" style="width: 60%;">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit Project</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="edit_project_form" method="POST" class="ajax-form">
                @csrf
                @method('PUT')
                <!-- Same fields as Add form, with id prefixes edit_ -->
                <div class="row">
                    <!-- Fields will be populated via JavaScript -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Request Date <span class="text-danger">*</span></label>
                            <input type="date" name="request_date" id="edit_request_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Category <span class="text-danger">*</span></label>
                            <select name="project_categories_id" id="edit_project_categories_id" class="select form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Sub Category</label>
                            <select name="project_sub_categories_id" id="edit_project_sub_categories_id" class="select form-control">
                                <option value="">Select Sub Category</option>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Name <span class="text-danger">*</span></label>
                            <input type="text" name="project_name" id="edit_project_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">User Name <span class="text-danger">*</span></label>
                            <input type="text" name="user_name" id="edit_user_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">User Code</label>
                            <input type="text" name="user_code" id="edit_user_code" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">User Address</label>
                            <textarea name="user_address" id="edit_user_address" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="edit_phone_number" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Location</label>
                            <input type="text" name="project_location" id="edit_project_location" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Coordinates</label>
                            <input type="text" name="project_coordinates" id="edit_project_coordinates" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Job Type</label>
                            <input type="text" name="job_type" id="edit_job_type" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Taxpayer ID</label>
                            <input type="text" name="taxpayer_id" id="edit_taxpayer_id" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">PIC</label>
                            <select name="pic_id" id="edit_pic_id" class="select form-control">
                                <option value="">Select PIC</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Equipment Rental Rate</label>
                            <select name="equipment_rental_rates_hm_id" id="edit_equipment_rental_rates_hm_id" class="select form-control">
                                <option value="">Select Equipment Rate</option>
                                @foreach($equipmentRates as $rate)
                                    <option value="{{ $rate->id }}">{{ $rate->jenis_alat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="edit_start_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" id="edit_end_date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Project Value</label>
                            <input type="text" name="project_value" id="edit_project_value" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Bank Account</label>
                            <input type="text" name="bank_account" id="edit_bank_account" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Scope of Work</label>
                            <textarea name="scope_of_work" id="edit_scope_of_work" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit">Update Project</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit Project Offcanvas -->

    <!-- Detail Project Modal -->
    <div class="modal fade" id="detail_project_modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Project Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="project_detail_content">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="delete_project_form" method="POST" style="display: none;">
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
                ajax: "{{ route('projects.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'project_number', name: 'project_number'},
                    {data: 'project_name', name: 'project_name'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'project_value', name: 'project_value'},
                    {data: 'duration_of_work', name: 'duration_of_work'},
                    {data: 'project_status', name: 'project_status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Category data for conditional logic
            var categories = @json($categories);
            
            // Function to toggle subcategory visibility
            function toggleSubcategory(categoryId, subcategorySelector) {
                var category = categories.find(c => c.id == categoryId);
                if (category && category.code && category.code.toUpperCase() === 'P') {
                    // Profit category - hide subcategory
                    $(subcategorySelector).closest('.col-md-6').hide();
                    $(subcategorySelector).val('').trigger('change');
                } else {
                    // Non-Profit category - show subcategory
                    $(subcategorySelector).closest('.col-md-6').show();
                }
            }

            // Add form category change
            $('select[name="project_categories_id"]').on('change', function() {
                toggleSubcategory($(this).val(), '#add_project_sub_categories_id');
            });

            // Edit form category change
            $('#edit_project_categories_id').on('change', function() {
                toggleSubcategory($(this).val(), '#edit_project_sub_categories_id');
            });

            // Toast Configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // Rupiah Formatting
            $('body').on('input', '.rupiah-input', function(e) {
                var value = $(this).val();
                $(this).val(formatRupiah(value));
            });

            function formatRupiah(angka) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
    
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }

            // AJAX Form Submit
            $('.ajax-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find('.btn-submit');
                var originalText = btn.text();
                
                btn.prop('disabled', true);
                btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        btn.prop('disabled', false);
                        btn.text(originalText);
                        $('.offcanvas').offcanvas('hide');
                        table.ajax.reload();
                        form[0].reset();
                        Toast.fire({icon: 'success', title: response.success});
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false);
                        btn.text(originalText);
                        var errorMessage = xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors)[0][0] : 'Something went wrong!';
                        Toast.fire({icon: 'error', title: errorMessage});
                    }
                });
            });

            // Edit Project
            $('body').on('click', '.edit-project-btn', function() {
                var id = $(this).data('id');
                
                $.ajax({
                    url: '/projects/' + id + '/data',
                    method: 'GET',
                    success: function(data) {
                        $('#edit_request_date').val(data.request_date ? data.request_date.split('T')[0] : '');
                        $('#edit_project_categories_id').val(data.project_categories_id).trigger('change');
                        $('#edit_project_sub_categories_id').val(data.project_sub_categories_id).trigger('change');
                        $('#edit_project_name').val(data.project_name);
                        $('#edit_user_name').val(data.user_name);
                        $('#edit_user_code').val(data.user_code);
                        $('#edit_user_address').val(data.user_address);
                        $('#edit_email').val(data.email);
                        $('#edit_phone_number').val(data.phone_number);
                        $('#edit_project_location').val(data.project_location);
                        $('#edit_project_coordinates').val(data.project_coordinates);
                        $('#edit_job_type').val(data.job_type);
                        $('#edit_taxpayer_id').val(data.taxpayer_id);
                        $('#edit_pic_id').val(data.pic_id).trigger('change');
                        $('#edit_equipment_rental_rates_hm_id').val(data.equipment_rental_rates_hm_id).trigger('change');
                        $('#edit_start_date').val(data.start_date ? data.start_date.split('T')[0] : '');
                        $('#edit_end_date').val(data.end_date ? data.end_date.split('T')[0] : '');
                        $('#edit_project_value').val(formatRupiah(data.project_value.toString()));
                        $('#edit_bank_account').val(data.bank_account);
                        $('#edit_scope_of_work').val(data.scope_of_work);
                        $('#edit_description').val(data.description);
                        
                        // Trigger subcategory visibility after setting category
                        toggleSubcategory(data.project_categories_id, '#edit_project_sub_categories_id');
                        
                        $('#edit_project_form').attr('action', '/projects/' + id);
                        $('#edit_project_offcanvas').offcanvas('show');
                    }
                });
            });

            // Detail Project
            $('body').on('click', '.detail-project-btn', function() {
                var id = $(this).data('id');
                
                $.ajax({
                    url: '/projects/' + id,
                    method: 'GET',
                    success: function(data) {
                        var html = `
                            <div class="row">
                                <div class="col-md-6"><strong>Project Code:</strong> ${data.project_code}</div>
                                <div class="col-md-6"><strong>Project Number:</strong> ${data.project_number}</div>
                                <div class="col-md-6"><strong>Project Name:</strong> ${data.project_name}</div>
                                <div class="col-md-6"><strong>User Name:</strong> ${data.user_name}</div>
                                <div class="col-md-6"><strong>Email:</strong> ${data.email || '-'}</div>
                                <div class="col-md-6"><strong>Phone:</strong> ${data.phone_number || '-'}</div>
                                <div class="col-md-6"><strong>Status:</strong> <span class="badge bg-info">${data.project_status}</span></div>
                                <div class="col-md-6"><strong>Project Value:</strong> Rp ${formatRupiah(data.project_value.toString())}</div>
                                <div class="col-md-6"><strong>Duration:</strong> ${data.duration_of_work || '-'} days</div>
                                <div class="col-md-12 mt-3"><strong>Description:</strong><br>${data.description || '-'}</div>
                            </div>
                        `;
                        $('#project_detail_content').html(html);
                    }
                });
            });

            // Delete Project
            $('body').on('click', '.delete-project-btn', function() {
                var id = $(this).data('id');
                var deleteForm = $('#delete_project_form');
                deleteForm.attr('action', '/projects/' + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    customClass: {
                        confirmButton: "btn btn-primary me-2",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteForm.attr('action'),
                            method: 'POST',
                            data: deleteForm.serialize(),
                            success: function(response) {
                                table.ajax.reload();
                                Toast.fire({icon: 'success', title: response.success});
                            },
                            error: function(xhr) {
                                Toast.fire({icon: 'error', title: xhr.responseJSON?.error || 'Failed to delete project.'});
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endpush

@endsection
