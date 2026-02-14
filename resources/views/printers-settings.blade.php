<?php $page = 'printers-settings'; ?>
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
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-3 pb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <h5 class="mb-0 fs-17">Printer</h5>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_printer"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add New Printer</a>
                            </div>
                            <!-- start table -->
                            <div class="table-responsive">
                                <table class="table table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Printer Name</th>
                                            <th>Connection Type</th>
                                            <th>IP Address</th>
                                            <th>Port</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>HD Printer</td>
                                            <td>Network</td>
                                            <td>151.00.1.22</td>
                                            <td>900</td>
                                            <td>
                                                <div class="dropdown table-action">
                                                    <a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#edit_printer"><i class="ti ti-edit me-1"></i> Edit</a>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_printer"><i class="ti ti-trash me-1"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Epson</td>
                                            <td>Network</td>
                                            <td>151.00.1.20</td>
                                            <td>500</td>
                                            <td>
                                                <div class="dropdown table-action">
                                                    <a href="#" class="action-icon btn btn-xs shadow d-inline-flex btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#edit_printer"><i class="ti ti-edit me-1"></i> Edit</a>
                                                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#delete_printer"><i class="ti ti-trash me-1"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table -->
                        </div>
                    </div>
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