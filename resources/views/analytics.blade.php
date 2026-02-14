<?php $page = 'analytics'; ?>
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
                    <h4 class="mb-0">Analytics</h4>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- start row -->
            <div class="row">

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Recently Created Contacts</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table dataTable table-nowrap mb-0" id="analytic-contact">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Contact</th>
                                            <th>Phone</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Won Deals Stage</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Marketing Pipeline
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Marketing Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Sales Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Email
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Chats
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Operational
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div id="won-chart"></div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Recently Created Deals</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap custom-table mb-0" id="analytic-deal">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Deal Name</th>
                                            <th>Stage</th>
                                            <th>Deal Value</th>
                                            <th>Probability</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Lost Leads Stage</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Marketing Pipeline
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Marketing Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Sales Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Email
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Chats
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Operational
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div id="last-chart-2"></div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card ">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Leads By Stage</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Sales Pipeline
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Marketing Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Sales Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Email
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Chats
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Operational
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div id="leads-chart"></div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Recently Added Companies</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add_2"><i class="ti ti-square-rounded-plus me-1"></i>Add New Company</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0" id="analytic-company">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Phone</th>
                                            <th>Created at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Deals By Stage</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Sales Pipeline
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Marketing Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Sales Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Email
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Chats
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Operational
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div id="deals-chart"></div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Activities</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus me-1"></i>Add New Activity</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body p-3">

                                    <!-- start row -->
                                    <div class="row align-items-center row-gap-2">

                                        <div class="col-sm-4">
                                            <div class="activity-name">
                                                <h6 class="fs-14 fw-medium mb-1">We scheduled a meeting</h6>
                                                <p class="fs-13 mb-1">25 sep 2025, 12:12 PM</p>
                                                <span class="badge bg-info">Meeting</span>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar flex-shrink-0">
                                                    <img src="{{URL::asset('build/img/profiles/avatar-12.jpg')}}" class="rounded-circle" alt="">
                                                </span>
                                                <div class="ms-2">
                                                    <h6 class="fs-14 fw-medium mb-1">Elizabeth Morgan</h6>
                                                    <p class="fs-13 mb-0">Product Manager</p>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="text-sm-end">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                                        Inprogress
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Completed
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Inprogress
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Cancelled
                                                        </a>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div> <!-- end col -->
                                        
                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card body -->
                            </div> <!-- end card -->

                            <div class="card">
                                <div class="card-body p-3">

                                    <!-- start row -->
                                    <div class="row align-items-center row-gap-2">

                                        <div class="col-sm-4">
                                            <div class="activity-name">
                                                <h6 class="fs-14 fw-medium mb-1">We scheduled a meeting</h6>
                                                <p class="fs-13 mb-1">28 sep 2025, 12:12 PM</p>
                                                <span class="badge bg-secondary">Email</span>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar flex-shrink-0">
                                                    <img src="{{URL::asset('build/img/profiles/avatar-13.jpg')}}" class="rounded-circle" alt="">
                                                </span>
                                                <div class="ms-2">
                                                    <h6 class="fs-14 fw-medium mb-1">Katherine Brooks</h6>
                                                    <p class="fs-13 mb-0">Installer</p>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="text-sm-end">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                                        Inprogress
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Completed
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Inprogress
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Cancelled
                                                        </a>
                                                    </div>
                                                </div>	
                                            </div>	
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row -->
                                            
                                </div> <!-- end card body -->
                            </div> <!-- end card -->

                            <div class="card">
                                <div class="card-body p-3">

                                    <!-- start row -->
                                    <div class="row align-items-center row-gap-2">

                                        <div class="col-sm-4">
                                            <div class="activity-name">
                                                <h6 class="fs-14 fw-medium mb-1">We scheduled a meeting</h6>
                                                <p class="fs-13 mb-1">25 jun 2025, 12:12 PM</p>
                                                <span class="badge bg-cyan">Task</span>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar flex-shrink-0">
                                                    <img src="{{URL::asset('build/img/profiles/avatar-18.jpg')}}" class="rounded-circle" alt="">
                                                </span>
                                                <div class="ms-2">
                                                    <h6 class="fs-14 fw-medium mb-1">Samantha Reed</h6>
                                                    <p class="fs-13 mb-0">Human Resources</p>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="text-sm-end">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                                        Inprogress
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Completed
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Inprogress
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Cancelled
                                                        </a>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div> <!-- end col -->

                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card body -->
                            </div> <!-- end card -->

                            <div class="card mb-0">
                                <div class="card-body p-3">
                                    
                                    <!-- start row -->
                                    <div class="row align-items-center row-gap-2">

                                        <div class="col-sm-4">
                                            <div class="activity-name">
                                                <h6 class="fs-14 fw-medium mb-1">We scheduled a meeting</h6>
                                                <p class="fs-13 mb-1">20 sep 2025, 12:00 PM</p>
                                                <span class="badge bg-teal">Calls</span>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar flex-shrink-0">
                                                    <img src="{{URL::asset('build/img/profiles/avatar-20.jpg')}}" class="rounded-circle" alt="">
                                                </span>
                                                <div class="ms-2">
                                                    <h6 class="fs-14 fw-medium mb-1">William Anderson</h6>
                                                    <p class="fs-13 mb-0">Data Analytics</p>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->

                                        <div class="col-sm-4">
                                            <div class="text-sm-end">
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                                        Inprogress
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Completed
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Inprogress
                                                        </a>
                                                        <a href="javascript:void(0);" class="dropdown-item">
                                                            Cancelled
                                                        </a>
                                                    </div>
                                                </div>	
                                            </div>	
                                        </div> <!-- end col -->
                                        
                                    </div>
                                    <!-- end row -->

                                </div>		
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Lost Leads Stage</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Marketing Pipeline
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Marketing Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Sales Pipeline
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Email
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Chats
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Operational
                                            </a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body py-0">
                            <div id="last-chart"></div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <div class="card ">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Recently Created Leads</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0" id="analytic-lead">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Lead Name</th>
                                            <th>Company Name</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <h6 class="mb-0">Recently Created Campaign</h6>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="dropdown me-2">
                                        <a class="dropdown-toggle btn btn-outline-white shadow" data-bs-toggle="dropdown" href="javascript:void(0);">
                                            Last 30 Days
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 30 Days
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 3 Months
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                Last 6 Months
                                            </a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pipeline"><i class="ti ti-square-rounded-plus me-2"></i>Add Pipeline</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="overflow-x-auto">									
                                <div class="card w-min-content mb-3">
                                    <div class="card-body p-3">
                                        <div class="border-bottom mb-2 pb-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="w-25">
                                                    <h6 class="fs-14 fw-medium mb-1">Distribution</h6>
                                                    <p class="fs-13 mb-0">Public Relations</p>
                                                </div>
                                                <div class="w-auto">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">40.5%</h6>
                                                            <p class="fs-13 mb-0">Opened</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">20.5%</h6>
                                                            <p class="fs-13 mb-0">Closed</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">30.5%</h6>
                                                            <p class="fs-13 mb-0">Unsubscribe</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">70.5%</h6>
                                                            <p class="fs-13 mb-0">Delivered</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">35.0%</h6>
                                                            <p class="fs-13 mb-0">Conversation</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>											
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-pill bg-danger">Bounced</span>
                                                <p class="fs-13 mb-0">Due Date : 25 Sep 2025</p>
                                            </div>
                                            <div class="avatar-list-stacked avatar-group-sm">
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-14.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-15.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-16.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-17.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded bg-light text-dark fs-10 fw-medium">+8</a>
                                            </div>
                                        </div>
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->

                                <div class="card w-min-content mb-3">
                                    <div class="card-body p-3">
                                        <div class="border-bottom mb-2 pb-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="w-25">
                                                    <h6 class="fs-14 fw-medium mb-1">Pricing</h6>
                                                    <p class="fs-13 mb-0">Social Marketing</p>
                                                </div>
                                                <div class="w-auto">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">70.5%</h6>
                                                            <p class="fs-13 mb-0">Opened</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">90.5%</h6>
                                                            <p class="fs-13 mb-0">Closed</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">20.5%</h6>
                                                            <p class="fs-13 mb-0">Unsubscribe</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">90.5%</h6>
                                                            <p class="fs-13 mb-0">Delivered</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">98.0%</h6>
                                                            <p class="fs-13 mb-0">Conversation</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>											
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-pill bg-teal">Running</span>
                                                <p class="fs-13 mb-0">Due Date : 28 Sep 2025</p>
                                            </div>
                                            <div class="avatar-list-stacked avatar-group-sm">
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-11.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-12.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-13.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-14.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded bg-light text-dark fs-10 fw-medium">+2</a>
                                            </div>
                                        </div>
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->

                                <div class="card w-min-content mb-3">
                                    <div class="card-body p-3">
                                        <div class="border-bottom mb-2 pb-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="w-25">
                                                    <h6 class="fs-14 fw-medium mb-1">Merchandising</h6>
                                                    <p class="fs-13 mb-0">Content Marketing</p>
                                                </div>
                                                <div class="w-auto">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">30.5%</h6>
                                                            <p class="fs-13 mb-0">Opened</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">10.5%</h6>
                                                            <p class="fs-13 mb-0">Closed</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">70.5%</h6>
                                                            <p class="fs-13 mb-0">Unsubscribe</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">90.5%</h6>
                                                            <p class="fs-13 mb-0">Delivered</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">45.0%</h6>
                                                            <p class="fs-13 mb-0">Conversation</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>											
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-pill bg-cyan">Paused</span>
                                                <p class="fs-13 mb-0">Due Date : 14 Sep 2025</p>
                                            </div>
                                            <div class="avatar-list-stacked avatar-group-sm">
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-04.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-06.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-08.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded bg-light text-dark fs-10 fw-medium">+4</a>
                                            </div>
                                        </div>										
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->

                                <div class="card w-min-content mb-0">
                                    <div class="card-body p-3">
                                        <div class="border-bottom mb-2 pb-2">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="w-25">
                                                    <h6 class="fs-14 fw-medium mb-1">Repeat Customer</h6>
                                                    <p class="fs-13 mb-0">Rebranding</p>
                                                </div>
                                                <div class="w-auto">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">80.5%</h6>
                                                            <p class="fs-13 mb-0">Opened</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">20.5%</h6>
                                                            <p class="fs-13 mb-0">Closed</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">70.5%</h6>
                                                            <p class="fs-13 mb-0">Unsubscribe</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">60.5%</h6>
                                                            <p class="fs-13 mb-0">Delivered</p>
                                                        </div>
                                                        <div>
                                                            <h6 class="fs-14 fw-semibold mb-1">75.0%</h6>
                                                            <p class="fs-13 mb-0">Conversation</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>											
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge badge-pill bg-danger">Bounced</span>
                                                <p class="fs-13 mb-0">Due Date : 25 Sep 2023</p>
                                            </div>
                                            <div class="avatar-list-stacked avatar-group-sm">
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-01.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-03.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-05.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded"><img src="{{URL::asset('build/img/profiles/avatar-07.jpg')}}" class="border border-white" alt="img"></a>
                                                <a href="#" class="avatar avatar-rounded bg-light text-dark fs-10 fw-medium">+5</a>
                                            </div>
                                        </div>
                                    </div> <!-- end card body -->
                                </div> <!-- end card -->
                                
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

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