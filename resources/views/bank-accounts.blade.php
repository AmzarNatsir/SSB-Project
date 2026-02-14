<?php $page = 'bank-accounts'; ?>
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
                                <h4 class="fs-17 mb-0">Bank Accounts</h4>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_bank"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Account</a>
                            </div>

                            <div class="row row-gap-3">
                                <!-- Bank Account -->
                                <div class="col-xxl-4 col-sm-6">
                                    <div class="position-relative">
                                        <input type="radio" name="bank" id="bank1" class="bank-radio" checked>
                                        <div class="bank-box">
                                            <div class="check-icon"></div>
                                            <div class="mb-4">
                                                <h5 class="fw-bold mb-1 fs-16">HDFC</h5>
                                                <p class="mb-0 fs-14">**** **** 4872</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h6 class="fw-semibold mb-1 fs-14">Holder Name</h6>
                                                    <p class="fs-13">Darlee Robertson</p>
                                                </div>

                                                <div class="dropdown table-action position-relative z-1">
                                                    <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_bank">
                                                            <i class="ti ti-edit text-blue me-1"></i>Edit
                                                        </a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_bank">
                                                            <i class="ti ti-trash text-blue me-1"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Bank Account -->

                                <!-- Bank Account -->
                                <div class="col-xxl-4 col-sm-6">
                                    <div class="position-relative">
                                        <input type="radio" name="bank" id="bank2" class="bank-radio">
                                        <div class="bank-box">
                                            <div class="check-icon"></div>
                                            <div class="mb-4">
                                                <h5 class="fw-bold mb-1 fs-16">SBI</h5>
                                                <p class="mb-0 fs-14">**** **** 2495</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h6 class="fw-semibold mb-1 fs-14">Holder Name</h6>
                                                    <p class="fs-13">Sharon Roy</p>
                                                </div>

                                                <div class="dropdown table-action position-relative z-1">
                                                    <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_bank">
                                                            <i class="ti ti-edit text-blue me-1"></i>Edit
                                                        </a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_bank">
                                                            <i class="ti ti-trash text-blue me-1"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Bank Account -->

                                <!-- Bank Account -->
                                <div class="col-xxl-4 col-sm-6">
                                    <div class="position-relative">
                                        <input type="radio" name="bank" id="bank3" class="bank-radio">
                                        <div class="bank-box">
                                            <div class="check-icon"></div>
                                            <div class="mb-4">
                                                <h5 class="fw-bold mb-1 fs-16">KVB</h5>
                                                <p class="mb-0 fs-14">**** **** 3948</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h6 class="fw-semibold mb-1 fs-14">Holder Name</h6>
                                                    <p class="fs-13">Vaughan Lewis</p>
                                                </div>

                                                <div class="dropdown table-action position-relative z-1">
                                                    <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_bank">
                                                            <i class="ti ti-edit text-blue me-1"></i>Edit
                                                        </a>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_bank">
                                                            <i class="ti ti-trash text-blue me-1"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Bank Account -->
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