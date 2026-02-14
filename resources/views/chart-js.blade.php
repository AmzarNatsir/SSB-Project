<?php $page = 'chart-js'; ?>
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
                <h4 class="mb-1">Chart JS</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Charts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chart JS</li>
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
                            <div>
                                <canvas id="chartBar1" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Transparency </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <canvas id="chartBar2" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Gradient Bar Chart</div>
                        </div>
                        <div class="card-body">
                            <div>
                                <canvas id="chartBar3" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->


                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Horizontal Bar Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartBar4" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Horizontal Bar Chart Style2</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartBar5" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Vertical Stacked Bar Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartStacked1" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Horizontal Stacked Bar Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartStacked2" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Line Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartLine1" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Donut Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartPie" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Pie Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartDonut" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <!-- Chart -->
                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Area Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartArea1" class="h-300"></canvas>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div> <!-- end col -->

                <div class="col-md-6">
                    <div class="card card-h-100">
                        <div class="card-header">
                            <div class="card-title">Scatter Chart</div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-wrapper-demo">
                                <canvas id="chartRadar" class="h-300"></canvas>
                            </div>
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