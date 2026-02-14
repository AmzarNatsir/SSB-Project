<?php $page = 'profile-setings'; ?>
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
                                <h5 class="mb-0 fs-17">Profile</h5>
                            </div>
                            <form action="{{url('profile-settings')}}">
                                <div class="mb-3">
                                    <h6 class="mb-1">Employee Information</h6>
                                    <p class="mb-0">Provide the information below</p>
                                </div>
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
                                            <p class="mb-0">JPG, GIF or PNG. Max size of 800K</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom mb-3">
                                    
                                    <!-- start row -->
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    First Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Last Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    User Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Phone Number <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Email <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row -->

                                </div>
                                <div class="border-bottom mb-3">
                                    <div class="mb-3">
                                        <h6 class="mb-1">Address</h6>
                                        <p class="mb-0">Please enter the address details</p>
                                    </div>

                                    <!-- start row -->
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Address
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Country
                                                </label>
                                                <select class="select">
                                                    <option>United States</option>
                                                    <option>Canada</option>
                                                    <option>Germany</option>
                                                    <option>France</option>
                                                </select>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    State / Province
                                                </label>
                                                <select class="select">
                                                    <option>California</option>
                                                    <option>New York</option>
                                                    <option>Texas</option>
                                                    <option>Florida</option>
                                                </select>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    City
                                                </label>
                                                <select class="select">
                                                    <option>Los Angeles</option>
                                                    <option>San Diego</option>
                                                    <option>Fresno</option>
                                                    <option>San Francisco</option>
                                                </select>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Postal Code
                                                </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row -->

                                </div>
                                <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                    <a href="#" class="btn btn-sm btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                </div> <!-- end col -->              

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