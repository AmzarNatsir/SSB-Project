<?php $page = 'companies'; ?>
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
                    <h4 class="mb-1">Companies<span class="badge badge-soft-primary ms-2">125</span></h4>
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
                                            <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Owner</a>
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
                                            <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Location</a>
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
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{URL::asset('build/img/flags/us.svg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>USA
                                                        </label>
                                                    </li>
                                                        <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{URL::asset('build/img/flags/ae.svg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>UAE
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{URL::asset('build/img/flags/de.svg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>Germany
                                                        </label>
                                                    </li>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-1" type="checkbox">
                                                            <span class="avatar avatar-xss rounded-circle me-1"><img src="{{URL::asset('build/img/flags/fr.svg')}}" class="flex-shrink-0 rounded-circle" alt="img"></span>France
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
                                    <a href="{{url('companies-list')}}" class="btn btn-primary w-100">Filter</a>
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
                        <a href="{{url('companies-list')}}" class="btn btn-sm p-1 border-0 fs-14"><i class="ti ti-list-tree"></i></a>
                        <a href="{{url('companies')}}" class="flex-shrink-0 btn btn-sm p-1 border-0 ms-1 fs-14 active"><i class="ti ti-grid-dots"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Company</a>
                </div>
            </div>
            <!-- table header -->
            
            <!-- Company Grid -->
            <div class="row">

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-01.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}"
                                                class="fw-medium">NovaWave LLC</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>4.2
                                        </div>
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
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>robertson@example.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 875455453</p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>Germany</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-01.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-02.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}" class="fw-medium">BlueSky
                                                Industries</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>5.0
                                        </div>
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
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>sharon@example.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 989757485</p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>USA</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-03.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}" class="fw-medium">Summit
                                                Peak</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>4.5
                                        </div>
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
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>jessica13@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 89316-83167
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>India</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-03.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-04.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}" class="fw-medium">Summit
                                                Peak</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>4.5
                                        </div>
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
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>jessica13@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 89316-83167
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>India</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-04.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-05.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}"
                                                class="fw-medium">RiverStone Ventur</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>4.7
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>carolTho3@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 84295-01629
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>China</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-06.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-06.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}" class="fw-medium">Bright
                                                Bridge Grp</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>5.0
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>dawnmercha@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 79253-01692
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>Martin Lewis</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-07.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-07.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}"
                                                class="fw-medium">CoastalStar Co.</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>3.1
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>rachel@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 52804-89153
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>Indonesia
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-08.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-08.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}"
                                                class="fw-medium">HarborView</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>5.0
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>jonelle@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 60364-91683
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>Cuba</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-09.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-09.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}" class="fw-medium">Golden
                                                Gate Ltd</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>2.7
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>jonathan@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 69023-95179
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>Isreal</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-10.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-10.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}" class="fw-medium">Redwood
                                                Inc</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>3.0
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>brook@gmail.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 49815-90142
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>Colombia
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-11.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-03.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}"
                                                class="fw-medium">SilverHawk</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>3.0
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>vaughan12@example.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 546555455</p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>Canada</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-12.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-md-6">
                    <div class="card border shadow">
                        <div class="card-body">
                            <div
                                class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-3 border-bottom pb-3">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('company-details')}}"
                                        class="avatar border rounded-circle flex-shrink-0 me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-04.svg')}}"
                                            class="w-auto h-auto" alt="img">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a href="{{url('company-details')}}"
                                                class="fw-medium">SummitPeak</a></h6>
                                        <div class="set-star text-default">
                                            <i class="ti ti-star-filled me-1 text-warning"></i>3.0
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item " href="#"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvas_edit"><i
                                                class="ti ti-edit text-blue"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#delete_contact"><i
                                                class="ti ti-trash"></i> Delete</a>
                                        <a class="dropdown-item" href="{{url('company-details')}}"><i
                                                class="ti ti-eye text-blue-light"></i> Preview</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column mb-0">
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-mail text-dark me-1"></i>jessica13@example.com
                                    </p>
                                    <p class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-phone text-dark me-1"></i>+1 454478787</p>
                                    <p class="text-default d-inline-flex align-items-center"><i
                                            class="ti ti-map-pin-pin text-dark me-1"></i>India</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="badge badge-tag badge-soft-success me-2">Collab</span>
                                    <span class="badge badge-tag badge-soft-warning">Rated</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap row-gap-2 border-top pt-3 mt-3">
                                <div class="d-flex align-items-center grid-social-links">
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-mail fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-phone-check fs-14"></i></a>
                                    <a href="#"
                                        class="avatar avatar-xs text-dark rounded-circle me-1"><i
                                            class="ti ti-message-circle-share fs-14"></i></a>
                                    <a href="#" class="avatar avatar-xs text-dark rounded-circle"><i
                                            class="ti ti-brand-facebook fs-14"></i></a>
                                </div>
                                <div>
                                    <span class="avatar avatar-xs border-0">
                                        <img src="{{URL::asset('build/img/profiles/avatar-13.jpg')}}"
                                            class="rounded-circle" alt="img">
                                    </span>
                                </div>                                    
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Company Grid -->

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