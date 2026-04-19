<?php $page = 'unit-replacements'; ?>
@extends('layout.mainlayout')
@section('title', 'Edit ' . $unitReplacement->ptu_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit {{ $unitReplacement->ptu_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.index') }}">Unit Replacements</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.show', $unitReplacement->uid) }}">{{ $unitReplacement->ptu_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('unit-replacements.show', $unitReplacement->uid) }}" class="btn btn-light d-flex align-items-center">
                <i class="ti ti-arrow-left me-1"></i>Back to Detail
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('unit-replacements.update', $unitReplacement->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">PTU Information</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Project <span class="text-danger">*</span></label>
                                    <select name="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
                                        <option value="">-- Select Project --</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ $unitReplacement->project_id == $project->id ? 'selected' : '' }}>
                                                {{ $project->project_name }} ({{ $project->project_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Replacement Date <span class="text-danger">*</span></label>
                                    <input type="date" name="replacement_date" class="form-control @error('replacement_date') is-invalid @enderror"
                                        value="{{ old('replacement_date', $unitReplacement->replacement_date?->format('Y-m-d')) }}" required>
                                    @error('replacement_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobilization Date</label>
                                    <input type="date" name="mobilization_date" class="form-control @error('mobilization_date') is-invalid @enderror"
                                        value="{{ old('mobilization_date', $unitReplacement->mobilization_date?->format('Y-m-d')) }}">
                                    @error('mobilization_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Replacement Reason <span class="text-danger">*</span></label>
                                    <textarea name="replacement_reason" rows="3" class="form-control @error('replacement_reason') is-invalid @enderror"
                                        placeholder="Describe the reason...">{{ old('replacement_reason', $unitReplacement->replacement_reason) }}</textarea>
                                    @error('replacement_reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Attachment</label>
                                    @if($unitReplacement->attachment_path)
                                    <div class="mb-2">
                                        <i class="ti ti-paperclip me-1 text-muted"></i>
                                        <a href="{{ route('unit-replacements.attachment', $unitReplacement->uid) }}" class="small text-primary">Current attachment</a>
                                        <span class="text-muted small"> (upload new to replace)</span>
                                    </div>
                                    @endif
                                    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">Accepted: PDF, JPG, PNG (max 5MB)</div>
                                    @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items -->
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
                                            <th style="width:36%">Old Unit</th>
                                            <th style="width:36%">Replacement Unit</th>
                                            <th style="width:22%">Notes</th>
                                            <th style="width:6%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        @foreach($unitReplacement->items as $i => $item)
                                        <tr class="item-row">
                                            <td>
                                                <input type="text" name="items[{{ $i }}][old_unit_name]" class="form-control form-control-sm"
                                                    value="{{ $item->old_unit_name }}" placeholder="Old unit name / code" required>
                                                <input type="hidden" name="items[{{ $i }}][old_unit_id]" value="{{ $item->old_unit_id }}">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $i }}][replacement_unit_name]" class="form-control form-control-sm"
                                                    value="{{ $item->replacement_unit_name }}" placeholder="Replacement unit name / code" required>
                                                <input type="hidden" name="items[{{ $i }}][replacement_unit_id]" value="{{ $item->replacement_unit_id }}">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $i }}][notes]" class="form-control form-control-sm"
                                                    value="{{ $item->notes }}" placeholder="Optional notes">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-light-200"><h6 class="mb-0">Actions</h6></div>
                        <div class="card-body d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i> Save Changes
                            </button>
                            <a href="{{ route('unit-replacements.show', $unitReplacement->uid) }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let rowIndex = {{ $unitReplacement->items->count() }};

document.getElementById('addItemBtn').addEventListener('click', function () {
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

document.getElementById('itemsBody').addEventListener('click', function (e) {
    if (e.target.closest('.remove-item-btn')) {
        e.target.closest('tr').remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.item-row');
    rows.forEach(row => {
        row.querySelector('.remove-item-btn').disabled = rows.length === 1;
    });
}

updateRemoveButtons();
</script>
@endpush
@endsection
