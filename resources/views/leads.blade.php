<?php $page = 'leads'; ?>
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
                    <h4 class="mb-1">Leads<span class="badge badge-soft-primary ms-2">123</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leads</li>
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
                                            <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Lead Name</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse show" id="collapseTwo" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-2">
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
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-06.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Elizabeth Morgan
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-40.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Katherine Brooks
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-05.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Sophia Lopez
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-10.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>John Michael
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-15.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Natalie Brooks
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>William Turner
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-13.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Ava Martinez
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-12.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Nathan Reed
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-03.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Lily Anderson
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-18.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Ryan Coleman
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="link-primary text-decoration-underline p-2 d-flex">Load More</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Company Name</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-2">
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
                                                            BlueSky Industries
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Silver Hawk
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Summit  Peak
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#status" aria-expanded="false" aria-controls="status">Lead Status</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="status" data-bs-parent="#accordionExample">
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
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Closed
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Not Closed
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Contacted
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Lost
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date2" aria-expanded="false" aria-controls="date2">Created Date</a>
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#owner" aria-expanded="false" aria-controls="owner">Lead Owner</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="owner" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-2">
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
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-17.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Robert Johnson
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-16.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Isabella Cooper
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-14.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>John Smith
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-22.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Sophia Parker
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-25.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Emma Reynolds
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-24.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Liam Carter
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-39.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Noah Mitchell
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-31.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Mason Hayes
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-21.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Ron Thompson
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xs rounded-circle me-2"><img src="{{URL::asset('build/img/users/user-10.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Laura Bennett
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
                        <a href="{{url('leads-list')}}" class="btn btn-sm p-1 border-0 fs-14"><i class="ti ti-list-tree"></i></a>
                        <a href="{{url('leads')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 active"><i class="ti ti-grid-dots"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Lead</a>
                </div>
            </div>
            <!-- table header -->
            
            <!-- Leads Kanban -->
            <div class="d-flex overflow-x-auto align-items-start gap-3">
                <div class="kanban-list-items p-2 rounded border">
                    <div class="card mb-0 border-0 shadow">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="d-flex align-items-center mb-1"><i
                                            class="ti ti-circle-filled fs-10 text-warning me-1"></i>Contacted
                                    </h6>
                                    <span class="fw-medium">45 Leads - $15,44,540</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="text-info"><i
                                            class="ti ti-plus"></i></a>
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_lead"><i
                                                    class="fa-regular fa-trash-can text-danger"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kanban-drag-wrap">
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-secondary"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-info flex-shrink-0 me-2"><span
                                                    class="avatar-title text-info">SM</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Schumm</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $03,50,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            darleeo@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 12445-47878
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Newyork, United States
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-09.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-secondary"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-danger flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">CS</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Collins</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $02,10,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            robertson@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 13987-90231
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Austin, United States
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-01.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-secondary"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-warning flex-shrink-0 me-2"><span
                                                    class="avatar-title text-warning">KI</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a
                                                    href="{{url('leads-details')}}">Konopelski</a></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $02,18,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            sharon@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 17932-04278
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Atlanta, United States
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-02.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kanban-list-items p-2 rounded border">
                    <div class="card mb-0 border-0 shadow">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="d-flex align-items-center mb-1"><i
                                            class="ti ti-circle-filled fs-10 text-info me-1"></i>Not
                                        Contacted</h6>
                                    <span class="fw-medium">45 Leads - $15,44,540</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="text-info"><i
                                            class="ti ti-plus"></i></a>
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_lead"><i
                                                    class="fa-regular fa-trash-can text-danger"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kanban-drag-wrap">
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-info"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-danger flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">AS</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Adams</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $02,45,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            vaughan12@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 17392-27846
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            London, United Kingdom
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-03.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-info"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-info flex-shrink-0 me-2"><span
                                                    class="avatar-title text-info">WK</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Wizosk</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $01,17,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            caroltho3@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 78982-09163
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Bristol, United Kingdom
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-04.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-info"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-success flex-shrink-0 me-2"><span
                                                    class="avatar-title text-success">HR</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Heller</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $02,12,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            dawnmercha@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 27691-89246
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            San Francisco, United States
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-05.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kanban-list-items p-2 rounded border">
                    <div class="card mb-0 border-0 shadow">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="d-flex align-items-center mb-1"><i
                                            class="ti ti-circle-filled fs-10 text-success me-1"></i>Closed
                                    </h6>
                                    <span class="fw-medium">45 Leads - $15,44,540</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="text-info"><i
                                            class="ti ti-plus"></i></a>
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item " href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_lead"><i
                                                    class="fa-regular fa-trash-can text-danger"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kanban-drag-wrap">
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-success"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-danger flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">GI</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Gutkowsi</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $01,84,043
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            rachel@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 17839-93617
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Dallas, United States
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-06.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-success"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-warning flex-shrink-0 me-2"><span
                                                    class="avatar-title text-warning">WR</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Walter</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $09,35,189
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            jonelle@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 16739-47193
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Leicester, United Kingdom
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-07.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-success"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-success flex-shrink-0 me-2"><span
                                                    class="avatar-title text-success">HN</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Hansen</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $04,27,940
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            jonathan@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 18390-37153
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Norwich, United Kingdom
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-08.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kanban-list-items p-2 rounded border">
                    <div class="card mb-0 border-0 shadow">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="d-flex align-items-center mb-1"><i
                                            class="ti ti-circle-filled fs-10 text-danger me-1"></i>Lost</h6>
                                    <span class="fw-medium">15 Leads - $14,89,543</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="text-info"><i
                                            class="ti ti-plus"></i></a>
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item " href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_lead"><i
                                                    class="fa-regular fa-trash-can text-danger"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kanban-drag-wrap">
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-danger"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-danger flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">SE</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Steve</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $04,17,593
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            sidney@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 11739-38135
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Manchester, United Kingdom
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-09.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-danger"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-info flex-shrink-0 me-2"><span
                                                    class="avatar-title text-info">LE</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Leuschke</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $08,81,389
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            brook@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 19302-91043
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Chicago, United States
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-10.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card kanban-card border mb-0 mt-3 shadow ui-sortable-handle">
                                <div class="card-body">
                                    <div class="d-block">
                                        <div class="card-topbar mb-3 pt-1 bg-danger"></div>
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('leads-details')}}"
                                                class="avatar rounded-circle bg-soft-danger flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">AY</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('leads-details')}}">Anthony</a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $09,27,193
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            mickey@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 17280-92016
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Derby, United Kingdom
                                        </p>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3">
                                        <span
                                            class="avatar avatar-xs border rounded-circle d-flex align-items-center justify-content-center p-1"><img
                                                src="{{URL::asset('build/img/icons/company-icon-01.svg')}}"
                                            alt=""></span>
                                        <div class="icons-social d-flex align-items-center gap-1">
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-phone-check"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center me-1"><i
                                                    class="ti ti-message-circle-2"></i></a>
                                            <a href="#"
                                                class="d-flex align-items-center justify-content-center"><i
                                                    class="ti ti-color-swatch"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Leads Kanban -->

        </div>
        <!-- End Content -->    

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection        