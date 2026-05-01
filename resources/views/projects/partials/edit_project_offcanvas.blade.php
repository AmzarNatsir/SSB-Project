<!-- Edit Project Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_project_offcanvas" style="width: 60%;">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Edit Project</h5>
        <button type="button"
            class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
            data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="edit_project_form" method="POST" class="ajax-form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Request Date <span class="text-danger">*</span></label>
                        <input type="date" name="request_date" id="edit_request_date" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Project Category <span class="text-danger">*</span></label>
                        <select name="project_categories_id" id="edit_project_categories_id" class="select form-control"
                            required>
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
                        <select name="project_sub_categories_id" id="edit_project_sub_categories_id"
                            class="select form-control">
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
                        <input type="text" name="project_coordinates" id="edit_project_coordinates"
                            class="form-control">
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
                        <select name="equipment_rental_rates_hm_id" id="edit_equipment_rental_rates_hm_id"
                            class="select form-control">
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
                        <input type="text" name="project_value" id="edit_project_value"
                            class="form-control rupiah-input"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57">
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