<?php $page = 'audio-call'; ?>
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
                    <h4 class="mb-1">Audio Call</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Applications</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Audio Call</li>
                        </ol>
                    </nav>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>                
            <!-- End Page Header -->

            <!-- start row -->
            <div class="row">

                <div class="col-xxl-12">
                    <div class="card card-max-height mb-0 shadow-none">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-lg avatar-rounded me-2">
                                        <img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="img-fluid rounded-circle" alt="img">
                                    </span>
                                    <div>
                                        <h6 class="mb-1"><a href="#">Anthony Lewis</a></h6>
                                        <span class="fs-13 d-block">Online</span>
                                    </div>
                                </div>
                                <a href="#" class="avatar avatar-md rounded-circle bg-light text-dark">
                                    <i class="ti ti-user-plus fs-20"></i>
                                </a>
                            </div>
                        </div> <!-- end card-header -->
                        <div class="card-body position-relative text-center d-flex flex-column justify-content-center">
                            <div class="animation-ripple avatar avatar-xxxl d-flex mx-auto mb-3 rounded-circle">
                                <img src="{{URL::asset('build/img/users/user-01.jpg')}}" class="img-fluid rounded-circle" alt="img">
                            </div>
                            <h5>Anthony Lewis</h5>
                            <p>00:24</p>
                            <a href="#" class="avatar avatar-xl position-absolute end-0 bottom-0 m-3"><img src="{{URL::asset('build/img/users/user-05.jpg')}}" alt="Img"></a>
                        </div> <!-- end card-body -->
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="#" class="btn btn-light btn-icon rounded-circle p-0 d-flex align-items-center justify-content-center me-3"><i class="ti ti-video fs-20"></i></a>
                                <a href="#" class="btn btn-danger btn-icon rounded-circle p-0 d-flex align-items-center justify-content-center me-3"><i class="ti ti-phone fs-20"></i></a>
                                <a href="#" class="btn btn-light btn-icon rounded-circle p-0 d-flex align-items-center justify-content-center"><i class="ti ti-microphone fs-20"></i></a>
                            </div>
                        </div> <!-- end card-footer -->
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