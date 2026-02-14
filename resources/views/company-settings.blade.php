<?php $page = 'company-setings'; ?>
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

                    <!-- Company Settings -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-3 pb-3">
                                <h5 class="mb-0 fs-17">Company Settings</h5>
                            </div>
                            <form action="{{url('company-settings')}}">
                                <div class="mb-3">
                                    <h6 class=" mb-1">Company Information</h6>
                                    <p class="mb-0">Provide the company information below</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Company Email Address <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Fax</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Website</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="mb-1">Company Images</h6>
                                    <p class="mb-0">Provide the company images</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="profile-upload d-flex align-items-center">
                                                    <div class="profile-upload-img avatar avatar-xxl border border-dashed rounded position-relative flex-shrink-0">
                                                        <span><i class="ti ti-photo"></i></span>
                                                        <img id="ImgPreview" src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" alt="img" class="preview1">
                                                        <a href="javascript:void(0);"  class="profile-remove">
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
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="profile-upload d-flex align-items-center">
                                                    <div class="profile-upload-img avatar avatar-xxl border border-dashed rounded position-relative flex-shrink-0">
                                                        <span><i class="ti ti-photo"></i></span>
                                                        <img id="ImgPreview2" src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" alt="img" class="preview1">
                                                        <a href="javascript:void(0);"  class="profile-remove">
                                                            <i class="ti ti-x"></i>
                                                        </a>
                                                    </div>
                                                    <div class="profile-upload-content ms-3">
                                                        <label class="d-inline-flex align-items-center position-relative btn btn-primary btn-sm mb-2">
                                                            <i class="ti ti-file-broken me-1"></i>Upload File
                                                            <input type="file" id="imag2" class="input-img position-absolute w-100 h-100 opacity-0 top-0 end-0">
                                                        </label>
                                                        <p class="mb-0">Upload Logo of your company to display in website. Recommended size is 250 px*100 px</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="profile-upload d-flex align-items-center">
                                                    <div class="profile-upload-img avatar avatar-xxl border border-dashed rounded position-relative flex-shrink-0">
                                                        <span><i class="ti ti-photo"></i></span>
                                                        <img id="ImgPreview3" src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" alt="img" class="preview1">
                                                        <a href="javascript:void(0);"  class="profile-remove">
                                                            <i class="ti ti-x"></i>
                                                        </a>
                                                    </div>
                                                    <div class="profile-upload-content ms-3">
                                                        <label class="d-inline-flex align-items-center position-relative btn btn-primary btn-sm mb-2">
                                                            <i class="ti ti-file-broken me-1"></i>Upload File
                                                            <input type="file" id="imag3" class="input-img position-absolute w-100 h-100 opacity-0 top-0 end-0">
                                                        </label>
                                                        <p class="mb-0">Upload Logo of your company to display in website. Recommended size is 250 px*100 px</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="profile-upload d-flex align-items-center">
                                                    <div class="profile-upload-img avatar avatar-xxl border border-dashed rounded position-relative flex-shrink-0">
                                                        <span><i class="ti ti-photo"></i></span>
                                                        <img id="ImgPreview4" src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" alt="img" class="preview1">
                                                        <a href="javascript:void(0);"  class="profile-remove">
                                                            <i class="ti ti-x"></i>
                                                        </a>
                                                    </div>
                                                    <div class="profile-upload-content ms-3">
                                                        <label class="d-inline-flex align-items-center position-relative btn btn-primary btn-sm mb-2">
                                                            <i class="ti ti-file-broken me-1"></i>Upload File
                                                            <input type="file" id="imag4" class="input-img position-absolute w-100 h-100 opacity-0 top-0 end-0">
                                                        </label>
                                                        <p class="mb-0">Upload Logo of your company to display in website. Recommended size is 250 px*100 px</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="mb-1">Address</h6>
                                    <p class="mb-0">Please enter the company address details</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Country</label>
                                                <select class="select">
                                                            <option>United States</option>
                                                            <option>Canada</option>
                                                            <option>Germany</option>
                                                            <option>France</option>
                                                        </select>
                                            </div>
                                        </div>
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
                                    </div>
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
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Zip Code
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                    <a href="#" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Company Settings -->

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