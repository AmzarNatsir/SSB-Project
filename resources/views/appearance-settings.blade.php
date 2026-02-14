<?php $page = 'appearance-setings'; ?>
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
                                <h5 class="mb-0 fs-17">Appearance</h5>
                            </div>
                            <form action="{{url('appearance-settings')}}">
                                <div class="border-bottom mb-3">

                                    <!-- start row -->
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Select Theme</h6>
                                                <p class="fs-13 mb-0">Select theme of the website</p>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-8">
                                            <div class="mb-3 mb-0">
                                                <div class="theme-type-images d-flex align-items-center gap-2">
                                                    <div class="theme-image  text-center p-2 rounded active">
                                                        <div class="mb-2">
                                                            <img src="{{URL::asset('build/img/theme/theme-01.jpg')}}" alt="">
                                                        </div>
                                                        <span class="fw-medium">Light</span>
                                                    </div>
                                                    <div class="theme-image text-center p-2 rounded">
                                                        <div class="mb-2">
                                                            <img src="{{URL::asset('build/img/theme/theme-02.jpg')}}" alt="">
                                                        </div>
                                                        <span class="fw-medium">Dark</span>
                                                    </div>
                                                    <div class="theme-image text-center p-2 rounded">
                                                        <div class="mb-2">
                                                            <img src="{{URL::asset('build/img/theme/theme-03.jpg')}}" alt="">
                                                        </div>
                                                        <span class="fw-medium">Automatic</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                    </div> 
                                    <!-- end row -->
                                    
                                    <!-- start col -->
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Accent Color</h6>
                                                <p class="fs-13 mb-0">Select accent color of website</p>
                                            </div>
                                        </div><!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="theme-colors">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="themecolorset defaultcolor active"></span>
                                                        <span class="themecolorset theme-secondary"></span>
                                                        <span class="themecolorset theme-violet"></span>
                                                        <span class="themecolorset theme-blue"></span>
                                                        <span class="themecolorset theme-brown"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Expand Sidebar</h6>
                                                <p class="fs-13 mb-0">To display in all the pages</p>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Sidebar Size</h6>
                                                <p class="fs-13 mb-0">Select size of sidebar to display</p>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>Large - 250px</option>
                                                    <option>Small - 85px</option>
                                                </select>
                                            </div>
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row -->

                                    <!-- start row -->
                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Font Family</h6>
                                                <p class="fs-13 mb-0">Select font family of website</p>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>Noto Sans</option>
                                                    <option>Nunito</option>
                                                </select>
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