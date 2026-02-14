<?php $page = 'calendar'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">
        
        <!-- Start Content -->
        <div class="content content-two">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
                <div>
                    <h4 class="mb-1">Calendar</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Applications</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                        </ol>
                    </nav>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_event" class="btn btn-primary">
                        <i class="ti ti-circle-plus me-1"></i>New Event
                    </a>
                </div>
            </div>                
            <!-- End Page Header -->

            <div class="row">
                <!-- Calendar Sidebar -->
                <div class="col-xxl-3 col-xl-4">
                    <div class="card">
                        <div class="card-body p-3">

                            <!-- Event -->
                            <div class="border-bottom pb-4 mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h5>Event </h5>
                                    <a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#add_event"><i class="ti ti-square-rounded-plus-filled fs-16"></i></a>
                                </div>
                                <p class="fs-12 mb-2">Drag and drop your event or click in the calendar</p>
                                <div id='external-events'>
                                    <div class="fc-event bg-soft-success rounded text-dark d-flex align-items-center mb-1" data-event='{ "title": "Team Events" }' data-event-classname="bg-transparent-success">
                                        <i class="ti ti-square-rounded text-success me-2"></i>Team Events
                                    </div>
                                    <div class="fc-event bg-soft-warning rounded text-dark d-flex align-items-center mb-1" data-event='{ "title": "Team Events" }' data-event-classname="bg-transparent-warning">
                                        <i class="ti ti-square-rounded text-warning me-2"></i>Work
                                    </div>
                                    <div class="fc-event bg-soft-danger rounded text-dark d-flex align-items-center mb-1" data-event='{ "title": "External" }' data-event-classname="bg-transparent-danger">
                                        <i class="ti ti-square-rounded text-danger me-2"></i>External
                                    </div>
                                    <div class="fc-event bg-soft-secondary rounded text-dark d-flex align-items-center mb-1" data-event='{ "title": "Projects" }' data-event-classname="bg-transparent-skyblue">
                                        <i class="ti ti-square-rounded text-secondary me-2"></i>Projects
                                    </div>
                                    <div class="fc-event bg-soft-primary rounded text-dark d-flex align-items-center mb-1" data-event='{ "title": "Applications" }' data-event-classname="bg-transparent-purple">
                                        <i class="ti ti-square-rounded text-primary me-2"></i>Applications
                                    </div>
                                    <div class="fc-event bg-soft-info rounded text-dark d-flex align-items-center mb-0" data-event='{ "title": "Desgin" }' data-event-classname="bg-transparent-info">
                                        <i class="ti ti-square-rounded text-info me-2"></i>Desgin
                                    </div>
                                </div>
                            </div>
                            <!-- /Event -->

                            <!-- Upcoming Event -->
                            <div class="border-bottom pb-2 mb-4">
                                <h5 class="mb-2">Upcoming Event<span class="badge badge-success rounded-pill ms-2">15</span></h5>
                                <div class="border-start border-secondary border-3 mb-3">
                                    <div class="ps-3">
                                        <h6 class="fw-medium mb-1">Meeting with Team Dev</h6>
                                        <p class="fs-12"><i class="ti ti-calendar-check text-info me-2"></i>15 Mar 2025</p>
                                    </div>
                                </div>
                                <div class="border-start border-danger border-3 mb-3">
                                    <div class="ps-3">
                                        <h6 class="fw-medium mb-1">Design System With Client</h6>
                                        <p class="fs-12"><i class="ti ti-calendar-check text-info me-2"></i>24 Mar 2025</p>
                                    </div>
                                </div>
                                <div class="border-start border-success border-3 mb-3">
                                    <div class="ps-3">
                                        <h6 class="fw-medium mb-1">UI/UX Team Call</h6>
                                        <p class="fs-12"><i class="ti ti-calendar-check text-info me-2"></i>28 Mar 2025</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /Upcoming Event -->

                            <!-- Upgrade Details -->
                            <div class="bg-dark rounded text-center position-relative p-4">
                                <span class="avatar avatar-lg rounded-circle bg-white mb-2">
                                    <i class="ti ti-alert-triangle text-dark"></i>
                                </span>
                                <h6 class="text-white mb-3">Enjoy Unlimited Access on a small price monthly.</h6>
                                <a href="#" class="btn bg-white">Upgrade Now <i class="ti ti-arrow-right"></i></a>
                            </div>
                            <!-- /Upgrade Details -->

                        </div>
                    </div>					

                </div>
                <!-- /Calendar Sidebar -->
                <div class="col-xxl-9 col-xl-8">

                    <div class="card mb-0">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>

                </div>
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