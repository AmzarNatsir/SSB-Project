@extends('layout.mainlayout')
@section('title', 'New Unit Request')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">New Unit Request</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-requests.index') }}">Unit Requests</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-requests.store') }}" method="POST" enctype="multipart/form-data" id="unitRequestForm">
            @csrf
            <div class="row">
                <!-- Left Column: Main Form -->
                <div class="col-lg-8">
                    <!-- Project Selection -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-building me-2 text-primary"></i>Project Selection</h5>
                        </div>
                        <div class="card-body">
                            @if($eligibleProjects->isEmpty())
                                <div class="alert alert-warning mb-0">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    No projects with an <strong>APPROVED</strong> negotiation found. Please ensure a negotiation is approved before creating a unit request.
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="project_id" class="form-label fw-semibold">Project <span class="text-danger">*</span></label>
                                    <select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                        <option value="">-- Select a Project --</option>
                                        @foreach($eligibleProjects as $project)
                                            <option value="{{ $project->id }}"
                                                data-items="{{ $project->negotiations->first()?->quotation?->items->toJson() }}"
                                                {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->project_name }}
                                                ({{ $project->project_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Unit Items Preview -->
                    <div class="card mb-3" id="itemsCard" style="display:none !important;">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-list me-2 text-primary"></i>Units from Quotation</h5>
                            <p class="text-muted small mb-0 mt-1">Auto-populated from the approved quotation. These items will be included in the unit request.</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width:40px">#</th>
                                            <th>Unit Name</th>
                                            <th class="text-center" style="width:80px">Qty</th>
                                            <th class="text-center" style="width:100px">Duration (Days)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        <tr><td colspan="4" class="text-center text-muted py-3">Select a project to see units.</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Request Details -->
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ti ti-calendar me-2 text-primary"></i>Request Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="request_date" class="form-label fw-semibold">Request Date <span class="text-danger">*</span></label>
                                <input type="date" id="request_date" name="request_date"
                                    class="form-control @error('request_date') is-invalid @enderror"
                                    value="{{ old('request_date', date('Y-m-d')) }}" required>
                                @error('request_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobilization_date" class="form-label fw-semibold">Mobilization Date <span class="text-danger">*</span></label>
                                <input type="date" id="mobilization_date" name="mobilization_date"
                                    class="form-control @error('mobilization_date') is-invalid @enderror"
                                    value="{{ old('mobilization_date') }}" required>
                                @error('mobilization_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label fw-semibold">Notes</label>
                                <textarea id="notes" name="notes" rows="4"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Additional notes or requirements...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="attachment" class="form-label fw-semibold">
                                    Attachment
                                    <span class="text-muted small">(PDF/DOCX, max 10MB)</span>
                                </label>
                                <input type="file" id="attachment" name="attachment"
                                    class="form-control @error('attachment') is-invalid @enderror"
                                    accept=".pdf,.doc,.docx">
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn" {{ $eligibleProjects->isEmpty() ? 'disabled' : '' }}>
                            <i class="ti ti-device-floppy me-2"></i>Save as Draft
                        </button>
                        <a href="{{ route('unit-requests.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-x me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const projectSelect = document.getElementById('project_id');
    const itemsCard     = document.getElementById('itemsCard');
    const itemsTableBody = document.getElementById('itemsTableBody');

    function renderItems(items) {
        if (!items || items.length === 0) {
            itemsTableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">No items found in quotation.</td></tr>';
            return;
        }

        itemsTableBody.innerHTML = items.map((item, idx) => `
            <tr>
                <td class="text-center">${idx + 1}</td>
                <td>${item.unit_name ?? item.description ?? '-'}</td>
                <td class="text-center">${item.quantity ?? item.qty ?? '-'}</td>
                <td class="text-center">${item.duration ?? item.duration_days ?? '-'}</td>
            </tr>
        `).join('');
    }

    projectSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const rawItems = selectedOption.dataset.items;

        if (rawItems) {
            try {
                const items = JSON.parse(rawItems);
                renderItems(items);
                itemsCard.style.removeProperty('display');
                itemsCard.style.display = 'block';
            } catch (e) {
                itemsCard.style.display = 'none';
            }
        } else {
            itemsCard.style.display = 'none';
            itemsTableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Select a project to see units.</td></tr>';
        }
    });

    // Trigger on load if value is pre-selected (validation error)
    if (projectSelect.value) {
        projectSelect.dispatchEvent(new Event('change'));
    }

    // Prevent mobilization_date from being before request_date
    document.getElementById('request_date').addEventListener('change', function() {
        document.getElementById('mobilization_date').min = this.value;
    });
    document.getElementById('request_date').dispatchEvent(new Event('change'));
});
</script>
@endpush
