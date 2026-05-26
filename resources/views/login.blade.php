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
                        <form action="{{ route('login.post') }}" method="POST" class=" vh-100 d-flex justify-content-between flex-column p-4 pb-0">
                            @csrf
                            <div class="text-center mb-4 auth-logo">
                                <img src="{{URL::asset('assets/logo_perusahaan/logo_ssb.png')}}" class="img-fluid"
                                    alt="Logo">
                            </div>
                            <div>
                                <div class="mb-3">
                                    <h3 class="mb-2">Sign In</h3>
                                    <p class="mb-0">Access the Project panel using your email and passcode.</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group input-group-flat">
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                        <span class="input-group-text">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group input-group-flat pass-group">
                                        <input type="password" name="password" class="form-control pass-input" required>
                                        <span class="input-group-text toggle-password ">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                </div>
                            </div>
                            <div class="text-center pb-4">
                                <p class="text-dark mb-0">Copyright &copy; <script>document.write(new Date().getFullYear())</script> - SSB - Project Management System</p>
                            </div>
                        </form>
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
