<?php $page = 'notifications'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-wrap">
                <div>
                    <h4 class="mb-1">Notifications</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                        </ol>
                    </nav>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>
            <!-- End Page Header -->
            
            <!-- card start -->
            <div class="card mb-0">

                <div class="card-header d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <h6 class="d-inline-flex align-items-center mb-0">Total Notifications <span class="badge bg-danger ms-2">658</span></h6>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="javascript:void(0);" class="btn btn-light"><i class="ti ti-checks me-1"></i>Mark all as read</a>
                        <a href="javascript:void(0);" class="btn btn-danger"><i class="ti ti-trash me-1"></i>Delete All</a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="card notication-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('employee-details')}}" class="avatar flex-shrink-0">
                                        <img src="{{URL::asset('./build/img/users/user-07.jpg')}}" alt="img" class="rounded-circle">
                                    </a>
                                    <div class="ms-2">
                                        <div>
                                            <p class="mb-1"><a href="{{url('employee-details')}}" class="fw-medium">Daniel Martinz</a> requested Sick Leave from <span class="text-dark fw-medium">May 28 2025</span> to  <span class="text-dark fw-medium"> May 29 2025</span></p>
                                            <p class="fs-12 mb-0 d-inline-flex align-items-center"><i class="ti ti-clock me-1"></i> 4 min ago<span class="ms-2"><i class="ti ti-point-filled text-danger fs-16 lh-sm"></i></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="noti-btn">
                                    <a href="javascript:void(0);" class="btn btn-danger d-inline-flex align-items-center"><i class="ti ti-trash me-1"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card notication-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('employee-details')}}" class="avatar flex-shrink-0">
                                        <img src="{{URL::asset('./build/img/users/user-02.jpg')}}" alt="img" class="rounded-circle">
                                    </a>
                                    <div class="ms-2">
                                        <div>
                                            <p class="mb-1">Leave for <a href="{{url('employee-details')}}" class="fw-medium">Emily Clark</a> <span class="text-dark fw-medium">(May 26 2025)</span> has been approved.</p>
                                            <p class="fs-12 mb-0 d-inline-flex align-items-center"><i class="ti ti-clock me-1"></i> 15 min ago<span class="ms-2"><i class="ti ti-point-filled text-danger fs-16 lh-sm"></i></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="noti-btn">
                                    <a href="javascript:void(0);" class="btn btn-danger d-inline-flex align-items-center"><i class="ti ti-trash me-1"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card notication-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('employee-details')}}" class="avatar flex-shrink-0">
                                        <img src="{{URL::asset('./build/img/users/user-04.jpg')}}" alt="img" class="rounded-circle">
                                    </a>
                                    <div class="ms-2">
                                        <div>
                                            <p class="mb-1">Leave request from <a href="{{url('employee-details')}}" class="fw-medium">David Anderson</a> <span class="text-dark fw-medium">(May 30 2025)</span> has been rejected.</p>
                                            <p class="fs-12 mb-0 d-inline-flex align-items-center"><i class="ti ti-clock me-1"></i> 45 Min Ago<span class="ms-2"><i class="ti ti-point-filled text-danger fs-16 lh-sm"></i></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="noti-btn">
                                    <a href="javascript:void(0);" class="btn btn-danger d-inline-flex align-items-center"><i class="ti ti-trash me-1"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card notication-card mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center">
                                    <a href="{{url('employee-details')}}" class="avatar flex-shrink-0">
                                        <img src="{{URL::asset('./build/img/users/user-24.jpg')}}" alt="img" class="rounded-circle">
                                    </a>
                                    <div class="ms-2">
                                        <div>
                                            <p class="mb-1"><a href="{{url('employee-details')}}" class="fw-medium">Ann McClure</a> cancelled her appointment scheduled for <span class="text-dark fw-medium">February 5, 2024</span></p>
                                            <p class="fs-12 mb-0 d-inline-flex align-items-center"><i class="ti ti-clock me-1"></i> 58 Min Ago<span class="ms-2"><i class="ti ti-point-filled text-danger fs-16 lh-sm"></i></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="noti-btn">
                                    <a href="javascript:void(0);" class="btn btn-danger d-inline-flex align-items-center"><i class="ti ti-trash me-1"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- card start -->

        </div>
        <!-- End Content -->    

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection   