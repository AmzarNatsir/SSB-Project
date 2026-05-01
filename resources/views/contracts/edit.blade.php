<?php $page = 'final-contracts'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Edit Final Project Contract</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('final-contracts.index') }}">Final Contracts</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- /Page Header -->

            <form action="{{ route('final-contracts.update', $contract->uid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-primary">Project Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Project <span class="text-danger">*</span></label>
                                        <select name="project_id" id="project_id" class="select form-control" disabled>
                                            <option value="{{ $contract->project_id }}">
                                                {{ $contract->project->project_number }} - {{ $contract->project->project_name }}
                                            </option>
                                        </select>
                                        <input type="hidden" name="project_id" value="{{ $contract->project_id }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Client Name</label>
                                        <input type="text" id="client_name" class="form-control" value="{{ $contract->project->user_name }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Client Code</label>
                                        <input type="text" id="client_code" class="form-control" value="{{ $contract->project->user_code }}" readonly>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Client Address</label>
                                        <textarea id="client_address" class="form-control" rows="2" readonly>{{ $contract->project->user_address }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Project Location</label>
                                        <input type="text" id="project_location" class="form-control" value="{{ $contract->project->project_location }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Account</label>
                                        <input type="text" id="bank_account" class="form-control" value="{{ $contract->project->bank_account }}" readonly>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Scope of Work</label>
                                        <textarea id="scope_of_work" class="form-control" rows="3" readonly>{{ $contract->project->scope_of_work }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-primary">Unit Item List (Contract Items)</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="items_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Unit Item</th>
                                                <th>QTY</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items_body">
                                            @foreach($contract->items as $item)
                                            <tr>
                                                <td>{{ $item->unit_name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $item->duration }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-primary">Contract Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Contract Effective Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contract Expiration Date <span class="text-danger">*</span></label>
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Upload New Contract File (PDF/DOC)</label>
                                    <div class="form-file">
                                        <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                                        <small class="text-muted">Current: <a href="{{ Storage::url($contract->attachment_path) }}" target="_blank">{{ basename($contract->attachment_path) }}</a></small>
                                    </div>
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-device-floppy me-1"></i>Update Contract
                                </button>
                                <a href="{{ route('final-contracts.index') }}" class="btn btn-light w-100">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Page Wrapper -->
@endsection
