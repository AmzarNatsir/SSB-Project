<?php $page = 'membership-plans'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content pb-0">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
                <div>
                    <h4 class="mb-1">Membership Plans<span class="badge badge-soft-primary ms-2">152</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Membership plans</li>
                        </ol>
                    </nav>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-package-export me-2"></i>Export</a>
                        <div class="dropdown-menu  dropdown-menu-end">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-pdf me-1"></i>Export as
                                    PDF
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Export as
                                    Excel 
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>                
            <!-- End Page Header -->
            
            <!-- card start -->
            <div class="card border-0 rounded-0">
                <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <div class="input-icon input-icon-start position-relative">
                        <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Membership</a>
                </div>
                <div class="card-body pb-0">

                    <div class="d-block">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <p class="text-dark mb-0">Yearly</p>
                            <div class="form-check form-switch ms-2 me-1">
                                <input class="form-check-input" type="checkbox" role="switch" checked>
                            </div>
                            <p class="text-dark mb-0">Monthly</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center border-bottom pb-3 mb-3">
                                            <span>Basic</span>
                                            <h5 class="d-flex align-items-center mb-0 justify-content-center mt-1">$50 <span class="fs-14 fw-medium ms-1">/ month</span></h5>
                                        </div>
                                        <div class="d-block">
                                            <div>
                                                <p class="d-flex align-items-center fs-16 text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>10 Contacts
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>10 Leads
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>20 Companies
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>50 Compaigns
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>100 Projects
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-xbox-x-filled text-body"></i></span><del>Deals</del>
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-xbox-x-filled text-body"></i></span><del>Tasks</del>
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark">
                                                    <span class="me-1"><i class="ti ti-xbox-x-filled text-body"></i></span><del>Pipelines</del>
                                                </p>
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="#" class="btn btn-primary w-100">Choose</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center border-bottom pb-3 mb-3">
                                            <span>Business</span>
                                            <h5 class="d-flex align-items-center mb-0 justify-content-center mt-1">$200 <span class="fs-14 fw-medium ms-1">/ month</span></h5>
                                        </div>
                                        <div class="d-block">
                                            <div>
                                                <p class="d-flex align-items-center fs-16 text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>20 Contacts
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>20 Leads
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>50 Companies
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Unlimited Compaigns
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Unlimited Projects
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-xbox-x-filled text-body"></i></span><del>Deals</del>
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-xbox-x-filled text-body"></i></span><del>Tasks</del>
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark">
                                                    <span class="me-1"><i class="ti ti-xbox-x-filled text-body"></i></span><del>Pipelines</del>
                                                </p>
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="#" class="btn btn-primary w-100">Choose</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center border-bottom pb-3 mb-3">
                                            <span>Enterprise</span>
                                            <h5 class="d-flex align-items-center mb-0 justify-content-center mt-1">$400 <span class="fs-14 fw-medium ms-1">/ month</span></h5>
                                        </div>
                                        <div class="d-block">
                                            <div>
                                                <p class="d-flex align-items-center fs-16 text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Unlimited Contacts
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Unlimited Leads
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Unlimited Companies
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Unlimited Compaigns
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Unlimited Projects
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Deals
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Tasks
                                                </p>
                                                <p class="d-flex align-items-center fs-16 fw-medium text-dark">
                                                    <span class="me-1"><i class="ti ti-circle-check-filled text-success"></i></span>Pipelines
                                                </p>
                                            </div>
                                            <div class="text-center mt-3">
                                                <a href="#" class="btn btn-primary w-100">Choose</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
            <!-- card end -->

        </div>
        <!-- End Content -->   

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection   