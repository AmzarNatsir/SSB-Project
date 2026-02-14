<?php $page = 'video-call'; ?>
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
                    <h4 class="mb-1">Video Call</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Applications</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Video Call</li>
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
                    <div class="single-video d-flex">
                        <div class="join-video flex-fill position-relative">
                            <img src="{{URL::asset('build/img/social/video.jpg')}}" class="img-fluid" alt="Logo">
                            <div class="chat-active-users">
                                <div class="video-avatar position-absolute p-2 top-0 end-0">
                                    <img src="{{URL::asset('./build/img/users/user-01.jpg')}}" class="img-fluid rounded border border-primary" alt="Logo">
                                    <div class="position-absolute start-0 bottom-0 w-100 text-center py-2">
                                        <span class="bg-white text-dark d-inline-block fw-medium rounded p-1 my-2">Joe Lewis</span>
                                    </div>
                                </div>
                            </div>

                            <div class="position-absolute start-0 top-0 p-2 z-1 d-flex align-items-center">
                                <div class="me-2">
                                    <span class="bg-light-subtle rounded badge text-dark p-2 d-inline-flex align-items-center"><i class="ti ti-circle-filled me-1"></i>40:12</span>
                                </div>
                                <a href="javascript:void(0);" class="btn p-0 avatar-sm btn-light btnFullscreen	">
                                    <i class="ti ti-maximize"></i> 
                                </a>
                            </div>
                            <div class="d-flex justify-content-center align-items-center flex-wrap w-100 position-absolute bottom-0 z-2 p-2">
                                <div class="bg-light bg-opacity-50 px-3 py-2 rounded-pill d-flex justify-content-center align-items-center">
                                    <a href="javascript:void(0);" class="bg-light btn-icon btn-sm bg-light d-flex justify-content-center align-items-center rounded me-2"><i class="ti ti-microphone"></i></a>
                                    <a href="javascript:void(0);" class="bg-light btn-icon btn-sm bg-light d-flex justify-content-center align-items-center rounded me-2"><i class="ti ti-video"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-icon btn-lg text-white bg-danger d-flex justify-content-center align-items-center rounded"><i class="ti ti-phone"></i></a>
                                    <a href="javascript:void(0);" class="bg-light btn-icon btn-sm bg-light d-flex justify-content-center align-items-center rounded mx-2"><i class="ti ti-volume"></i></a>                                        
                                    <a href="javascript:void(0);" class="bg-light text-dark btn-icon btn-sm d-flex align-items-center justify-content-center rounded"><i class="ti ti-user-off"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
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