<?php $page = 'invoices'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
                <div>
                    <h4 class="mb-1">Invoices<span class="badge badge-soft-primary ms-2">125</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
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
                                        PDF</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls me-1"></i>Export as
                                        Excel </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>                
            <!-- End Page Header -->

                <!-- table header -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-light shadow px-2" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="ti ti-filter me-2"></i>Filter<i class="ti ti-chevron-down ms-2"></i></a>
                        <div class="filter-dropdown-menu dropdown-menu dropdown-menu-lg p-0">
                            <div class="filter-header d-flex align-items-center justify-content-between border-bottom">
                                <h6 class="mb-0"><i class="ti ti-filter me-1"></i>Filter</h6>
                                <button type="button" class="btn-close close-filter-btn" data-bs-dismiss="dropdown-menu" aria-label="Close"></button>
                            </div>
                            <div class="filter-set-view p-3">                                            
                                <div class="accordion" id="accordionExample">
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Client</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-1">
                                                    <div class="input-icon-start input-icon position-relative">
                                                        <span class="input-icon-addon fs-12">
                                                            <i class="ti ti-search"></i>
                                                        </span>
                                                        <input type="text" class="form-control form-control-md" placeholder="Search">
                                                    </div>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            NovaWave LLC
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Redwood Inc
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Harborview
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#owner" aria-expanded="false" aria-controls="owner">Project</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="owner" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-1">
                                                    <div class="input-icon-start input-icon position-relative">
                                                        <span class="input-icon-addon fs-12">
                                                            <i class="ti ti-search"></i>
                                                        </span>
                                                        <input type="text" class="form-control form-control-md" placeholder="Search">
                                                    </div>
                                                </div>
                                                <ul class="mb-0">
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Turelysell
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Dreamschat
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            DreamGigs
                                                        </label>
                                                    </li>
                                                    <li class="mb-0">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Servbook
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#Status" aria-expanded="false" aria-controls="Status">Amount</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="Status" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            $2,15,000
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            $1,45,000	
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            $2,12,000
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            $4,80,380
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                                             
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="javascript:void(0);" class="btn btn-outline-light w-100">Reset</a>
                                    <a href="{{url('invoices')}}" class="btn btn-primary w-100">Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-icon input-icon-start position-relative">
                        <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">                               
                    <div class="d-flex align-items-center shadow p-1 rounded border view-icons bg-white">
                        <a href="{{url('invoice-list')}}" class="btn btn-sm p-1 border-0 fs-14"><i class="ti ti-list-tree"></i></a>
                        <a href="{{url('invoices')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 active"><i class="ti ti-grid-dots"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Invoice</a>
                </div>
            </div>
            <!-- table header -->

            <!-- start row -->
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                <div class="users-profile">
                                    <span class="badge badge-soft-info">#1465781</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                        <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/truellysel.svg')}}" class="w-auto h-auto rounded-0" alt="Truelysell">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Truelysell</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary">Partially Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$2,15,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">22 Jun 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$2,15,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$0</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-01.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">BlueSky Industries</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465782</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/dreamchat.svg')}}" class="w-auto h-auto rounded-0" alt="Truelysell">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Dreamschat</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$1,45,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">20 May 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$1,45,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$0</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-02.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">NovaWave LLC</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465783</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/truellysell.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">DreamGigs</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-warning">Partially Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$2,15,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">30 Apr 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$1,00,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$1,15,000</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-03.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">Silver Hawk</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465784</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/servbook.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Servbook</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$4,80,380</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">21 Apr 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$4,80,380</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$0</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-04.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">Summit  Peak</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465785</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/dream-pos.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">DreamPOS</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-danger">Unpaid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$2,12,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">19 Mar 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$0</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$2,12,000</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-05.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">RiverStone Ltd</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465786</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/kofejob.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Kofejob</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary">Partially Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$3,50,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">11 Mar 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$1,50,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$2,00,000</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-06.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">Bright Bridge Grp</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465787</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/smarthr.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">SmartHR</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-info">Overdue</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$2,46,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">17 Feb 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$1,23,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$1,23,000</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-07.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">CoastalStar Co.</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465788</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/doccure.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Doccure</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$3,12,500</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">07 Feb 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$3,12,500</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$0</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-09.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">HarborView</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465789</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/laundry.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Best@laundry</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-danger">Unpaid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$4,18,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">20 Jan 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$0</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$4,18,000</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-10.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">Golden Gate Ltd</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465790</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/sports.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Dreamsports</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$5,00,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">18 Jan 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$5,00,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$0</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-08.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">Redwood Inc</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="card border shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-3">
                                    <div class="users-profile">
                                        <span class="badge badge-soft-info">#1465791</span>
                                    </div>
                                        <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i>Edit</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                            <a class="dropdown-item d-inline-flex align-items-center" href="javascript:void(0);"><i class="ti ti-file me-1"></i>Mark as Partially Paid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i>Mark ad Unpaid</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border flex-shrink-0 me-2">
                                                <img src="{{URL::asset('build/img/priority/gig.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                            </a>
                                            <div>
                                                <h6 class="fs-14 fw-medium mb-0"><a href="{{url('project-details')}}">Dreamsgigs</a></h6>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary">Partially Paid</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-report-money text-dark fs-16 me-1"></i>Total Value : <span class="text-dark ms-1">$5,00,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-event text-dark fs-16 me-1"></i>Due Date : <span class="text-dark ms-1">19 Jan 2025</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-1"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Paid Amount : <span class="text-dark ms-1">$2,15,000</span></p>
                                        <p class="text-default d-inline-flex align-items-center mb-0"><i class="ti ti-calendar-stats text-dark fs-16 me-1"></i>Balance Amount : <span class="text-dark ms-1">$2,15,000</span></p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}" class="avatar avatar-rounded border me-2">
                                        <img src="{{URL::asset('build/img/company/company-11.svg')}}" class="w-auto h-auto rounded-0" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <h6 class="fs-14 fw-medium mb-1"><a href="{{url('company-details')}}">Acme Corp.</a></h6>
                                        <span class="d-block fs-13">Sent to</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <!-- end row -->

            <div class="load-btn text-center">
                <a href="javascript:void(0);" class="btn btn-primary"><i class="ti ti-loader me-1"></i> Load More</a>
            </div>

        </div>
        <!-- End Content -->

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection        