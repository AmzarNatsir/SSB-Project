<?php $page = 'language-web'; ?>
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

                    <!-- Custom Fields -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row border-bottom mb-3 pb-3 align-items-center row-gap-3">
                                <div class="col-md-3">
                                    <h4 class="fs-17 mb-0">Language</h4>
                                </div>
                                <div class="col-md-9">
                                    <div class="d-flex align-items-center justify-content-md-end flex-wrap gap-2">
                                        <a href="{{url('language-settings')}}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-arrow-left me-1"></i>Back to Translations</a>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-light px-2 shadow" data-bs-toggle="dropdown"><img src="{{URL::asset('build/img/flags/us.svg')}}" alt="" class="me-2" height="16">English</a>
                                            <div class="dropdown-menu  dropdown-menu-end">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center gap-2"><img src="{{URL::asset('build/img/flags/us.svg')}}" alt="" height="16">English</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center gap-2"><img src="{{URL::asset('build/img/flags/de.svg')}}" alt="" height="16">German</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center gap-2"><img src="{{URL::asset('build/img/flags/ae.svg')}}" alt="" height="16">Arabic</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center gap-2"><img src="{{URL::asset('build/img/flags/fr.svg')}}" alt="" height="16">French</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="w-lg-25 w-md-25 w-100">
                                            <p class="fs-14 text-dark mb-1">Progress</p>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 bg-light" style="height: 5px; border-radius: 10px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 80%; border-radius: 10px;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="ms-2">80%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact List -->
                            <div class="table-responsive custom-table">
                                <table class="table" id="language-web">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="no-sort">Medium</th>
                                            <th class="no-sort">File</th>
                                            <th class="no-sort">Total</th>
                                            <th class="no-sort">Done</th>
                                            <th class="no-sort">Progress</th>
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
                            <!-- /Contact List -->

                        </div>
                    </div>
                    <!-- /Custom Fields -->

                </div><!-- end col -->

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