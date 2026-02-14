<?php $page = 'under-maintenance'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="container">

        <!-- start row -->
        <div class="row justify-content-center align-items-center vh-100">

            <div class="col-md-8 d-flex align-items-center justify-content-center mx-auto">
                <div>
                    <div class="error-img mb-4">
                        <img src="{{URL::asset('build/img/authentication/maintenance-img.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="text-center">
                        <h2 class="mb-3">We are Under Maintenance</h2>
                        <p class="mb-3">Sorry for any inconvenience caused, we have almost <br> done Will get back soon!
                        </p>
                        <div class="pb-4">
                            <a href="{{url('index')}}" class="btn btn-primary">
                                <i class="ti ti-chevron-left me-1"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

        </div>
        <!-- end row -->
        
    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection       