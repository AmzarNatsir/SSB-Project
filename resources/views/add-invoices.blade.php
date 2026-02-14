<?php $page = 'add-invoices'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">

            <!-- Start Page Header -->
            <div class="d-flex align-items-sm-center flex-sm-row flex-column gap-2 mb-3">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-0 d-flex align-items-center"><a href="{{url('invoice')}}" class=""><i class="ti ti-chevron-left me-1 fs-14"></i>Invoices</a></h6>
                </div>
            </div>
            <!-- End Page Header -->

            <div class="card rounded-0 mb-0">
                <div class="card-header">
                    <h6 class="fw-bold m-0"> New Invoice </h6>
                </div> <!-- end card-header -->

                <form action="{{url('add-invoices')}}">
                    <div class="card-body">

                        <!-- start row -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Patient Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Customer <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Anthony Lewis</option>
                                        <option>Brian Villalobos</option>
                                        <option>Harvey Smith</option>
                                        <option>Stephan Peralt</option>
                                    </select>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tax <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>GST</option>
                                        <option>VAT</option>
                                        <option>Professional</option>
                                        <option>Income</option>
                                    </select>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                                    <div class="input-group w-auto input-group-flat">
                                        <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" placeholder="dd/mm/yyyy">
                                        <span class="input-group-text">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Due Date <span class="text-danger">*</span></label>
                                    <div class="input-group w-auto input-group-flat">
                                        <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" placeholder="dd/mm/yyyy">
                                        <span class="input-group-text">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Patient Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Billing Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>PayPal</option>
                                        <option>Options Enhanced</option>
                                        <option>Cheque</option>
                                    </select>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Inporgress</option>
                                        <option>Completed</option>
                                        <option>Pending</option>
                                    </select>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-12 col-md-12">

                                <div class="mb-3">
                                    <table class="table invoice-table border">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Unit Cost</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody class="invoices-list">
                                            <tr class="invoices-list-item">
                                                <td><input type="text" class="form-control"></td>
                                                <td><input type="text" class="form-control"></td>
                                                <td><input type="number" class="form-control"></td>
                                                <td><input type="number" class="form-control"></td>
                                                <td><input type="text" class="form-control" readonly></td>
                                                <td><button class="btn remove-invoices btn-sm border shadow-sm p-2 d-flex align-items-center justify-content-center rounded fs-14"> <i class="ti ti-trash"></i> </button></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="btn add-invoices border-0 text-dark d-felx align-items-center fs-14"> <i class="ti ti-circle-plus text-primary me-1"></i> Add Invoice</a>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                    
                            </div> <!-- end col -->

                            <div class="col-lg-8 col-md-8"></div> <!-- end col -->

                            <div class="col-lg-4">
                                <div class="">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="fs-14 fw-normal text-dark">Amount</h6>
                                        <h6 class="fs-14 fw-semibold text-dark">$0</h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="fs-14 fw-normal text-dark">Tax (0%)</h6>
                                        <h6 class="fs-14 fw-semibold text-dark">$0</h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="fs-14 fw-normal text-dark">Discount</h6>
                                        <h6 class="fs-14 fw-semibold text-dark">
                                            <select class="select form-control-sm rounded">
                                                <option>0%</option>
                                                <option>1%</option>
                                                <option>2%</option>
                                                <option>3%</option>
                                                <option>4%</option>
                                            </select>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                                        <h6 class="fs-14 fw-normal text-dark d-flex align-items-center">
                                            <label class="d-flex align-items-center form-switch ps-1">
                                                <input class="form-check-input m-0 me-2" type="checkbox" checked="">
                                            </label>
                                            Round Off Total
                                        </h6>
                                        <h6 class="fs-14 fw-semibold text-dark">$0</h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="fs-18 fw-bold">Total (USD)</h6>
                                        <h6 class="fs-18 fw-bold">$0</h6>
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-lg-12 col-md-12">
                                <div>
                                    <label class="form-label">Other Information <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <textarea rows="3"  class="form-control "></textarea>
                                    </div>
                                </div> 
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- end card-body -->
                    <div class="card-footer">
                        <div class="d-flex gap-2 align-items-center justify-content-end mb-0">
                            <button type="button" class="btn btn-light">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Invoice</button>
                        </div>
                    </div> <!-- end card footer -->
                </form>
            </div> <!-- end card --> 

        </div>
        <!-- End Content -->

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection   