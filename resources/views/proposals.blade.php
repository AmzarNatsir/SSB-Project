<?php $page = 'proposals'; ?>
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
                    <h4 class="mb-1">Proposals<span class="badge badge-soft-primary ms-2">125</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Proposals</li>
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Subjects</a>
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
                                                            SEO Proposals
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Web Design
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Logo & Branding
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Development
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Logo
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#owner" aria-expanded="false" aria-controls="owner">Sent to</a>
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
                                                            NovaWave LLC
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Redwood Inc
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            HarborVie w
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            CoastalStar Co.
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            RiverStone Ventur
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date" aria-expanded="false" aria-controls="date">Date of Proposals</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="date" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="input-group w-auto input-group-flat">
                                                    <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y">
                                                    <span class="input-group-text">
                                                        <i class="ti ti-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date2" aria-expanded="false" aria-controls="date2">Create Date</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="date2" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="input-group w-auto input-group-flat">
                                                    <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y">
                                                    <span class="input-group-text">
                                                        <i class="ti ti-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#project" aria-expanded="false" aria-controls="project">Project</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="project" data-bs-parent="#accordionExample">
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
                                                            Truelysell
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Dreamsports
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Best@laundry
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Doccure
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
                                    <a href="" class="btn btn-primary w-100">Filter</a>
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
                        <a href="{{url('proposals-list')}}" class="btn btn-sm p-1 border-0 fs-14"><i class="ti ti-list-tree"></i></a>
                        <a href="{{url('proposals')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 active"><i class="ti ti-grid-dots"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Proposal</a>
                </div>
            </div>
            <!-- table header -->

            <!-- Proposal Grid -->
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-success">Accepted</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-01.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);" class="text-default">NovaWave
                                            LLC</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger">Deleted</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-02.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);" class="text-default">Redwood
                                            Inc</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-info">Draft</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-03.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);"
                                            class="text-default">HarborView</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-secondary">Declined</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-04.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);"
                                            class="text-default">CoastalStar Co.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-secondary">Declined</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-05.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);" class="text-default">Summit
                                            Peak</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-teal">Sent</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-07.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);" class="text-default">Silver
                                            Hawk</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-danger">Deleted</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-06.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);" class="text-default">BlueSky
                                            Industries</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                <div class="flex-shrink-0">
                                    <span class="badge badge-soft-info">#1493016</span>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_proposals"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> View
                                            Proposal</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-checks"></i> Mark As
                                            Accepted</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file text-tertiary"></i> Mark as
                                            Draft</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-sticker text-blue"></i> Mark ad
                                            Declined</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask text-pink"></i> Convert to
                                            estimate</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-file-invoice text-tertiary"></i>
                                            Convert to Invoice</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1 fs-14 fw-semibold">SEO Proposal</h4>
                                        <p class="fs-13 mb-0">Project : Truelysell</p>
                                    </div>
                                    <div>
                                        <span class="badge bg-info">Draft</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-moneybag fs-12"></i></span>Total Value
                                        : $2,04,214</p>
                                    <p class="d-flex align-items-center mb-2"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-event fs-12"></i></span>Date :
                                        25 May 2024</p>
                                    <p class="d-flex align-items-center"><span
                                            class="me-2 text-dark"><i
                                                class="ti ti-calendar-stats fs-12"></i></span>Open
                                        till : 31 Jun 2024</p>
                                </div>
                            </div>
                            <div class="rounded">
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);"
                                        class="avatar rounded-circle bg-white border me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-08.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div class="d-flex flex-column">
                                        <span class="d-block">Sent to</span>
                                        <a href="javascript:void(0);" class="text-default">NovaWave
                                            LLC</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Proposal Grid -->

            <div class="load-btn text-center">
                <a href="javascript:void(0);" class="btn btn-primary"><i class="ti ti-loader me-1"></i>Load More</a>
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