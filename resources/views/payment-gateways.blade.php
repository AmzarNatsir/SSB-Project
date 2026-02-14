<?php $page = 'payment-gateways'; ?>
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
                                <h4 class="fs-17 mb-0">Payment Gateways</h4>
                            </div>
                            <div class="row">

                                <!-- Email Wrap -->
                                <div class="col-md-12">
                                    <!-- Payment -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-1.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#php-mail"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_paypal"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="php-mail">
                                            <div>
                                                <p class="mb-0">PayPal Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment -->

                                    <!-- Payment-2 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-2.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#stripe-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_stripe"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="stripe-pay">
                                            <div>
                                                <p class="mb-0">Stripe Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-2 -->

                                    <!-- Payment-3 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-3.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#brain-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_brain"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="brain-pay">
                                            <div>
                                                <p class="mb-0">Braintree Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-3 -->

                                    <!-- Payment-4 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-4.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#skrill-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_skrill"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="skrill-pay">
                                            <div>
                                                <p class="mb-0">Skrill Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-4 -->

                                    <!-- Payment-5 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-5.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#razor-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_razor"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="razor-pay">
                                            <div>
                                                <p class="mb-0">Razorpay Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-5 -->

                                    <!-- Payment-6 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-6.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#payoneer-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_payoneer"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="payoneer-pay">
                                            <div>
                                                <p class="mb-0">Payoneer Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-6 -->

                                    <!-- Payment-7 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-7.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#pay-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_pay"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="pay-pay">
                                            <div>
                                                <p class="mb-0">Pay Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-7 -->

                                    <!-- Payment-8 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-8.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#paytm-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_paytm"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="paytm-pay">
                                            <div>
                                                <p class="mb-0">Paytm Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-8 -->

                                    <!-- Payment-9 -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-9.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#bank-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_bank"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="bank-pay">
                                            <div>
                                                <p class="mb-0">Bank Transfer Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-9 -->

                                    <!-- Payment-10 -->
                                    <div class="border rounded shadow p-3 mb-0">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="">
                                                        <img src="{{URL::asset('build/img/payments/payment-10.svg')}}" alt="">
                                                    </span>
                                                    <div class="ms-2">
                                                        <a href="javascript:void(0);"
                                                            class="badge badge-tag badge-soft-success ms-2">Connected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center">
                                                        <a href="javascript:void(0);"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#cash-pay"
                                                            class="text-default me-1 me-lg-3 me-md-3 me-sm-3 border-end pe-1 pe-lg-3 pe-md-3 pe-sm-3 fs-16"><i
                                                                class="ti ti-info-circle-filled"></i></a>
                                                        <a href="#" class="btn btn-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#add_cash"><i
                                                                class="ti ti-tool me-1"></i>View
                                                            Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch p-0">
                                                        <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                            <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse pt-3 mt-3 border-top" id="cash-pay">
                                            <div>
                                                <p class="mb-0">Cash on delivery Holdings, Inc. is an American multinational
                                                    financial technology company operating an online
                                                    payments system in the majority of countries that
                                                    support online money transfers, and serves as an
                                                    electronic alternative to traditional paper methods such
                                                    as checks and money orders. </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Payment-10 -->

                                </div>
                                <!-- /Email Wrap -->

                            </div>
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