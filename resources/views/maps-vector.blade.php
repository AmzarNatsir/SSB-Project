<?php $page = 'maps-vector'; ?>
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
                <h4 class="mb-1">Vector Maps</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Maps</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Vector Maps</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Header -->

            <!-- start row-->
            <div class="row">

                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Basic Vector Map</div>
                        </div> 
                        <div class="card-body">
                            <div id="vector-map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
                
                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Map With Markers</div>
                        </div> 
                        <div class="card-body">
                            <div id="marker-map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Map With Image Markers</div>
                        </div> 
                        <div class="card-body">
                            <div id="marker-image-map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Map With Lines</div>
                        </div> 
                        <div class="card-body">
                            <div id="lines-map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">US Vector Map</div>
                        </div> 
                        <div class="card-body">
                            <div id="us-map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Russia Vector Map</div>
                        </div> 
                        <div class="card-body">
                            <div id="russia-map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Spain Vector Map</div>
                        </div> 
                        <div class="card-body">
                            <div id="spain-map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">Canada Vector Map</div>
                        </div> 
                        <div class="card-body">
                            <div id="canada-map"></div>
                        </div> <!-- end card-body -->
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