<?php $page = 'email-settings'; ?>
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
                                <h5 class="mb-0 fs-17">Email Settings</h5>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_mail"><i class="ti ti-send me-1"></i>Send Test Mail</a>
                            </div>
                            <div class="row">

                                <!-- Email Wrap -->
                                <div class="col-md-12">

                                    <!-- PHP Mailer -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-lg border me-2 flex-shrink-0">
                                                        <img src="{{URL::asset('build/img/icons/mail-01.svg')}}" class="w-auto h-auto rounded-0" alt="">
                                                    </span>
                                                    <div>
                                                        <h6 class="fs-14 fw-medium mb-1">PHP Mailer</h6>
                                                        <a href="javascript:void(0);" class="badge badge-soft-success">Connected</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#php-mail" class="border-end fs-18 pe-3 me-3"><i class="ti ti-info-circle-filled me-1"></i></a>
                                                        <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add_phpmail"><i class="ti ti-tool me-1"></i>View Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch ps-0">
                                                        <input class="form-check-input ms-0 mt-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse" id="php-mail">
                                            <div class="mail-collapse mt-2">
                                                <p class="mb-0">PHPMailer is a third-party PHP library that provides a simple way to send emails in PHP. It offers a range of
                                                    features that make it a popular alternative to PHP's
                                                    built-in mail() function, such as support for HTML
                                                    emails, attachments, and SMTP authentication.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /PHP Mailer -->

                                    <!-- SMTP -->
                                    <div class="border rounded shadow p-3 mb-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-lg border me-2 flex-shrink-0">
                                                        <img src="{{URL::asset('build/img/icons/mail-02.svg')}}"
                                                            class="w-auto h-auto" alt="">
                                                    </span>
                                                    <div>
                                                        <h6 class="fs-14 fw-medium mb-1">SMTP</h6>
                                                        <a href="javascript:void(0);" class="badge badge-soft-success">Connected</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <a href="javascript:void(0);"
                                                            class="border-end fs-18 pe-3 me-3"><i
                                                                class="ti ti-info-circle-filled me-1"></i></a>
                                                        <a href="#" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#add_smtp"><i class="ti ti-tool me-1"></i>View Integration</a>
                                                    </div>
                                                    <div class="form-check form-switch ps-0">
                                                        <input class="form-check-input ms-0 mt-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /SMTP -->

                                    <!-- SendGrid -->
                                    <div class="border rounded shadow p-3">
                                        <div class="row gy-3">
                                            <div class="col-sm-5">
                                                <div class="d-flex align-items-center">
                                                    <span class="avatar avatar-lg border me-2 flex-shrink-0">
                                                        <img src="{{URL::asset('build/img/icons/mail-03.svg')}}"
                                                            class="w-auto h-auto" alt="">
                                                    </span>
                                                    <div>
                                                        <h6 class="fs-14 fw-medium mb-1">SendGrid</h6>
                                                        <a href="javascript:void(0);" class="badge badge-soft-light text-body">Not Connected</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <div
                                                    class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <a href="javascript:void(0);"
                                                            class="border-end fs-18 pe-3 me-3"><i
                                                                class="ti ti-info-circle-filled me-1"></i></a>
                                                        <a href="#" class="btn btn-light"><i class="ti ti-plug-connected me-1"></i>Connect</a>
                                                    </div>
                                                    <div class="form-check form-switch ps-0">
                                                        <input class="form-check-input ms-0 mt-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /SendGrid -->

                                </div>
                                <!-- /Email Wrap -->

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