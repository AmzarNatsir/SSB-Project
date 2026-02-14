<?php $page = 'notifications-settings'; ?>
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
                            <div class="border-bottom mb-3 pb-3">
                                <h5 class="mb-0 fs-17">Notification Settings</h5>
                            </div>
                            <div>
                                <div class="mb-3">
                                    <h6 class="mb-1">General Notifications</h6>
                                    <p class="mb-0">Select notifications</p>
                                </div>
                                <div class="border-bottom mb-3 pb-3">
                                    <div class="form-check d-flex align-items-center justify-content-between ps-0 mb-3">
                                        <label class="form-check-label text-dark fw-medium" for="notification1">
                                            Mobile Push Notifications
                                        </label>
                                        <input class="form-check-input" type="checkbox" value="" id="notification1" checked="">
                                    </div>
                                    <div class="form-check d-flex align-items-center justify-content-between ps-0 mb-3">
                                        <label class="form-check-label text-dark fw-medium" for="notification2">
                                            Desktop Notifications
                                        </label>
                                        <input class="form-check-input" type="checkbox" value="" id="notification2" checked="">
                                    </div>
                                    <div class="form-check d-flex align-items-center justify-content-between ps-0 mb-3">
                                        <label class="form-check-label text-dark fw-medium" for="notification3">
                                            Email Notifications
                                        </label>
                                        <input class="form-check-input" type="checkbox" id="notification3" checked="">
                                    </div>
                                    <div class="form-check d-flex align-items-center justify-content-between ps-0 mb-0">
                                        <label class="form-check-label text-dark fw-medium" for="notification4">
                                            SMS Notifications
                                        </label>
                                        <input class="form-check-input" type="checkbox" id="notification4" checked="">
                                    </div>
                                </div>

                                    <div class="mb-3">
                                    <h6 class="mb-1">Custom Notifications</h6>
                                    <p class="mb-0">Select when you will be notified when the following changes occur
                                    </p>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-borderless notification-table border-0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Push</th>
                                                <th>SMS</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium text-dark py-2">Payment</td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-dark py-2">
                                                    Transaction
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-dark py-2">
                                                    Email Verification
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-dark py-2">
                                                    OTP
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-dark py-2">
                                                    Activity
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium text-dark py-2">
                                                    Account
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                                <td class="py-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- end table responsive -->

                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                </div> <!-- end col -->

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