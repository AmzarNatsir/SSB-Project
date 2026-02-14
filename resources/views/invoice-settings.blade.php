<?php $page = 'invoice-settings'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
                <div>
                    <h4 class="mb-1">Settings</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>                
            <!-- End Page Header -->

            @component('components.settings-menu')
            @endcomponent

            <!-- start row -->
            <div class="row">

                @component('components.settings-sidebar')
                @endcomponent

                <div class="col-xl-9 col-lg-12">

                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-3 pb-3">
                                <h5 class="mb-0 fs-17">Invoice Settings</h5>
                            </div>
                                <form action="{{url('invoice-settings')}}">
                                    <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Invoice Logo</h6>
                                                <p class="fs-13 mb-0">Upload logo of your company to display in invoice</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="profile-upload d-flex align-items-center">
                                                    <div class="profile-upload-img avatar avatar-xxl border border-dashed rounded position-relative flex-shrink-0">
                                                        <span><i class="ti ti-photo"></i></span>
                                                        <img id="ImgPreview" src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" alt="img" class="preview1">
                                                        <a href="javascript:void(0);" id="removeImage1" class="profile-remove">
                                                            <i class="ti ti-x"></i>
                                                        </a>
                                                    </div>
                                                    <div class="profile-upload-content ms-3">
                                                        <label class="d-inline-flex align-items-center position-relative btn btn-primary btn-sm mb-2">
                                                            <i class="ti ti-file-broken me-1"></i>Upload File
                                                            <input type="file" id="imag" class="input-img position-absolute w-100 h-100 opacity-0 top-0 end-0">
                                                        </label>
                                                        <p class="mb-0">Upload Logo of your company to display in website. Recommended size is 250 px*100 px</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Invoice Prefix</h6>
                                                <p class="fs-13 mb-0">Add prefix to your invoice</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" value="INV-">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Invoice Due</h6>
                                                <p class="fs-13 mb-0">Select due date to display in invoice</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center inv-days">
                                                    <div class="me-2">
                                                        <select class="select">
                                                            <option selected>5</option>
                                                            <option>7</option>
                                                        </select>
                                                    </div>
                                                    <p class="fs-13 mb-0">Days</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Invoice Round Off</h6>
                                                <p class="fs-13 mb-0">Value roundoff in invoice</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            role="switch" checked>
                                                    </div>
                                                    <div class="w-100">
                                                        <select class="select">
                                                            <option selected>Roundoff Up</option>
                                                            <option>Roundoff Down</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Show Company Details</h6>
                                                <p class="fs-13 mb-0">Show/hide company details in invoice</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Invoice Footer Terms</h6>
                                                <p class="fs-13 mb-0">Enter terms that will appear on All Proposals by default.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="snow-editor"></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                        <a href="#" class="btn btn-sm btn-light">Cancel</a>
                                        <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /Invoice Settings -->
                    </div>
                </div>

            </div>
			<!-- end row -->

        </div>
        <!-- End Content -->   

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection                  