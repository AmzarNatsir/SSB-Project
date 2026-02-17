@extends('layout.mainlayout')
@section('title', 'Negotiation Dashboard')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Negotiation Overview</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Negotiations</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                 <a href="{{ route('negotiations.create') }}" class="btn btn-primary btn-label">
                    <i class="ti ti-plus label-icon align-middle fs-16 me-2"></i> Start Negotiation
                </a>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Negotiations</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                        <i class="ti ti-briefcase"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $totalNegotiations }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Active Deals</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                        <i class="ti ti-clock"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $negotiatingCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Closed Won</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                        <i class="ti ti-trophy"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $approvedCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Success Rate</p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                        <i class="ti ti-chart-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $successRate }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Negotiation List -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="negotiationList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Recent Deals</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search...">
                                        <i class="ti ti-search search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="negotiationTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                            </div>
                                        </th>
                                        <th class="sort" data-sort="deal_id">Deal Ref</th>
                                        <th class="sort" data-sort="project_name">Project</th>
                                        <th class="sort" data-sort="value">Current Value</th>
                                        <th class="sort" data-sort="discount">Discount</th>
                                        <th class="sort" data-sort="status">Status</th>
                                        <th class="sort" data-sort="date">Last Updated</th>
                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse($negotiations as $negotiation)
                                    @php
                                        // KPI Logic Calculation
                                        $currentValue = $negotiation->final_agreed_value ?? ($negotiation->company_offer_value > 0 ? $negotiation->company_offer_value : $negotiation->quotation->selling_price);
                                        $originalValue = $negotiation->quotation->selling_price;
                                        $diff = $originalValue - $currentValue;
                                        $discountPercent = $originalValue > 0 ? ($diff / $originalValue) * 100 : 0;
                                        
                                        // Color logic for discount
                                        $discountColor = 'success';
                                        if ($discountPercent < 0) $discountColor = 'info'; // Upsell
                                        if ($discountPercent > 10) $discountColor = 'warning';
                                        if ($discountPercent > 20) $discountColor = 'danger';
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="chk_child" value="{{ $negotiation->id }}">
                                            </div>
                                        </th>
                                        <td class="deal_id">
                                            <a href="{{ route('negotiations.show', $negotiation->uid) }}" class="fw-medium link-primary">{{ $negotiation->negotiation_number }}</a>
                                        </td>
                                        <td class="project_name">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar-xs rounded-circle bg-light text-primary d-flex align-items-center justify-content-center">
                                                        <i class="ti ti-building"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 max-w-200 text-truncate">{{ $negotiation->project->project_name }}</h6>
                                                    <small class="text-muted">{{ $negotiation->project->customer_name ?? 'Client' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="value">
                                            <h6 class="mb-0">Rp {{ number_format($currentValue, 0, ',', '.') }}</h6>
                                            <small class="text-muted">Orig: Rp {{ number_format($originalValue, 0, ',', '.') }}</small>
                                        </td>
                                        <td class="discount">
                                            <span class="badge bg-{{ $discountColor }}-subtle text-{{ $discountColor }}">
                                                <i class="ti ti-arrow-{{ $discountPercent >= 0 ? 'down' : 'up' }} me-1"></i>
                                                {{ abs(round($discountPercent, 1)) }}%
                                            </span>
                                        </td>
                                        <td class="status">
                                            <span class="badge bg-{{ $negotiation->status->color() }}-subtle text-{{ $negotiation->status->color() }} text-uppercase">
                                                {{ $negotiation->status->label() }}
                                            </span>
                                        </td>
                                        <td class="date">{{ $negotiation->updated_at->format('d M, H:i') }}</td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('negotiations.show', $negotiation->uid) }}">
                                                            <i class="ti ti-eye align-bottom me-2 text-muted"></i> View Details
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="avatar-lg mx-auto mb-3">
                                                <div class="avatar-title bg-light rounded-circle text-muted fs-1">
                                                     <i class="ti ti-search"></i>
                                                </div>
                                            </div>
                                            <h5>No Negotiations Found</h5>
                                            <p class="text-muted">Start a new negotiation from a quotation.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                             {{ $negotiations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
