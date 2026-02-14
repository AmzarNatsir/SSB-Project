<?php $page = 'chart-flot'; ?>
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
                    <h4 class="mb-1">Chart Flot</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Charts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chart Flot</li>
                        </ol>
                    </nav>
				</div>
				<!-- End Page Header -->


            <!-- start row -->
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Bar Chart</div>
                        </div>
                        <div class="card-body  chart-set">
                            <div class="h-250" id="flotBar1"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Bar Chart</div>
                        </div>
                        <div class="card-body chart-set">
                            <div class="h-250" id="flotBar2"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Line Chart</div>
                        </div>
                        <div class="card-body chart-set">
                            <div class="h-250" id="flotLine1"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Line ChartPOints</div>
                        </div>
                        <div class="card-body chart-set">
                            <div class="h-250" id="flotLine2"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Area Chart</div>
                        </div>
                        <div class="card-body chart-set">
                            <div class="h-250" id="flotArea1"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Area Chart Points</div>
                        </div>
                        <div class="card-body chart-set">
                            <div class="h-250" id="flotArea2"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Pie Chart</div>
                        </div>
                        <div class="card-body chart-set">
                            <div class="h-250" id="flotPie1"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Donut Chart</div>
                        </div>
                        <div class="card-body chart-set">
                            <div class="h-250" id="flotPie2"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
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