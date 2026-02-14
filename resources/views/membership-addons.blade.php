<?php $page = 'membership-addons'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content pb-0">

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <!-- card start -->
                    <div class="card border-0 rounded-0">
                        <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <h6 class="fs-18 mb-0">Membership Addons</h6>
                            <a href="{{url('membership-plans')}}" class="btn btn-primary btn-sm">Back<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                        <form action="{{url('membership-addons')}}">
                            <div class="card-body pb-0">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Contacts <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Leads <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Companies <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck3">
                                                <label class="form-check-label" for="customCheck3">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Compaigns <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck4">
                                                <label class="form-check-label" for="customCheck4">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Projects <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck5">
                                                <label class="form-check-label" for="customCheck5">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Deals <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck6">
                                                <label class="form-check-label" for="customCheck6">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tasks <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck7">
                                                <label class="form-check-label" for="customCheck7">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Pipelines <span class="text-danger">*</span></label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control" value="0-100">
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input" type="checkbox" role="switch">
                                                </div>
                                            </div>
                                            <div class="form-check mt-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck8">
                                                <label class="form-check-label" for="customCheck8">Unlimited</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-light btn-sm me-2">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm">Create New</button>
                            </div>
                        </form>
                    </div>
                    <!-- card end -->
                </div>
            </div>

        </div>
        <!-- End Content -->  

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection   