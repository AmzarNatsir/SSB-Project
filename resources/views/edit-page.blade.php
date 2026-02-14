<?php $page = 'edit-page'; ?>
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
                            <h6 class="fs-18 mb-0">Edit Page</h6>
                            <a href="{{url('pages')}}" class="btn btn-primary btn-sm">Back<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                        <form action="{{url('edit-page')}}">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="Reports">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Slug <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="reports">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Keywords <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="Reports">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="customRadio1" name="customRadio1" class="form-check-input" checked>
                                                    <label class="form-check-label" for="customRadio1">Active</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="customRadio2" name="customRadio1" class="form-check-input">
                                                    <label class="form-check-label" for="customRadio2">Inactive</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Visibility</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="customRadio3" name="customRadio2" class="form-check-input" checked>
                                                    <label class="form-check-label" for="customRadio3">Show</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="customRadio4" name="customRadio2" class="form-check-input">
                                                    <label class="form-check-label" for="customRadio4">Hide</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3"> Track revenue targets, closed deals, deal velocity, and quota attainment by team or individual sales reps.</textarea>
                                        </div>
                                    </div>
                                </div>									
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-light btn-sm me-2">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
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