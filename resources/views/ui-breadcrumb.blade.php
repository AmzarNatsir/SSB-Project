<?php $page = 'ui-breadcrumb'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content pb-0">

            <!-- Page Header -->
            <div class="mb-4">
                <h4 class="mb-1">Breadcrumb</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Base UI</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Breadcrumb</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Header -->

            <!-- start row -->
            <div class="row">

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Default Breadcrumb</h5>
                        </div>
                        <div class="card-body  py-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 py-2">
                                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 py-2">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 py-2">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                                </ol>
                            </nav>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Breadcrumb with Icons</h5>
                        </div>
                        <div class="card-body  py-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb py-2 mb-0">
                                    <li class="breadcrumb-item active" aria-current="page"><i class="ti ti-smart-home fs-16 me-1"></i>Home</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb py-2 mb-0">
                                    <li class="breadcrumb-item"><a href="#"><i class="ti ti-smart-home fs-16 me-1"></i>Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb py-2 mb-0">
                                    <li class="breadcrumb-item"><a href="#"><i class="ti ti-smart-home fs-16 me-1"></i>Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                                </ol>
                            </nav>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->

            </div>
            <!-- end row -->
            
            <!-- start row -->
            <div class="row">

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Arrow Style</h5>
                        </div>
                        <div class="card-body py-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-arrow mb-0 py-2">
                                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-arrow mb-0 py-2">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-arrow mb-0 py-2">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                                </ol>
                            </nav>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Pipe Style</h5>
                        </div>
                        <div class="card-body py-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-pipe py-2 mb-0">
                                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-pipe py-2 mb-0">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-pipe py-2 mb-0">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                                </ol>
                            </nav>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
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
