<?php $page = 'projects'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Project Header -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-2">{{ $project->project_name }}</h2>
                            <div class="d-flex align-items-center gap-3">
                                <span class="text-muted">Lokasi Proyek</span>
                                <span class="fw-semibold">: {{ $project->category->name ?? '-' }}</span>
                                
                                <span class="text-muted ms-4">Waktu Pelaksanaan</span>
                                <span class="fw-semibold">: {{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <span class="text-muted">Waktu Berjalan</span>
                                <span class="fw-semibold">: {{ $project->duration_of_work ?? 0 }} Hari</span>
                                
                                <span class="text-muted ms-4">Sisa Waktu</span>
                                <span class="fw-semibold">: {{ $project->end_date ? \Carbon\Carbon::now()->diffInDays($project->end_date, false) : 0 }} Hari</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('projects.index') }}" class="btn btn-light">
                                <i class="ti ti-arrow-left me-1"></i> Back to List
                            </a>
                            @if($project->project_status === 'NOT STARTED')
                                <a href="javascript:void(0);" class="btn btn-warning edit-project-btn" data-id="{{ $project->uid }}">
                                    <i class="ti ti-edit me-1"></i> Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs-modern mb-4" id="projectTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="ti ti-info-circle me-1"></i> Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
                                <i class="ti ti-file-text me-1"></i> Project Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="client-tab" data-bs-toggle="tab" data-bs-target="#client" type="button" role="tab">
                                <i class="ti ti-user me-1"></i> Client Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">
                                <i class="ti ti-photo me-1"></i> Images
                            </button>
                        </li>
                        @if($project->project_status === 'COMPLETED' && $project->surveys->isNotEmpty())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="feasibility-tab" data-bs-toggle="tab" data-bs-target="#feasibility" type="button" role="tab">
                                <i class="ti ti-clipboard-check me-1"></i> Feasibility Project
                            </button>
                        </li>
                        @endif
                        @if($project->latest_budget && $project->latest_budget->status === \App\Enums\BudgetStatus::BASELINE_APPROVED)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="budget-tab" data-bs-toggle="tab" data-bs-target="#budget" type="button" role="tab">
                                <i class="ti ti-calculator me-1"></i> Project Budget
                            </button>
                        </li>
                        @endif
                        @if($project->latest_quotation && $project->latest_quotation->status === 'APPROVED')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="quotation-tab" data-bs-toggle="tab" data-bs-target="#quotation" type="button" role="tab">
                                <i class="ti ti-file-invoice me-1"></i> Quotation
                            </button>
                        </li>
                        @endif
                        @if($project->latest_negotiation && $project->latest_negotiation->status === \App\Enums\NegotiationStatus::APPROVED)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="negotiation-tab" data-bs-toggle="tab" data-bs-target="#negotiation" type="button" role="tab">
                                <i class="ti ti-messages me-1"></i> Negotiation
                            </button>
                        </li>
                        @endif

                        @if($project->contracts->isNotEmpty())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contracts-tab" data-bs-toggle="tab" data-bs-target="#contracts" type="button" role="tab">
                                <i class="ti ti-file-certificate me-1"></i> Final Contracts
                            </button>
                        </li>
                        @endif
                        
                        @if($project->unitRequests->isNotEmpty())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="units-tab" data-bs-toggle="tab" data-bs-target="#units" type="button" role="tab">
                                <i class="ti ti-truck me-1"></i> Units
                            </button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manpower-tab" data-bs-toggle="tab" data-bs-target="#manpower" type="button" role="tab">
                                <i class="ti ti-users me-1"></i> Work Force
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="projectTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Number</label>
                                        <p class="fw-semibold">{{ $project->project_number }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Code</label>
                                        <p class="fw-semibold">{{ $project->project_code }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Category</label>
                                        <p class="fw-semibold">{{ $project->category->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Sub Category</label>
                                        <p class="fw-semibold">{{ $project->subCategory->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Status</label>
                                        <div>
                                            @php
                                                $statusConfig = [
                                                    'NOT STARTED' => ['color' => 'bg-purple', 'text' => 'Plan'],
                                                    'ON PROGRESS' => ['color' => 'bg-info', 'text' => 'Survey'],
                                                    'COMPLETED' => ['color' => 'bg-success', 'text' => 'Completed'],
                                                    'ON HOLD' => ['color' => 'bg-warning', 'text' => 'On Hold'],
                                                    'CANCELLED' => ['color' => 'bg-danger', 'text' => 'Cancelled'],
                                                ];
                                                $config = $statusConfig[$project->project_status] ?? ['color' => 'bg-secondary', 'text' => $project->project_status];
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 80px; height: 6px;">
                                                    <div class="progress-bar {{ $config['color'] }}" role="progressbar" style="width: 100%"></div>
                                                </div>
                                                <span>{{ $config['text'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Value</label>
                                        <p class="fw-semibold text-success">Rp {{ number_format($project->project_value, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-muted small">Description</label>
                                        <p>{{ $project->description ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Details Tab -->
                        <div class="tab-pane fade" id="details" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Request Date</label>
                                        <p class="fw-semibold">{{ $project->request_date ? $project->request_date->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Start Date</label>
                                        <p class="fw-semibold">{{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">End Date</label>
                                        <p class="fw-semibold">{{ $project->end_date ? $project->end_date->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Duration</label>
                                        <p class="fw-semibold">{{ $project->duration_of_work ?? 0 }} Days</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Project Location</label>
                                        <p class="fw-semibold">{{ $project->project_location ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Coordinates</label>
                                        <p class="fw-semibold">{{ $project->project_coordinates ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Job Type</label>
                                        <p class="fw-semibold">{{ $project->job_type ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">PIC</label>
                                        <p class="fw-semibold">{{ $project->pic->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Equipment Rental Rate</label>
                                        <p class="fw-semibold">{{ $project->equipmentRentalRate->jenis_alat ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Bank Account</label>
                                        <p class="fw-semibold">{{ $project->bank_account ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-muted small">Scope of Work</label>
                                        <p>{{ $project->scope_of_work ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client Information Tab -->
                        <div class="tab-pane fade" id="client" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">User Name</label>
                                        <p class="fw-semibold">{{ $project->user_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">User Code</label>
                                        <p class="fw-semibold">{{ $project->user_code ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Email</label>
                                        <p class="fw-semibold">{{ $project->email ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Phone Number</label>
                                        <p class="fw-semibold">{{ $project->phone_number ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Taxpayer ID</label>
                                        <p class="fw-semibold">{{ $project->taxpayer_id ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-muted small">Address</label>
                                        <p>{{ $project->user_address ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Images Tab -->
                        <div class="tab-pane fade" id="images" role="tabpanel">
                            <!-- Breadcrumb -->
                            <div class="mb-3">
                                <h5 class="mb-2">File Uploads</h5>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">File Uploads</li>
                                    </ol>
                                </nav>
                            </div>

                            <!-- Dropzone Upload Section -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Dropzone File Upload</h6>
                                    <p class="text-muted small mb-3">DropzoneJS is an open source library that provides drag'n'drop file uploads with image previews.</p>
                                    
                                    <form action="{{ route('projects.upload-image', $project->uid) }}" 
                                          class="dropzone" 
                                          id="projectImageDropzone">
                                        @csrf
                                        <div class="dz-message text-center">
                                            <i class="ti ti-cloud-upload" style="font-size: 48px; color: #6c757d;"></i>
                                            <h5 class="mt-3">Drop files here or click to upload.</h5>
                                            <p class="text-muted">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Image Gallery -->
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Uploaded Images</h6>
                                    <div class="row" id="imageGallery">
                                        @forelse($project->images as $image)
                                            <div class="col-md-4 col-lg-3 mb-3" id="image-{{ $image->uid }}">
                                                <div class="card h-100 shadow-sm border-0">
                                                    <a href="{{ url('storage/' . $image->file_path) }}" 
                                                       data-fancybox="gallery" 
                                                       data-type="image"
                                                       data-caption="{{ $image->description ?? $image->file_image }}">
                                                        <img src="{{ url('storage/' . $image->file_path) }}" 
                                                             class="card-img-top rounded" 
                                                             alt="{{ $image->file_image }}"
                                                             style="height: 200px; object-fit: cover; cursor: pointer;">
                                                    </a>
                                                    <div class="card-body p-2">
                                                        <p class="card-text small text-truncate mb-2" title="{{ $image->description ?? $image->file_image }}">
                                                            {{ $image->description ?? $image->file_image }}
                                                        </p>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger delete-image-btn w-100" 
                                                                data-id="{{ $image->uid }}">
                                                            <i class="ti ti-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12 text-center py-5" id="noImagesMessage">
                                                <i class="ti ti-photo" style="font-size: 64px; color: #ccc;"></i>
                                                <p class="text-muted mt-3">No images uploaded yet</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Feasibility Tab -->
                        @if($project->project_status === 'COMPLETED' && $project->surveys->isNotEmpty())
                        @php $survey = $project->surveys->first(); @endphp
                        <div class="tab-pane fade" id="feasibility" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    @php
                                        $recommendation = $survey->metadata['feasibility_recommendation'] ?? 'No recommendation available';
                                        $isFeasible = $survey->is_feasible;
                                    @endphp

                                    <div class="card mb-3 border-{{ $isFeasible ? 'success' : 'danger' }}">
                                        <div class="card-header bg-{{ $isFeasible ? 'success' : 'danger' }}-transparent">
                                            <h5 class="card-title mb-0 text-{{ $isFeasible ? 'success' : 'danger' }}">
                                                <i class="ti ti-{{ $isFeasible ? 'check-circle' : 'x-circle' }} me-2"></i>
                                                Feasibility Assessment Result
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row align-items-center mb-3">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-xl bg-{{ $isFeasible ? 'success' : 'danger' }}-transparent rounded me-3">
                                                            <i class="ti ti-{{ $isFeasible ? 'thumb-up' : 'thumb-down' }} fs-32 text-{{ $isFeasible ? 'success' : 'danger' }}"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Feasibility Status</h6>
                                                            <h4 class="mb-0 text-{{ $isFeasible ? 'success' : 'danger' }}">
                                                                {{ $isFeasible ? 'FEASIBLE' : 'NOT FEASIBLE' }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <h6 class="mb-1">Total Score</h6>
                                                    <h2 class="mb-0 text-{{ $isFeasible ? 'success' : 'danger' }}">
                                                        {{ number_format($survey->total_score, 2) }}
                                                        <small class="text-muted fs-6">/100</small>
                                                    </h2>
                                                </div>
                                            </div>

                                            <div class="alert alert-{{ $isFeasible ? 'success' : 'danger' }} mb-0">
                                                <h6 class="alert-heading">
                                                    <i class="ti ti-bulb me-2"></i>Recommendation
                                                </h6>
                                                <p class="mb-0">{{ $recommendation }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h6 class="card-title mb-0">Survey info</h6>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-sm mb-0">
                                                        <tr>
                                                            <td class="text-muted" style="width: 150px;">Survey Number</td>
                                                            <td class="fw-semibold">: {{ $survey->survey_number ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">Scheduled At</td>
                                                            <td class="fw-semibold">: {{ $survey->scheduled_at ? $survey->scheduled_at->format('d M Y') : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">Completed At</td>
                                                            <td class="fw-semibold">: {{ $survey->updated_at->format('d M Y') }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-3">
                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                    <h6 class="card-title mb-0">Supporting Documents</h6>
                                                    <a href="{{ route('project-survey.show', $survey->uid) }}" class="btn btn-sm btn-primary">
                                                        <i class="ti ti-external-link"></i> Full Details
                                                    </a>
                                                </div>
                                                <div class="card-body">
                                                    @if($survey->is_skipped)
                                                        <div class="alert alert-warning mb-0">
                                                            <i class="ti ti-alert-triangle me-2"></i>This survey was skipped.
                                                        </div>
                                                    @else
                                                        <p class="text-muted small mb-0">This project has passed the feasibility survey stage. You can view all scores, team members, and documents in the full survey report.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Budget Tab -->
                        @if($project->latest_budget && $project->latest_budget->status === \App\Enums\BudgetStatus::BASELINE_APPROVED)
                        @php $budget = $project->latest_budget; @endphp
                        <div class="tab-pane fade" id="budget" role="tabpanel">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card border-0 bg-primary-transparent overflow-hidden mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="text-muted mb-1 fw-medium fs-13">Total HPP (COGS)</p>
                                                    <h4 class="mb-0 fw-bold">Rp {{ number_format($budget->total_hpp, 0, ',', '.') }}</h4>
                                                </div>
                                                <div class="bg-primary text-white p-2 rounded">
                                                    <i class="ti ti-calculator fs-20"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 bg-success-transparent overflow-hidden mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="text-muted mb-1 fw-medium fs-13">Profit Margin ({{ $budget->profit_margin_percent ?? 0 }}%)</p>
                                                    <h4 class="mb-0 fw-bold text-success">Rp {{ number_format($budget->selling_price - $budget->total_hpp, 0, ',', '.') }}</h4>
                                                </div>
                                                <div class="bg-success text-white p-2 rounded">
                                                    <i class="ti ti-chart-pie fs-20"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 bg-info-transparent overflow-hidden mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="text-muted mb-1 fw-medium fs-13">Selling Price</p>
                                                    <h4 class="mb-0 fw-bold text-info">Rp {{ number_format($budget->selling_price, 0, ',', '.') }}</h4>
                                                </div>
                                                <div class="bg-info text-white p-2 rounded">
                                                    <i class="ti ti-currency-dollar fs-20"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-list-check me-2 text-primary"></i>Cost Breakdown
                                            </h5>
                                            <a href="{{ route('budgets.show', $budget->uid) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-external-link me-1"></i> View Full Budget
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <ul class="nav nav-pills nav-fill mb-3 p-1 bg-light rounded" role="tablist">
                                                @foreach(App\Enums\BudgetCategory::cases() as $category)
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link {{ $loop->first ? 'active' : '' }} d-flex align-items-center justify-content-center gap-1 py-1 fs-12" href="#budget_tab_{{ $category->value }}" data-bs-toggle="pill" role="tab">
                                                            <i class="ti {{ $category->icon() }} fs-14"></i>
                                                            <span class="d-none d-lg-inline">{{ $category->label() }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            
                                            <div class="tab-content pt-2">
                                                @foreach(App\Enums\BudgetCategory::cases() as $category)
                                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="budget_tab_{{ $category->value }}" role="tabpanel">
                                                        <div class="table-responsive">
                                                            <table class="table table-nowrap table-hover border-top-0 table-sm">
                                                                <thead class="bg-light-500">
                                                                    <tr>
                                                                        <th class="border-0">Item Description</th>
                                                                        <th class="text-end border-0">Qty</th>
                                                                        <th class="border-0 text-center">Unit</th>
                                                                        <th class="text-end border-0">Unit Cost</th>
                                                                        <th class="text-end border-0">Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="border-0">
                                                                    @php
                                                                        $categoryItems = $budget->items->where('category', $category);
                                                                        $categoryTotal = 0;
                                                                    @endphp
                                                                    @forelse($categoryItems as $item)
                                                                        @php $categoryTotal += $item->total_cost; @endphp
                                                                        <tr>
                                                                            <td class="fw-medium text-dark">{{ $item->item_name }}</td>
                                                                            <td class="text-end">{{ number_format($item->qty, 2) }}</td>
                                                                            <td class="text-center"><span class="badge bg-light text-dark border">{{ $item->units }}</span></td>
                                                                            <td class="text-end">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                                                                            <td class="text-end fw-bold text-primary">Rp {{ number_format($item->total_cost, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="5" class="text-center py-4 text-muted">
                                                                                No items found
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                                @if($categoryItems->count() > 0)
                                                                <tfoot class="bg-light-500">
                                                                    <tr>
                                                                        <th colspan="4" class="text-end border-0 px-3 py-2">Subtotal:</th>
                                                                        <th class="text-end border-0 px-3 py-2 fs-14 text-primary">Rp {{ number_format($categoryTotal, 0, ',', '.') }}</th>
                                                                    </tr>
                                                                </tfoot>
                                                                @endif
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Quotation Tab -->
                        @if($project->latest_quotation && $project->latest_quotation->status === 'APPROVED')
                        @php $quotation = $project->latest_quotation; @endphp
                        <div class="tab-pane fade" id="quotation" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-file-invoice me-2 text-primary"></i>Quotation Details
                                            </h5>
                                            <a href="{{ route('quotations.show', $quotation->uid) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-external-link me-1"></i> View Full Quotation
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3 small">Project Information</h6>
                                                    <h5 class="mb-1 text-primary">{{ $quotation->project->project_name ?? 'N/A' }}</h5>
                                                    <p class="text-muted mb-2 small"><i class="ti ti-hash me-1"></i> {{ $quotation->project->project_number ?? 'N/A' }}</p>
                                                    <p class="text-muted mb-0 small"><i class="ti ti-calendar-event me-1"></i> Created on {{ $quotation->created_at->format('d M, Y') }}</p>
                                                </div>
                                                <div class="col-md-6 text-md-end mt-4 mt-md-0">
                                                    <h6 class="text-muted text-uppercase fw-semibold mb-3 small">Financial Summary</h6>
                                                    <h3 class="text-primary mb-1">Rp {{ number_format($quotation->selling_price, 0, ',', '.') }}</h3>
                                                    <p class="text-muted small mb-0">Valid Until: <span class="text-dark fw-medium">{{ $quotation->valid_until ? $quotation->valid_until->format('d M, Y') : 'N/A' }}</span></p>
                                                </div>
                                            </div>

                                            <h6 class="text-muted text-uppercase fw-semibold mb-3 small">Unit Selection & Rate Breakdown</h6>
                                            <div class="table-responsive">
                                                <table class="table table-hover border-top-0 table-sm">
                                                    <thead class="bg-light-500">
                                                        <tr>
                                                            <th class="border-0">Unit / Equipment</th>
                                                            <th class="text-end border-0">Rate (Rp)</th>
                                                            <th class="text-center border-0">Qty</th>
                                                            <th class="text-center border-0">Duration</th>
                                                            <th class="text-end border-0">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border-0">
                                                        @foreach($quotation->items as $item)
                                                        <tr>
                                                            <td class="fw-medium text-dark">{{ $item->unit_name }}</td>
                                                            <td class="text-end">Rp {{ number_format($item->rate, 0, ',', '.') }}</td>
                                                            <td class="text-center">{{ $item->quantity }}</td>
                                                            <td class="text-center">{{ $item->duration }}</td>
                                                            <td class="text-end fw-bold text-primary">Rp {{ number_format($item->rate * $item->quantity * $item->duration, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="bg-light-500">
                                                        <tr>
                                                            <th colspan="4" class="text-end border-0 px-3 py-2">Total Project Value:</th>
                                                            <th class="text-end border-0 px-3 py-2 fs-14 text-primary">Rp {{ number_format($quotation->selling_price, 0, ',', '.') }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            @if($quotation->terms_conditions)
                                            <div class="mt-4 p-3 bg-light rounded-3">
                                                <h6 class="text-muted text-uppercase fw-semibold mb-2 fs-11">Terms & Conditions</h6>
                                                <p class="text-muted mb-0 small" style="white-space: pre-wrap;">{{ $quotation->terms_conditions }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Negotiation Tab -->
                        @if($project->latest_negotiation && $project->latest_negotiation->status === \App\Enums\NegotiationStatus::APPROVED)
                        @php $negotiation = $project->latest_negotiation; @endphp
                        <div class="tab-pane fade" id="negotiation" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-messages me-2 text-primary"></i>Negotiation History
                                            </h5>
                                            <a href="{{ route('negotiations.show', $negotiation->uid) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-external-link me-1"></i> View Full Negotiation
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-lg bg-success-transparent rounded me-3">
                                                            <i class="ti ti-check fs-24 text-success"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 text-muted small">Final Agreed Value</h6>
                                                            <h3 class="mb-0 text-success">Rp {{ number_format($negotiation->final_agreed_value, 0, ',', '.') }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <p class="mb-1 text-muted small">Negotiation #{{ $negotiation->negotiation_number }}</p>
                                                    <span class="badge bg-success-transparent text-success border border-success-subtle px-3 py-2 rounded-pill">
                                                        {{ $negotiation->status->label() }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="ms-md-4 border-start border-2 border-primary-light ps-4 py-2">
                                                <!-- Initial Quote -->
                                                <div class="position-relative mb-4">
                                                    <div class="position-absolute translate-middle-x bg-primary rounded-circle" style="width: 12px; height: 12px; left: -32.5px; top: 10px; border: 3px solid #fff;"></div>
                                                    <h6 class="mb-1 fw-bold">Initial Quotation Submitted</h6>
                                                    <p class="text-muted small mb-2">{{ $negotiation->quotation->created_at->format('d M Y, H:i') }}</p>
                                                    <div class="bg-light p-2 rounded d-inline-block">
                                                        <span class="text-muted fs-11 text-uppercase d-block">Company Offer</span>
                                                        <span class="fw-bold text-dark">Rp {{ number_format($negotiation->quotation->selling_price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>

                                                <!-- Rounds -->
                                                @foreach($negotiation->rounds as $round)
                                                <div class="position-relative mb-4">
                                                    <div class="position-absolute translate-middle-x bg-info rounded-circle" style="width: 12px; height: 12px; left: -32.5px; top: 10px; border: 3px solid #fff;"></div>
                                                    <h6 class="mb-1 fw-bold text-info">Round {{ $round->round_number }} Negotiation</h6>
                                                    <p class="text-muted small mb-2">Meeting on {{ $round->meeting_date->format('d M Y') }}</p>
                                                    
                                                    <div class="row g-2">
                                                        <div class="col-auto">
                                                            <div class="bg-danger-transparent border border-danger-subtle p-2 rounded">
                                                                <span class="fs-11 text-uppercase text-danger d-block">Client Offer</span>
                                                                <span class="fw-bold text-danger">Rp {{ number_format($round->client_offer_value, 0, ',', '.') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="bg-success-transparent border border-success-subtle p-2 rounded">
                                                                <span class="fs-11 text-uppercase text-success d-block">Company Counter</span>
                                                                <span class="fw-bold text-success">Rp {{ number_format($round->company_counter_offer, 0, ',', '.') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($round->summary_notes)
                                                    <p class="text-muted small mt-2 mb-0 italic">"{{ $round->summary_notes }}"</p>
                                                    @endif
                                                </div>
                                                @endforeach

                                                <!-- Final Result -->
                                                <div class="position-relative">
                                                    <div class="position-absolute translate-middle-x bg-success rounded-circle" style="width: 12px; height: 12px; left: -32.5px; top: 10px; border: 3px solid #fff;"></div>
                                                    <h6 class="mb-1 fw-bold text-success">Deal Sealed</h6>
                                                    <p class="text-muted small mb-2">{{ $negotiation->approved_at ? $negotiation->approved_at->format('d M Y, H:i') : '' }}</p>
                                                    <div class="alert alert-success d-inline-block py-2 px-3 mb-0">
                                                        Final Agreed Price: <strong>Rp {{ number_format($negotiation->final_agreed_value, 0, ',', '.') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Final Contracts Tab -->
                        @if($project->contracts->isNotEmpty())
                        <div class="tab-pane fade" id="contracts" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-file-certificate me-2 text-primary"></i>Active Contracts
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            @foreach($project->contracts as $contract)
                                            <div class="mb-5">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div>
                                                        <h6 class="text-muted text-uppercase fw-semibold mb-1 small">Contract Number</h6>
                                                        <h5 class="mb-0 text-primary">{{ $contract->contract_number }}</h5>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-5 mb-4 mb-lg-0">
                                                        <div class="card h-100 border shadow-none mb-0">
                                                            <div class="card-header bg-light-200 py-2">
                                                                <h6 class="mb-0 fs-14">Contract Summary</h6>
                                                            </div>
                                                            <div class="card-body py-3">
                                                                <div class="mb-3">
                                                                    <label class="text-muted d-block small mb-1">Status</label>
                                                                    <span class="badge bg-{{ $contract->status->color() }} fs-12">
                                                                        {{ $contract->status->label() }}
                                                                    </span>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-6">
                                                                        <label class="text-muted d-block small mb-1">Effective Date</label>
                                                                        <span class="fw-bold fs-13">{{ $contract->start_date ? $contract->start_date->format('d/m/Y') : '-' }}</span>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="text-muted d-block small mb-1">Expiration Date</label>
                                                                        <span class="fw-bold fs-13 text-{{ $contract->end_date && $contract->end_date->isPast() ? 'danger' : 'success' }}">
                                                                            {{ $contract->end_date ? $contract->end_date->format('d/m/Y') : '-' }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="text-muted d-block small mb-1">Days Remaining</label>
                                                                    @if($contract->end_date && $contract->end_date->isPast())
                                                                        <span class="text-danger fs-13">EXPIRED</span>
                                                                    @else
                                                                        <span class="fw-bold fs-13">{{ $contract->end_date ? now()->diffInDays($contract->end_date) : '-' }} days</span>
                                                                    @endif
                                                                </div>
                                                                <hr class="my-2">
                                                                <div class="mb-2">
                                                                    <label class="text-muted d-block small mb-1">Created By</label>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <div class="avatar avatar-xs rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 10px;">
                                                                                {{ $contract->creator ? strtoupper(substr($contract->creator->name, 0, 1)) : '?' }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2">
                                                                            <h6 class="mb-0 fs-13">{{ $contract->creator->name ?? 'Unknown' }}</h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if($contract->approved_by)
                                                                <div class="mb-0 mt-3">
                                                                    <label class="text-muted d-block small mb-1">Approved By</label>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0">
                                                                            <div class="avatar avatar-xs rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 10px;">
                                                                                {{ $contract->approver ? strtoupper(substr($contract->approver->name, 0, 1)) : '?' }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1 ms-2">
                                                                            <h6 class="mb-0 fs-13">{{ $contract->approver->name ?? 'Unknown' }}</h6>
                                                                            <span class="text-muted" style="font-size: 11px;">{{ $contract->approved_at ? $contract->approved_at->format('d M Y') : '' }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif

                                                                @if($contract->attachment_path)
                                                                <hr class="my-3">
                                                                <div class="d-grid gap-2">
                                                                    <a href="{{ Storage::url($contract->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center">
                                                                        <i class="ti ti-download me-2"></i>Download Contract
                                                                    </a>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-8 col-lg-7">
                                                        <div class="card h-100 border shadow-none mb-0">
                                                            <div class="card-header bg-light-200 py-2">
                                                                <h6 class="mb-0 fs-14">Contract Items</h6>
                                                            </div>
                                                            <div class="card-body p-0">
                                                                <div class="table-responsive">
                                                                    <table class="table table-hover border-top-0 table-sm mb-0">
                                                                        <thead class="bg-light-500">
                                                                            <tr>
                                                                                <th class="border-0">Item Description</th>
                                                                                <th class="text-center border-0">Qty</th>
                                                                                <th class="text-center border-0">Unit Price</th>
                                                                                <th class="text-end border-0">Total Price</th>
                                                                                <th class="text-center border-0">Duration</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="border-0">
                                                                            @php $totalagreed = 0; @endphp
                                                                            @foreach($contract->items as $item)
                                                                            @php 
                                                                                $itemTotal = $item->total_price ?? ($item->qty * $item->unit_price);
                                                                                $totalagreed += $itemTotal; 
                                                                            @endphp
                                                                            <tr>
                                                                                <td class="fw-medium text-dark">{{ $item->unit_name ?? $item->description ?? '-' }}</td>
                                                                                <td class="text-center">{{ $item->qty }}</td>
                                                                                <td class="text-center">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                                                <td class="text-end fw-bold text-primary">Rp {{ number_format($itemTotal, 0, ',', '.') }}</td>
                                                                                <td class="text-center">{{ $item->duration }} Month</td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <tfoot class="fw-bold bg-light">
                                                                            <tr>
                                                                                <td colspan="3" class="text-end py-2">Total Agreed Value:</td>
                                                                                <td class="text-end text-primary py-2">Rp {{ number_format($totalagreed, 0, ',', '.') }}</td>
                                                                                <td></td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!$loop->last)
                                                <hr class="border-light opacity-50 mb-4">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Units Tab -->
                        @if($project->unitRequests->isNotEmpty())
                        <div class="tab-pane fade" id="units" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-truck me-2 text-primary"></i>Deployed Units
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            @foreach($project->unitRequests as $unitRequest)
                                            <div class="mb-4">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div>
                                                        <h6 class="text-muted text-uppercase fw-semibold mb-1 small">Request Number</h6>
                                                        <h5 class="mb-0 text-primary">{{ $unitRequest->request_number }}</h5>
                                                    </div>
                                                    <a href="{{ route('unit-requests.show', $unitRequest->uid) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-external-link me-1"></i> View Request
                                                    </a>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover border-top-0 table-sm">
                                                        <thead class="bg-light-500">
                                                            <tr>
                                                                <th class="border-0">Unit Name</th>
                                                                <th class="text-center border-0">Qty</th>
                                                                <th class="text-center border-0">Duration (Days)</th>
                                                                <th class="text-center border-0">Unit Ready</th>
                                                                <th class="border-0">Operator Name</th>
                                                                <th class="border-0">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="border-0">
                                                            @foreach($unitRequest->items as $item)
                                                            <tr>
                                                                <td class="fw-medium text-dark">{{ $item->unit_name }}</td>
                                                                <td class="text-center">{{ $item->qty }}</td>
                                                                <td class="text-center">{{ $item->duration_days }}</td>
                                                                <td class="text-center">
                                                                    @if($item->unit_ready)
                                                                        <span class="badge bg-success-transparent text-success border border-success-subtle px-2 py-1">Ready</span>
                                                                    @else
                                                                        <span class="badge bg-warning-transparent text-warning border border-warning-subtle px-2 py-1">Not Ready</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $item->operator_name ?? '-' }}</td>
                                                                <td class="text-muted small">{{ $item->remarks ?? '-' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @if(!$loop->last)
                                                <hr class="border-light opacity-50 mb-4">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Manpower Tab -->
                        <div class="tab-pane fade" id="manpower" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-users me-2 text-primary"></i>Work Force
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            List Work Force in project
                                        </div>
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

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .dropzone {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            background: #ffffff;
            min-height: 250px;
            padding: 40px;
            transition: all 0.3s ease;
        }
        .dropzone:hover {
            border-color: #0087F7;
            background: #f8f9fa;
        }
        .dropzone .dz-message {
            margin: 0;
        }
        .dropzone .dz-message h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
        }
        .dropzone .dz-message p {
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        /* Image gallery hover effect */
        .card img {
            transition: transform 0.3s ease;
        }
        .card a:hover img {
            transform: scale(1.05);
        }

        /* Modern Tabs Style */
        .nav-tabs-modern {
            display: inline-flex;
            background-color: #f4f7fb;
            padding: 6px;
            border-radius: 12px;
            border: none;
            gap: 4px;
        }

        .nav-tabs-modern .nav-item {
            margin-bottom: 0;
            border: none;
        }

        .nav-tabs-modern .nav-link {
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            color: #64748b;
            font-weight: 500;
            font-size: 14px;
            background: transparent;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .nav-tabs-modern .nav-link i {
            font-size: 18px;
            transition: transform 0.2s ease;
        }

        .nav-tabs-modern .nav-link:hover {
            color: #1e293b;
            background-color: rgba(0, 0, 0, 0.03);
        }

        .nav-tabs-modern .nav-link:hover i {
            transform: translateY(-1px);
        }

        .nav-tabs-modern .nav-link.active {
            background-color: #ffffff;
            color: #ff3b3b; /* Using theme red or primary */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: none !important;
        }

        .nav-tabs-modern .nav-link.active i {
            color: #ff3b3b;
        }

        /* Adjusting for theme primary if available */
        :root {
            --primary-color: #ff3b3b;
        }

        .nav-tabs-modern .nav-link.active {
            color: var(--primary-color);
        }
        .nav-tabs-modern .nav-link.active i {
            color: var(--primary-color);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            // Fancybox initialization
            Fancybox.bind("[data-fancybox='gallery']", {
                Images: {
                    type: "image",
                },
                Toolbar: {
                    display: {
                        left: ["infobar"],
                        middle: [],
                        right: ["slideshow", "thumbs", "close"],
                    },
                },
            });

            // Initialize Dropzone
            var myDropzone = new Dropzone("#projectImageDropzone", {
                paramName: "file",
                maxFilesize: 5, // MB
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "Drop images here or click to upload",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(file, response) {
                    if (response.success) {
                        $('#noImagesMessage').remove();
                        var imageHtml = `
                            <div class="col-md-4 col-lg-3 mb-3" id="image-${response.image.uid}">
                                <div class="card h-100 shadow-sm border-0">
                                    <a href="${response.url}" 
                                       data-fancybox="gallery" 
                                       data-type="image"
                                       data-caption="${response.image.file_image}">
                                        <img src="${response.url}" 
                                             class="card-img-top rounded" 
                                             alt="${response.image.file_image}"
                                             style="height: 200px; object-fit: cover; cursor: pointer;">
                                    </a>
                                    <div class="card-body p-2">
                                        <p class="card-text small text-truncate mb-2" title="${response.image.file_image}">
                                            ${response.image.file_image}
                                        </p>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-image-btn w-100" 
                                                data-id="${response.image.uid}">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#imageGallery').append(imageHtml);
                        myDropzone.removeFile(file);
                    }
                },
                error: function(file, response) {
                    alert('Error uploading image: ' + (response.message || 'Unknown error'));
                    myDropzone.removeFile(file);
                }
            });

            // Delete image
            $('body').on('click', '.delete-image-btn', function() {
                var imageId = $(this).data('id');
                
                if (typeof Swal === 'undefined') {
                    if (confirm('Are you sure you want to delete this image?')) {
                        performDelete(imageId);
                    }
                    return;
                }

                Swal.fire({
                    title: "Delete this image?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    customClass: {
                        confirmButton: "btn btn-primary me-2",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        performDelete(imageId);
                    }
                });
            });

            function performDelete(imageId) {
                $.ajax({
                    url: '/project-images/' + imageId,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#image-' + imageId).fadeOut(300, function() {
                            $(this).remove();
                            if ($('#imageGallery .col-md-4').length === 0 && $('#imageGallery .col-lg-3').length === 0) {
                                $('#imageGallery').html(`
                                    <div class="col-12 text-center py-5" id="noImagesMessage">
                                        <i class="ti ti-photo" style="font-size: 64px; color: #ccc;"></i>
                                        <p class="text-muted mt-3">No images uploaded yet</p>
                                    </div>
                                `);
                            }
                        });
                        
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.success,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Failed to delete image.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var res = JSON.parse(xhr.responseText);
                                if (res.message) errorMessage = res.message;
                            } catch(e) {}
                        }
                        
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        } else {
                            alert(errorMessage);
                        }
                    }
                });
            }
        });
    </script>
    @endpush

@endsection
