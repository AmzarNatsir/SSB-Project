@extends('layout.mainlayout')
@section('title', 'Quotation Dashboard')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Quotation Dashboard (Penawaran Harga)</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quotations</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <a href="{{ route('quotations.create') }}" class="btn btn-primary btn-label">
                        <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Create New Quote
                    </a>
                </div>
            </div>

            <!-- KPIs -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate border-0 shadow-sm overflow-hidden">
                        <div class="position-absolute start-0 top-0 end-0 bottom-0"
                            style="background: linear-gradient(135deg, rgba(10, 179, 156, 0.1) 0%, rgba(10, 179, 156, 0) 100%); pointer-events: none;">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-2">Total Value
                                        (Potential)</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rp
                                        {{ number_format($kpi['value'], 0, ',', '.') }}
                                    </h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-success-subtle text-success rounded fs-3">
                                            <i class="ri-money-dollar-circle-line"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate border-0 shadow-sm overflow-hidden">
                        <div class="position-absolute start-0 top-0 end-0 bottom-0"
                            style="background: linear-gradient(135deg, rgba(41, 156, 219, 0.1) 0%, rgba(41, 156, 219, 0) 100%); pointer-events: none;">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-2">Draft Quotations</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ $kpi['draft'] }}</h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-info-subtle text-info rounded fs-3">
                                            <i class="ri-file-edit-line"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate border-0 shadow-sm overflow-hidden">
                        <div class="position-absolute start-0 top-0 end-0 bottom-0"
                            style="background: linear-gradient(135deg, rgba(247, 184, 75, 0.1) 0%, rgba(247, 184, 75, 0) 100%); pointer-events: none;">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-2">Pending Approval</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ $kpi['pending'] }}</h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-warning-subtle text-warning rounded fs-3">
                                            <i class="ri-time-line"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate border-0 shadow-sm overflow-hidden">
                        <div class="position-absolute start-0 top-0 end-0 bottom-0"
                            style="background: linear-gradient(135deg, rgba(64, 81, 137, 0.1) 0%, rgba(64, 81, 137, 0) 100%); pointer-events: none;">
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-2">Sent to Client</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ $kpi['sent'] }}</h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                            <i class="ri-send-plane-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quotation List -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="quotationList">
                        <div class="card-header border-0">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">Recent Quotations</h5>
                                <div class="flex-shrink-0">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('quotations.index') }}"
                                            class="btn btn-soft-danger btn-icon btn-sm"><i class="ri-refresh-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom-dashed border-bottom">
                            <div class="row g-3">
                                <div class="col-xl-3 col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-text text-muted bg-light border-0"><i
                                                class="ri-search-line"></i></span>
                                        <input type="text" class="form-control content-group bg-light border-0"
                                            placeholder="Search for project, ID or status...">
                                    </div>
                                </div>
                                <!-- Add Filters here if needed later -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card mb-4">
                                <table class="table table-hover table-nowrap align-middle" id="customerTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="quotation_id">ID</th>
                                            <th class="sort" data-sort="project_name">Project</th>
                                            <th class="sort" data-sort="date">Date</th>
                                            <th class="sort" data-sort="amount">Value</th>
                                            <th class="sort" data-sort="margin">Margin</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="position">Current Approver</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @forelse($quotations as $quote)
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                                            value="{{ $quote->id }}">
                                                    </div>
                                                </th>
                                                <td class="id">
                                                    <a href="{{ route('quotations.show', $quote->uid) }}"
                                                        class="fw-medium link-primary">#{{ substr($quote->uid, 0, 8) }}</a>
                                                </td>
                                                <td class="project_name">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <div
                                                                class="avatar-xs rounded-circle bg-light text-primary d-flex align-items-center justify-content-center">
                                                                <i class="ri-building-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">
                                                                {{ $quote->project->project_name ?? 'Unknown Project' }}
                                                            </h6>
                                                            <small
                                                                class="text-muted">{{ $quote->project->project_number ?? '-' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="date">{{ $quote->created_at->format('d M, Y') }}</td>
                                                <td class="amount">
                                                    <h6 class="mb-0 text-success">Rp
                                                        {{ number_format($quote->selling_price, 0, ',', '.') }}
                                                    </h6>
                                                </td>
                                                <td class="margin">
                                                    <span
                                                        class="badge {{ $quote->profit_margin_percent >= 20 ? 'bg-success-subtle text-success' : ($quote->profit_margin_percent >= 10 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                                                        <i class="ri-line-chart-line me-1"></i>
                                                        {{ $quote->profit_margin_percent }}%
                                                    </span>
                                                </td>
                                                <td class="status">
                                                    @php
                                                        $statusClass = match ($quote->status) {
                                                            'DRAFT' => 'bg-secondary-subtle text-secondary',
                                                            'SUBMITTED' => 'bg-warning-subtle text-warning',
                                                            'APPROVED' => 'bg-success-subtle text-success',
                                                            'SENT' => 'bg-primary-subtle text-primary',
                                                            'REVISION_REQUIRED' => 'bg-danger-subtle text-danger',
                                                            default => 'bg-light text-muted'
                                                        };
                                                    @endphp
                                                    <span
                                                        class="badge {{ $statusClass }} text-uppercase">{{ str_replace('_', ' ', $quote->status) }}</span>
                                                </td>
                                                <td class="position">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-shield-user-line me-2 text-warning fs-16"></i>
                                                        <span
                                                            class="text-muted fw-medium fs-12">{{ $quote->current_approver_label }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill align-middle"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('quotations.show', $quote->uid) }}">
                                                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('quotations.pdf', $quote->uid) }}"
                                                                    target="_blank">
                                                                    <i
                                                                        class="ri-file-pdf-fill align-bottom me-2 text-muted"></i>
                                                                    PDF
                                                                </a>
                                                            </li>
                                                            @if(!$quote->isLocked())
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('quotations.edit', $quote->uid) }}">
                                                                    <i class="ri-edit-fill align-bottom me-2 text-muted"></i>
                                                                    Edit
                                                                </a>
                                                            </li>
                                                            @endif
                                                            @if($quote->status === 'DRAFT')
                                                                <li>
                                                                    <form action="{{ route('quotations.submit', $quote->uid) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i
                                                                                class="ri-send-plane-fill align-bottom me-2 text-muted"></i>
                                                                            Submit
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">
                                                    <div class="noresult">
                                                        <div class="text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                                                trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                                                style="width:75px;height:75px"></lord-icon>
                                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                                            <p class="text-muted mb-0">We've searched more than 150+ Orders We
                                                                did not find any orders for you search.</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                {{ $quotations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection