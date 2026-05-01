<?php $page = 'final-contracts'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Contract: {{ $contract->contract_number }}</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('final-contracts.index') }}">Final Contracts</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Details</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="{{ route('final-contracts.index') }}" class="btn btn-light d-flex align-items-center">
                            <i class="ti ti-arrow-left me-1"></i>Back to List
                        </a>
                    </div>
                    @if($contract->attachment_path)
                        <div class="mb-2">
                            <a href="{{ Storage::url($contract->attachment_path) }}" target="_blank" class="btn btn-info d-flex align-items-center">
                                <i class="ti ti-download me-1"></i>Download Contract
                            </a>
                        </div>
                    @endif
                    @if(!$contract->isLocked())
                        <div class="mb-2">
                            <a href="{{ route('final-contracts.edit', $contract->uid) }}" class="btn btn-warning d-flex align-items-center text-white">
                                <i class="ti ti-edit me-1"></i>Edit Contract
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="card overflow-hidden">
                        <div class="card-header bg-light-200">
                            <h5 class="mb-0">Contract Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted d-block small mb-1">Status</label>
                                <span class="badge bg-{{ $contract->status->color() }} fs-14">
                                    {{ $contract->status->label() }}
                                </span>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="text-muted d-block small mb-1">Effective Date</label>
                                    <span class="fw-bold">{{ $contract->start_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted d-block small mb-1">Expiration Date</label>
                                    <span class="fw-bold text-{{ $contract->end_date->isPast() ? 'danger' : 'success' }}">
                                        {{ $contract->end_date->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block small mb-1">Days Remaining</label>
                                @if($contract->end_date->isPast())
                                    <span class="text-danger">EXPIRED</span>
                                @else
                                    <span class="fw-bold">{{ now()->diffInDays($contract->end_date) }} days</span>
                                @endif
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="text-muted d-block small mb-1">Created By</label>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center">
                                            {{ strtoupper(substr($contract->creator->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0 small">{{ $contract->creator->name }}</h6>
                                        <span class="text-muted x-small">{{ $contract->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            @if($contract->approved_by)
                                <div class="mb-0">
                                    <label class="text-muted d-block small mb-1">Approved By</label>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar avatar-sm rounded-circle bg-success text-white d-flex align-items-center justify-content-center">
                                                {{ strtoupper(substr($contract->approver->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0 small">{{ $contract->approver->name }}</h6>
                                            <span class="text-muted x-small">{{ $contract->approved_at->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header bg-light-200">
                            <h5 class="mb-0">Client Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted d-block small mb-1">Client Name</label>
                                <span class="fw-bold">{{ $contract->project->user_name }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted d-block small mb-1">Client Code</label>
                                <span class="fw-bold">{{ $contract->project->user_code }}</span>
                            </div>
                            <div class="mb-0">
                                <label class="text-muted d-block small mb-1">Address</label>
                                <p class="mb-0 small line-height-1.5">{{ $contract->project->user_address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#contract_details" role="tab">
                                        <i class="ti ti-file-text me-1"></i>Contract Items
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#project_info" role="tab">
                                        <i class="ti ti-atom-2 me-1"></i>Project Info
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="contract_details" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Unit Item</th>
                                                    <th class="text-center">QTY</th>
                                                    <th class="text-end">Unit Price</th>
                                                    <th class="text-end">Total Price</th>
                                                    <th class="text-center">Duration</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $totalagreed = 0; @endphp
                                                @foreach($contract->items as $item)
                                                    @php $totalagreed += $item->total_price; @endphp
                                                    <tr>
                                                        <td>{{ $item->unit_name }}</td>
                                                        <td class="text-center">{{ number_format($item->qty, 0) }}</td>
                                                        <td class="text-end">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                        <td class="text-end">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                                        <td class="text-center">{{ number_format($item->duration, 0) }} MONTH</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="fw-bold bg-light">
                                                <tr>
                                                    <td colspan="3" class="text-end">Total Agreed Value:</td>
                                                    <td class="text-end text-primary">Rp {{ number_format($totalagreed, 0, ',', '.') }}</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h6 class="fw-bold mb-2">Scope of Work:</h6>
                                        <div class="p-3 bg-light rounded border">
                                            {!! nl2br(e($contract->project->scope_of_work)) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="project_info" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="text-muted d-block small mb-1">Project Number</label>
                                            <span class="fw-bold">{{ $contract->project->project_number }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted d-block small mb-1">Project Name</label>
                                            <span class="fw-bold">{{ $contract->project->project_name }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted d-block small mb-1">Location</label>
                                            <span class="fw-bold">{{ $contract->project->project_location ?? '-' }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted d-block small mb-1">Negotiation Number</label>
                                            <span class="fw-bold text-primary">{{ $contract->negotiation->negotiation_number }}</span>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="text-muted d-block small mb-1">Project Description</label>
                                            <p class="mb-0 small">{{ $contract->project->description ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-flex justify-content-end">
                                        <a href="{{ route('projects.show', $contract->project->id) }}" class="btn btn-primary btn-sm">
                                            View Full Project Details <i class="ti ti-external-link ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

@endsection
