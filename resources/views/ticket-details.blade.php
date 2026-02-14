<?php $page = 'ticket-details'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <h4 class="mb-4">Ticket Details</h4>

            <div class="row">
                <div class="col-lg-10 mx-auto">

                    <div class="mb-3">
                        <a href="{{url('tickets')}}" class="d-inline-flex align-items-center fw-medium"><i class="ti ti-arrow-left me-1"></i>Back to Tickets</a>
                    </div>

                    <!-- Ticket Details -->
                    <div class="card mb-0">
                        <div class="card-body">

                            <div class="border br-5 mb-3">
                                <div class="p-3 bg-light d-flex align-items-center justify-content-between flex-wrap gap-3">
                                    <h6>#TK0020 - <span class="text-body">Support for Theme</span></h6>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle btn bg-white border d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                            <i class="ti ti-badge me-1"></i>Resolved
                                        </a>
                                        <ul class="dropdown-menu  dropdown-menu-end p-2">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Resolved</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Inprogress</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Open</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Closed</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="row row-cols-xl-5 row-cols-md-3 row-cols-sm-2 row-cols-1 row-gap-3">
                                        <div class="col">
                                            <h6 class="fs-13 fw-medium mb-1">Created By</h6>
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0);" class="avatar avatar-xs rounded-circle me-1"><img src="{{URL::asset('build/img/users/user-03.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></a>
                                                <a href="javascript:void(0);" class="text-truncate">Michael Dawson</a>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="fs-13 fw-medium mb-1">Priority</h6>
                                            <span class="badge bg-danger d-inline-flex align-items-center badge-sm">High</span>
                                        </div>
                                        <div class="col">
                                            <h6 class="fs-13 fw-medium mb-1">Assigned To</h6>
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0);" class="avatar avatar-xs rounded-circle me-1"><img src="{{URL::asset('build/img/users/user-07.jpg')}}" class="flex-shrink-0 rounded-circle" alt="img"></a>
                                                <a href="javascript:void(0);" class="text-truncate">Michael Dawson</a>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="fs-13 fw-medium mb-1">Created at</h6>
                                            <p class="fs-13">20 Jan 2025</p>
                                        </div>
                                        <div class="col">
                                            <h6 class="fs-13 fw-medium mb-1">Last Updated</h6>
                                            <p class="fs-13">18 Feb 2025</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">					
                                <h6 class="mb-2">Description</h6>
                                <p class="mb-2">After applying the updated CRM theme, I am experiencing significant layout and design problems that affect my workflow. I urgently need assistance to resolve these display issues and compatibility challenges with the existing modules and plugins to ensure smooth operations and a consistent user experience.</p>
                                <p class="mb-0">I’ve made several attempts to adjust theme settings and configurations, but the layout issues persist. The theme appears to conflict with essential CRM modules and custom workflows I heavily depend on.</p>
                            </div>
                            <div class="mb-3">					
                                <h6 class="mb-2">Attachments</h6>
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <div class="bg-light br-5 p-3 d-flex align-items-center border">
                                        <span class="avatar d-flex align-items-center justify-content-center bg-danger me-2">
                                            <img src="{{URL::asset('build/img/icons/pdf-1.svg')}}" alt="img" class="w-auto h-auto">
                                        </span>
                                        <div class="me-2">
                                            <h6 class="fs-14 fw-medium">Report1.pdf</h6>
                                            <p class="fs-12 mb-0">45 KB</p>
                                        </div>
                                        <a href="javascript:void(0);" class="avatar avatar-sm avatar-rounded download-icon d-flex align-items-center justify-content-center">
                                            <i class="ti ti-download fs-16"></i>
                                        </a>
                                    </div>
                                    <div class="bg-light br-5 p-3 d-flex align-items-center border">
                                        <span class="avatar d-flex align-items-center justify-content-center bg-success me-2">
                                            <img src="{{URL::asset('build/img/icons/jpg-1.svg')}}" alt="img" class="w-auto h-auto">
                                        </span>
                                        <div class="me-2">
                                            <h6 class="fs-14 fw-medium">Image2.jpg</h6>
                                            <p class="fs-12 mb-0">38 KB</p>
                                        </div>
                                        <a href="javascript:void(0);" class="avatar avatar-sm avatar-rounded download-icon d-flex align-items-center justify-content-center">
                                            <i class="ti ti-download fs-16"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <a href="javascript:void(0);" class="avatar rounded-circle me-2"><img src="{{URL::asset('build/img/profiles/avatar-27.jpg')}}" alt="img" class="avatar rounded-circle"></a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="fw-medium text-dark mb-0 me-1">Rely To :</p>
                                        <a href="javascript:void(0);" class="py-1 px-2 bg-soft-danger text-danger fs-12 fw-medium rounded">Michael Dawson (michael123@example.com) <i class="ti ti-x ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <h6 class="mb-2">Message</h6>
                                <div class="editor pages-editor">
                                    <p>Dear Michael Dawson, we sincerely apologize for the inconvenience. We have forwarded your issue to our Los Angeles branch for an immediate resolution. Meanwhile, we are arranging a replacement vehicle, and we will update you shortly.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-end">
                                <a href="javascript:void(0);" class="btn btn-light me-3">Cancel</a>
                                <a href="javascript:void(0);" class="btn btn-primary">Send Reply</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Ticket Details -->
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