<?php $page = 'form-mask'; ?>
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
                <h4 class="mb-1">Form Inputmask</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{url('index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Inputmask</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Header -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Inputmask</h5>
                </div>
                <div class="card-body pb-0">
                    <p class="text-muted">A JavaScript plugin for applying input masks to form fields and HTML elements</p>

                    <!-- start row -->
                    <div class="row">

                        <div class="col-md-6">
                            <form action="#">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000">
                                    <span class="fs-13 text-muted">e.g "DD/MM/YYYY"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="00/00/0000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Hour</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00">
                                    <span class="fs-13 text-muted">e.g "HH:MM:SS"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="00:00:00"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date & Hour</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000 00:00:00">
                                    <span class="fs-13 text-muted">e.g "DD/MM/YYYY HH:MM:SS"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="00/00/0000 00:00:00"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00000-000">
                                    <span class="fs-13 text-muted">e.g "xxxxx-xxx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="00000-000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">SSN field 1</label>
                                    <input type="text" id="ssn" class="form-control" data-toggle="input-mask" data-mask-format="000-00-0000">
                                    <span class="form-text text-muted">e.g "999-99-9999"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="000-00-0000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Crazy Zip Code</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0-00-00-00">
                                    <span class="fs-13 text-muted">e.g "x-xx-xx-xx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="0-00-00-00"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Money</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true">
                                    <span class="fs-13 text-muted">e.g "Your money"</span>
                                    <p class="mt-1">Add attribute <code>data-mask-format="000.000.000.000.000,00" data-reverse="true"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Percent</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00%" data-reverse="true">
                                    <span class="fs-13 text-muted">e.g "99%"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="00%" data-reverse="true"</code></p>
                                </div>
                            </form>
                        </div> <!-- end col -->

                        <div class="col-md-6">
                            <form action="#">
                                <div class="mb-3">
                                    <label class="form-label">Telephone</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0000-0000">
                                    <span class="fs-13 text-muted">e.g "xxxx-xxxx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="0000-0000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telephone with Code Area</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(00) 0000-0000">
                                    <span class="fs-13 text-muted">e.g "(xx) xxxx-xxxx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="(00) 0000-0000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">US Telephone</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(000) 000-0000">
                                    <span class="fs-13 text-muted">e.g "(xxx) xxx-xxxx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="(000) 000-0000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">São Paulo Celphones</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(00) 00000-0000">
                                    <span class="fs-13 text-muted">e.g "(xx) xxxxx-xxxx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="(00) 00000-0000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000-00" data-reverse="true">
                                    <span class="fs-13 text-muted">e.g "xxx.xxx.xxxx-xx"</span>
                                    <p class="mt-1">Add attribute <code>data-mask-format="000.000.000-00" data-reverse="true"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">IP Address</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="099.099.099.099" data-reverse="true">
                                    <span class="fs-13 text-muted">e.g "xxx.xxx.xxx.xxx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="099.099.099.099"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Credit Card Number</label>
                                    <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0000.0000.0000.0000" >
                                    <span class="form-text text-muted">e.g "xxxx.xxxx.xxxx.xxxx"</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="0000.0000.0000.0000"</code></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Eye Script</label>
                                    <input type="text" id="eyescript" class="form-control" data-toggle="input-mask" data-mask-format="~0.00 ~0.00 000">
                                    <span class="form-text text-muted">~9.99 ~9.99 999</span>
                                    <p class="mt-1">Add attribute <code>data-toggle="input-mask" data-mask-format="~0.00 ~0.00 000"</code></p>
                                </div>
                            </form>
                        </div> <!-- end col -->

                    </div>
                    <!-- end row -->

                </div> <!-- end card body -->
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