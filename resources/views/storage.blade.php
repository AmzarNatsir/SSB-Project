<?php $page = 'storage'; ?>
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

                    <!-- Settings Info -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-3 pb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <h4 class="fs-17 mb-0">Storage</h4>
                            </div>
                            
                            <!-- start row -->
                            <div class="row row-gap-3">
                                <!-- Storage -->
                                <div class="col-xxl-6 col-sm-6">
                                    <div class="border rounded p-3 d-flex align-items-center justify-content-between shadow">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="avatar avatar-lg bg-light-100 border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/icons/storage-icon-01.svg')}}"
                                                    class="w-auto h-auto" alt="">
                                            </span>
                                            <h6 class="fw-medium fs-14 mb-0">Local Storage</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch p-0">
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Storage -->

                                <!-- Storage -->
                                <div class="col-xxl-6 col-sm-6">
                                    <div class="border rounded p-3 d-flex align-items-center justify-content-between shadow">
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="avatar avatar-lg bg-light-100 border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/icons/storage-icon-02.svg')}}"
                                                    class="w-auto h-auto" alt="">
                                            </span>
                                            <h6 class="fw-medium fs-14 mb-0">AWS</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="me-2 d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#add_aws"><i
                                                    class="ti ti-settings fs-24"></i>
                                                </a>
                                            <div class="form-check form-switch p-0">
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Storage -->
                            </div>
                            <!-- end row -->

                        </div>
                    </div>
                    <!-- /Settings Info -->

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