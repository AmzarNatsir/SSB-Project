<?php $page = 'deals'; ?>
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
                    <h4 class="mb-1">Deals<span class="badge badge-soft-primary ms-2">125</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Deals</li>
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Deals Name</a>
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
                                                            Konopelski
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Adams
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Gutkowski
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Walter
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#Status" aria-expanded="false" aria-controls="Status">Status</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="Status" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Won
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Open
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#tags" aria-expanded="false" aria-controls="tags">Tags</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse" id="tags" data-bs-parent="#accordionExample">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <ul>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Promotion
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Rated
                                                        </label>
                                                    </li>
                                                        <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Rejected
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Collab
                                                        </label>
                                                    </li>
                                                    <li>
                                                            <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            Calls
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
                        <a href="{{url('deals-list')}}" class="btn btn-sm p-1 border-0 fs-14"><i class="ti ti-list-tree"></i></a>
                        <a href="{{url('deals')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 active"><i class="ti ti-grid-dots"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Deal</a>
                </div>
            </div>
            <!-- table header -->
            
            <!-- Deals Kanban -->
            <div class="d-flex overflow-x-auto align-items-start mb-0 gap-3">
                <div class="kanban-list-items p-2 rounded border">
                    <div class="card mb-0 border-0 shadow">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="d-flex align-items-center mb-1"><i
                                            class="ti ti-circle-filled fs-10 text-info me-1"></i>Qualify
                                        To Buy</h6>
                                    <span>45 Leads - $15,44,540</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_deal"><i
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-success text-success rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-success">HT</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Howell,
                                                    Tremblay <br> and Rath</a></h6>
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-19.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Darlee
                                                Robertson</a>
                                        </div>
                                        <span class="badge bg-success">85%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 10 Jan 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-warning text-warning rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-warning">RJ</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Robert, John
                                                    and <br> Carlos</a></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $02,10,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            sheron@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 12445-47878
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Exeter, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-20.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Sharon
                                                Roy</a>
                                        </div>
                                        <span class="badge bg-warning">15%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 12 Jan 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-info text-info rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-info">WS</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Wendy, Star
                                                    and <br> David</a></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $04,22,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            vau@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 12445-47878
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Phoenix, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-21.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Vaughan Lewis</a>
                                        </div>
                                        <span class="badge bg-info">95%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 14 Jan 2024</span>
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
                                            class="ti ti-circle-filled fs-10 text-info me-1"></i>Contact Made
                                    </h6>
                                    <span>30 Leads - $19,94,938</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_deal"><i
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-danger text-danger rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">BR</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Byron, Roman
                                                    and <br> Bailey</a></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-report-money text-dark me-1"></i>
                                            $02,45,000
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-mail text-dark me-1"></i>
                                            jessica13@example.com
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center mb-2">
                                            <i class="ti ti-phone text-dark me-1"></i>
                                            +1 89351-90346
                                        </p>
                                        <p class="text-default d-inline-flex align-items-center">
                                            <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                            Chester, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-01.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Jessica Louise</a>
                                        </div>
                                        <span class="badge bg-danger">47%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 06 Feb 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-success text-success rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-success">RJ</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Robert, John
                                                    and <br> Carlos</a></h6>
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
                                            Charlotte, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-16.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Carol
                                                Thomas</a>
                                        </div>
                                        <span class="badge bg-success">98%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 15 Jan 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-danger text-danger rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">IC</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Irene,
                                                    Charles and <br> Wilston</a></h6>
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
                                            Bristol, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-22.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Dawn
                                                Mercha</a>
                                        </div>
                                        <span class="badge bg-danger">95%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 25 Jan 2024</span>
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
                                            class="ti ti-circle-filled fs-10 text-info me-1"></i>Presentation
                                    </h6>
                                    <span>25 Leads - $10,36.390</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_deal"><i
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-info text-info rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-info">HT</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Jody, Powell
                                                    and <br> Cecil</a></h6>
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
                                            Baltimore, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-23.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Rachel
                                                Hampton</a>
                                        </div>
                                        <span class="badge bg-info">25%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 18 Mar 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-danger text-danger rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">BL</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Bonnie, Linda
                                                    and <br> Mullin</a></h6>
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
                                            Coventry, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-24.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Jonelle
                                                Curtiss</a>
                                        </div>
                                        <span class="badge bg-danger">70%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 15 Feb 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-success text-success rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-success">CJ</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Carlos, Jones
                                                    and <br> Jim</a></h6>
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
                                            Seattle
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-25.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Jonathan Smith</a>
                                        </div>
                                        <span class="badge bg-success">45%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 30 Jan 2024</span>
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
                                            class="ti ti-circle-filled fs-10 text-info me-1"></i>Proposal
                                        Made</h6>
                                    <span>50 Leads - $18,83,013</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item " href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_deal"><i
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-info text-info rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-info">FJ</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a
                                                    href="{{url('deals-details')}}">Freda,Jennfier and <br>
                                                    Thompson</a></h6>
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
                                            London, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-17.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Sidney
                                                Franks</a>
                                        </div>
                                        <span class="badge bg-info">59%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 11 Apr 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-danger text-danger rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">BF</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Bruce,
                                                    Faulkner and <br> Lela</a></h6>
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
                                            Detroit, United State
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-26.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Brook Carter</a>
                                        </div>
                                        <span class="badge bg-danger">72%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 17 Apr 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-danger text-danger rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">LP</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Lawrence,
                                                    Patrick and <br> Vandorn</a></h6>
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
                                            Manchester, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-15.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Mickey</a>
                                        </div>
                                        <span class="badge bg-danger">20%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 10 Feb 2024</span>
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
                                    <h6 class="fw-semibold d-flex align-items-center mb-1">
                                        <i class="ti ti-circle-filled fs-10 text-info me-1"></i>Appointment
                                    </h6>
                                    <span>45 Leads - $15,44,540</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown table-action ms-2">
                                        <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item " href="#" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvas_edit"><i
                                                    class="fa-solid fa-pencil text-blue"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_deal"><i
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-danger text-danger rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">HT</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a
                                                    href="{{url('deals-details')}}">Howell, Tremblay <br>
                                                    and Rath</a></h6>
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
                                            London, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-17.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Sidney
                                                Franks</a>
                                        </div>
                                        <span class="badge bg-danger">59%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 11 Apr 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-danger text-danger rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-danger">BF</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Bruce,
                                                    Faulkner and <br> Lela</a></h6>
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
                                            Detroit, United State
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-26.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Brook Carter</a>
                                        </div>
                                        <span class="badge bg-danger">72%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 17 Apr 2024</span>
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
                            <div class="card kanban-card border mb-0 mt-3 shadow">
                                <div class="card-body">
                                    <div class="d-block">
                                        
                                        <div class="d-flex align-items-center mb-3">
                                            <a href="{{url('deals-details')}}"
                                                class="avatar bg-soft-info text-info rounded-circle flex-shrink-0 me-2"><span
                                                    class="avatar-title text-info">LP</span></a>
                                            <h6 class="fw-medium fs-14 mb-0"><a href="{{url('deals-details')}}">Lawrence,
                                                    Patrick and <br> Vandorn</a></h6>
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
                                            Manchester, United States
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <a href="javascript:void(0);"
                                                class="avatar avatar-xs flex-shrink-0 me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-15.jpg')}}" alt="" class="rounded-circle"></a>
                                            <a href="javascript:void(0);" class="text-default">Mickey</a>
                                        </div>
                                        <span class="badge bg-info">20%</span>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                        <span><i class="ti ti-calendar-due"></i> 10 Feb 2024</span>
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
            <!-- /Deals Kanban -->

        </div>
        <!-- End Content -->   

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection        