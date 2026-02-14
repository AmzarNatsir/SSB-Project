<?php $page = 'maps-leaflet'; ?>
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
                <h4 class="mb-1">Leaflet Maps</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Maps</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Leaflet Maps</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Header -->

            <!-- start row-->
            <div class="row">

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Leaflet Map</div>
                        </div> 
                        <div class="card-body">
                            <div id="map"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Map With Markers,circles and Polygons</div>
                        </div> 
                        <div class="card-body">
                            <div id="map1"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Map With Popup</div>
                        </div> 
                        <div class="card-body">
                            <div id="map-popup"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Map With Custom Icon</div>
                        </div> 
                        <div class="card-body">
                            <div id="map-custom-icon"></div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Interactive Choropleth Map</div>
                        </div> 
                        <div class="card-body">
                            <div id="interactive-map"></div>
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