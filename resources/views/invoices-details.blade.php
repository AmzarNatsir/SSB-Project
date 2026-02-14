<?php $page = 'invoices-details'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content pb-0">

            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-0">Invoices Details</h4>
                <button class="btn btn-primary" type="button"><i class="ti ti-download me-1"></i>Download</button>
            </div>

            <!-- start row-->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    
                    <!-- start page header -->
                    <h6 class="mb-3 fw-normal fs-14"> <a href="{{url('invoices')}}"><i class="ti ti-arrow-left me-1"></i>Back to Invoice</a></h6>
                    <!-- end page header -->

                    <div class="card">
                        <div class="card-body">
                            <!-- Items -->
                            <div class="d-flex align-items-center justify-content-between border-1 border-bottom pb-3 mb-3">
                                <div>
                                    <img src="{{URL::asset('build/img/logo.svg')}}" class="invoice-light-logo" width="140" alt="">
                                    <img src="{{URL::asset('build/img/logo-white.svg')}}" class="dark-logo" width="140" alt="">
                                    <p class="mb-0 mt-2">3099 Kennedy Court Framingham, MA 01702</p>
                                </div>
                                <div>
                                    <p class="mb-1 fw-semibold">Invoice No : <span class="text-primary">#INV0287</span></p>
                                    <p class="mb-1">Invoice No : <span class="text-dark">12/09/2024</span></p>
                                    <p class="mb-0">Due date : <span class="text-dark">12/10/2024</span></p>
                                </div>
                            </div>

                            <!-- start row -->
                            <div class="row pb-3 border-1 border-bottom mb-4">
                                <div class="col-lg-4">
                                    <h5 class="mb-2 fs-14 fw-medium">From</h5>
                                    <h6 class="mb-1">Thomas Lawler</h6>
                                    <p class="mb-1">2077 Chicago Avenue Orosi, CA 93647</p>
                                    <p class="mb-1"> Email : <span class="text-dark"> tarala2445@gmail.com </span> </p>
                                    <p class="mb-0"> Phone : <span class="text-dark"> +1 987 654 3210</span> </p>
                                </div> <!-- end col -->
                                <div class="col-lg-4">
                                    <h5 class="mb-2 fs-14 fw-medium">To</h5>
                                    <h6 class="mb-1">Sara Inc,.</h6>
                                    <p class="mb-1">3103 Trainer Avenue Peoria, IL 61602</p>
                                    <p class="mb-1"> Email : <span class="text-dark">sara_inc34@gmail.com</span> </p>
                                    <p class="mb-0"> Phone : <span class="text-dark">+1 987 471 6589 </span> </p>
                                </div> <!-- end col -->
                                
                                <div class="col-lg-4">
                                    <h5 class="mb-2 fs-14 fw-medium">Payment Status </h5>
                                    <span class="badge bg-danger mb-2">Due in 10 Days</span>
                                    <img src="{{URL::asset('build/img/icons/invoice-qr.png')}}" class="d-block" alt="">
                                </div> <!-- end col -->
                                
                            </div>
                            <!-- end row -->

                            <!-- Items -->
                            <div class="mb-4">
                                <p>Invoice For : <span class="text-dark">Design & Development of Website</span> </p>
                                <div>
                                    <!-- Table List -->
                                    <div class="table-responsive">
                                        <table class="table table-nowrap border">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Job Description</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Discount</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Design System</td>
                                                    <td>1</td>
                                                    <td>$5000</td>
                                                    <td>$100</td>
                                                    <td>$5000</td>
                                                </tr>
                                                <tr>
                                                    <td>UX Strategy</td>
                                                    <td>1</td>
                                                    <td>$500</td>
                                                    <td>$100</td>
                                                    <td>$500</td>
                                                </tr>
                                                <tr>
                                                    <td>Brand Guidellines</td>
                                                    <td>1</td>
                                                    <td>$5000</td>
                                                    <td>$100</td>
                                                    <td>$5000</td>
                                                </tr>
                                                <tr>
                                                    <td>Social Media Template</td>
                                                    <td>1</td>
                                                    <td>$5000</td>
                                                    <td>$100</td>
                                                    <td>$5000</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /Table List -->
                                </div>
                            </div>
                            <!-- etart row -->
                             
                            <div class="pb-3 mb-3 border-1 border-bottom ">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div>
                                            <div class=" mb-3">
                                                <h6 class="mb-1 fs-14 fw-semibold"> Terms and Conditions </h6>
                                                <p class="mb-0"> Please pay within 15 days from the date of invoice, overdue interest &copy; 14% will be charged on delayed payments.</p>
                                            </div>

                                            <div>
                                                <h6 class="mb-1 fs-14 fw-semibold"> Notes </h6>
                                                <p class="mb-0"> Please quote invoice number when remitting funds.</p>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-lg-6">
                                        <div class="">
                                            <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2">
                                                <h6 class="fs-14 fw-medium mb-0">Sub Total</h6>
                                                <h6 class="fs-14 fw-medium mb-0">$5500</h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2">
                                                <h6 class="fs-14 fw-medium mb-0">Discount(0%)</h6>
                                                <h6 class="fs-14 fw-medium mb-0">$400</h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h6 class="fs-14 fw-medium mb-0">VAT(5%)</h6>
                                                <h6 class="fs-14 fw-medium mb-0">$54</h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0">TotalAMount</h6>
                                                <h6 class="mb-0">$5775</h6>
                                            </div>
                                            <p>Amount in Words : Dollar Five thousand Seven Seventy Five</p>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                            </div>
                            <!-- end row -->

                            <!-- Items -->
                            <div class="text-end border-bottom mb-3 pb-3">
                                <div>
                                    <img src="{{URL::asset('build/img/icons/signature-img.svg')}}" alt="" class="img-fluid "> 
                                    <h6 class="fs-14 fw-semibold"> Ted M. Davis </h6>
                                    <p class="fs-13 fw-normal mb-0">Assistant Manager</p>
                                </div>
                            </div>

                            <div class="text-center border-bottom pb-3 mb-3">
                                <div class="text-center mb-3">
                                    <img src="{{URL::asset('build/img/logo.svg')}}" class="invoice-light-logo" width="130" alt="">
                                    <img src="{{URL::asset('build/img/logo-white.svg')}}" class="dark-logo" width="130" alt="">
                                </div>
                                <p class="fs-13 mb-1">Payment Made Via bank transfer / Cheque in the name of Thomas Lawler</p>
                                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                                    <p class="mb-0">Bank Name : <span class="text-dark">HDFC Bank</span></p>
                                    <p class="mb-0">Account Number : <span class="text-dark">45366287987</span></p>
                                    <p class="mb-0">IFSC : <span class="text-dark">HDFC0018159</span></p>
                                </div>
                            </div>

                            <div class="text-center d-flex align-items-center justify-content-end">
                                <a href="#" class="btn btn-md btn-light me-2 d-flex align-items-center" > <i class="ti ti-copy me-1"></i>Clone Invoice</a>
                                <a href="#" class="btn btn-md btn-primary d-flex align-items-center" > <i class="ti ti-printer me-1"></i>Print Invoice</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- end row-->
            
        </div>
        <!-- End Content -->

        @component('components.footer')
        @endcomponent

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection        