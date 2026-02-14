<?php $page = 'contracts'; ?>
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
                    <h4 class="mb-1">Contracts<span class="badge badge-soft-primary ms-2">125</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contracts</li>
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Contracts Id</a>
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
                                                            #274729
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                        <input class="form-check-input m-0 me-1" type="checkbox">
                                                            #274730
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                        <input class="form-check-input m-0 me-1" type="checkbox">
                                                            #274731
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                        <input class="form-check-input m-0 me-1" type="checkbox">
                                                            #274732
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                        <input class="form-check-input m-0 me-1" type="checkbox">
                                                            #274733
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                        <input class="form-check-input m-0 me-1" type="checkbox">
                                                            #274734
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#owner" aria-expanded="false" aria-controls="owner">Subject</a>
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
                                                            SEO Proposal
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Web Design
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Logo & Branding
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Development
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Business Card Design
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Customer</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="collapseFive" data-bs-parent="#accordionExample">
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
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{URL::asset('build/img/company/company-01.svg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>NovaWave LLC
                                                        </label>
                                                    </li>
                                                        <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{URL::asset('build/img/company/company-02.svg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>BlueSky Industries
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{URL::asset('build/img/company/company-03.svg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Silver Hawk
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#Status" aria-expanded="false" aria-controls="Status">Contract Type</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="Status" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                        <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Contract Under Seal
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Executory Contracts
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                                             
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="javascript:void(0);" class="btn btn-outline-light w-100">Reset</a>
                                    <a href="{{url('contacts-list')}}" class="btn btn-primary w-100">Filter</a>
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
                    <div class="d-flex align-items-center shadow p-1 rounded border bg-white view-icons">
                        <a href="{{url('contracts-list')}}" class="btn btn-sm p-1 border-0 fs-14"><i class="ti ti-list-tree"></i></a>
                        <a href="{{url('contracts')}}" class="flex-shrink-0 btn btn-sm active p-1 border-0 ms-1 fs-14"><i class="ti ti-grid-dots"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Contract</a>
                </div>
            </div>
            <!-- table header -->
            
            <!-- Contact Grid -->
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274729</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">SEO Contracts</h6>
                                    <p>Category : Contracts under Seal</p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">23 Nov 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">17 Dec 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-01.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">NovaWave LLC</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value : $2,04,214</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274730</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Web Design</h6>
                                    <p>Category : Executory Contracts</p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">07 Nov 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">11 Dec 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-02.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">BlueSky Industries</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $1,45,000</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274731</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Logo & Branding</h6>
                                    <p>Category : Express Contracts</p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">15 Oct 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">23 Nov 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-03.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">Sliver Hawk</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $2,15,000</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274732</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Development</h6>
                                    <p>Category : Implied Contracts</p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">28 Sep 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">12 Nov 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-04.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">Summit Peak</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $4,80,380</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274733</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Business Card Design</h6>
                                    <p>Category : Unconscionable </p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">25 Sep 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">07 Nov 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-05.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">RiverStone Ltd</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $4,80,380</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274734</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Technical SEO</h6>
                                    <p>Category : Fixed Price Contract </p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">12 Sep 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">27 Oct 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-06.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">Bright Bridge Grp</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $3,50,000</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274735</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Social Media profile Branding</h6>
                                    <p>Category : Cost Plus Contract </p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">17 Aug 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">15 Oct 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-07.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">CoastalStar.Co.</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $1,23,000</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274736</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Portfolio Site</h6>
                                    <p>Category : Service Level Agreement </p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">11 Jun 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">04 Oct 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-08.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">HarborView</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $3,12,500</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274737</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Logo Design</h6>
                                    <p>Category : Partnership  Contract </p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">11 Mar 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">29 Sep 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-09.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">Golden Gate Ltd</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $4,18,000</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274738</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Web Design</h6>
                                    <p>Category : Executory Contracts</p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">27 Jan 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">25 Sep 2025</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-10.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">BlueSky Industries</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $1,45,000</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274739</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">HarborView</h6>
                                    <p>Category : Implied Contracts </p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">17 Dec 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">18 Oct 2026</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-07.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">RiverStone Ltd</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $4,18,000</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <span class="badge badge-soft-info">274740</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit"><i class="ti ti-edit"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_contracts"><i class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-copy"></i> Clone</a>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_view"><i class="ti ti-clipboard-copy"></i> View  Contract</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-checks"></i> Mark as Signed</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="mb-3">
                                    <h6 class="fs-14 mb-1 fw-semibold">Business Card Design</h6>
                                    <p>Category : Partnership  Contract </p>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span class="text-dark me-1"><i class="ti ti-calendar-event fs-16"></i></span>Date : <span class="text-dark ms-1">18 Dec 2025</span></p>
                                    <p class="d-flex align-items-center"><span class="text-dark me-1"><i class="ti ti-calendar-stats fs-16"></i></span>Open till : <span class="text-dark ms-1">19 Oct 2026</span></p>
                                </div>
                                <div class="bg-light border rounded d-flex align-items-center p-2 mb-3">
                                    <a href="javascript:void(0);" class="avatar rounded-circle border bg-white me-2">
                                        <img src="{{URL::asset('build/img/company/company-08.svg')}}" class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <a href="javascript:void(0);" class="text-dark fw-medium">RiverStone Ltd</a>
                                        <span class="d-block">Customer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <div>
                                    <span class="badge badge-soft-info border-0"> <i class="ti ti-moneybag me-1"></i>Value: $4,80,380</span>
                                </div>
                                <a href="javascript:void(0);" class="avatar avatar-xs bg-light text-dark rounded-circle"> <i class="ti ti-file-dots fs-12"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Contact Grid -->

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