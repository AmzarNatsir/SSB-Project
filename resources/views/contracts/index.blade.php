<?php $page = 'final-contracts'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Final Project Contracts</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Final Contracts</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="{{ route('final-contracts.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="ti ti-plus-circle me-2"></i>Create Contract
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Search Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('final-contracts.index') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-0">
                                    <label class="form-label">Contract Number</label>
                                    <input type="text" name="contract_number" class="form-control" placeholder="Search by number..." value="{{ request('contract_number') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <label class="form-label">Start Date (From)</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <label class="form-label">End Date (To)</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ti ti-search"></i>
                                    </button>
                                    <a href="{{ route('final-contracts.index') }}" class="btn btn-light w-100">
                                        <i class="ti ti-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Search Filters -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Contract List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Contract Number</th>
                                    <th>Project</th>
                                    <th>Client</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contracts as $contract)
                                    <tr>
                                        <td>
                                            <a href="{{ route('final-contracts.show', $contract->uid) }}" class="fw-bold text-primary">
                                                {{ $contract->contract_number }}
                                            </a>
                                        </td>
                                        <td>{{ $contract->project->project_name }}</td>
                                        <td>{{ $contract->project->user_name }}</td>
                                        <td>{{ $contract->start_date->format('d/m/Y') }}</td>
                                        <td>{{ $contract->end_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $contract->status->color() }}">
                                                {{ $contract->status->label() }}
                                            </span>
                                            @if($contract->isExpiringSoon())
                                                <span class="badge bg-warning text-dark ms-1" title="Expires in {{ now()->diffInDays($contract->end_date) }} days">
                                                    <i class="ti ti-alert-triangle"></i> Expiring Soon
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Action
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('final-contracts.show', $contract->uid) }}"><i class="ti ti-eye me-1"></i> View Details</a></li>
                                                    @if($contract->attachment_path)
                                                        <li><a class="dropdown-item" href="{{ Storage::url($contract->attachment_path) }}" target="_blank"><i class="ti ti-file-download me-1"></i> Download File</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No contracts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $contracts->links() }}
                </div>
            </div>
            <!-- /Contract List -->

        </div>
    </div>
    <!-- /Page Wrapper -->

@endsection
