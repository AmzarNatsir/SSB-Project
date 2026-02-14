<?php $page = 'system-update'; ?>
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
                    <h4 class="mb-1">Settings</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>                
            <!-- End Page Header -->

            @component('components.settings-menu')
            @endcomponent

            <!-- start row -->
            <div class="row">

                @component('components.settings-sidebar')
                @endcomponent

                    <div class="col-xl-9 col-lg-12">

                        <!-- Settings Info -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="border-bottom mb-3 pb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <h4 class="fs-17 mb-0">System Update</h4>
                                </div>
                                <!-- Item -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="position-relative z-1">
                                            <span class="avatar avatar-lg badge-soft-success badge-sm border-0 text-success rounded-circle"><i class="ti ti-circle-check-filled fs-24"></i></span>
                                        </div>
                                        <div>
                                            <h6 class="fs-14 mb-1 fw-semibold"> You are up to date <a href="javascript:void(0);" class="badge badge-tag badge-soft-info ms-2" data-bs-toggle="modal" data-bs-target="#default">Default</a> </h6>
                                            <p class="fs-13 mb-0">Last Checked : Today 10:30AM</p>
                                        </div>
                                    </div>
                                </div>

								<!-- Item -->
                                <div class = "mb-3">
                                    <div class="w-100">
                                        <label class="form-label">Purchase Key<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <!-- Item -->
                                <div class="bg-light border rounded p-2 d-flex align-items-center">
                                    <p class="mb-0"> <i class="ti ti-info-circle me-2 text-info"></i> Before updating, it's best to back up your files and database and review the changelog.</p>
                                </div>
                            </div>
                        </div>
                        <!-- /Settings Info -->

                    </div>

            </div>
			<!-- end row -->

        </div>
        <!-- End Content -->   

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection                  