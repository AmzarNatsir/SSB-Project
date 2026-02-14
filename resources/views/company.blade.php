<?php $page = 'company'; ?>
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
                    <h4 class="mb-1">Companies<span class="badge badge-soft-primary ms-2">152</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Companies</li>
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
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Page</a>
                </div>
                <div class="card-body">

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
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#country" aria-expanded="false" aria-controls="country">Country</a>
                                                </div>
                                                <div class="filter-set-contents accordion-collapse collapse" id="country" data-bs-parent="#accordionExample">
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
                                                                    USA
                                                                </label>
                                                            </li>
                                                            <li class="mb-1">
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    France
                                                                </label>
                                                            </li>
                                                            <li class="mb-1">
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Italy
                                                                </label>
                                                            </li>
                                                            <li class="mb-1">
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Germany
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="link-primary text-decoration-underline p-2 pt-0 d-flex">Load More</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="filter-set-content">
                                                <div class="filter-set-content-head">
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#owner" aria-expanded="false" aria-controls="owner">Owner</a>
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
                                                                    Hendry Milner
                                                                </label>
                                                            </li>
                                                            <li class="mb-1">
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Guilory Berggren
                                                                </label>
                                                            </li>
                                                            <li class="mb-1">
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Jami Carlile
                                                                </label>
                                                            </li>
                                                            <li class="mb-1">
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Theresa Nelson
                                                                </label>
                                                            </li>
                                                            <li class="mb-1">
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Smith Cooper
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0);" class="link-primary text-decoration-underline p-2 pt-0 d-flex">Load More</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="filter-set-content">
                                                <div class="filter-set-content-head">
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Tags</a>
                                                </div>
                                                <div class="filter-set-contents accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
                                                    <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                        <ul>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Collab
                                                                </label>
                                                            </li>
                                                                <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Promotion
                                                                </label>
                                                            </li>
                                                                <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    VIP
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="filter-set-content">
                                                <div class="filter-set-content-head">
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Rating</a>
                                                </div>
                                                <div class="filter-set-contents accordion-collapse collapse" id="collapseOne" data-bs-parent="#accordionExample">
                                                    <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                        <ul>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                        <span class="rating">
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <span class="ms-1">5.0</span>
                                                                    </span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                        <span class="rating">
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <span class="ms-1">4.0</span>
                                                                    </span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                        <span class="rating">
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <span class="ms-1">3.0</span>
                                                                    </span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                        <span class="rating">
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <span class="ms-1">2.0</span>
                                                                    </span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                        <span class="rating">
                                                                        <i class="ti ti-star-filled text-warning"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <i class="ti ti-star-filled"></i>
                                                                        <span class="ms-1">1.0</span>
                                                                    </span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="filter-set-content">
                                                <div class="filter-set-content-head">
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#Status" aria-expanded="false" aria-controls="Status">Status</a>
                                                </div>
                                                <div class="filter-set-contents accordion-collapse collapse" id="Status" data-bs-parent="#accordionExample">
                                                    <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                        <ul>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Active
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Inactive
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>                                             
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="javascript:void(0);" class="btn btn-outline-light w-100">Reset</a>
                                            <a href="{{url('company')}}" class="btn btn-primary w-100">Filter</a>
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
                                            <a href="javascript:void(0);" class="dropdown-item">Recently Viewed</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item">Recently Added</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item">Ascending</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item">Descending</a>
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
                                                    <span>Name</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Email</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Account URL</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Plan</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Created Dated</span>   
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
                                        <li class="gap-1 d-flex align-items-center">       
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
                        </div>
                    </div>
                    <!-- table header -->

                    <!-- Report List -->
                    <div class="table-responsive custom-table">
                        <table class="table table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th class="no-sort"></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Account URL</th>
                                    <th>Plan</th>
                                    <th>Created Dated</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select filled"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-01.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">NovaWave LLC</a>
                                        </div>
                                    </td>
                                    <td>nova@llc.com</td>
                                    <td>nw.nova.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Advanced (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>25 Feb 2025, 01:22 PM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-02.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">BlueSky Industries</a>
                                        </div>
                                    </td>
                                    <td>bluesky@ind.com</td>
                                    <td>bl.blue.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Enterprise (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>03 Apr 2025, 09:45AM</td>
                                    <td><span class="badge bg-danger">Inactive</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-03.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">Silver Hawk</a>
                                        </div>
                                    </td>
                                    <td>silver@hawk.com</td>
                                    <td>sh.silver.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Advanced (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>14 Apr 2025, 11:11AM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-04.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">Summit  Peak</a>
                                        </div>
                                    </td>
                                    <td>sumpK@peak.com</td>
                                    <td>sp.summer.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Advanced (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>12 May 2025, 01:09AM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-05.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">RiverStone Ventur</a>
                                        </div>
                                    </td>
                                    <td>stone@river.com</td>
                                    <td>ro.stone.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Basic (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>28 May 2025, 07:08AM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-06.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">Bright Bridge Grp</a>
                                        </div>
                                    </td>
                                    <td>bright@grp.com</td>
                                    <td>bb.bright.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Enterprise (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>01 July 2025, 02:15AM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-07.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">CoastalStar Co.</a>
                                        </div>
                                    </td>
                                    <td>coastal@star.com</td>
                                    <td>cs.coastal.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Advanced (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>20 Jul 2025, 10:25AM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-08.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">HarborView</a>
                                        </div>
                                    </td>
                                    <td>harbor@view.com</td>
                                    <td>hv.harbor.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Advanced (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>16 Sep 2025, 02:10 PM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-09.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">Golden Gate Ltd</a>
                                        </div>
                                    </td>
                                    <td>golden@gate.com</td>
                                    <td>ggt.golden.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Enterprise (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>10 Oct 2025, 10:15AM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled fs-16"></i></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);" class="avatar rounded-circle border p-1 me-2">
                                                <img class="w-auto h-auto" src="{{URL::asset('build/img/icons/company-icon-10.svg')}}" alt="User Image">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fw-medium">Redwood Inc</a>
                                        </div>
                                    </td>
                                    <td>wood@inc.com</td>
                                    <td>ri.redwood.com</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span>Basic (Monthly)</span>
                                            <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="offcanvas" data-bs-target="#upgrade_plan">Upgrade</a>
                                        </div>
                                    </td>
                                    <td>01 Nov 2025, 01:32 PM</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light " data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                    <i class="ti ti-edit text-blue me-1"></i>Edit
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_company">
                                                    <i class="ti ti-trash text-blue me-1"></i>Delete
                                                </a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#company_detail">
                                                    <i class="ti ti-eye text-blue me-1"></i>View
                                                </a>
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
                    <!-- /Contact List -->
                        
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