<?php $page = 'approval-flows'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Approval Matrix</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Approval Matrix</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                @foreach($flows as $flow)
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-md bg-primary-transparent text-primary rounded">
                                        <i class="ti ti-settings-automation fs-20"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $flow->name }}</h5>
                                        <small class="text-muted">{{ $flow->code }}</small>
                                    </div>
                                </div>
                                @if($flow->is_active)
                                <span class="badge badge-soft-success">Active</span>
                                @else
                                <span class="badge badge-soft-danger">Inactive</span>
                                @endif
                            </div>
                            <p class="text-muted fs-13 mb-3">{{ $flow->description }}</p>
                            <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-auto">
                                <span class="fs-12 text-muted">
                                    <i class="ti ti-layers-subtract me-1"></i>
                                    {{ $flow->levels->count() }} Levels Configured
                                </span>
                                <a href="{{ route('approval-flows.show', $flow->id) }}" class="btn btn-sm btn-outline-primary">
                                    Configure Flow
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

@endsection
