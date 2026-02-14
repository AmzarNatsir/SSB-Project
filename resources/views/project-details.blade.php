<?php $page = 'project-details'; ?>
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

            <div class="row">
                <div class="col-md-12">

                    <div class="mb-3">
                        <a href="{{url('projects')}}"><i class="ti ti-arrow-narrow-left me-1"></i>Back to Projects</a>
                    </div>

                    <div class="card">
                        <div class="card-body pb-2">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar avatar-xxl p-2 avatar-rounded border me-3 flex-shrink-0">
                                        <img src="{{URL::asset('build/img/priority/truellysel.svg')}}" alt="img" class="avatar avtart-sm rounded-circle">
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Trulysell</h5>
                                        <p class="mb-1">Project Id : <span class="text-dark fw-medium">154454887</span></p>
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-sm badge-soft-danger fw-medium me-2 border-0"><i class="ti ti-arrow-up-right me-1"></i>High</span>
                                            <span class="badge badge-sm bg-success">Active</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <span class="py-1 px-2 fs-12 bg-soft-danger rounded text-danger fw-medium"><i class="ti ti-lock me-1"></i>Private</span>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-xs btn-success fs-12 py-1 px-2 fw-medium d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false"> <i class="ti ti-thumb-up me-1"></i>Completed<i class="ti ti-chevron-down ms-1"></i> </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0);"><span>Completed</span></a>
                                            <a class="dropdown-item" href="javascript:void(0);"><span>Development</span></a>
                                            <a class="dropdown-item" href="javascript:void(0);"><span>Design</span></a>
                                            <a class="dropdown-item" href="javascript:void(0);"><span>Plan</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Contact User -->

                </div>

                <!-- Contact Sidebar -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <h6 class="mb-3 fw-semibold">Project Information</h6>
                            <div class="border-bottom mb-3 pb-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Start Date</p>
                                    <p class="mb-0 text-dark"> 27 Sep 2025, 11:45 PM  </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Due Date </p>
                                    <p class="mb-0 text-dark"> 27 Sep 2025, 11:45 PM  </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Deal Value</p>
                                    <p class="mb-0 text-dark">$25,11,145</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Project Type</p>
                                    <p class="mb-0 text-dark">Mobile Application</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Project Timing</p>
                                    <p class="mb-0 text-dark">Hourly</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="mb-3 fw-semibold">Client</h6>
                                <a href="javascript:void(0);" class="link-primary mb-3"><i class="ti ti-plus me-1"></i>Add New</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs rounded-circle me-2">
                                        <img src="{{URL::asset('build/img/icons/company-icon-08.svg')}}" alt="" class="img-fluid rounded-circle w-auto h-auto">
                                    </span>
                                    <div>
                                        <p class="mb-0">Jessica Sen</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="mb-3 fw-semibold">Responsible Persons</h6>
                                <a href="javascript:void(0);" class="link-primary mb-3" data-bs-toggle="modal" data-bs-target="#add_contact"><i class="ti ti-plus me-1"></i>Add New</a>
                            </div>
                            <div class="mb-3">
                                <div class="avatar-list-stacked avatar-group-sm">
                                    <span class="avatar avatar-rounded">
                                        <img class="border border-white" src="{{URL::asset('build/img/profiles/avatar-01.jpg')}}" alt="img">
                                    </span>
                                    <span class="avatar avatar-rounded">
                                        <img class="border border-white" src="{{URL::asset('build/img/profiles/avatar-02.jpg')}}" alt="img">
                                    </span>
                                    <span class="avatar avatar-rounded">
                                        <img class="border border-white" src="{{URL::asset('build/img/profiles/avatar-03.jpg')}}" alt="img">
                                    </span>
                                    <span class="avatar avatar-rounded">
                                        <img class="border border-white" src="{{URL::asset('build/img/profiles/avatar-04.jpg')}}" alt="img">
                                    </span>
                                    <span class="avatar avatar-rounded">
                                        <img class="border border-white" src="{{URL::asset('build/img/profiles/avatar-05.jpg')}}" alt="img">
                                    </span>
                                    <a class="avatar bg-light avatar-rounded text-dark" href="javascript:void(0);">
                                        +1
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <h6 class="mb-3 fw-semibold">Team Leader</h6>
                                <a href="javascript:void(0);" class="link-primary mb-3">Change</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs rounded-circle me-2">
                                        <img src="{{URL::asset('build/img/users/avatar-4.jpg')}}" alt="" class="img-fluid rounded-circle w-auto h-auto">
                                    </span>
                                    <div>
                                        <p class="mb-0">Jessica Sen</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="mb-0 fw-semibold">Pipeline</h6>
                                <p class="mb-0 fw-medium text-dark"><i class="ti ti-timeline-event-text me-1"></i>Marketing Pipeline</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="mb-0">Last Modified </p>
                                <p class="mb-0 text-dark"> 27 Sep 2025, 11:45 PM  </p>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <p class="mb-0">Modified By</p>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs rounded-circle me-2">
                                        <img src="{{URL::asset('build/img/users/avatar-2.jpg')}}" alt="" class="img-fluid rounded-circle w-auto h-auto">
                                    </span>
                                    <div>
                                        <p class="mb-0">Darlee Robertson</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Contact Sidebar -->

                <!-- Contact Details -->
                <div class="col-xl-8">
                    <div class="mb-3 pb-3 border-bottom">
                        <h5 class="mb-3">Project Pipeline Status</h5>
                        <div class="step-progress d-flex flex-wrap gap-2">
                            <div class="step bg-indigo">Plan</div>
                            <div class="step bg-cyan">Design</div>
                            <div class="step bg-success">Development</div>
                            <div class="step bg-orange">Completed</div>
                            <div class="step bg-transparent"></div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body pb-0 pt-2 px-2">
                            <ul class="nav nav-tabs nav-bordered border-0 mb-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#tab_1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active border-3" aria-selected="true" role="tab">
                                        <span class="d-md-inline-block"><i class="ti ti-alarm-minus me-1"></i>Activities</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tab_2" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-3" aria-selected="false" role="tab" tabindex="-1">
                                        <span class="d-md-inline-block"><i class="ti ti-notes me-1"></i>Notes</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tab_3" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3" aria-selected="false" tabindex="-1" role="tab">
                                        <span class="d-md-inline-block"><i class="ti ti-phone me-1"></i>Calls</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tab_4" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3" aria-selected="false" tabindex="-1" role="tab">
                                        <span class="d-md-inline-block"><i class="ti ti-file me-1"></i>Files</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tab_5" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3" aria-selected="false" tabindex="-1" role="tab">
                                        <span class="d-md-inline-block"><i class="ti ti-mail-check me-1"></i>Email</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content pt-0">

                        <!-- Activities -->
                        <div class="tab-pane active show" id="tab_1">
                            <div class="card">
                                <div
                                    class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                    <h5 class="fw-semibold mb-0">Activities</h5>
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
                                </div>
                                <div class="card-body">
                                    <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>28 May 2025</div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex flex-wrap row-gap-2">
                                                <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-info">
                                                    <i class="ti ti-mail-code fs-20"></i>
                                                </span>
                                                <div>
                                                    <h6 class="fw-medium fs-14 mb-1">You sent 1 Message to the contact.</h6>
                                                    <p class="mb-0">10:25 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex flex-wrap row-gap-2">
                                                <span
                                                    class="avatar avatar-md flex-shrink-0 rounded me-2 bg-teal">
                                                    <i class="ti ti-phone fs-20"></i>
                                                </span>
                                                <div>
                                                    <h6 class="fw-medium fs-14 mb-1">Denwar responded to your appointment schedule by call at 09:30pm.</h6>
                                                    <p class="mb-0">09:25 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center flex-lg-nowrap flex-wrap row-gap-2">
                                                <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-danger">
                                                    <i class="ti ti-notes fs-20"></i>
                                                </span>
                                                <div>
                                                    <h6 class="fw-medium fs-14 mb-1">Notes added by Antony</h6>
                                                    <p class="mb-1">Please accept my apologies for the inconvenience caused. It would be much appreciated if it's possible to reschedule to 6:00 PM, or any other day that week.</p>
                                                    <p class="mb-0">10.00 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>27 May 2025</div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex flex-wrap row-gap-2">
                                                <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-warning">
                                                    <i class="ti ti-user-pin fs-20"></i>
                                                </span>
                                                <div>
                                                    <h6 class="fw-medium mb-1 d-inline-flex align-items-center fs-14 flex-wrap">Meeting With <span class="avatar avatar-xs rounded mx-2"><img src="{{URL::asset('build/img/profiles/avatar-19.jpg')}}" alt="img"></span> Abraham</h6>
                                                    <p class="mb-0">Schedueled on 05:00 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex flex-wrap row-gap-2">
                                                <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-teal">
                                                    <i class="ti ti-notes fs-20"></i>
                                                </span>
                                                <div>
                                                    <h6 class="fw-medium fs-14 mb-1">Drain responded to your appointment schedule question.</h6>
                                                    <p class="mb-0">09:25 pm</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="badge badge-soft-info border-0 mb-3"><i class="ti ti-calendar-check me-1"></i>Upcoming Activity</div>
                                    <div class="card border shadow-none mb-0">
                                        <div class="card-body p-3">
                                            <div class="d-flex flex-lg-nowrap flex-wrap row-gap-2">
                                                <span class="avatar avatar-md flex-shrink-0 rounded me-2 bg-warning">
                                                    <i class="ti ti-user-pin fs-20"></i>
                                                </span>
                                                <div>
                                                    <h6 class="fw-medium fs-14 mb-1">Product Meeting</h6>
                                                    <p class="mb-1">A product team meeting is a gathering of the
                                                        cross-functional product team — ideally including team
                                                        members from product, engineering, marketing, and customer
                                                        support.</p>
                                                    <p>25 Jul 2023, 05:00 pm</p>
                                                    <div class="card mb-0">
                                                        <div class="card-body">
                                                            <div class="row gy-3">
                                                                <div class="col-md-4">
                                                                    <div>
                                                                        <label class="form-label">Reminder <span class="text-danger">*</span></label>
                                                                        <select class="select">
                                                                            <option>Select</option>
                                                                            <option selected>1 hr</option>
                                                                            <option>Remainder</option>
                                                                            <option>10hr</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div>
                                                                        <label class="form-label">Task Priority <span class="text-danger">*</span></label>
                                                                        <select class="select">
                                                                            <option>Select</option>
                                                                            <option selected>High</option>
                                                                            <option>Low</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div>
                                                                        <label class="form-label">Assigned To <span class="text-danger">*</span></label>
                                                                        <select class="select">
                                                                            <option>Select</option>
                                                                            <option selected>Jerald Sen</option>
                                                                            <option>Jackson Daniel</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Activities -->

                        <!-- Notes -->
                        <div class="tab-pane fade" id="tab_2">
                            <div class="card">
                                <div
                                    class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                    <h5 class="fw-semibold mb-0">Notes</h5>
                                    <div class="d-inline-flex align-items-center">
                                        <div class="dropdown me-2">
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
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_notes" class="link-primary fw-medium"><i class="ti ti-circle-plus me-1"></i>Add New</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="notes-activity">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 pb-2">
                                                    <div class="d-inline-flex align-items-center mb-2">
                                                        <span class="avatar avatar-md me-2 flex-shrink-0">
                                                            <img src="{{URL::asset('build/img/profiles/avatar-19.jpg')}}" alt="img">
                                                        </span>
                                                        <div>
                                                            <h6 class="fw-medium fs-14 mb-1">Darlee Robertson</h6>
                                                            <p class="mb-0 fs-13">15 Sep 2023, 12:10 pm</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <div class="dropdown">
                                                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_notes"><i class="ti ti-edit me-1"></i>Edit</a>
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_note"><i class="ti ti-trash me-1"></i>Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5 class="fw-medium fs-14 mb-1">Notes added by Antony</h5>
                                                <p class="mb-3">A project review evaluates the success of an initiative and
                                                    identifies areas for improvement. It can also evaluate a current
                                                    project to determine whether it's on the right track. Or, it can
                                                    determine the success of a completed project. 
                                                </p>
                                                <div class="row">
                                                    <div class="col-xxl-4 col-lg-5">
                                                        <div class="card">
                                                            <div class="card-body p-2">
                                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                                                    <div class="d-flex align-items-center me-3">
                                                                        <span class="avatar bg-success me-2">
                                                                            <i class="ti ti-file-spreadsheet fs-20"></i>
                                                                        </span>
                                                                        <div>
                                                                            <h6 class="fw-medium fs-14 mb-1">Project Specs.xls</h6>
                                                                            <p class="mb-0">365 KB</p>
                                                                        </div>
                                                                    </div>
                                                                    <a href="javascript:void(0);" class="avatar avatar-xs rounded-circle bg-light text-dark"><i class="ti ti-arrow-down"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-4 col-lg-5">
                                                        <div class="card bg-light">
                                                            <div class="card-body p-2">
                                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                                                    <div class="d-flex align-items-center me-3">
                                                                        <span class="avatar bg-success me-2">
                                                                            <img src="{{URL::asset('build/img/media/media-35.jpg')}}" alt="img">
                                                                        </span>
                                                                        <div>
                                                                            <h6 class="fw-medium fs-14 mb-1">637.jpg</h6>
                                                                            <p class="mb-0">365 KB</p>
                                                                        </div>
                                                                    </div>
                                                                    <a href="javascript:void(0);" class="avatar avatar-xs rounded-circle bg-white text-dark"><i class="ti ti-arrow-down"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="notes-editor">
                                                    <div class="note-edit-wrap">
                                                        <div class="editor pages-editor"></div>
                                                        <div class="text-end note-btns mt-3">
                                                            <a href="javascript:void(0);" class="btn btn-light add-cancel me-2">Cancel</a>
                                                            <a href="javascript:void(0);" class="btn btn-primary">Save</a>
                                                        </div>
                                                    </div>
                                                    <div class="text-end mt-2">
                                                        <a href="javascript:void(0);" class="add-comment link-primary fw-medium"><i class="ti ti-circle-plus me-1"></i>Add Comment</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 pb-2">
                                                    <div class="d-inline-flex align-items-center mb-2">
                                                        <span class="avatar avatar-md me-2 flex-shrink-0">
                                                            <img src="{{URL::asset('build/img/profiles/avatar-20.jpg')}}" alt="img">
                                                        </span>
                                                        <div>
                                                            <h6 class="fw-medium fs-14 mb-1">Sharon Roy</h6>
                                                            <p class="mb-0">18 Sep 2023, 09:52 am</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <div class="dropdown">
                                                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_notes"><i class="ti ti-edit me-1"></i>Edit</a>
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_note"><i class="ti ti-trash me-1"></i>Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5 class="fw-medium fs-14 mb-1">Notes added by Antony</h5>
                                                <p>A project plan typically contains a list of the essential
                                                    elements of a project, such as stakeholders, scope, timelines,
                                                    estimated cost and communication methods. The project manager
                                                    typically lists the information based on the assignment.
                                                </p>
                                                <div class="row">
                                                    <div class="col-xxl-4 col-lg-5">
                                                        <div class="card">
                                                            <div class="card-body p-2">
                                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                                                    <div class="d-flex align-items-center me-3">
                                                                        <span class="avatar bg-teal me-2">
                                                                            <i class="ti ti-file-spreadsheet fs-20"></i>
                                                                        </span>
                                                                        <div>
                                                                            <h6 class="fw-medium fs-14 mb-1">Andewpass.txt</h6>
                                                                            <p class="mb-0">365 KB</p>
                                                                        </div>
                                                                    </div>
                                                                    <a href="javascript:void(0);" class="avatar avatar-xs rounded-circle bg-light text-dark"><i class="ti ti-arrow-down"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-light p-3 rounded">
                                                    <p class="mb-2">The best way to get a project done faster is to start sooner.
                                                        A goal without a timeline is just a dream.The goal you set
                                                        must be challenging. At the same time, it should be
                                                        realistic and attainable, not impossible to reach.</p>
                                                    <p>Commented by <span class="text-info">Aeron</span> on 15 Sep 2024, 11:15 pm</p>
                                                    <a href="#" class="btn btn-outline-white bg-white btn-sm"><i class="ti ti-arrow-back-up-double me-1"></i>Reply</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 pb-2">
                                                    <div class="d-inline-flex align-items-center mb-2">
                                                        <span class="avatar avatar-md me-2 flex-shrink-0">
                                                            <img src="{{URL::asset('build/img/profiles/avatar-21.jpg')}}" alt="img">
                                                        </span>
                                                        <div>
                                                            <h6 class="fw-medium fs-14 mb-1">Vaughan Lewis</h6>
                                                            <p class="mb-0">20 Sep 2023, 10:26 pm</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <div class="dropdown">
                                                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_notes"><i class="ti ti-edit me-1"></i>Edit</a>
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_note"><i class="ti ti-trash me-1"></i>Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mb-0">Projects play a crucial role in the success of organizations, and
                                                    their importance cannot be overstated. Whether it's launching a
                                                    new product, improving an existing
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Notes -->

                        <!-- Calls -->
                        <div class="tab-pane fade" id="tab_3">
                            <div class="card">
                                <div
                                    class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                    <h5 class="fw-semibold mb-0">Calls</h5>
                                    <div class="d-inline-flex align-items-center">
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_call" class="link-primary fw-medium"><i class="ti ti-circle-plus me-1"></i>Add New</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-sm-flex align-items-center justify-content-between pb-2">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="avatar avatar-md me-2 flex-shrink-0">
                                                        <img src="{{URL::asset('build/img/profiles/avatar-19.jpg')}}" alt="img">
                                                    </span>
                                                    <p class="mb-0"><span class="text-dark fw-medium">Darlee Robertson</span>
                                                        logged a call on 23 Jul 2023, 10:00 pm
                                                    </p>
                                                </div>
                                                <div class="d-inline-flex align-items-center mb-2">
                                                    <div class="dropdown me-2">
                                                        <a href="#" class="btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">Busy<i class="ti ti-chevron-down ms-2"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">Busy</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">No Answer</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Unavailable</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Wrong Number</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Left Voice Message</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Moving Forward</a>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_call"><i class="ti ti-edit me-1"></i>Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_call"><i class="ti ti-trash me-1"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-0">A project review evaluates the success of an initiative and
                                                identifies areas for improvement. It can also evaluate a current
                                                project to determine whether it's on the right track. Or, it can
                                                determine the success of a completed project. 
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-sm-flex align-items-center justify-content-between pb-2">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="avatar avatar-md me-2 flex-shrink-0">
                                                        <img src="{{URL::asset('build/img/profiles/avatar-20.jpg')}}" alt="img">
                                                    </span>
                                                    <p class="mb-0"><span class="text-dark fw-medium">Sharon Roy</span>
                                                        logged a call on 18 Sep 2025, 09:52AM
                                                    </p>
                                                </div>
                                                <div class="d-inline-flex align-items-center mb-2">
                                                    <div class="dropdown me-2">
                                                        <a href="#" class="btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">No Answrer<i class="ti ti-chevron-down ms-2"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">No Answrer</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Unavailable</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Wrong Number</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Left Voice Message</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Moving Forward</a>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_call"><i class="ti ti-edit me-1"></i>Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#delete_call"><i class="ti ti-trash me-1"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-0">A project plan typically contains a list of the essential 
                                                elements of a project, such as stakeholders, scope, timelines, estimated cost and 
                                                communication methods. The project manager 
                                                typically lists the information based on the assignment.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div class="d-sm-flex align-items-center justify-content-between pb-2">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="avatar avatar-md me-2 flex-shrink-0">
                                                        <img src="{{URL::asset('build/img/profiles/avatar-21.jpg')}}" alt="img">
                                                    </span>
                                                    <p class="mb-0"><span class="text-dark fw-medium">Vaughan</span>
                                                        logged a call on 20 Sep 2025, 10:26 PM
                                                    </p>
                                                </div>
                                                <div class="d-inline-flex align-items-center mb-2">
                                                    <div class="dropdown me-2">
                                                        <a href="#" class="btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">No Answrer<i class="ti ti-chevron-down ms-2"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);">No Answrer</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Unavailable</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Wrong Number</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Left Voice Message</a>
                                                            <a class="dropdown-item" href="javascript:void(0);">Moving Forward</a>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_call"><i class="ti ti-edit me-1"></i>Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_call"><i class="ti ti-trash me-1"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mb-0">Projects play a crucial role in the success of organizations, 
                                                and their importance cannot be overstated. 
                                                Whether it's launching a new product, improving an existing
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Calls -->

                        <!-- Files -->
                        <div class="tab-pane fade" id="tab_4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="fw-semibold mb-0">Files</h5>
                                </div>
                                <div class="card-body">
                                    <div class="card border mb-3">
                                        <div class="card-body pb-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="mb-1">Manage Documents</h6>
                                                        <p>Send customizable quotes, proposals and contracts to close deals faster.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <div class="mb-3">
                                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new_file">Create Document</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body pb-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fw-semibold fs-14 mb-1">Collier-Turner Proposal</h6>
                                                        <p>Send customizable quotes, proposals and contracts to close deals faster.</p>
                                                        <div class="d-flex align-items-center flex-wrap row-gap-2">
                                                            <span class="avatar avatar-md me-2 flex-shrink-0">
                                                                <img src="{{URL::asset('build/img/profiles/avatar-21.jpg')}}" alt="img" class="rounded-circle">
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 me-2">Vaughan Lewis</p>
                                                                <span class="badge bg-light text-body">Owner</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <div class="mb-3 d-inline-flex align-items-center">
                                                        <span class="badge badge-soft-danger me-1">Proposal</span>
                                                        <span class="badge bg-info me-1">Draft</span>
                                                        <div class="dropdown">
                                                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_file">
                                                                    <i class="ti ti-trash me-1"></i>Delete
                                                                </a>
                                                                <a class="dropdown-item" href="javascript:void(0);">
                                                                    <i class="ti ti-download me-1"></i>Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-none mb-3">
                                        <div class="card-body pb-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fw-semibold fs-14 mb-1">Collier-Turner Proposal</h6>
                                                        <p>Send customizable quotes, proposals and contracts to
                                                            close deals faster.</p>
                                                        <div class="d-flex align-items-center flex-wrap row-gap-2">
                                                            <span class="avatar avatar-md me-2 flex-shrink-0">
                                                                <img src="{{URL::asset('build/img/profiles/avatar-01.jpg')}}" alt="img" class="rounded-circle">
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 me-2">Jessica Louise</p>
                                                                <span class="badge bg-light text-body">Owner</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <div class="mb-3 d-inline-flex align-items-center">
                                                        <span class="badge badge-purple-light me-1">Quote</span>
                                                        <span class="badge bg-success me-1">Sent</span>
                                                        <div class="dropdown">
                                                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_file">
                                                                    <i class="ti ti-trash me-1"></i>Delete
                                                                </a>
                                                                <a class="dropdown-item" href="javascript:void(0);">
                                                                    <i class="ti ti-download me-1"></i>Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border shadow-none mb-0">
                                        <div class="card-body pb-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="fw-semibold fs-14 mb-1">Collier-Turner Proposal</h6>
                                                        <p>Send customizable quotes, proposals and contracts to close deals faster.</p>
                                                        <div class="d-flex align-items-center flex-wrap row-gap-2">
                                                            <span class="avatar avatar-md me-2 flex-shrink-0">
                                                                <img src="{{URL::asset('build/img/profiles/avatar-22.jpg')}}" alt="img" class="rounded-circle">
                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0 me-2">Dawn Merhca</p>
                                                                <span class="badge bg-light text-body">Owner</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <div class="mb-3 d-inline-flex align-items-center">
                                                        <span class="badge badge-danger-light me-1">Proposal</span>
                                                        <span class="badge bg-pending priority-badge me-1">Draft</span>
                                                        <div class="dropdown">
                                                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_file">
                                                                    <i class="ti ti-trash me-1"></i>Delete
                                                                </a>
                                                                <a class="dropdown-item" href="javascript:void(0);">
                                                                    <i class="ti ti-download me-1"></i>Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Files -->

                        <!-- Email -->
                        <div class="tab-pane fade" id="tab_5">
                            <div class="card">
                                <div
                                    class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                    <h5 class="mb-1">Email</h5>
                                    <div class="d-inline-flex align-items-center">
                                        <a href="javascript:void(0);" class="link-primary fw-medium" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-dark" data-bs-original-title="There are no email accounts configured, Please configured your email account in order to Send/ Create EMails"><i class="ti ti-circle-plus me-1"></i>Create Email</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card border mb-0">
                                        <div class="card-body pb-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <div class="mb-3">
                                                        <h6 class="mb-1">Manage Emails</h6>
                                                        <p>You can send and reply to emails directly via this section.</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <div class="mb-3">
                                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#create_email">Connect Account</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Email -->

                    </div>
                    <!-- /Tab Content -->

                </div>
                <!-- /Contact Details -->

            </div>
            <!-- Start Footer -->
        
        </div>
        <!-- End Content --> 

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection        