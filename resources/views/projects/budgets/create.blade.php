@extends('layout.mainlayout')
@section('content')

<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">Create Project Budget</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('budgets.index') }}">Budgets</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Page Header -->

        <form action="{{ route('budgets.store') }}" method="POST" id="create-budget-form" class="ajax-form">
            @csrf
            
            <!-- Project Project & Margin -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Project <span class="text-danger">*</span></label>
                                <select name="project_id" id="project_id" class="form-control" required>
                                    <option value="">Select Project</option>
                                    @if(isset($project))
                                        <option value="{{ $project->id }}" selected>{{ $project->project_name }} ({{ $project->project_number }})</option>
                                    @endif
                                    <!-- Populate via JS if needed or pass all projects -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Profit Margin (%) <span class="text-danger">*</span></label>
                                <input type="number" name="profit_margin_percent" id="profit_margin_percent" class="form-control" value="0" min="0" step="0.01" required>
                            </div>
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
                                <div class="d-flex justify-content-end mb-2">
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
                    <i class="ti ti-device-floppy me-1"></i> Save Draft
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Simple search for projects if not pre-selected
        // Assuming select2 is available based on class 'select'
        // If not, we might need to load projects via AJAX or pass them all. 
        // For 10k projects, Select2 AJAX is needed.
        // Let's assume standard select for now or user provided $project.

        $('#project_id').select2({
             placeholder: "Select Project",
             allowClear: true,
             ajax: {
                 url: "{{ route('projects.search') }}",
                 dataType: 'json',
                 delay: 250,
                 data: function (params) {
                     return {
                         term: params.term // search term
                     };
                 },
                 processResults: function (data) {
                     return {
                         results: data.results
                     };
                 },
                 cache: true
             }
        });

        // Initialize empty state
        calculateAll();

        // Add Item
        $('.add-item-btn').click(function() {
            var category = $(this).data('category');
            var rowIdx = $('#table_' + category + ' tbody tr').length;
            
            var html = `
                <tr>
                    <td>
                        <input type="text" name="items[${category}][${rowIdx}][item_name]" class="form-control" required>
                        <input type="hidden" name="items[${category}][${rowIdx}][category]" value="${category}">
                    </td>
                    <td><input type="number" name="items[${category}][${rowIdx}][qty]" class="form-control qty-input" min="0" step="0.01" required></td>
                    <td><input type="text" name="items[${category}][${rowIdx}][units]" class="form-control" required></td>
                    <td><input type="text" name="items[${category}][${rowIdx}][unit_cost]" class="form-control cost-input rupiah-input" required></td>
                    <td class="text-end total-cell">Rp 0</td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="ti ti-trash"></i></button></td>
                </tr>
            `;
            $('#table_' + category + ' tbody').append(html);
        });

        // Remove Item
        $(document).on('click', '.remove-row', function() {
            var row = $(this).closest('tr');
            Swal.fire({
                title: 'Are you sure?',
                text: "This item will be removed from the budget.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    calculateAll();
                    Swal.fire(
                        'Deleted!',
                        'Item has been removed.',
                        'success'
                    );
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

        // Validate Profit Margin & Qty - Numbers and Decimal
        $('#profit_margin_percent').on('keypress', function(event) {
             return validateDecimal(event, $(this));
        });
        
        $(document).on('keypress', '.qty-input', function(event) {
             return validateDecimal(event, $(this));
        });
        
        // Validate Cost - Only Numbers
        $(document).on('keypress', '.cost-input', function(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        });

        function validateDecimal(event, element) {
            var charCode = (event.which) ? event.which : event.keyCode;
            // Allow: backspace, delete, tab, escape, enter, dot
            if (charCode == 46) {
                if (element.val().indexOf('.') !== -1) {
                    return false;
                }
                return true;
            }
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

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
        
        // Form Submit
        $('#create-budget-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('.btn-submit');
            
            // Collect all items into a linear array for the backend
            // The backend expects items as a list of objects
            // Our form names are items[category][index][field]
            // We need to ensure the backend can parse this.
            // Actually, standard PHP POST handling will give nested arrays.
            // StoreBudgetRequest validates 'items' as array.
            // ProjectBudgetService expects array of items. 
            // We might need to flatten it or adjust backend to handle nested or just flatten here.
            
            // Let's flatten in JS to match expected "items" array structure if backend expects simple list
            // Backend: $request->input('items', [])
            // ProjectBudgetService creates them.
            // ProjectBudgetItem model has 'category' field.
            
            // We can just rely on standard form serialization if we name them `items[][field]` and include category input?
            // But we used indices. items[cat][idx].
            // PHP will parse this as associative array.
            // Let's adjust to flatten.
            
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

            var formData = {
                project_id: $('#project_id').val(),
                profit_margin_percent: $('#profit_margin_percent').val(),
                items: items,
                _token: $('input[name="_token"]').val()
            };

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData, // Send as JSON explicitly? Or stick to form serialization? Service expects array. 
                // Creating a budget expects "items" as array of objects.
                // It is safer to send JSON.
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
                    btn.prop('disabled', false).html('<i class="ti ti-device-floppy me-1"></i> Save Draft');
                    var msg = xhr.responseJSON?.message || 'Error occurred';
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });
</script>
@endpush
@endsection
