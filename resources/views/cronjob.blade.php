<?php $page = 'cronjob'; ?>
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
                            <div class="border-bottom mb-3 pb-3">
                                <h4 class="fs-17 mb-0">Cronjob</h4>
                            </div>

                            <!-- start row -->
                            <div class="row row-gap-2 mb-3 align-items-center">
                                <div class="col-lg-6">
                                    <h6 class="mb-1 fs-14">Cronjob Link</h6>
                                    <p class="fs-13 mb-0">You can configure the Link</p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-0">
                                        <input type="text" class="form-control" value="https://example.com/cronjob">
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->

                            <!-- start row -->
                            <div class="row row-gap-2 mb-3 pb-4 border-bottom align-items-center">
                                <div class="col-lg-6">
                                    <h6 class="mb-1 fs-14">Execution Interval</h6>
                                    <p class="fs-13 mb-0">You can configure the intervals</p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-0">
                                        <input class="input-tags form-control border-0 h-100" data-choices data-choices-limit="infinite" data-choices-removeItem type="text" value="1 day, 1 hour">
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="javascript:void(0);" class=" btn btn-sm btn-light">Cancel</a>
                                <a href="javascript:void(0);" class=" btn btn-sm btn-primary">Save Changes</a>
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