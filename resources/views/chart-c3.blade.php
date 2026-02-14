<?php $page = 'chart-c3'; ?>
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
                <h4 class="mb-1">C3 Charts</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Charts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">C3 Charts</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Header -->

            <!-- start row -->
            <div class="row">

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Bar Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-bar-stacked"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Multiple Bar Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-bar"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Horizontal Bar Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-bar-rotated"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Line Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-sracked"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Line Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-spline-rotated"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Line Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-area-spline-sracked"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Pie Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-pie"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Donut Chart</div>
                        </div>
                        <div class="card-body">
                            <div id="chart-donut"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
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