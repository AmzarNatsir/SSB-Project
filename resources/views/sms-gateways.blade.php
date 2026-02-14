<?php $page = 'sms-gateways'; ?>
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
                                <h5 class="mb-0 fs-17">SMS Gateways</h5>
                            </div>
                                <div class="row">

                                    <!-- Gateway Wrap -->
                                    <div class="col-xxl-4 col-sm-6">
                                        <div
                                            class="border rounded d-flex align-items-center justify-content-between p-3 mb-3 shadow">
                                            <div>
                                                <img src="{{URL::asset('build/img/icons/gateway-01.svg')}}" alt="">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#add_nexmo"><i
                                                        class="ti ti-settings fs-24"></i></a>
                                                <div class="form-check form-switch ps-2">
                                                    <input class="form-check-input ms-0 mt-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Gateway Wrap -->

                                    <!-- Gateway Wrap -->
                                    <div class="col-xxl-4 col-sm-6">
                                        <div
                                            class="border rounded d-flex align-items-center justify-content-between p-3 mb-3 shadow">
                                            <div>
                                                <img src="{{URL::asset('build/img/icons/gateway-02.svg')}}" alt="">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#add_factor"><i
                                                        class="ti ti-settings fs-24"></i></a>
                                                <div class="form-check form-switch ps-2">
                                                    <input class="form-check-input ms-0 mt-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Gateway Wrap -->

                                    <!-- Gateway Wrap -->
                                    <div class="col-xxl-4 col-sm-6">
                                        <div
                                            class="border rounded d-flex align-items-center justify-content-between p-3 mb-3 shadow">
                                            <div>
                                                <img src="{{URL::asset('build/img/icons/gateway-03.svg')}}" alt="">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#add_twilio"><i
                                                        class="ti ti-settings fs-24"></i></a>
                                                <div class="form-check form-switch ps-2">
                                                    <input class="form-check-input ms-0 mt-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Gateway Wrap -->

                                </div>
                            </div>
                        </div>
                        <!-- /Settings Info -->

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