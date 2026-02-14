<?php $page = 'prefixes-setings'; ?>
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

						<div class="card">
							<div class="card-body">
								<div class="border-bottom mb-3 pb-3">
									<h5 class="mb-0 fs-17">Prefixes</h5>
								</div>
								<form action="{{url('prefixes-settings')}}">
									<div class="border-bottom mb-3">

										<!-- start row -->
										<div class="row">
											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Products</label>
													<input type="text" class="form-control" value="SKU - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Supplier</label>
													<input type="text" class="form-control" value="SUP - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Purchase</label>
													<input type="text" class="form-control" value="PU - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Purchase Return</label>
													<input type="text" class="form-control" value="PR - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Sales</label>
													<input type="text" class="form-control" value="SA - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Sales Return</label>
													<input type="text" class="form-control" value="SR -  ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Customer</label>
													<input type="text" class="form-control" value="CT - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Expense</label>
													<input type="text" class="form-control" value="EX - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Stock Transfer</label>
													<input type="text" class="form-control" value="ST -  ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Stock Adjustment</label>
													<input type="text" class="form-control" value="SA -  ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Sales Order</label>
													<input type="text" class="form-control" value="SO - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Invoice</label>
													<input type="text" class="form-control" value="INV -  ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Estimation</label>
													<input type="text" class="form-control" value="EST - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Transaction</label>
													<input type="text" class="form-control" value="TRN - ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Employee</label>
													<input type="text" class="form-control" value="EMP -  ">
												</div>
											</div> <!-- end col -->

											<div class="col-md-3 col-sm-6">
												<div class="mb-3">
													<label class="form-label">Purchase Return</label>
													<input type="text" class="form-control" value="PR -  ">
												</div>
											</div> <!-- end col -->

										</div>
										<!-- end row -->

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