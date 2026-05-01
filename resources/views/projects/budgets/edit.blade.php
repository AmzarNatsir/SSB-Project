@extends('layout.mainlayout')
@section('content')

<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Edit Project Budget</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('budgets.index') }}">Budgets</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit v{{ $budget->version }}</li>
                    </ol>
                </nav>
            </div>
             <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <span class="badge bg-{{ $budget->status->value === 'DRAFT' ? 'secondary' : 'warning' }}">{{ $budget->status->value }}</span>
            </div>
        </div>
        <!-- /Page Header -->

        <form action="{{ route('budgets.update', $budget) }}" method="POST" id="edit-budget-form" class="ajax-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="version" value="{{ $budget->version }}">
            
            <!-- Project Project & Margin -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Project</label>
                                <input type="text" class="form-control" value="{{ $budget->project->project_name }} ({{ $budget->project->project_number }})" disabled>
                                <input type="hidden" name="project_id" value="{{ $budget->project_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Profit Margin (%) <span class="text-danger">*</span></label>
                                <input type="number" name="profit_margin_percent" id="profit_margin_percent" class="form-control" value="{{ $budget->profit_margin_percent }}" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Information Card -->
            <div class="card" id="project-info-card">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fs-15"><i class="ti ti-info-circle me-1 text-primary"></i> Project Information</h5>
                </div>
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="text-muted mb-1 fs-13">Project Code</p>
                            <h6 class="fw-bold mb-0" id="info-project-code">{{ $budget->project->project_number ?? '-' }}</h6>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1 fs-13">Project Name</p>
                            <h6 class="fw-bold mb-0" id="info-project-name">{{ $budget->project->project_name ?? '-' }}</h6>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-1 fs-13">Project Value</p>
                            <h6 class="fw-bold mb-0 text-primary" id="info-project-value">{{ isset($budget->project->project_value) ? 'Rp ' . number_format($budget->project->project_value, 0, ',', '.') : '-' }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cost Items -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cost Components</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills nav-fill mb-3 p-2 bg-light rounded" role="tablist">
                        @foreach(App\Enums\BudgetCategory::cases() as $category)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }} d-flex align-items-center justify-content-center gap-2" href="#tab_{{ $category->value }}" data-bs-toggle="pill" role="tab">
                                    <i class="ti {{ $category->icon() }} fs-5"></i>
                                    <span class="fw-semibold">{{ $category->label() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content pt-3">
                        @foreach(App\Enums\BudgetCategory::cases() as $index => $category)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab_{{ $category->value }}" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="col-md-5">
                                        <label class="form-label form-label-sm mb-1 text-muted" style="font-size: 0.8rem;">Upload Document (PDF, Word, Excel) - Optional</label>
                                        <input type="file" class="form-control form-control-sm file-upload-input" id="file_{{ $category->value }}" data-category="{{ $category->value }}" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                        @if(isset($budget->attachments[$category->value]))
                                            <div class="mt-1" style="font-size: 0.8rem;">
                                                <a href="{{ Storage::url($budget->attachments[$category->value]) }}" target="_blank" class="text-primary"><i class="ti ti-download me-1"></i>View existing document</a>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary add-item-btn" data-category="{{ $category->value }}">
                                        <i class="ti ti-plus me-1"></i> Add Item
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered item-table" id="table_{{ $category->value }}">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th width="100">Qty</th>
                                                <th width="100">Unit</th>
                                                <th width="150">Unit Cost</th>
                                                <th width="150">Total</th>
                                                <th width="50"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Rows added via JS -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                                                <td class="text-end fw-bold category-total" data-category="{{ $category->value }}">Rp 0</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="card bg-light-primary">
                <div class="card-body">
                    <div class="row text-end">
                        <div class="col-md-12">
                            <h4>Total COGS: <span id="summary-cogs">Rp 0</span></h4>
                            <h5>Margin Amount: <span id="summary-margin">Rp 0</span></h5>
                            <h3 class="text-primary">Selling Price: <span id="summary-selling-price">Rp 0</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('budgets.index') }}" class="btn btn-light me-2">Cancel</a>
                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="ti ti-device-floppy me-1"></i> Update Budget
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Load existing items
        var existingItems = @json($budget->items);
        
        // Group items by category in JS
        var itemsByCategory = {};
        existingItems.forEach(function(item) {
            if (!itemsByCategory[item.category]) {
                itemsByCategory[item.category] = [];
            }
            itemsByCategory[item.category].push(item);
        });

        // Populate tables
        for (var category in itemsByCategory) {
            itemsByCategory[category].forEach(function(item) {
                addItemRow(category, item);
            });
        }
        
        // Initial Calculation
        calculateAll();

        // Add Item Button
        $('.add-item-btn').click(function() {
            var category = $(this).data('category');
            addItemRow(category, null);
        });

        // Remove Item
        $(document).on('click', '.remove-row', function() {
            var row = $(this).closest('tr');
            var itemId = row.data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: itemId ? "This item will be PERMANENTLY deleted from the database." : "This item will be removed from the budget.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (itemId) {
                        // AJAX call to delete from DB
                        $.ajax({
                            url: `items/${itemId}`,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            },
                            success: function(response) {
                                row.remove();
                                calculateAll();
                                Swal.fire('Deleted!', response.message, 'success');
                            },
                            error: function(xhr) {
                                Swal.fire('Error', xhr.responseJSON?.message || 'Failed to delete item from database', 'error');
                            }
                        });
                    } else {
                        // Just remove from DOM
                        row.remove();
                        calculateAll();
                        Swal.fire('Removed!', 'Item has been removed.', 'success');
                    }
                }
            });
        });

        // Input Changes
        $(document).on('input', '.qty-input, .cost-input, #profit_margin_percent', function() {
            calculateAll();
        });

        // Format Rupiah Input
         $(document).on('input', '.rupiah-input', function(e) {
            var value = $(this).val().replace(/[^,\d]/g, '');
            $(this).val(formatNumber(value));
        });

        // Validate Profit Margin - Only Numbers and Decimal
        $('#profit_margin_percent, .qty-input').on('keypress', function(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            // Allow: backspace, delete, tab, escape, enter, dot
            if (charCode == 46) {
                 // Check if dot already exists
                if ($(this).val().indexOf('.') !== -1) {
                    return false;
                }
                return true;
            }
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        });
        
        // Validate Cost Input - Only Numbers
        $(document).on('keypress', '.cost-input', function(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            // Allow: backspace, delete, tab, escape, enter
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        });

        function calculateAll() {
            var totalCOGS = 0;

            // Iterate through all categories
            $('.item-table').each(function() {
                var categoryTotal = 0;
                $(this).find('tbody tr').each(function() {
                    var qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    var costStr = $(this).find('.cost-input').val() || '0';
                    var cost = parseInt(costStr.replace(/\./g, '')) || 0;
                    
                    var lineTotal = qty * cost;
                    categoryTotal += lineTotal;
                    
                    $(this).find('.total-cell').text('Rp ' + formatNumber(lineTotal));
                });
                
                $(this).find('tfoot .category-total').text('Rp ' + formatNumber(categoryTotal));
                totalCOGS += categoryTotal;
            });

            var marginPercent = parseFloat($('#profit_margin_percent').val()) || 0;
            var marginAmount = totalCOGS * (marginPercent / 100);
            var sellingPrice = totalCOGS + marginAmount;

            $('#summary-cogs').text('Rp ' + formatNumber(totalCOGS));
            $('#summary-margin').text('Rp ' + formatNumber(marginAmount));
            $('#summary-selling-price').text('Rp ' + formatNumber(sellingPrice));
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        function addItemRow(category, item) {
            var rowIdx = $('#table_' + category + ' tbody tr').length;
            var itemId = item ? item.id : '';
            var itemName = item ? item.item_name : '';
            var qty = item ? item.qty : '';
            var units = item ? item.units : '';
            
            var formattedCost = '';
            if (item && item.unit_cost) {
                 var val = parseFloat(item.unit_cost).toString(); 
                 formattedCost = formatNumber(val);
            }
            
            var html = `
                <tr data-id="${itemId}">
                    <td>
                        <input type="text" name="items[${category}][${rowIdx}][item_name]" class="form-control" value="${itemName}" required>
                        <input type="hidden" name="items[${category}][${rowIdx}][category]" value="${category}">
                    </td>
                    <td><input type="number" name="items[${category}][${rowIdx}][qty]" class="form-control qty-input" value="${qty}" min="0" step="0.01" required></td>
                    <td><input type="text" name="items[${category}][${rowIdx}][units]" class="form-control" value="${units}" required></td>
                    <td><input type="text" name="items[${category}][${rowIdx}][unit_cost]" class="form-control cost-input rupiah-input" value="${formattedCost}" required></td>
                    <td class="text-end total-cell">Rp 0</td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="ti ti-trash"></i></button></td>
                </tr>
            `;
            $('#table_' + category + ' tbody').append(html);
        }
        
        // Form Submit
        $('#edit-budget-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('.btn-submit');
            
            var items = [];
            $('.item-table tbody tr').each(function() {
                var category = $(this).find('input[name*="[category]"]').val();
                var itemName = $(this).find('input[name*="[item_name]"]').val();
                var qty = $(this).find('input[name*="[qty]"]').val();
                var units = $(this).find('input[name*="[units]"]').val();
                var costStr = $(this).find('input[name*="[unit_cost]"]').val() || '0';
                var unitCost = parseInt(costStr.replace(/\./g, ''));
                
                if (itemName && qty && unitCost) {
                    items.push({
                        category: category,
                        item_name: itemName,
                        qty: qty,
                        units: units,
                        unit_cost: unitCost,
                        total_cost: qty * unitCost
                    });
                }
            });

            if (items.length === 0) {
                Swal.fire('Error', 'Please add at least one cost item.', 'error');
                return;
            }

            var formData = new FormData();
            formData.append('profit_margin_percent', $('#profit_margin_percent').val());
            formData.append('version', $('input[name="version"]').val());
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('_method', 'PUT');

            items.forEach(function(item, index) {
                formData.append('items[' + index + '][category]', item.category);
                formData.append('items[' + index + '][item_name]', item.item_name);
                formData.append('items[' + index + '][qty]', item.qty);
                formData.append('items[' + index + '][units]', item.units);
                formData.append('items[' + index + '][unit_cost]', item.unit_cost);
            });

            $('.file-upload-input').each(function() {
                var category = $(this).data('category');
                if (this.files && this.files[0]) {
                    formData.append('attachments[' + category + ']', this.files[0]);
                }
            });

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                         window.location.href = "{{ route('budgets.index') }}";
                    });
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="ti ti-device-floppy me-1"></i> Update Budget');
                    var msg = xhr.responseJSON?.message || 'Error occurred';
                    // Show version mismatch specific error if present
                    if(xhr.responseJSON?.errors?.version) {
                         msg = xhr.responseJSON.errors.version[0];
                    }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });
</script>
@endpush
@endsection
