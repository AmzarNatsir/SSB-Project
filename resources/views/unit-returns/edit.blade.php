<?php $page = 'unit-returns'; ?>
@extends('layout.mainlayout')
@section('title', 'Edit ' . $unitReturn->ppu_number)
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit {{ $unitReturn->ppu_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-returns.index') }}">Unit Returns</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-returns.show', $unitReturn->uid) }}">{{ $unitReturn->ppu_number }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('unit-returns.show', $unitReturn->uid) }}" class="btn btn-light d-flex align-items-center">
                <i class="ti ti-arrow-left me-1"></i>Back to Detail
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <form action="{{ route('unit-returns.update', $unitReturn->uid) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light-200"><h5 class="mb-0">PPU Information</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Project <span class="text-danger">*</span></label>
                                    <select name="project_id" class="form-select" required>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ $unitReturn->project_id == $project->id ? 'selected' : '' }}>{{ $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Return Date <span class="text-danger">*</span></label>
                                    <input type="date" name="return_date" class="form-control" value="{{ old('return_date', $unitReturn->return_date->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Demobilization Date</label>
                                    <input type="date" name="demobilization_date" class="form-control" value="{{ old('demobilization_date', $unitReturn->demobilization_date?->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label class="form-label">Attachment</label>
                                    @if($unitReturn->attachment_path)
                                        <div class="mb-2 small"><a href="{{ route('unit-returns.attachment', $unitReturn->uid) }}" class="text-primary">Current Attachment</a></div>
                                    @endif
                                    <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light-200 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Return Items</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="addItemBtn"><i class="ti ti-plus me-1"></i> Add Item</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Project Unit ID</th>
                                            <th>Equipment ID</th>
                                            <th>Notes</th>
                                            <th style="width:6%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        @foreach($unitReturn->items as $i => $item)
                                        <tr class="item-row">
                                            <td><input type="text" name="items[{{ $i }}][project_unit_id]" class="form-control form-control-sm" value="{{ $item->project_unit_id }}" required></td>
                                            <td><input type="text" name="items[{{ $i }}][equipment_id]" class="form-control form-control-sm" value="{{ $item->equipment_id }}" required></td>
                                            <td><input type="text" name="items[{{ $i }}][notes]" class="form-control form-control-sm" value="{{ $item->notes }}"></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn"><i class="ti ti-trash"></i></button>
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
                            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Save Changes</button>
                            <a href="{{ route('unit-returns.show', $unitReturn->uid) }}" class="btn btn-light">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let rowIndex = {{ $unitReturn->items->count() }};
document.getElementById('addItemBtn').addEventListener('click', function() {
    const tbody = document.getElementById('itemsBody');
    const idx = rowIndex++;
    const row = document.createElement('tr');
    row.className = 'item-row';
    row.innerHTML = `
        <td><input type="text" name="items[${idx}][project_unit_id]" class="form-control form-control-sm" required></td>
        <td><input type="text" name="items[${idx}][equipment_id]" class="form-control form-control-sm" required></td>
        <td><input type="text" name="items[${idx}][notes]" class="form-control form-control-sm"></td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-item-btn"><i class="ti ti-trash"></i></button></td>
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
    rows.forEach(row => { row.querySelector('.remove-item-btn').disabled = rows.length === 1; });
}
updateRemoveButtons();
</script>
@endpush
@endsection
