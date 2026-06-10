<?php $page = 'login'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="overflow-hidden p-3 acc-vh">

        <!-- start row -->
        <div class="row vh-100 w-100 g-0">

            <div class="col-lg-6 vh-100 overflow-y-auto overflow-x-hidden">

                <!-- start row -->
                <div class="row">

                    <div class="col-md-10 mx-auto">
                        <div class="vh-100 d-flex justify-content-between flex-column p-4 pb-0">
                            <div class="text-center mb-4 auth-logo">
                                <img src="{{URL::asset('assets/logo_perusahaan/logo_ssb.png')}}" class="img-fluid"
                                    alt="Logo">
                            </div>
                            <div>
                                <div class="mb-4">
                                    <h3 class="mb-2">Sign In</h3>
                                    <p class="mb-0 text-muted">Access the Project panel using your Single Sign-On account.</p>
                                </div>

                                @if($errors->has('sso'))
                                    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert" style="border-radius: 8px;">
                                        <i class="ti ti-alert-triangle-filled me-2" style="font-size: 1.25rem;"></i>
                                        <div>
                                            {{ $errors->first('sso') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-4 text-center">
                                    <a href="{{ route('sso.redirect') }}" class="btn btn-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="font-weight: 600; font-size: 1.05rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);">
                                        <i class="ti ti-shield-lock" style="font-size: 1.35rem;"></i>
                                        Sign In with SSB ID
                                    </a>
                                </div>

                                <div class="text-center text-muted small">
                                    <p>Secure login powered by SSB Identity Provider</p>
                                </div>
                            </div>
                            <div class="text-center pb-4">
                                <p class="text-dark mb-0">Copyright &copy; <script>document.write(new Date().getFullYear())</script> - SSB - Project Management System</p>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>
                <!-- end row -->

            </div>

            <div class="col-lg-6 account-bg-01"></div> <!-- end col -->

        </div>
        <!-- end row -->

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection
