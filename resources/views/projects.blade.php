<?php $page = 'projects'; ?>
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
                    <h4 class="mb-1">Projects<span class="badge badge-soft-primary ms-2">125</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Projects</li>
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Project Name</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                                Turelysell
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Dreamschat
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Servbook
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            DreamsPOS
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Kofejob
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Doccure
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
                                                            Dreamsports
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            SmartHR
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Dreamsports
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#owner" aria-expanded="false" aria-controls="owner">Client Name</a>
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
                                                            BlueSky Industries
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Silver Hawk
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Summit  Peak
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            RiverStone Ltd
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Bright Bridge Grp
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
                                                            HarborView
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Golden Gate Ltd
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Redwood Inc
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#type" aria-expanded="false" aria-controls="type">Type</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="type" data-bs-parent="#accordionExample">
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
                                                            Web App
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Client Meeting
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Mobile App
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            UI/UX Design
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Product Lanuch
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Bug Fixing
                                                        </label>
                                                    </li>
                                                        <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Content creation
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Sales Demo
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            QA Testing
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Customer Support
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date" aria-expanded="false" aria-controls="date">Start Date</a>
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date2" aria-expanded="false" aria-controls="date2">End Date</a>
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
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#stage" aria-expanded="false" aria-controls="stage">Pipeline Stage</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="stage" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Develop
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Meeting
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Design
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Launch
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Fix
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Write
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Demo
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Test
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Support
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
                        <a href="{{url('projects-list')}}" class="btn btn-sm p-1 border-0 fs-14"><i class="ti ti-list-tree"></i></a>
                        <a href="{{url('projects')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 active"><i class="ti ti-grid-dots"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Project</a>
                </div>
            </div>
            <!-- table header -->
            
            <!-- Projects List -->
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/truellysel.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Truelysell</a></h5>
                                        <p class="fs-13 mb-0">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12145</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $03,50,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        15 Oct 2023</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-14.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-15.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-16.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +05
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border rounded-circle flex-shrink-0">
                                            <img src="{{URL::asset('build/img/icons/company-icon-01.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 100</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/dreamchat.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Dreamschat</a></h5>
                                        <p class="fs-13 mb-0">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12145</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $02,15,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        19 Oct 2023</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-01.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-03.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +04
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-02.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 80</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/truellysell.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Truelysell</a></h5>
                                        <p class="fs-13 mb-0">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12147</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $01,45,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        12 Oct 2023</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-04.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-05.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-06.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +04
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-03.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 75</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/servbook.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Servbook</a></h5>
                                        <p class="fs-13 mb-0">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12148</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $02,15,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        24 Oct 2023</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-07.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-08.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-09.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +04
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-04.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 75</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/dream-pos.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">DreamPOS</a></h5>
                                        <p class="mb-0 fs-13">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12149</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $03,64,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        22 Oct 2023</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-10.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-11.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-12.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +03
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-05.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 60</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/project-01.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Kofejob</a></h5>
                                        <p class="fs-13 mb-0">Meeting</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12150</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $02,12,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        09 Dec 2023</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-15.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-16.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-17.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +03
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-06.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 96</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/project-01.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Doccure</a></h5>
                                        <p class="fs-13 mb-0">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12151</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $04,18,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        16 Dec 2023</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-18.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-19.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-20.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +03
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-07.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 80</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/best.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Best@laundry</a></h5>
                                        <p class="fs-13 mb-0">Meeting</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12152</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $01,23,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        13 Jan 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-21.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-22.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-23.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +02
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-08.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 65</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/dream-pos.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">POS</a></h5>
                                        <p class="fs-13 mb-0">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12153</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $03,64,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        11 Jan 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-24.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-25.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-26.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +02
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-09.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 65</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/servbook.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Servbook</a></h5>
                                        <p class="fs-13 mb-0">Meeting</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12153</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $04,10,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        29 Jan 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-27.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-22.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-05.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +02
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-10.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 56</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/dreamchat.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Dreamchat</a></h5>
                                        <p class="fs-13 mb-0">Meeting</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12154</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $04,10,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        30 Jan 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-08.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-12.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-15.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +02
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-01.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 60</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-danger  text-danger me-2 border-0"><i
                                            class="ti ti-square-rounded-filled text-danger fs-8 me-1"></i>High</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <span class="avatar avatar-xs fs-16">
                                    <i class="ti ti-star-filled text-warning"></i>
                                </span>
                            </div>
                            <div
                                class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('project-details')}}"
                                        class="avatar border rounded-circle bg-white flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/priority/sports.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h5 class="fw-medium fs-14"><a
                                                href="{{url('project-details')}}">Sports</a></h5>
                                        <p class="fs-13 mb-0">Web App</p>
                                    </div>
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
                                            data-bs-target="#delete_project"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-clipboard-copy text-green"></i> Clone
                                            this Project</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-printer"></i> Print</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="ti ti-subtask"></i> Add New Task</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <p class="mb-3">Kofejob is a freelancers marketplace where you can
                                    post projects &amp; get instant help.</p>
                                <div class="mb-3">
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-forbid-2 me-2"></i>Project ID : #12155</p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-report-money me-2"></i>Value : $04,10,000
                                    </p>
                                    <p class="d-flex align-items-center mb-2"><i
                                            class="ti ti-calendar-exclamation me-2"></i>Due Date :
                                        31 Jan 2024</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-08.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img class="border border-white"
                                                src="{{URL::asset('build/img/profiles/avatar-12.jpg')}}" alt="img">
                                        </span>
                                        <span class="avatar avatar-rounded">
                                            <img src="{{URL::asset('build/img/profiles/avatar-15.jpg')}}" alt="img">
                                        </span>
                                        <a class="avatar text-dark bg-light border avatar-rounded fs-10"
                                            href="javascript:void(0);">
                                            +02
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm p-1 border flex-shrink-0 rounded-circle">
                                            <img src="{{URL::asset('build/img/icons/company-icon-02.svg')}}" alt="img">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge badge-sm bg-soft-info text-info"><i
                                        class="ti ti-clock-stop me-2"></i>Total Hours : 60</span>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-flex align-items-center me-2"><i
                                            class="ti ti-brand-wechat me-1"></i>02</span>
                                    <span class="d-inline-flex align-items-center"><i
                                            class="ti ti-subtask me-1"></i>04</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Projects List -->

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