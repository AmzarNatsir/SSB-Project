<?php $page = 'pipeline'; ?>
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
                    <h4 class="mb-1">Pipeline<span class="badge badge-soft-primary ms-2">125</span></h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pipeline</li>
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
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add Pipeline</a>
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
                            <div class="reportrange-picker reportrange d-flex align-items-center shadow">
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
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Pipeline Name</a>
                                                </div>
                                                <div class="filter-set-contents accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample">
                                                    <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                        <ul>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Sales
                                                                </label>
                                                            </li>
                                                                <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Marketing
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Email
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Chats
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Operational
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Collaborative
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Differentiate
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Interact
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Deals
                                                                </label>
                                                            </li>
                                                            <li>
                                                                    <label class="dropdown-item px-2 d-flex align-items-center">
                                                                    <input class="form-check-input m-0 me-1" type="checkbox">
                                                                    Onboarding
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
                                                <div class="filter-set-content">
                                                <div class="filter-set-content-head">
                                                    <a href="#" class="collapsed" data-bs-toggle="collapse" data-bs-target="#date" aria-expanded="false" aria-controls="date">Created Date</a>
                                                </div>
                                                <div class="filter-set-contents accordion-collapse collapse" id="date" data-bs-parent="#accordionExample">
                                                    <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                        <div class="reportrange-picker reportrange d-flex align-items-center shadow">
                                                            <i class="ti ti-calendar-due text-dark fs-14 me-1"></i><span class="reportrange-picker-field"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                              
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="javascript:void(0);" class="btn btn-outline-light w-100">Reset</a>
                                            <a href="{{url('pipeline')}}" class="btn btn-primary w-100">Filter</a>
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
                                                    <span>Pipeline Name</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Deal Value</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>No of Deals</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch">     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Stages</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
                                            <i class="ti ti-columns me-1"></i>                                     
                                            <div class="form-check form-switch w-100 ps-0">
                                                                                                    
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100">
                                                    <span>Created Date</span>   
                                                    <input class="form-check-input switchCheckDefault ms-auto" type="checkbox" role="switch" checked>     
                                                </label>
                                            </div>
                                        </li>
                                        <li class="gap-1 d-flex align-items-center mb-2">       
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

                    <!-- Pipeline List -->
                    <div class="table-responsive custom-table table-nowrap">
                        <table class="table table-nowrap" id="pipeline-list">
                            <thead class="table-light">
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check form-check-md">
                                            <input class="form-check-input" type="checkbox" id="select-all">
                                        </div>
                                    </th>
                                    <th>Pipeline Name</th>
                                    <th>Total Deal Value</th>
                                    <th>No of Deals</th>
                                    <th>Stages</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>

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
                    <!-- /Pipeline List -->
                        
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