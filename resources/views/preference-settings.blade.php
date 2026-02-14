<?php $page = 'preference-setings'; ?>
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
                            <div class="border-bottom mb-3 pb-3">
                                <h5 class="mb-0 fs-17">Preference</h5>
                            </div>
                            <form action="{{url('preference-settings')}}">
                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-01.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Contact</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-02.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Deals</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-03.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Leads</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-04.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Pipelines</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-02.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Campaign</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-06.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Projects</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-07.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Tasks</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-08.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Acivities</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-09.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Company</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-10.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Analytics</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-11.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Clients</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="card border mb-3">
                                                <div
                                                    class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{URL::asset('build/img/icons/preference-12.svg')}}" alt="">
                                                        <h6 class="fs-14 fw-semibold ms-2 mb-0">Customers</h6>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                    <a href="#" class="btn btn-sm btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div> <!-- end card body -->
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