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

                            @if($project->project_status === 'COMPLETED')
                                <button type="button" class="btn btn-danger initiate-amendment-btn" data-uid="{{ $project->uid }}">
                                    <i class="ti ti-edit me-1"></i> Amandemen Project
                                </button>
                            @endif

                            @if($project->project_status === 'AMENDMENT')
                                <button type="button" class="btn btn-success finalize-amendment-btn" data-id="{{ $project->amendments->where('status', 'IN_PROGRESS')->first()->id ?? '' }}">
                                    <i class="ti ti-check me-1"></i> Selesaikan Amandemen
                                </button>
                                <a href="javascript:void(0);" class="btn btn-warning edit-project-btn" data-id="{{ $project->uid }}">
                                    <i class="ti ti-edit me-1"></i> Edit Project
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
                                <i class="ti ti-truck-delivery me-1"></i> Unit Request
                                <span class="badge bg-primary-subtle text-primary ms-1">{{ $project->unitRequests->count() }}</span>
                            </button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manpower-tab" data-bs-toggle="tab" data-bs-target="#manpower" type="button" role="tab">
                                <i class="ti ti-users me-1"></i> Work Force
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="amendment-history-tab" data-bs-toggle="tab" data-bs-target="#amendment-history" type="button" role="tab">
                                <i class="ti ti-history me-1"></i> History Amandemen
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="projectTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            @php
                                $statusConfig = [
                                    'NOT STARTED' => ['color' => 'purple',    'icon' => 'ti-bookmark',      'text' => 'Plan'],
                                    'ON PROGRESS' => ['color' => 'info',      'icon' => 'ti-progress',      'text' => 'Survey'],
                                    'COMPLETED'   => ['color' => 'success',   'icon' => 'ti-circle-check',  'text' => 'Completed'],
                                    'AMENDMENT'   => ['color' => 'danger',    'icon' => 'ti-edit-circle',   'text' => 'Amendment'],
                                    'ON HOLD'     => ['color' => 'warning',   'icon' => 'ti-player-pause',  'text' => 'On Hold'],
                                    'CANCELLED'   => ['color' => 'danger',    'icon' => 'ti-ban',           'text' => 'Cancelled'],
                                ];
                                $config = $statusConfig[$project->project_status] ?? ['color' => 'secondary', 'icon' => 'ti-help', 'text' => $project->project_status];
                            @endphp

                            {{-- Hero summary card --}}
                            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                                <div class="card-body p-4 position-relative" style="background: linear-gradient(135deg, rgba(13,110,253,0.08) 0%, rgba(102,16,242,0.05) 100%);">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-lg-7">
                                            <div class="d-flex align-items-center mb-2 flex-wrap gap-2">
                                                <span class="badge bg-{{ $config['color'] }}-subtle text-{{ $config['color'] }} border border-{{ $config['color'] }}-subtle px-3 py-2">
                                                    <i class="ti {{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                                                </span>
                                                <span class="badge bg-white text-dark border px-3 py-2">
                                                    <i class="ti ti-hash text-muted me-1"></i>{{ $project->project_number }}
                                                </span>
                                                @if($project->project_code)
                                                <span class="badge bg-white text-dark border px-3 py-2">
                                                    <i class="ti ti-code text-muted me-1"></i>{{ $project->project_code }}
                                                </span>
                                                @endif
                                            </div>
                                            <h4 class="fw-bold mb-1">{{ $project->project_name ?? 'Project' }}</h4>
                                            <div class="text-muted small mb-2">
                                                <i class="ti ti-folder me-1"></i>{{ $project->category->name ?? '-' }}
                                                @if($project->subCategory)
                                                    <span class="mx-1">/</span>{{ $project->subCategory->name }}
                                                @endif
                                            </div>
                                            <p class="text-muted mb-0">{{ $project->description ?? 'Tidak ada deskripsi.' }}</p>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="bg-white rounded-3 p-3 shadow-sm border">
                                                <div class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing:.5px;">
                                                    <i class="ti ti-coin text-success me-1"></i>Project Value
                                                </div>
                                                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($project->project_value, 0, ',', '.') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Info grid --}}
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-3">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-hash text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Project Number</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->project_number }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-code text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Project Code</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->project_code ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-folder text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Category</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->category->name ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-folders text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Sub Category</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->subCategory->name ?? '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Project Details Tab -->
                        <div class="tab-pane fade" id="details" role="tabpanel">
                            @php
                                $startDate = $project->start_date;
                                $endDate = $project->end_date;
                                $today = \Carbon\Carbon::now();
                                $totalDays = ($startDate && $endDate) ? $startDate->diffInDays($endDate) : 0;
                                $elapsed = ($startDate && $today->gte($startDate)) ? $startDate->diffInDays($today->lte($endDate ?? $today) ? $today : $endDate) : 0;
                                $progressPct = $totalDays > 0 ? min(100, round(($elapsed / $totalDays) * 100)) : 0;
                            @endphp

                            {{-- Timeline header --}}
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3">
                                            <div class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing:.4px;">
                                                <i class="ti ti-calendar-plus text-primary me-1"></i>Request Date
                                            </div>
                                            <div class="fw-semibold">{{ $project->request_date ? $project->request_date->format('d M Y') : '—' }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing:.4px;">
                                                <i class="ti ti-calendar-event text-success me-1"></i>Start Date
                                            </div>
                                            <div class="fw-semibold">{{ $startDate ? $startDate->format('d M Y') : '—' }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing:.4px;">
                                                <i class="ti ti-calendar-x text-danger me-1"></i>End Date
                                            </div>
                                            <div class="fw-semibold">{{ $endDate ? $endDate->format('d M Y') : '—' }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing:.4px;">
                                                <i class="ti ti-clock text-info me-1"></i>Duration
                                            </div>
                                            <div class="fw-semibold">{{ $project->duration_of_work ?? 0 }} Hari</div>
                                        </div>
                                    </div>
                                    @if($startDate && $endDate)
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span class="text-muted">Progress timeline</span>
                                            <span class="fw-semibold text-primary">{{ $progressPct }}%</span>
                                        </div>
                                        <div class="progress" style="height:8px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progressPct }}%"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Detail grid --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-map-pin text-danger me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Project Location</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->project_location ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-current-location text-warning me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Coordinates</span>
                                        </div>
                                        <div class="fw-semibold font-monospace small">{{ $project->project_coordinates ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-briefcase text-info me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Job Type</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->job_type ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-user-cog text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">PIC</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->pic->name ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-bulldozer text-success me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Equipment Rental Rate</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->equipmentRentalRate->jenis_alat ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-building-bank text-secondary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Bank Account</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->bank_account ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded-3 p-3 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-list-details text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Scope of Work</span>
                                        </div>
                                        <div>{{ $project->scope_of_work ?? '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client Information Tab -->
                        <div class="tab-pane fade" id="client" role="tabpanel">
                            @php
                                $clientName = $project->user_name ?? '—';
                                $clientInitials = collect(explode(' ', trim($clientName)))->filter()->take(2)
                                    ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
                            @endphp

                            {{-- Client header --}}
                            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                                <div class="card-body p-4" style="background: linear-gradient(135deg, rgba(25,135,84,0.08) 0%, rgba(13,202,240,0.05) 100%);">
                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white fw-bold shadow-sm"
                                             style="width:64px;height:64px;font-size:22px;">
                                            {{ $clientInitials ?: '?' }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="fw-bold mb-1">{{ $clientName }}</h4>
                                            <div class="d-flex flex-wrap gap-2">
                                                @if($project->user_code)
                                                <span class="badge bg-white text-dark border px-3 py-2">
                                                    <i class="ti ti-id text-muted me-1"></i>{{ $project->user_code }}
                                                </span>
                                                @endif
                                                @if($project->taxpayer_id)
                                                <span class="badge bg-white text-dark border px-3 py-2">
                                                    <i class="ti ti-receipt-tax text-muted me-1"></i>NPWP: {{ $project->taxpayer_id }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Contact grid --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-user text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">User Name</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->user_name ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-id text-primary me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">User Code</span>
                                        </div>
                                        <div class="fw-semibold">{{ $project->user_code ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-mail text-info me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Email</span>
                                        </div>
                                        @if($project->email)
                                            <a href="mailto:{{ $project->email }}" class="fw-semibold text-decoration-none">{{ $project->email }}</a>
                                        @else
                                            <div class="fw-semibold">—</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-phone text-success me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Phone Number</span>
                                        </div>
                                        @if($project->phone_number)
                                            <a href="tel:{{ $project->phone_number }}" class="fw-semibold text-decoration-none">{{ $project->phone_number }}</a>
                                        @else
                                            <div class="fw-semibold">—</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-receipt-tax text-warning me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Taxpayer ID</span>
                                        </div>
                                        <div class="fw-semibold font-monospace">{{ $project->taxpayer_id ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded-3 p-3 bg-light-subtle">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="ti ti-map-pin text-danger me-2"></i>
                                            <span class="text-muted small text-uppercase fw-semibold" style="letter-spacing:.4px;">Address</span>
                                        </div>
                                        <div>{{ $project->user_address ?? '—' }}</div>
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
                        @if($project->unitRequests->isNotEmpty() || $unitFormations->isNotEmpty())
                        <div class="tab-pane fade" id="units" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{-- SK Penetapan Unit (Unit Formation) yang aktif --}}
                                    @if($unitFormations->isNotEmpty())
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-clipboard-check me-2 text-primary"></i>SK Penetapan Unit Aktif
                                                @php $totalUnits = $unitFormations->sum(fn($f) => $f->items->count()); @endphp
                                                <span class="badge bg-success-subtle text-success ms-2">{{ $totalUnits }} unit</span>
                                            </h5>
                                            <a href="{{ route('unit-formations.create') }}?project_id={{ $project->id }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-plus me-1"></i> Buat SK Baru
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            @foreach($unitFormations as $formation)
                                                <div class="border rounded mb-3">
                                                    <div class="d-flex align-items-center justify-content-between p-3 bg-light border-bottom flex-wrap gap-2">
                                                        <div>
                                                            <a href="{{ route('unit-formations.show', $formation->uid) }}" class="fw-semibold link-primary">
                                                                <i class="ti ti-file-text me-1"></i> {{ $formation->formation_number }}
                                                            </a>
                                                            <span class="badge bg-{{ $formation->status->color() }}-subtle text-{{ $formation->status->color() }} ms-2">
                                                                {{ $formation->status->label() }}
                                                            </span>
                                                            <div class="small text-muted mt-1">
                                                                <i class="ti ti-calendar me-1"></i>
                                                                Berlaku {{ $formation->effective_date?->format('d M Y') }}
                                                                @if($formation->end_date)
                                                                    s/d {{ $formation->end_date->format('d M Y') }}
                                                                @else
                                                                    s/d {{ $formation->contract->end_date?->format('d M Y') ?? '-' }} <span class="text-muted">(ikut kontrak)</span>
                                                                @endif
                                                                @if($formation->contract)
                                                                    &middot; Kontrak: <span class="text-dark">{{ $formation->contract->contract_number }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="text-muted small text-end">
                                                            <div><i class="ti ti-user me-1"></i>Dibuat oleh: {{ $formation->creator->name ?? '-' }}</div>
                                                            <div>{{ $formation->items->count() }} unit aktif</div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm align-middle mb-0">
                                                            <thead class="text-muted small text-uppercase bg-white">
                                                                <tr>
                                                                    <th style="width:40px">#</th>
                                                                    <th>Unit</th>
                                                                    <th>Operator</th>
                                                                    <th class="text-end">HM Awal</th>
                                                                    <th class="text-end">Target/Bulan</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($formation->items as $idx => $item)
                                                                    <tr>
                                                                        <td class="text-muted">{{ $idx + 1 }}</td>
                                                                        <td>
                                                                            <div class="fw-medium">{{ $item->unit_name }}</div>
                                                                            @if($item->equipment_code)
                                                                                <div class="small text-muted">{{ $item->equipment_code }}</div>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $item->operator_name ?? '—' }}</td>
                                                                        <td class="text-end">{{ number_format($item->hm_start, 0, ',', '.') }} HM</td>
                                                                        <td class="text-end">
                                                                            @if($item->hm_target_monthly)
                                                                                {{ number_format($item->hm_target_monthly, 0, ',', '.') }} HM
                                                                            @else
                                                                                —
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $sBadge = match($item->status) {
                                                                                    'ACTIVE' => 'success', 'DOWN' => 'danger',
                                                                                    'READY' => 'secondary', default => 'light',
                                                                                };
                                                                            @endphp
                                                                            <span class="badge bg-{{ $sBadge }}-subtle text-{{ $sBadge }}">{{ $item->status }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada unit aktif.</td></tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Deployed Units (Unit Request — APPROVED_FROM_WORKSHOP) --}}
                                    @if($project->unitRequests->isNotEmpty())
                                    @php
                                        $totalReq = $project->unitRequests->count();
                                        $totalUnitsDeployed = $project->unitRequests->sum(fn($ur) => $ur->items->sum('qty'));
                                        $totalReady = $project->unitRequests->sum(fn($ur) => $ur->items->where('unit_ready', true)->sum('qty'));
                                        $totalAssigned = $project->unitRequests->flatMap->items->whereNotNull('operator_id')->count();
                                    @endphp
                                    <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                                        <div class="card-header bg-gradient bg-primary-subtle border-0 py-3">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md bg-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width:48px;height:48px;">
                                                        <i class="ti ti-truck-delivery fs-3 text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title mb-0 fw-bold">Unit Request — Deployed</h5>
                                                        <small class="text-muted">Unit yang telah disetujui Workshop dan digunakan di project ini</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge rounded-pill bg-white text-dark border px-3 py-2">
                                                        <i class="ti ti-file-text text-primary me-1"></i> {{ $totalReq }} Request
                                                    </span>
                                                    <span class="badge rounded-pill bg-white text-dark border px-3 py-2">
                                                        <i class="ti ti-package text-info me-1"></i> {{ (int) $totalUnitsDeployed }} Unit
                                                    </span>
                                                    <span class="badge rounded-pill bg-white text-dark border px-3 py-2">
                                                        <i class="ti ti-circle-check text-success me-1"></i> {{ (int) $totalReady }} Ready
                                                    </span>
                                                    <span class="badge rounded-pill bg-white text-dark border px-3 py-2">
                                                        <i class="ti ti-user-check text-warning me-1"></i> {{ $totalAssigned }} Operator
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3 p-md-4">
                                            @foreach($project->unitRequests as $unitRequest)
                                            @php
                                                $reqReady = $unitRequest->items->where('unit_ready', true)->sum('qty');
                                                $reqTotal = $unitRequest->items->sum('qty');
                                                $readyPct = $reqTotal > 0 ? round(($reqReady / $reqTotal) * 100) : 0;
                                            @endphp
                                            <div class="border rounded-3 mb-3 overflow-hidden bg-white">
                                                {{-- Header Request --}}
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 p-3 border-bottom bg-light-subtle">
                                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                                        <div>
                                                            <div class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing:.5px;">Request Number</div>
                                                            <a href="{{ route('unit-requests.show', $unitRequest->uid) }}" class="text-decoration-none">
                                                                <h5 class="mb-0 text-primary fw-bold">
                                                                    <i class="ti ti-file-invoice me-1"></i>{{ $unitRequest->request_number }}
                                                                </h5>
                                                            </a>
                                                        </div>
                                                        <div class="vr d-none d-md-block"></div>
                                                        <div class="small">
                                                            <div class="text-muted">
                                                                <i class="ti ti-calendar me-1"></i>{{ optional($unitRequest->request_date)->format('d M Y') ?? optional($unitRequest->created_at)->format('d M Y') }}
                                                            </div>
                                                            @if($unitRequest->creator)
                                                            <div class="text-muted">
                                                                <i class="ti ti-user me-1"></i>{{ $unitRequest->creator->name }}
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="vr d-none d-md-block"></div>
                                                        <div>
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                                                <i class="ti ti-shield-check me-1"></i>Disetujui Workshop
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="text-end d-none d-md-block">
                                                            <div class="small text-muted">Kesiapan Unit</div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="progress" style="width:100px;height:6px;">
                                                                    <div class="progress-bar bg-success" style="width: {{ $readyPct }}%"></div>
                                                                </div>
                                                                <span class="small fw-semibold">{{ $readyPct }}%</span>
                                                            </div>
                                                        </div>
                                                        <a href="{{ route('unit-requests.show', $unitRequest->uid) }}" class="btn btn-sm btn-primary">
                                                            <i class="ti ti-external-link me-1"></i> Detail
                                                        </a>
                                                    </div>
                                                </div>

                                                {{-- Items table --}}
                                                <div class="table-responsive">
                                                    <table class="table align-middle mb-0">
                                                        <thead class="text-muted small text-uppercase" style="letter-spacing:.4px;">
                                                            <tr class="bg-light-subtle">
                                                                <th class="ps-3" style="width:40px;">#</th>
                                                                <th>Unit</th>
                                                                <th class="text-center" style="width:90px;">Qty</th>
                                                                <th class="text-center" style="width:120px;">Durasi</th>
                                                                <th class="text-center" style="width:110px;">Status</th>
                                                                <th>Operator</th>
                                                                <th class="pe-3">Catatan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($unitRequest->items as $idx => $item)
                                                            @php
                                                                $opProfile = $deployedOperators[$item->operator_id] ?? null;
                                                                $opName = $item->operator_name ?: ($opProfile['name'] ?? null);
                                                                $opPos = $opProfile['position'] ?? null;
                                                                $initials = $opName
                                                                    ? collect(explode(' ', trim($opName)))->filter()->take(2)
                                                                        ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('')
                                                                    : '';
                                                                $photoUrl = $item->operator_id ? route('employees.photo', ['id' => $item->operator_id]) : null;
                                                            @endphp
                                                            <tr>
                                                                <td class="ps-3 text-muted">{{ $idx + 1 }}</td>
                                                                <td>
                                                                    <div class="fw-semibold text-dark">{{ $item->unit_name }}</div>
                                                                    @if($item->equipment_code)
                                                                        <div class="small text-muted"><i class="ti ti-barcode me-1"></i>{{ $item->equipment_code }}</div>
                                                                    @endif
                                                                    @if($item->replaced_at)
                                                                        <div class="mt-1">
                                                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                                                <i class="ti ti-replace me-1"></i>Replaced
                                                                                @if($item->replacedByItem && $item->replacedByItem->unitReplacement)
                                                                                    by
                                                                                    <a href="{{ route('unit-replacements.show', $item->replacedByItem->unitReplacement->uid) }}" class="text-warning text-decoration-underline">
                                                                                        {{ $item->replacedByItem->unitReplacement->replacement_number }}
                                                                                    </a>
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="fw-semibold">{{ (int) $item->qty }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if($item->duration_days)
                                                                        <span class="text-muted small">{{ $item->duration_days }} Hari</span>
                                                                    @else
                                                                        <span class="text-muted">—</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    @if($item->unit_ready)
                                                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                                            <i class="ti ti-circle-check me-1"></i>Ready
                                                                        </span>
                                                                    @else
                                                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                                            <i class="ti ti-clock me-1"></i>Belum Ready
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($opName || $item->operator_id)
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <div class="position-relative" style="width:34px;height:34px;flex-shrink:0;">
                                                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-semibold position-absolute top-0 start-0"
                                                                                      style="width:34px;height:34px;font-size:12px;">
                                                                                    {{ $initials ?: '?' }}
                                                                                </span>
                                                                                @if($photoUrl)
                                                                                <img src="{{ $photoUrl }}" alt="{{ $opName }}"
                                                                                     class="rounded-circle position-absolute top-0 start-0"
                                                                                     style="width:34px;height:34px;object-fit:cover;background:#fff;"
                                                                                     onerror="this.style.display='none'">
                                                                                @endif
                                                                            </div>
                                                                            <div class="lh-sm">
                                                                                <div class="fw-medium small">{{ $opName ?? 'ID: ' . $item->operator_id }}</div>
                                                                                @if($opPos)
                                                                                    <small class="text-muted">{{ $opPos }}</small>
                                                                                @elseif($opName && $item->operator_id)
                                                                                    <small class="text-muted">ID: {{ $item->operator_id }}</small>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <span class="text-muted fst-italic small">Belum ditugaskan</span>
                                                                    @endif
                                                                </td>
                                                                <td class="pe-3 text-muted small">{{ $item->remarks ?? '—' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif {{-- end @if($project->unitRequests->isNotEmpty()) inner --}}

                                    {{-- Penggantian Unit (PTU) --}}
                                    @if($project->unitReplacements->isNotEmpty())
                                    <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                                        <div class="card-header bg-gradient bg-warning-subtle border-0 py-3">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md bg-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width:48px;height:48px;">
                                                        <i class="ti ti-replace fs-3 text-warning"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title mb-0 fw-bold">Penggantian Unit (PTU)</h5>
                                                        <small class="text-muted">Riwayat permintaan penggantian unit untuk project ini</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge rounded-pill bg-white text-dark border px-3 py-2">
                                                        <i class="ti ti-file-text text-warning me-1"></i> {{ $project->unitReplacements->count() }} PTU
                                                    </span>
                                                    <a href="{{ route('unit-replacements.create') }}?project_id={{ $project->id }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="ti ti-plus me-1"></i> Buat PTU
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3 p-md-4">
                                            <div class="table-responsive">
                                                <table class="table align-middle mb-0">
                                                    <thead class="text-muted small text-uppercase" style="letter-spacing:.4px;">
                                                        <tr class="bg-light-subtle">
                                                            <th class="ps-3">No. PTU</th>
                                                            <th>UR Asal</th>
                                                            <th>Tgl. Penggantian</th>
                                                            <th>Items</th>
                                                            <th>Status</th>
                                                            <th>Dibuat Oleh</th>
                                                            <th class="pe-3 text-end">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($project->unitReplacements as $ptu)
                                                        <tr>
                                                            <td class="ps-3 fw-semibold">{{ $ptu->replacement_number }}</td>
                                                            <td>
                                                                @if($ptu->unitRequest)
                                                                    <a href="{{ route('unit-requests.show', $ptu->unitRequest->uid) }}" class="text-decoration-none">
                                                                        {{ $ptu->unitRequest->request_number }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $ptu->replacement_date?->format('d M Y') ?? '—' }}</td>
                                                            <td><span class="badge bg-light text-dark">{{ $ptu->items->count() }} unit</span></td>
                                                            <td>
                                                                <span class="badge bg-{{ $ptu->status->color() }}-subtle text-{{ $ptu->status->color() }}">
                                                                    {{ $ptu->status->label() }}
                                                                </span>
                                                            </td>
                                                            <td class="small">{{ $ptu->creator->name ?? '—' }}</td>
                                                            <td class="pe-3 text-end">
                                                                <a href="{{ route('unit-replacements.show', $ptu->uid) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="ti ti-external-link"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Manpower Tab -->
                        <div class="tab-pane fade" id="manpower" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-users me-2 text-primary"></i>Work Force
                                                @php
                                                    $totalActiveMembers = $workforceFormations->sum(fn($f) => $f->members->count());
                                                @endphp
                                                <span class="badge bg-success-subtle text-success ms-2">{{ $totalActiveMembers }} aktif</span>
                                            </h5>
                                            <a href="{{ route('workforce-formations.create') }}?project_id={{ $project->id }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-plus me-1"></i> Buat SK Baru
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            @forelse($workforceFormations as $formation)
                                                <div class="border rounded mb-3">
                                                    <div class="d-flex align-items-center justify-content-between p-3 bg-light border-bottom flex-wrap gap-2">
                                                        <div>
                                                            <a href="{{ route('workforce-formations.show', $formation->uid) }}" class="fw-semibold link-primary">
                                                                <i class="ti ti-file-text me-1"></i> {{ $formation->formation_number }}
                                                            </a>
                                                            <span class="badge bg-{{ $formation->status->color() }}-subtle text-{{ $formation->status->color() }} ms-2">
                                                                {{ $formation->status->label() }}
                                                            </span>
                                                            <div class="small text-muted mt-1">
                                                                <i class="ti ti-calendar me-1"></i>
                                                                Berlaku {{ $formation->effective_date?->format('d M Y') }}
                                                                @if($formation->end_date)
                                                                    s/d {{ $formation->end_date->format('d M Y') }}
                                                                @else
                                                                    s/d {{ $formation->contract->end_date?->format('d M Y') ?? '-' }} <span class="text-muted">(ikut kontrak)</span>
                                                                @endif
                                                                @if($formation->contract)
                                                                    &middot; Kontrak: <span class="text-dark">{{ $formation->contract->contract_number }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="text-muted small text-end">
                                                            <div><i class="ti ti-user me-1"></i>Dibuat oleh: {{ $formation->creator->name ?? '-' }}</div>
                                                            <div>{{ $formation->members->count() }} anggota aktif</div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm align-middle mb-0">
                                                            <thead class="text-muted small text-uppercase bg-white">
                                                                <tr>
                                                                    <th style="width:40px">#</th>
                                                                    <th>Karyawan</th>
                                                                    <th>Posisi</th>
                                                                    <th>Shift</th>
                                                                    <th class="text-end">Upah Harian</th>
                                                                    <th class="text-end">Tunjangan</th>
                                                                    <th>Masa Tugas</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($formation->members as $idx => $m)
                                                                    @php
                                                                        $empProfile = $workforceMembers[$m->employee_id] ?? null;
                                                                        $empName = $m->employee_name ?: ($empProfile['name'] ?? '—');
                                                                        $initials = collect(explode(' ', trim($empName)))->filter()->take(2)
                                                                            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
                                                                        $photoUrl = $m->employee_id ? route('employees.photo', ['id' => $m->employee_id]) : null;
                                                                    @endphp
                                                                    <tr>
                                                                        <td class="text-muted">{{ $idx + 1 }}</td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                <div class="position-relative" style="width:34px;height:34px;flex-shrink:0;">
                                                                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-semibold position-absolute top-0 start-0"
                                                                                          style="width:34px;height:34px;font-size:12px;">
                                                                                        {{ $initials ?: '?' }}
                                                                                    </span>
                                                                                    @if($photoUrl)
                                                                                    <img src="{{ $photoUrl }}" alt="{{ $empName }}"
                                                                                         class="rounded-circle position-absolute top-0 start-0"
                                                                                         style="width:34px;height:34px;object-fit:cover;background:#fff;"
                                                                                         onerror="this.style.display='none'">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="lh-sm">
                                                                                    <div class="fw-medium">{{ $empName }}</div>
                                                                                    <div class="small text-muted">ID: {{ $m->employee_id }}</div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>{{ $m->position_name }}</td>
                                                                        <td>
                                                                            <span class="badge bg-light text-dark">{{ $m->shift }}</span>
                                                                        </td>
                                                                        <td class="text-end">Rp {{ number_format($m->daily_rate, 0, ',', '.') }}</td>
                                                                        <td class="text-end">Rp {{ number_format($m->allowance, 0, ',', '.') }}</td>
                                                                        <td class="small">
                                                                            {{ $m->start_date?->format('d M Y') ?? '-' }}
                                                                            @if($m->end_date)
                                                                                <br>s/d {{ $m->end_date->format('d M Y') }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="7" class="text-center text-muted py-3">Tidak ada anggota aktif di SK ini.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-5">
                                                    <div class="avatar-lg mx-auto mb-3">
                                                        <div class="avatar-title bg-light rounded-circle text-muted fs-1">
                                                            <i class="ti ti-users-group"></i>
                                                        </div>
                                                    </div>
                                                    <h6 class="mb-1">Belum Ada Tim Aktif</h6>
                                                    <p class="text-muted small mb-3">
                                                        Proyek ini belum memiliki SK Penugasan Tim aktif. SK harus berstatus
                                                        <span class="badge bg-success-subtle text-success">Aktif</span>
                                                        agar muncul di sini.
                                                    </p>
                                                    <a href="{{ route('workforce-formations.create') }}?project_id={{ $project->id }}" class="btn btn-sm btn-primary">
                                                        <i class="ti ti-plus me-1"></i> Buat SK Penugasan Tim
                                                    </a>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Amendment History Tab -->
                        <div class="tab-pane fade" id="amendment-history" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-transparent border-bottom">
                                            <h5 class="card-title mb-0 d-flex align-items-center">
                                                <i class="ti ti-history me-2 text-primary"></i>History Amandemen
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            @forelse($project->amendments()->orderBy('created_at', 'desc')->get() as $amendment)
                                                <div class="mb-4 p-3 border rounded">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h6 class="mb-0 fw-bold">{{ $amendment->amendment_number }}</h6>
                                                        <span class="badge bg-{{ $amendment->status === 'FINALIZED' ? 'success' : 'info' }}">
                                                            {{ $amendment->status }}
                                                        </span>
                                                    </div>
                                                    <p class="mb-1 text-muted small">Alasan: {{ $amendment->reason }}</p>
                                                    <p class="mb-2 text-muted small">Tanggal: {{ $amendment->created_at->format('d M Y, H:i') }} | Pemohon: {{ $amendment->requester->name ?? '-' }}</p>

                                                    @if($amendment->histories->isNotEmpty())
                                                        <div class="mt-3">
                                                            <button class="btn btn-sm btn-outline-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#history-{{ $amendment->id }}">
                                                                <i class="ti ti-eye me-1"></i> Lihat Detail Perubahan
                                                            </button>
                                                            <div class="collapse" id="history-{{ $amendment->id }}">
                                                                <div class="table-responsive">
                                                                    <table class="table table-sm table-bordered">
                                                                        <thead>
                                                                            <tr class="bg-light">
                                                                                <th>Model</th>
                                                                                <th>Kolom</th>
                                                                                <th>Nilai Lama</th>
                                                                                <th>Nilai Baru</th>
                                                                                <th>Waktu</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($amendment->histories as $history)
                                                                                @foreach($history->new_values as $key => $newValue)
                                                                                    <tr>
                                                                                        <td>{{ $history->model_type }}</td>
                                                                                        <td>{{ str_replace('_', ' ', ucfirst($key)) }}</td>
                                                                                        <td class="text-danger">{{ $history->old_values[$key] ?? '-' }}</td>
                                                                                        <td class="text-success">{{ $newValue }}</td>
                                                                                        <td>{{ $history->created_at->format('d M Y, H:i') }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @empty
                                                <div class="text-center py-4 text-muted">
                                                    Belum ada riwayat amandemen.
                                                </div>
                                            @endforelse
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
    <!-- Amendment Reason Modal -->
    <div class="modal fade" id="amendmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inisiasi Amandemen Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="amendmentForm">
                        @csrf
                        <input type="hidden" name="project_uid" id="amendment_project_uid">
                        <div class="mb-3">
                            <label class="form-label">Alasan Amandemen</label>
                            <textarea class="form-control" name="reason" rows="4" required placeholder="Jelaskan alasan dilakukannya amandemen..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmAmendmentBtn">Mulai Amandemen</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /Page Wrapper -->

    @include('projects.partials.edit_project_offcanvas')

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

            // Amendment Actions
            $('.initiate-amendment-btn').on('click', function() {
                $('#amendment_project_uid').val($(this).data('uid'));
                $('#amendmentModal').modal('show');
            });

            $('#confirmAmendmentBtn').on('click', function() {
                var formData = $('#amendmentForm').serialize();
                $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

                $.ajax({
                    url: '{{ route("project-amendments.store") }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        $('#confirmAmendmentBtn').prop('disabled', false).text('Mulai Amandemen');
                        var msg = xhr.responseJSON ? xhr.responseJSON.error : 'Terjadi kesalahan.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg
                        });
                    }
                });
            });

            $('.finalize-amendment-btn').on('click', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Selesaikan Amandemen?',
                    text: "Project akan dikunci kembali setelah amandemen diselesaikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Selesaikan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-success me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/project-amendments/' + id + '/finalize',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.success,
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                var msg = xhr.responseJSON ? xhr.responseJSON.error : 'Terjadi kesalahan.';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: msg
                                });
                            }
                        });
                    }
                });
            });

            // Edit Project Logic for Show Page
            var categories = @json($categories);

            function toggleSubcategory(categoryId, subcategorySelector) {
                var category = categories.find(c => c.id == categoryId);
                if (category && category.code && category.code.toUpperCase() === 'P') {
                    $(subcategorySelector).closest('.col-md-6').hide();
                    $(subcategorySelector).val('').trigger('change');
                } else {
                    $(subcategorySelector).closest('.col-md-6').show();
                }
            }

            function formatRupiah(angka) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }

            $('body').on('input', '.rupiah-input', function(e) {
                $(this).val(formatRupiah($(this).val()));
            });

            $('#edit_project_categories_id').on('change', function() {
                toggleSubcategory($(this).val(), '#edit_project_sub_categories_id');
            });

            $('body').on('click', '.edit-project-btn', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/projects/' + id + '/data',
                    method: 'GET',
                    success: function(data) {
                        $('#edit_request_date').val(data.request_date ? data.request_date.split('T')[0] : '');
                        $('#edit_project_categories_id').val(data.project_categories_id).trigger('change');
                        $('#edit_project_sub_categories_id').val(data.project_sub_categories_id).trigger('change');
                        $('#edit_project_name').val(data.project_name);
                        $('#edit_user_name').val(data.user_name);
                        $('#edit_user_code').val(data.user_code);
                        $('#edit_user_address').val(data.user_address);
                        $('#edit_email').val(data.email);
                        $('#edit_phone_number').val(data.phone_number);
                        $('#edit_project_location').val(data.project_location);
                        $('#edit_project_coordinates').val(data.project_coordinates);
                        $('#edit_job_type').val(data.job_type);
                        $('#edit_taxpayer_id').val(data.taxpayer_id);
                        $('#edit_pic_id').val(data.pic_id).trigger('change');
                        $('#edit_equipment_rental_rates_hm_id').val(data.equipment_rental_rates_hm_id).trigger('change');
                        $('#edit_start_date').val(data.start_date ? data.start_date.split('T')[0] : '');
                        $('#edit_end_date').val(data.end_date ? data.end_date.split('T')[0] : '');
                        $('#edit_project_value').val(formatRupiah(data.project_value.toString()));
                        $('#edit_bank_account').val(data.bank_account);
                        $('#edit_scope_of_work').val(data.scope_of_work);
                        $('#edit_description').val(data.description);

                        toggleSubcategory(data.project_categories_id, '#edit_project_sub_categories_id');

                        $('#edit_project_form').attr('action', '/projects/' + id);
                        $('#edit_project_offcanvas').offcanvas('show');
                    }
                });
            });

            $('#edit_project_form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find('.btn-submit');
                var originalText = btn.text();

                btn.prop('disabled', true);
                btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false);
                        btn.text(originalText);
                        var errorMessage = xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors)[0][0] : 'Something went wrong!';
                        Swal.fire({icon: 'error', title: 'Error', text: errorMessage});
                    }
                });
            });
        });
    </script>
    @endpush

@endsection
