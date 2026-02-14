<?php $page = 'gdpr-cookies'; ?>
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
                                <h5 class="mb-0 fs-17">GDPR Cookies</h5>
                                    </div>
                                    <form action="{{url('gdpr-cookies')}}">
                                        <div class="border-bottom mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <h6 class="fs-14 fw-semibold mb-1">Cookies Content Text</h6>
                                                        <p class="fs-13">You can configure the text here</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div class="snow-editor"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fs-14 fw-semibold mb-1">Cookies Position</h6>
                                                        <p class="fs-13">You can configure the type</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <select class="select">
                                                            <option selected>Right</option>
                                                            <option>Left</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fs-14 fw-semibold mb-1">Agree Button Text</h6>
                                                        <p class="fs-13">You can configure the text here</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" value="Agree">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fs-14 fw-semibold mb-1">Decline Button Text</h6>
                                                        <p class="fs-13">You can configure the text here</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" value="Decline">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fs-14 fw-semibold mb-1">Show Decline Button</h6>
                                                        <p class="fs-13">To display decline button</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="form-check form-switch ms-0 ps-0">
                                                            <input class="form-check-input ms-0 mt-0" type="checkbox" role="switch" checked>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fs-14 fw-semibold mb-1">Link for Cookies Page</h6>
                                                        <p class="fs-13">You can configure the link here</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                            <a href="#" class="btn btn-sm btn-light me-2">Cancel</a>
                                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /GDPR Cookies -->

                        </div>
                    </div>

                </div><!-- end col -->

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