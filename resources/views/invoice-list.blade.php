<?php $page = 'invoice-list'; ?>
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

            
            
            <!-- card start -->
            <div class="card border-0 rounded-0">
                <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <div class="input-icon input-icon-start position-relative">
                        <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Invoice</a>
                </div>
                <div class="card-body">

                    <!-- table header -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 fs-16 fw-bold border-0" data-bs-toggle="dropdown">All Invoices</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-dots-vertical me-1"></i>All Invoices</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-dots-vertical me-1"></i>Paid</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-dots-vertical me-1"></i>Partially Paid</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-dots-vertical me-1"></i>Overdue</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-dots-vertical me-1"></i>Unpaid</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                                                            <li class="mb-1">
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
                                            <a href="{{url('invoice-list')}}" class="btn btn-primary w-100">Filter</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="reportrange" class="reportrange-picker d-flex align-items-center shadow">
                                <i class="ti ti-calendar-due text-dark fs-14 me-1"></i><span class="reportrange-picker-field">9 Jun 25 - 9 Jun 25</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">                                
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><i class="ti ti-sort-ascending-2 me-2"></i>Sort By</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item">Newest</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item">Oldest</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="btn bg-soft-indigo px-2 border-0" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="ti ti-columns-3 me-2"></i>Manage Columns</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-md p-3">
                                    <ul>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Invoice ID</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Client</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Project</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Due Date</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch">     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Amount</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Paid AMount</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Status</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-0">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Action</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-center shadow p-1 rounded border view-icons bg-white">
                                <a href="{{url('invoice-list')}}" class="btn btn-sm p-1 border-0 fs-14 active"><i class="ti ti-list-tree"></i></a>
                                <a href="{{url('invoices')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14"><i class="ti ti-grid-dots"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- table header -->

                    <!-- contracts List -->
                    <div class="table-responsive custom-table table-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th></th>
                                    <th>Invoice ID</th>
                                    <th>Client</th>
                                    <th>Project</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265781</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-01.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">NovaWave LLC</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-01.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">Truelysell</a>
                                        </h6>
                                    </td>
                                    <td>22 Jun 2025</td>
                                    <td>$2,15,000</td>
                                    <td>$2,15,000</td>
                                    <td><span class="badge bg-warning">Partially Paid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265782</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-02.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">BlueSky Industries</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-02.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">Dreamschat</a>
                                        </h6>
                                    </td>
                                    <td>20 May 2025</td>
                                    <td>$1,45,000</td>
                                    <td>$1,45,000</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265783</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-03.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">Silver Hawk</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-03.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">DreamGigs</a>
                                        </h6>
                                    </td>
                                    <td>30 Apr 2025</td>
                                    <td>$2,15,000</td>
                                    <td>$1,00,000</td>
                                    <td><span class="badge bg-warning">Partially Paid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265784</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-04.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">Summit Peak</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-04.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">Servbook</a>
                                        </h6>
                                    </td>
                                    <td>21 Apr 2025</td>
                                    <td>$4,80,380</td>
                                    <td>$4,80,380</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265785</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-05.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">RiverStone Ltd</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-05.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">DreamPOS</a>
                                        </h6>
                                    </td>
                                    <td>19 Mar 2025</td>
                                    <td>$2,12,000</td>
                                    <td>$0</td>
                                    <td><span class="badge bg-danger">Unpaid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265786</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-06.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">Bright Bridge Grp</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-06.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">Kofejob</a>
                                        </h6>
                                    </td>
                                    <td>11 Mar 2025</td>
                                    <td>$3,50,000</td>
                                    <td>$1,50,000</td>
                                    <td><span class="badge bg-warning">Partially Paid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265787</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-07.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">CoastalStar Co.</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-07.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">SmartHR</a>
                                        </h6>
                                    </td>
                                    <td>17 Feb 2025</td>
                                    <td>$1,23,000</td>
                                    <td>$1,23,000</td>
                                    <td><span class="badge bg-info">Overdue</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265788</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-08.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">HarborView</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-08.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">Doccure</a>
                                        </h6>
                                    </td>
                                    <td>07 Feb 2025</td>
                                    <td>$3,12,500</td>
                                    <td>$3,12,500</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265789</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-09.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">Golden Gate Ltd</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-09.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">Best@laundry</a>
                                        </h6>
                                    </td>
                                    <td>20 Jan 2025</td>
                                    <td>$4,18,000</td>
                                    <td>$0</td>
                                    <td><span class="badge bg-danger">Unpaid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td><a href="{{url('invoices-details')}}" class="title-name">#1265790</a></td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('company-details')}}" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/company/company-10.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="d-flex flex-column">Redwood Inc</a>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="d-flex align-items-center fs-14 mb-0 fw-medium">
                                            <a href="{{url('project-details')}}" class="avatar avatar-rounded border me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/projects/project-10.svg')}}" alt="User Image">
                                            </a>
                                            <a href="{{url('project-details')}}" class="d-flex flex-column">Dreamsports</a>
                                        </h6>
                                    </td>
                                    <td>18 Jan 2025</td>
                                    <td>$5,00,000</td>
                                    <td>$5,00,000</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_invoices"><i class="ti ti-trash me-1"></i>Delete</a>
                                                <a class="dropdown-item" href="{{url('invoices-details')}}"><i class="ti ti-clipboard-copy me-1"></i> View Invoices</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks me-1"></i> Mark as Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-file me-1"></i> Mark as Partially Paid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-sticker me-1"></i> Mark ad Unpaid</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer me-1"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="datatable-length"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="datatable-paginate"></div>
                        </div>
                    </div>
                    <!-- /contracts List -->
                        
                </div>
            </div>
            <!-- card end -->

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