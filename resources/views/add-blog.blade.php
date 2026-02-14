<?php $page = 'add-blog'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <h4 class="mb-4">Add Blog</h4>

            <div class="row">
                <div class="col-lg-10 mx-auto">

                    <div class="mb-3">
                        <a href="{{url('blogs')}}" class="d-inline-flex align-items-center fw-medium"><i class="ti ti-arrow-left me-1"></i>All Blogs</a>
                    </div>

                    <!-- Ticket Details -->
                    <div class="card mb-0">
                        <div class="card-body">

                            <div>
                                <div class="mb-3">
                                    <label class="form-label">Title<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Sales Optimization</option>
                                        <option>Automation</option>
                                        <option>Marketing</option>
                                        <option>Implementation</option>
                                        <option>Product Features</option>
                                        <option>Data & Analytics</option>
                                        <option>Customization</option>
                                        <option>Training & Adoption</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tags<span class="text-danger ms-1">*</span></label>
                                    <input class="input-tags form-control border-0 h-100" data-choices data-choices-limit="infinite" data-choices-removeItem type="text">
                                    <span class="fs-13">Enter value separated by comma</span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Content</label>
                                    <div class="editor pages-editor"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Featured Image</label>
                                    <div class="file-upload drag-file w-100 d-flex bg-light border shadow align-items-center justify-content-center flex-column">
                                        <span class="upload-img d-block mb-1"><i class="ti ti-folder-open text-primary fs-16"></i></span>
                                        <p class="mb-0 fs-14 text-dark">Drop your files here or <a href="javascript:void(0);" class="text-decoration-underline text-primary">browse</a></p>
                                        <input type="file" accept="video/image">
                                        <p class="fs-13 mb-0">Maximum size : 50 MB</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Status</label>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <input type="radio" class="status-radio" id="add-active" name="status">
                                        <label for="add-active">Active</label>
                                    </div>
                                    <div>
                                        <input type="radio" class="status-radio" id="add-inactive" name="status">
                                        <label for="add-inactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-end">
                                <a href="javascript:void(0);" class="btn btn-light me-3">Cancel</a>
                                <a href="javascript:void(0);" class="btn btn-primary">Create New</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Ticket Details -->
                </div>
            </div>

        </div>
        <!-- End Content -->   

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection   