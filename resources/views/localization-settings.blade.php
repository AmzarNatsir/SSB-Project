<?php $page = 'localization-setings'; ?>
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

                    <!-- Prefixes -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="border-bottom mb-3 pb-3">
                                <h5 class="mb-0 fs-17">Localization</h5>
                            </div>
                            <form action="{{url('localization-settings')}}">
                                <div class="mb-3">
                                    <h6 class="mb-1">Basic Information</h6>
                                    <p class="mb-0">Provide the basic information below</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Language</h6>
                                                <p class="fs-13 mb-0">Select Language of the website</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>English</option>
                                                    <option>French</option>
                                                    <option>German</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Language Switcher</h6>
                                                <p class="fs-13 mb-0">To display in all the pages</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="form-check form-switch ms-0 ps-0">
                                                    <input class="form-check-input ms-0" type="checkbox" role="switch" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Timezone</h6>
                                                <p class="fs-13 mb-0">Select date format to display in website</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>UTC 4:30</option>
                                                    <option>(UTC+11:00) INR</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Date Format</h6>
                                                <p class="fs-13 mb-0">Select Language of the website</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>01 Jan 2025</option>
                                                    <option>01-Jan-2025</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Time Format</h6>
                                                <p class="fs-13 mb-0">Select time format to display in website</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>12 Hours</option>
                                                    <option>24 Hours</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Financial Year</h6>
                                                <p class="fs-13 mb-0">Select year for finance</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>2025</option>
                                                    <option>2024</option>
                                                    <option>2022</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Starting Month</h6>
                                                <p class="fs-13 mb-0">Select starting month to display</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>January</option>
                                                    <option>February</option>
                                                    <option>March</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="mb-1">Currency Settings</h6>
                                    <p>Provide the currency information below</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Currency</h6>
                                                <p class="fs-13 mb-0">Select currency</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>USD</option>
                                                    <option>Dollar</option>
                                                    <option>Euro</option>
                                                    <option>Pound</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Currency Symbol</h6>
                                                <p class="fs-13 mb-0">Select currency symbol</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>$</option>
                                                    <option>€</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Currency Position</h6>
                                                <p class="fs-13 mb-0">Select currency position</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>$100</option>
                                                    <option>100$</option>
                                                    <option>$ 100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Decimal Seperator</h6>
                                                <p class="fs-13 mb-0">Select decimal seperator</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>.</option>
                                                    <option>,</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Thousand Seperator</h6>
                                                <p class="fs-13 mb-0">Select thousand seperator</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>,</option>
                                                    <option>.</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="mb-1">Country Settings</h6>
                                    <p class="mb-0">Provide the country information below</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Countries Restriction</h6>
                                                <p class="mb-0">Select restricted countries</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <select class="select">
                                                    <option selected>Allow All Countries</option>
                                                    <option>Deny All Countries</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="mb-1">File Settings</h6>
                                    <p class="mb-0">Provide the files information below</p>
                                </div>
                                <div class="border-bottom mb-3 border-0 mb-0">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Allowed Files</h6>
                                                <p class="fs-13 mb-0">Select allowed files</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input class="form-control" id="choices-text-remove-button" data-choices data-choices-removeItem type="text" value="JPG, PNG, GIF">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6 class="fs-14 fw-semibold mb-1">Max File Size</h6>
                                                <p class="fs-13 mb-0">Select size of the files</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" value="5000MB">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                                    <a href="#" class="btn btn-sm btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Prefixes -->

                </div>

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