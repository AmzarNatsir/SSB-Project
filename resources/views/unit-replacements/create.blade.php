<?php $page = 'unit-replacements'; ?>
@extends('layout.mainlayout')
@section('title', 'Create Unit Replacement (PTU)')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Create Unit Replacement</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.index') }}">Unit Replacements</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-replacements.index') }}" class="btn btn-light d-flex align-items-center">
                    <i class="ti ti-arrow-left me-1"></i>Back to List
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-replacements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Main Form -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200">
                            <h5 class="mb-0">PTU Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Project <span class="text-danger">*</span></label>
                                    <select name="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                        <option value="">-- Select Project --</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->project_name }} ({{ $project->project_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Replacement Date <span class="text-danger">*</span></label>
                                    <input type="date" name="replacement_date" class="form-control @error('replacement_date') is-invalid @enderror"
                                        value="{{ old('replacement_date') }}" required>
                                    @error('replacement_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobilization Date</label>
                                    <input type="date" name="mobilization_date" class="form-control @error('mobilization_date') is-invalid @enderror"
                                        value="{{ old('mobilization_date') }}">
                                    @error('mobilization_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Replacement Reason <span class="text-danger">*</span></label>
                                    <textarea name="replacement_reason" rows="3" class="form-control @error('replacement_reason') is-invalid @enderror"
                                        placeholder="Describe the reason for this unit replacement...">{{ old('replacement_reason') }}</textarea>
                                    @error('replacement_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Attachment</label>
                                    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">Accepted: PDF, JPG, PNG (max 5MB)</div>
                                    @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Replacement Items -->
                    <div class="card">
                        <div class="card-header bg-light-200 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Replacement Items</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
                                <i class="ti ti-plus me-1"></i> Add Item
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" id="itemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:36%">Old Unit (Being Replaced)</th>
                                            <th style="width:36%">Replacement Unit</th>
                                            <th style="width:22%">Notes</th>
                                            <th style="width:6%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        <tr class="item-row">
                                            <td>
                                                <input type="text" name="items[0][old_unit_name]" class="form-control form-control-sm"
                                                    placeholder="Old unit name / code" required>
                                                <input type="hidden" name="items[0][old_unit_id]" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="items[0][replacement_unit_name]" class="form-control form-control-sm"
                                                    placeholder="Replacement unit name / code" required>
                                                <input type="hidden" name="items[0][replacement_unit_id]" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="items[0][notes]" class="form-control form-control-sm"
                                                    placeholder="Optional notes">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn" disabled>
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200">
                            <h6 class="mb-0">Actions</h6>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-device-floppy me-1"></i> Save PTU
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted small mb-0">
                                <i class="ti ti-info-circle me-1 text-primary"></i>
                                PTU is created with <strong>DRAFT</strong> status. You can submit it for approval from the detail page.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let rowIndex = 1;

document.getElementById('addItemBtn').addEventListener('click', function() {
    const tbody = document.getElementById('itemsBody');
    const idx = rowIndex++;
    const row = document.createElement('tr');
    row.className = 'item-row';
    row.innerHTML = `
        <td>
            <input type="text" name="items[${idx}][old_unit_name]" class="form-control form-control-sm" placeholder="Old unit name / code" required>
            <input type="hidden" name="items[${idx}][old_unit_id]" value="">
        </td>
        <td>
            <input type="text" name="items[${idx}][replacement_unit_name]" class="form-control form-control-sm" placeholder="Replacement unit name / code" required>
            <input type="hidden" name="items[${idx}][replacement_unit_id]" value="">
        </td>
        <td>
            <input type="text" name="items[${idx}][notes]" class="form-control form-control-sm" placeholder="Optional notes">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn">
                <i class="ti ti-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(row);
    updateRemoveButtons();
});

document.getElementById('itemsBody').addEventListener('click', function(e) {
    if (e.target.closest('.remove-item-btn')) {
        e.target.closest('tr').remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.item-row');
    rows.forEach(row => {
        const btn = row.querySelector('.remove-item-btn');
        btn.disabled = rows.length === 1;
    });
}
</script>
@endpush
@endsection
