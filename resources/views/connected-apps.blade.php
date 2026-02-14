<?php $page = 'connected-apps'; ?>
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
                        <div class="card-body pb-0">
                            <div class="border-bottom mb-3 pb-3">
                                <h5 class="mb-0 fs-17">Connected Apps</h5>
                            </div>

                            <!-- start row -->
                            <div class="row">

                                <div class="col-md-4 col-sm-6">
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="avatar rounded bg-light p-2">
                                                    <img src="{{URL::asset('build/img/icons/integration-01.svg')}}" alt="Icon">
                                                </span>
                                                <div class="connect-btn">
                                                    <a href="javascript:void(0);" class="badge badge-soft-success">Connected</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="fw-medium text-dark  mb-0">Google Calendar</p>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->		

                                <div class="col-md-4 col-sm-6">
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="avatar rounded bg-light p-2">
                                                    <img src="{{URL::asset('build/img/icons/integration-03.svg')}}" alt="Icon">
                                                </span>
                                                <div class="connect-btn">
                                                    <a href="javascript:void(0);" class="badge badge-soft-success">Connected</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="fw-medium text-dark  mb-0">Dropbox</p>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->		

                                <div class="col-md-4 col-sm-6">
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="avatar rounded bg-light p-2">
                                                    <img src="{{URL::asset('build/img/icons/integration-04.svg')}}" alt="Icon">
                                                </span>
                                                <div class="connect-btn">
                                                    <a href="javascript:void(0);"
                                                        class="badge border badge-soft-success">Connected</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="fw-medium text-dark  mb-0">Slack</p>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->		
                                
                                <div class="col-md-4 col-sm-6">
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="avatar rounded bg-light p-2">
                                                    <img src="{{URL::asset('build/img/icons/integration-05.svg')}}" alt="Icon">
                                                </span>
                                                <div class="connect-btn">
                                                    <a href="javascript:void(0);" class="badge badge-soft-success">Connected</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="fw-medium text-dark  mb-0">Gmail</p>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->		
                                
                                <div class="col-md-4 col-sm-6">
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center justify-content-between mb-3">
                                                <span class="avatar rounded bg-light p-2">
                                                    <img src="{{URL::asset('build/img/icons/integration-06.svg')}}" alt="Icon">
                                                </span>
                                                <div class="connect-btn">
                                                    <a href="javascript:void(0);"
                                                        class="badge badge-soft-success">Connect</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="fw-medium text-dark  mb-0">Github</p>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->							

                            </div>
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