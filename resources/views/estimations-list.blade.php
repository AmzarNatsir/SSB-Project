<?php $page = 'estimations-list'; ?>
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
                    <h4 class="mb-1">Estimations<span class="badge badge-soft-primary ms-2">123</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Estimations</li>
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
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Estimation</a>
                </div>
                <div class="card-body">

                    <!-- table header -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
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
                            <div id="reportrange" class="reportrange-picker d-flex align-items-center shadow">
                                <i class="ti ti-calendar-due text-dark fs-14 me-1"></i><span class="reportrange-picker-field">9 Jun 25 - 9 Jun 25</span>
                            </div>
                        </div>
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
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Client Name</a>
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
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    RiverStone Ltd
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Bright Bridge Grp
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    CoastalStar Co.
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    HarborView
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Golden Gate Ltd
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Redwood Inc
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="filter-set-content">
                                                <div class="filter-set-content-head">
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date" aria-expanded="false" aria-controls="date">Date of Estimation</a>
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
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Estimated By</a>
                                                </div>
                                                <div class="filter-set-contents accordion-collapse collapse" id="collapseTwo" data-bs-parent="#accordionExample">
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
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date2" aria-expanded="false" aria-controls="date2">Expiry Date</a>
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
                                                                    Accepted
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Draft
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Declined
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
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="btn bg-soft-indigo px-2 border-0"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside"><i
                                        class="ti ti-columns-3 me-2"></i>Manage Columns</a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-md p-3">
                                    <ul>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Estimations ID</span>   
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
                                                    <span>Amount</span>   
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
                                                    <span>Date</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Expiry Date</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Project</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch">     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Estimation By</span>   
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
                                <a href="{{url('estimations-list')}}" class="btn btn-sm p-1 border-0 fs-14 active"><i class="ti ti-list-tree"></i></a>
                                <a href="{{url('estimations')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14"><i class="ti ti-grid-dots"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- table header -->

                    <!-- Projects List -->
                    <div class="table-responsive table-nowrap custom-table no-filter">
                        <table class="table datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th class="no-sort"></th>
                                    <th>Estimations ID</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Project</th>
                                    <th>Estimation By</th>
                                    <th>Status</th>
                                    <th class="text-end no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div>
                                    </td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274738</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center">
                                            <a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-01.svg')}}"
                                                    alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="fs-14 fw-medium">NovaWave LLC</a>
                                        </h2>
                                    </td>
                                    <td>$2,15,000</td>
                                    <td>
                                        <h2 class="d-flex align-items-center">
                                            <a href="#" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/truellysel.svg')}}"
                                                    alt="User Image">
                                            </a>
                                            <a href="#" class="fs-14 fw-medium">Truelysell</a>
                                        </h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-sm me-2">
                                                <img
                                                    src="{{URL::asset('build/img/profiles/avatar-19.jpg')}}"
                                                    alt="User Image" class="rounded-circle">
                                            </a>
                                            <a href="javascript:void(0);" class="d-flex flex-column fs-14 fw-medium d-flex">Darlee
                                                Robertson<span class="text-body d-flex mt-1 fs-13 fw-normal">Facility Manager </span>
                                            </a>
                                        </h2>
                                    </td>
                                    <td><span class="badge badge-status bg-teal">Sent</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"><i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274737</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center">
                                            <a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2">
                                                <img
                                                    src="{{URL::asset('build/img/icons/company-icon-02.svg')}}"
                                                    alt="User Image">
                                            </a>
                                            <a href="{{url('company-details')}}" class="fs-14 fw-medium">BlueSky Industries</a>
                                        </h2>
                                    </td>
                                    <td>$1,45,000</td>
                                    <td>
                                        <h2 class="d-flex align-items-center">
                                            <a href="#" class="avatar rounded-circle border me-2">
                                                <img class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/dreamchat.svg')}}"
                                                    alt="User Image">
                                            </a>
                                            <a href="#" class="fs-14 fw-medium">Dreamschat</a>
                                        </h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-20.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Sharon Roy<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Installer </span></a></h2>
                                    </td>
                                    <td><span
                                            class="badge badge-pill badge-status bg-success">Accepted</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274736</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    src="{{URL::asset('build/img/icons/company-icon-03.svg')}}"
                                                    alt="User Image"></a>
                                                <a href="{{url('company-details')}}" class="fs-14 fw-medium">Silver Hawk</a></h2>
                                    </td>
                                    <td>$2,15,000</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/truellysell.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">Truelysell</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-21.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Vaughan Lewis<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Senior Manager </span></a></h2>
                                    </td>
                                    <td><span class="badge badge-pill badge-status bg-warning">Draft</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274735</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-04.svg')}}"
                                                    alt="User Image"></a><a
                                                href="{{url('company-details')}}" class="fs-14 fw-medium">Summit Peak</a></h2>
                                    </td>
                                    <td>$4,80,380</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/servbook.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">Servbook</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-23.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Jessica Louise<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Test Engineer </span></a></h2>
                                    </td>
                                    <td><span
                                            class="badge badge-pill badge-status bg-success">Accepted</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274734</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-05.svg')}}"
                                                    alt="User Image"></a><a
                                                href="{{url('company-details')}}" class="fs-14 fw-medium">RiverStone Ventur</a></h2>
                                    </td>
                                    <td>$2,12,000</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/dream-pos.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">DreamPOS</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-16.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Carol Thomas<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">UI /UX Designer </span></a></h2>
                                    </td>
                                    <td><span
                                            class="badge badge-pill badge-status bg-danger">Declined</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274733</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-07.svg')}}"
                                                    alt="User Image"></a><a
                                                href="{{url('company-details')}}" class="fs-14 fw-medium">CoastalStar Co.</a></h2>
                                    </td>
                                    <td>$3,50,000</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/project-01.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">Kofejob</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-22.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Dawn Mercha<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Technician </span></a></h2>
                                    </td>
                                    <td><span class="badge badge-pill badge-status bg-warning">Draft</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274732</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-08.svg')}}"
                                                    alt="User Image"></a><a
                                                href="{{url('company-details')}}" class="fs-14 fw-medium">HarborView</a></h2>
                                    </td>
                                    <td>$1,23,000</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/project-02.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">Doccure</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-24.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Rachel Hampton<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Software Developer </span></a></h2>
                                    </td>
                                    <td><span class="badge badge-status bg-teal">Sent</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274731</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-09.svg')}}"
                                                    alt="User Image"></a><a
                                                href="{{url('company-details')}}" class="fs-14 fw-medium">Golden Gate Ltd</a></h2>
                                    </td>
                                    <td>$3,12,50</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto" src="{{URL::asset('build/img/priority/best.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">Best@laundry</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-24.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Jonelle Curtiss<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Supervisor </span></a></h2>
                                    </td>
                                    <td><span
                                            class="badge badge-pill badge-status bg-success">Accepted</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274730</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-10.svg')}}"
                                                    alt="User Image"></a><a
                                                href="{{url('company-details')}}" class="fs-14 fw-medium">Golden Gate Ltd</a></h2>
                                    </td>
                                    <td>$4,18,000</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/project-01.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">Dreamsports</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-26.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Jonathan Smith<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Team Lead Dev </span></a></h2>
                                    </td>
                                    <td><span
                                            class="badge badge-pill badge-status bg-danger">Declined</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="form-check form-check-md"><input class="form-check-input" type="checkbox"></div></td>
                                    <td>
                                        <div class="set-star rating-select"><i class="ti ti-star-filled"></i></div>
                                    </td>
                                    <td><a href="#">#274729</a></td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="{{url('company-details')}}"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/icons/company-icon-01.svg')}}"
                                                    alt="User Image"></a><a
                                                href="{{url('company-details')}}" class="fs-14 fw-medium">NovaWave LLC</a></h2>
                                    </td>
                                    <td>$4,80,380</td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar rounded-circle border me-2"><img
                                                    class="w-auto h-auto"
                                                    src="{{URL::asset('build/img/priority/truellysel.svg')}}"
                                                    alt="User Image"></a><a href="#" class="fs-14 fw-medium">Truelysell</a></h2>
                                    </td>
                                    <td>
                                        <h2 class="d-flex align-items-center"><a href="#"
                                                class="avatar avatar-sm me-2"><img
                                                    src="{{URL::asset('build/img/profiles/avatar-01.jpg')}}"
                                                    alt="User Image" class="rounded-circle"></a><a href="javascript:void(0);"
                                                class="d-flex flex-column fs-14 fw-medium d-flex">Brook Carter<span
                                                    class="text-body d-flex mt-1 fs-13 fw-normal">Team Lead Dev </span></a></h2>
                                    </td>
                                    <td><span
                                            class="badge badge-pill badge-status bg-success">Accepted</span>
                                    </td>
                                    <td>
                                        <div class="dropdown table-action">
                                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_edit"> <i
                                                        class="ti ti-edit text-blue"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#delete_estimations"><i
                                                        class="ti ti-trash"></i> Delete</a>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvas_view"><i
                                                        class="ti ti-clipboard-copy text-violet"></i> View
                                                    Estimation</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-checks text-green"></i> Mark as
                                                    Accepted</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-file"></i> Mark as Draft</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-sticker text-blue"></i> Mark as
                                                    Declined</a>
                                                <a class="dropdown-item" href="javascript:void(0);"><i
                                                        class="ti ti-printer"></i> Print</a>
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
                    <!-- /Projects List -->
                        
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