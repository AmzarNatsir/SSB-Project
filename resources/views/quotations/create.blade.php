@extends('layout.mainlayout')

@section('title', 'Create Quotation')

@section('content')

@push('styles')
<style>
    /* ===== Select2 - Unit Dropdown in Table ===== */
    #items_table .select2-container {
        width: 100% !important;
        min-width: 200px;
    }

    /* Selection Box */
    #items_table .select2-container .select2-selection--single {
        height: 36px !important;
        border: 1px solid #ced4da !important;
        border-radius: 6px !important;
        background-color: #fff !important;
        display: flex !important;
        align-items: center !important;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    #items_table .select2-container--focus .select2-selection--single,
    #items_table .select2-container--open .select2-selection--single {
        border-color: #405189 !important;
        box-shadow: 0 0 0 0.2rem rgba(64, 81, 137, 0.15) !important;
        outline: none !important;
    }
    #items_table .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 34px !important;
        padding-left: 10px !important;
        padding-right: 30px !important;
        color: #495057 !important;
        font-size: 0.875rem !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #items_table .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #9aa2b1 !important;
    }
    #items_table .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 34px !important;
        top: 1px !important;
        right: 6px !important;
    }

    /* Allow table-responsive to show the dropdown (overflow visible) */
    #step2 .table-responsive {
        overflow: visible !important;
    }
    /* But keep the table itself scrollable on small screens using wrapper trick */
    #step2 .table-scroll-wrapper {
        overflow-x: auto;
    }

    /* Hide original select replaced by Select2 */
    select.select2-hidden-accessible {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0,0,0,0) !important;
        border: 0 !important;
        visibility: hidden !important;
    }

    /* ===== Global Select2 Dropdown Panel ===== */
    .select2-dropdown {
        border: 1px solid #ced4da !important;
        border-radius: 6px !important;
        box-shadow: 0 4px 16px rgba(30, 32, 37, 0.15) !important;
        background-color: #fff !important;
        z-index: 2000 !important;
    }
    .select2-container--open {
        z-index: 2000 !important;
    }
    /* Unit dropdown: restricted width */
    .unit-select-dropdown {
        min-width: 250px !important;
        max-width: 450px !important;
    }
    
    /* Ensure the Select2 container itself doesn't cause overflow issues */
    .select2-container {
        display: block;
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        display: flex;
        align-items: center;
    }

    /* Search field inside dropdown */
    .select2-search--dropdown {
        padding: 8px 10px !important;
        border-bottom: 1px solid #f3f6f9 !important;
        background: #f8f9fa !important;
    }
    .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da !important;
        border-radius: 5px !important;
        padding: 6px 10px !important;
        width: 100% !important;
        box-sizing: border-box !important;
        font-size: 0.8125rem !important;
        color: #495057 !important;
        outline: none !important;
        background-color: #fff !important;
    }
    .select2-search--dropdown .select2-search__field:focus {
        border-color: #405189 !important;
        box-shadow: 0 0 0 0.15rem rgba(64,81,137,0.15) !important;
    }

    /* Options list */
    .select2-results__options {
        max-height: 220px !important;
        overflow-y: auto !important;
        padding: 4px 0 !important;
    }
    .select2-results__option {
        padding: 8px 14px !important;
        font-size: 0.875rem !important;
        color: #495057 !important;
        cursor: pointer;
        transition: background-color 0.12s ease, color 0.12s ease;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected],
    .select2-container--default .select2-results__option--highlighted[data-selected] {
        background-color: #405189 !important;
        color: #fff !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #eef0f7 !important;
        color: #405189 !important;
        font-weight: 500;
    }
</style>
@endpush

<div class="page-wrapper">
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-0">Create New Quotation</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('quotations.index') }}">Quotations</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body checkout-tab">
                        <form id="quotationForm" action="{{ isset($quotation) ? route('quotations.update', $quotation->uid) : route('quotations.store') }}">
                            @csrf
                            @if(isset($quotation))
                                @method('PUT')
                            @endif
                            <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                                <!-- Custom Wizard Style -->
                                <style>
                                    .wizard-steps {
                                        position: relative;
                                        margin-bottom: 2rem;
                                    }
                                    .wizard-steps .nav-link {
                                        background: transparent !important;
                                        color: #878a99;
                                        text-align: center;
                                        padding: 1rem 0;
                                        position: relative;
                                        width: 100%;
                                    }
                                    .wizard-steps .nav-link.active {
                                        color: #405189;
                                    }
                                    .wizard-steps .step-icon {
                                        width: 50px;
                                        height: 50px;
                                        line-height: 50px;
                                        border: 2px solid #e9ebec;
                                        border-radius: 50%;
                                        font-size: 20px;
                                        margin: 0 auto 10px;
                                        background: #fff;
                                        position: relative;
                                        z-index: 2;
                                        transition: all 0.3s ease;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                    }
                                    .wizard-steps .nav-link.active .step-icon {
                                        border-color: #405189;
                                        background: #405189;
                                        color: #fff;
                                        box-shadow: 0 0 0 5px rgba(64, 81, 137, 0.1);
                                    }
                                    .wizard-steps .nav-link.done .step-icon {
                                        border-color: #0ab39c;
                                        background: #0ab39c;
                                        color: #fff;
                                    }
                                    .wizard-steps .step-title {
                                        font-weight: 600;
                                        font-size: 14px;
                                        display: block;
                                    }
                                    /* Connector Line */
                                    .wizard-steps .nav-item {
                                        position: relative;
                                        flex: 1;
                                    }
                                    .wizard-steps .nav-item::before {
                                        content: "";
                                        position: absolute;
                                        top: 35px; /* Half of icon height + padding top */
                                        left: -50%;
                                        width: 100%;
                                        height: 2px;
                                        background-color: #e9ebec;
                                        z-index: 1;
                                    }
                                    .wizard-steps .nav-item:first-child::before {
                                        display: none;
                                    }
                                    .wizard-steps .nav-item.active::before {
                                        background-color: #405189;
                                    }
                                </style>
                                
                                <div class="wizard-steps">
                                    <ul class="nav nav-pills nav-justified" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="step1-tab" data-bs-toggle="pill" data-bs-target="#step1" type="button" role="tab" aria-selected="true" onclick="updateWizardProgress(1)">
                                                <div class="step-icon"><i class="ri-building-line"></i></div>
                                                <span class="step-title">Project Selection</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="step2-tab" data-bs-toggle="pill" data-bs-target="#step2" type="button" role="tab" aria-selected="false" onclick="updateWizardProgress(2)">
                                                <div class="step-icon"><i class="ri-truck-line"></i></div>
                                                <span class="step-title">Unit & Pricing</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="step3-tab" data-bs-toggle="pill" data-bs-target="#step3" type="button" role="tab" aria-selected="false" onclick="updateWizardProgress(3)">
                                                <div class="step-icon"><i class="ri-money-dollar-circle-line"></i></div>
                                                <span class="step-title">Profit Planning</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="step4-tab" data-bs-toggle="pill" data-bs-target="#step4" type="button" role="tab" aria-selected="false" onclick="updateWizardProgress(4)">
                                                <div class="step-icon"><i class="ri-checkbox-circle-line"></i></div>
                                                <span class="step-title">Summary & Submit</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                
                                <script>
                                    // Simple script to handle "Done" state visual for previous steps
                                    function updateWizardProgress(step) {
                                        // Wait for bootstrap to apply active class then run
                                        setTimeout(() => {
                                            const items = document.querySelectorAll('.wizard-steps .nav-item');
                                            let passed = true;
                                            items.forEach((item, index) => {
                                                const link = item.querySelector('.nav-link');
                                                const icon = item.querySelector('.step-icon i');
                                                link.classList.remove('done');
                                                // Reset icon
                                                if (index === 0) icon.className = 'ri-building-line';
                                                if (index === 1) icon.className = 'ri-truck-line';
                                                if (index === 2) icon.className = 'ri-money-dollar-circle-line';
                                                if (index === 3) icon.className = 'ri-checkbox-circle-line';
                                                
                                                if (link.classList.contains('active')) {
                                                    passed = false;
                                                }
                                                if (passed) {
                                                    link.classList.add('done');
                                                    icon.className = 'ri-check-line'; // Change to checkmark
                                                    item.classList.add('active'); // Light up the line
                                                } else {
                                                    if (!link.classList.contains('active')) item.classList.remove('active');
                                                }
                                            });
                                        }, 50);
                                    }
                                    
                                    // Hook into existing buttons (super simple way without editing js file heavily)
                                    document.addEventListener('DOMContentLoaded', () => {
                                        document.querySelectorAll('.nexttab, .previoustab').forEach(btn => {
                                            btn.addEventListener('click', function() {
                                                // Identify target and call update. 
                                                // Since bootstrap tabs event fires after click, we can just infer or wait for tab show event.
                                                // Let's use the tab show event globally for robustness.
                                            });
                                        });
                                        
                                        // Global tab event listener
                                        var triggerTabList = [].slice.call(document.querySelectorAll('.wizard-steps button[data-bs-toggle="pill"]'))
                                        triggerTabList.forEach(function (triggerEl) {
                                            triggerEl.addEventListener('shown.bs.tab', function (event) {
                                                // Get index
                                                const targetId = event.target.id;
                                                let step = 1;
                                                if(targetId === 'step2-tab') step = 2;
                                                if(targetId === 'step3-tab') step = 3;
                                                if(targetId === 'step4-tab') step = 4;
                                                updateWizardProgress(step);
                                            })
                                        })
                                    });
                                </script>
                            </div>

                            <div class="tab-content">
                                <!-- Step 1: Project Selection -->
                                <div class="tab-pane fade show active" id="step1" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="mb-3">{{ isset($quotation) ? 'Project Information' : 'Select Project' }}</h5>
                                            @if(!isset($quotation))
                                                <p class="text-muted">Choose a project with an approved budget baseline to proceed.</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Project</label>
                                                @if(isset($quotation))
                                                    <input type="text" class="form-control" value="{{ $quotation->project->project_number }} - {{ $quotation->project->project_name }}" readonly disabled>
                                                    <input type="hidden" name="project_id" id="project_id_hidden" value="{{ $quotation->project_id }}">
                                                    <!-- Keep select but hidden and disabled to satisfy JS logic if needed, but we'll use a better way -->
                                                    <select class="form-select d-none" id="project_id" name="project_id_disabled" disabled>
                                                        @foreach($projects as $project)
                                                            @php $budget = $project->latest_budget; @endphp
                                                            <option value="{{ $project->id }}" 
                                                                {{ $quotation->project_id == $project->id ? 'selected' : '' }}
                                                                data-project-number="{{ $project->project_number }}"
                                                                data-project-name="{{ $project->project_name }}"
                                                                data-budget-id="{{ $budget?->id }}" 
                                                                data-budget-hpp="{{ $budget?->total_hpp ?? 0 }}"
                                                                data-budget-labor="{{ $budget?->total_labor_cost ?? 0 }}"
                                                                data-budget-equipment="{{ $budget?->total_equipment_cost ?? 0 }}"
                                                                data-budget-maintenance="{{ $budget?->total_maintenance_cost ?? 0 }}"
                                                                data-budget-operational="{{ $budget?->total_operational_cost ?? 0 }}"
                                                                data-budget-mobilization="{{ $budget?->total_mobilization_cost ?? 0 }}"
                                                                data-budget-other="{{ $budget?->total_other_cost ?? 0 }}"
                                                                data-budget-margin="{{ $budget?->profit_margin_percent ?? 0 }}"
                                                                data-budget-selling="{{ $budget?->selling_price ?? 0 }}"
                                                            >
                                                                {{ $project->project_number }} - {{ $project->project_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select class="form-select" id="project_id" name="project_id" data-toggle="select2" data-placeholder="Select Project..." required>
                                                        <option value="">Select Project...</option>
                                                        @foreach($projects as $project)
                                                            @php $budget = $project->latest_budget; @endphp
                                                            <option value="{{ $project->id }}" 
                                                                data-project-number="{{ $project->project_number }}"
                                                                data-project-name="{{ $project->project_name }}"
                                                                data-budget-id="{{ $budget?->id }}" 
                                                                data-budget-hpp="{{ $budget?->total_hpp ?? 0 }}"
                                                                data-budget-labor="{{ $budget?->total_labor_cost ?? 0 }}"
                                                                data-budget-equipment="{{ $budget?->total_equipment_cost ?? 0 }}"
                                                                data-budget-maintenance="{{ $budget?->total_maintenance_cost ?? 0 }}"
                                                                data-budget-operational="{{ $budget?->total_operational_cost ?? 0 }}"
                                                                data-budget-mobilization="{{ $budget?->total_mobilization_cost ?? 0 }}"
                                                                data-budget-other="{{ $budget?->total_other_cost ?? 0 }}"
                                                                data-budget-margin="{{ $budget?->profit_margin_percent ?? 0 }}"
                                                                data-budget-selling="{{ $budget?->selling_price ?? 0 }}"
                                                            >
                                                                {{ $project->project_number }} - {{ $project->project_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                                <input type="hidden" name="project_budget_id" id="project_budget_id" value="{{ isset($quotation) ? $quotation->project_budget_id : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card bg-light border-0">
                                                <div class="card-body">
                                                    <h6 class="mb-3">Project & Budget Info</h6>
                                                    <div class="mb-3 p-2 border rounded bg-white">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p class="text-muted mb-1 fs-12">Project Code</p>
                                                                <h6 class="mb-0 fs-13" id="display_project_code">-</h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="text-muted mb-1 fs-12">Project Name</p>
                                                                <h6 class="mb-0 fs-13 text-truncate" id="display_project_name">-</h6>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <p class="text-muted mb-1 fs-12">Original Project Value (Budget Selling Price)</p>
                                                                <h6 class="mb-0 fs-13 text-primary" id="display_project_value">Rp 0</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <div class="p-2 border rounded bg-white">
                                                                <p class="text-muted mb-1 fs-12">Labor Cost</p>
                                                                <h6 class="mb-0 fs-13" id="display_labor">Rp 0</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="p-2 border rounded bg-white">
                                                                <p class="text-muted mb-1 fs-12">Equipment Cost</p>
                                                                <h6 class="mb-0 fs-13" id="display_equipment">Rp 0</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="p-2 border rounded bg-white">
                                                                <p class="text-muted mb-1 fs-12">Maintenance</p>
                                                                <h6 class="mb-0 fs-13" id="display_maintenance">Rp 0</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="p-2 border rounded bg-white">
                                                                <p class="text-muted mb-1 fs-12">Operational</p>
                                                                <h6 class="mb-0 fs-13" id="display_operational">Rp 0</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="p-2 border rounded bg-white">
                                                                <p class="text-muted mb-1 fs-12">Mobilization</p>
                                                                <h6 class="mb-0 fs-13" id="display_mobi">Rp 0</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="p-2 border rounded bg-white">
                                                                <p class="text-muted mb-1 fs-12">Other Cost</p>
                                                                <h6 class="mb-0 fs-13" id="display_other">Rp 0</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="my-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Total HPP (COGS):</span>
                                                        <span class="fw-bold text-primary" id="display_hpp">Rp 0</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">Target Margin:</span>
                                                        <span class="fw-bold text-success" id="display_margin_info">0%</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Selling Price:</span>
                                                        <span class="fw-bold text-info" id="display_selling">Rp 0</span>
                                                    </div>
                                                    <div class="alert alert-warning mb-0 d-none" id="no_budget_alert">
                                                        <i class="ri-alert-line me-1"></i> Selected project has no approved budget.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="step2-tab">
                                            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next Step
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Unit & Pricing -->
                                <div class="tab-pane fade" id="step2" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <h5>Unit Selection & Pricing</h5>
                                                <button type="button" class="btn btn-sm btn-success" id="add_item_btn">
                                                    <i class="ri-add-line me-1"></i> Add Unit
                                                </button>
                                            </div>
                                            
                                            <div class="table-responsive" style="overflow: visible;">
                                                <table class="table table-bordered align-middle" id="items_table" style="z-index: 1050;">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="30%">Unit/Equipment</th>
                                                            <th width="15%">Rate (Rp)</th>
                                                            <th width="10%">Qty</th>
                                                            <th width="15%">Duration</th>
                                                            <th width="15%">Total (Rp)</th>
                                                            <th width="5%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Items will be added here via JS -->
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="4" class="text-end fw-bold">Total Project Value</td>
                                                            <td class="fw-bold fs-16" id="total_project_value_display">Rp 0</td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-light btn-label previoustab" data-previous="step1-tab">
                                            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Project
                                        </button>
                                        <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="step3-tab">
                                            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next Step
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 3: Profit Planning -->
                                <div class="tab-pane fade" id="step3" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="mb-3">Profit Margin Simulation</h5>
                                            <div class="mb-4">
                                                <label class="form-label d-flex justify-content-between">
                                                    <span>Desired Profit Margin (%)</span>
                                                    <span class="fw-bold" id="margin_display">0%</span>
                                                </label>
                                                <input type="range" class="form-range" min="0" max="100" step="0.5" id="profit_margin_percent" name="profit_margin_percent" value="{{ isset($quotation) ? $quotation->profit_margin_percent : 0 }}">
                                            </div>
                                            
                                            <div class="card bg-soft-info border-info">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Quotation Price (HPP):</span>
                                                        <span class="fw-bold" id="sim_hpp">Rp 0</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span>Target Profit:</span>
                                                        <span class="fw-bold text-success" id="sim_profit">Rp 0</span>
                                                    </div>
                                                    <hr class="border-info">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fs-16 fw-bold">Selling Price:</span>
                                                        <span class="fs-16 fw-bold text-primary" id="sim_selling">Rp 0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="alert alert-info mt-3">
                                                 <i class="ri-information-line me-1"></i> 
                                                 "Total Project Value" from the previous step is effectively the "Selling Price". 
                                                 Adjusting this margin slider calculates what the Selling Price <i>should be</i> based on HPP. 
                                                 Use this to verify if your Item Pricing meets your margin targets.
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                             <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title mb-0">Project Value Analysis</h6>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Simple Text Chart for now -->
                                                    <p>Current Item Total: <strong id="analysis_item_total" class="text-primary">0</strong></p>
                                                    <p>Target Selling Price: <strong id="analysis_target_total" class="text-success">0</strong></p>
                                                    <div id="margin_status_badge" class="badge bg-secondary">Undetermined</div>
                                                </div>
                                             </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-light btn-label previoustab" data-previous="step2-tab">
                                            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Pricing
                                        </button>
                                        <button type="button" class="btn btn-primary btn-label right ms-auto nexttab" data-nexttab="step4-tab">
                                            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next Step
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 4: Summary & Submit -->
                                <div class="tab-pane fade" id="step4" role="tabpanel">
                                    <div class="text-center pt-3 pb-4">
                                        <h5>Review & Submit Quotation</h5>
                                        <p class="text-muted">Please review all details before submitting.</p>
                                    </div>
                                    
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="card border">
                                                <div class="card-body">
                                                    <h6 class="mb-3">Quotation Summary</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless table-sm">
                                                            <tr>
                                                                <td class="text-muted">Project:</td>
                                                                <td class="fw-medium" id="summary_project">Select Project</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">Total HPP:</td>
                                                                <td class="fw-medium" id="summary_hpp">Rp 0</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">Profit Margin:</td>
                                                                <td class="fw-medium" id="summary_margin">0%</td>
                                                            </tr>
                                                            <tr class="table-active">
                                                                <td class="fs-15 fw-bold">Grand Total (Selling Price):</td>
                                                                <td class="fs-15 fw-bold text-primary" id="summary_total">Rp 0</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Terms & Conditions</label>
                                                <textarea class="form-control" name="terms_conditions" rows="3" placeholder="Enter specific terms...">{{ isset($quotation) ? $quotation->terms_conditions : '' }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Valid Until</label>
                                                <input type="date" class="form-control" name="valid_until" value="{{ isset($quotation) && $quotation->valid_until ? $quotation->valid_until->format('Y-m-d') : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-light btn-label previoustab" data-previous="step3-tab">
                                            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Profit
                                        </button>
                                        <button type="submit" class="btn btn-success btn-label right ms-auto">
                                            <i class="ri-check-double-line label-icon align-middle fs-16 ms-2"></i>Submit Quotation
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for Items -->
<template id="item_row_template">
    <tr>
        <td>
            <select class="item-unit-select-init" name="items[{index}][unit_name]" data-toggle="select2" data-placeholder="Select Unit" required>
                <option value="">Select Unit</option>
            </select>
            <input type="hidden" name="items[{index}][unit_id]" class="item-unit-id">
            <input type="hidden" name="items[{index}][uid_unit]" class="item-unit-uid">
        </td>
        <td>
            <input type="text" class="form-control item-rate" name="items[{index}][rate]" placeholder="0" required>
        </td>
        <td>
            <input type="text" class="form-control item-qty" name="items[{index}][quantity]" value="1" required>
        </td>
        <td>
            <div class="input-group">
                <input type="number" class="form-control item-duration" name="items[{index}][duration]" value="1" min="1" required>
            </div>
        </td>
        <td class="text-end align-middle item-total">Rp 0</td>
        <td class="text-center align-middle">
            <button type="button" class="btn btn-sm btn-soft-danger remove-item"><i class="ri-delete-bin-line"></i></button>
        </td>
    </tr>
</template>

@push('scripts')
<script>
    // Configuration from Backend
    const WORKSHOP_API_URL = "{{ config('services.workshop.api_url') }}";
    
    // CRITICAL: Immediate check to confirm script is even present
    console.log('Wizard Script Inline Checking... API URL:', WORKSHOP_API_URL);
    
    $(document).ready(function() {
        console.log('Quotation Wizard DOM Ready');

        // ==========================================
        // Helper Functions (Hoisted)
        // ==========================================
        function formatCurrency(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        }

        function formatNumberID(value) {
            if (!value) return "";
            // Parse as float, round to integer, then format with dots
            var num = typeof value === 'string' ? parseFloat(value.replace(/[^0-9.]/g, '')) : value;
            var val = Math.round(num || 0).toString();
            return val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function unformatNumber(value) {
            if (!value) return 0;
            return parseFloat(value.toString().replace(/\./g, '')) || 0;
        }

        function calculateRow(row) {
            var rateStr = row.find('.item-rate').val() || "0";
            var rate = parseFloat(rateStr.replace(/\./g, '')) || 0;
            
            var qtyStr = row.find('.item-qty').val() || "0";
            var qty = parseFloat(qtyStr) || 0;
            
            var durStr = row.find('.item-duration').val() || "0";
            var dur = parseFloat(durStr) || 0;
            
            var total = rate * qty * dur;
            row.find('.item-total').text(formatCurrency(total));
            row.data('total', total);
        }

        function calculateGrandTotal() {
            var total = 0;
            $('#items_table tbody tr').each(function() {
                total += ($(this).data('total') || 0);
            });
            
            $('#total_project_value_display').text(formatCurrency(total));
            $('#analysis_item_total').text(formatCurrency(total));
            $('#analysis_item_total').data('value', total);
            recalculateSimulation();
        }

        // ==========================================
        // Wizard Navigation
        // ==========================================
        $('.nexttab').click(function() {
            console.log('Next Tab Clicked');
            var nextId = $(this).data('nexttab');
            var nextTabElement = document.querySelector('#' + nextId);
            if (nextTabElement) {
                var nextTab = new bootstrap.Tab(nextTabElement);
                nextTab.show();
            }
        });

        $('.previoustab').click(function() {
            var prevId = $(this).data('previous');
            var prevTabElement = document.querySelector('#' + prevId);
            if (prevTabElement) {
                var prevTab = new bootstrap.Tab(prevTabElement);
                prevTab.show();
            }
        });

        // ==========================================
        // Project Selection Logic
        // ==========================================
        
        function handleProjectChange() {
            console.log('Handle Project Change Triggered');
            var select = $('#project_id');
            var projectId = select.val();
            
            // If select is empty/disabled, try hidden input
            if (!projectId && $('#project_id_hidden').length > 0) {
                projectId = $('#project_id_hidden').val();
                // If we are using hidden ID, we need to find the option in the hidden/disabled select
                // to get the data attributes.
            }

            var selectedOption = select.find('option[value="' + projectId + '"]');
            
            if (!selectedOption.length || !projectId) {
                console.log('No project selected or found');
                resetProjectInfo();
                return;
            }

            var projectNumber = selectedOption.data('project-number') || '-';
            var projectActualName = selectedOption.data('project-name') || '-';
            var budgetId = selectedOption.data('budget-id');
            var hpp = parseFloat(selectedOption.data('budget-hpp')) || 0;
            var labor = parseFloat(selectedOption.data('budget-labor')) || 0;
            var equipment = parseFloat(selectedOption.data('budget-equipment')) || 0;
            var maintenance = parseFloat(selectedOption.data('budget-maintenance')) || 0;
            var operational = parseFloat(selectedOption.data('budget-operational')) || 0;
            var mobilization = parseFloat(selectedOption.data('budget-mobilization')) || 0;
            var other = parseFloat(selectedOption.data('budget-other')) || 0;
            var margin = parseFloat(selectedOption.data('budget-margin')) || 0;
            var selling = parseFloat(selectedOption.data('budget-selling')) || 0;
            var projectName = selectedOption.text();
            
            console.log('Selected Project Details:', {
                name: projectName,
                budgetId: budgetId,
                hpp: hpp
            });

            $('#project_budget_id').val(budgetId);
            
            // Update Displays
            $('#display_project_code').text(projectNumber);
            $('#display_project_name').text(projectActualName);
            $('#display_project_value').text(formatCurrency(selling));
            $('#display_labor').text(formatCurrency(labor));
            $('#display_equipment').text(formatCurrency(equipment));
            $('#display_maintenance').text(formatCurrency(maintenance));
            $('#display_operational').text(formatCurrency(operational));
            $('#display_mobi').text(formatCurrency(mobilization));
            $('#display_other').text(formatCurrency(other));
            $('#display_hpp').text(formatCurrency(hpp));
            $('#display_margin_info').text(margin + '%');
            $('#display_selling').text(formatCurrency(selling));
            
            $('#summary_project').text(projectName);
            $('#summary_hpp').text(formatCurrency(hpp));
            
            // Sim data
            $('#sim_hpp').text(formatCurrency(hpp));
            console.log('Project HPP:', hpp, 'Budget Margin:', margin);
            window.currentHpp = hpp;
            
            if (!budgetId || budgetId === "") {
                $('#no_budget_alert').removeClass('d-none');
            } else {
                $('#no_budget_alert').addClass('d-none');
            }
            
            recalculateSimulation();
            
            // Set margin from budget if not in edit mode
            @if(!isset($quotation))
                console.log('New Quotation Mode: Setting slider to budget margin:', margin);
                $('#profit_margin_percent').val(margin).trigger('input');
            @endif
        }

        function resetProjectInfo() {
            $('#display_project_code').text('-');
            $('#display_project_name').text('-');
            $('#display_project_value').text('Rp 0');
            $('#display_labor').text('Rp 0');
            $('#display_equipment').text('Rp 0');
            $('#display_maintenance').text('Rp 0');
            $('#display_operational').text('Rp 0');
            $('#display_mobi').text('Rp 0');
            $('#display_other').text('Rp 0');
            $('#display_hpp').text('Rp 0');
            $('#display_margin_info').text('0%');
            $('#display_selling').text('Rp 0');
            
            $('#summary_project').text('Select Project');
            $('#summary_hpp').text('Rp 0');
            $('#sim_hpp').text('Rp 0');
            window.currentHpp = 0;
            $('#no_budget_alert').addClass('d-none');
            recalculateSimulation();
        }

        // Bindings
        // 1. Standard jQuery
        $(document).on('change', '#project_id', function() {
            console.log('jQuery Change Event');
            handleProjectChange();
        });

        // 2. Select2 specific binding (theme likely uses Select2)
        $(document).on('select2:select', '#project_id', function() {
            console.log('Select2 Select Event');
            handleProjectChange();
        });

        // Initial trigger
        if ($('#project_id_hidden').length > 0 || ($('#project_id').val() && $('#project_id').val() !== "")) {
            console.log('Initial trigger for project load. Project ID:', $('#project_id').val() || $('#project_id_hidden').val());
            handleProjectChange();
            
            @if(isset($quotation))
                // For edit mode, we need to ensure simulation and analysis are updated after items load
                // The actual item loading happens in the $.get block below
                var prevMargin = @json($quotation->profit_margin_percent);
                $('#summary_margin').text(prevMargin + '%');
                $('#margin_display').text(prevMargin + '%');
                $('#profit_margin_percent').val(prevMargin).trigger('input');
            @endif
        }

        function addItemRow(data = null) {
            console.log('addItemRow called with data:', data);
            
            var index = $('#items_table tbody tr').length;
            var template = $('#item_row_template').html().replace(/{index}/g, index);
            var $row = $(template);
            
            // Append row to table
            $('#items_table tbody').append($row);
            
            var $select = $row.find('.item-unit-select-init');
            
            // Safely populate options
            $select.empty().append('<option value="">Select Unit</option>');
            if (typeof unitsData !== 'undefined' && Array.isArray(unitsData) && unitsData.length > 0) {
                unitsData.forEach(function(u) {
                    var isSelected = (data && data.unit_name === u.name);
                    $select.append(new Option(u.name, u.name, false, isSelected));
                });
            } else if (data && data.unit_name) {
                $select.append(new Option(data.unit_name, data.unit_name, true, true));
            }
            
            if (data) {
                $row.find('.item-rate').val(formatNumberID(data.rate));
                $row.find('.item-qty').val(data.quantity);
                $row.find('.item-duration').val(data.duration);
                $row.find('.item-unit-id').val(data.unit_id || '');
                $row.find('.item-unit-uid').val(data.uid_unit || '');
            }
            
            // Re-calculate row once
            calculateRow($row);
            
            // Initialize Select2 after a safe delay
            setTimeout(function() {
                if (typeof $.fn.select2 === 'function') {
                    console.log('Force Initializing Select2 for row', index);
                    $select.select2({
                        placeholder: "Pilih Unit / Peralatan",
                        width: '100%',
                        allowClear: true
                    });
                    
                    if (data && data.unit_name) {
                        $select.val(data.unit_name).trigger('change.select2');
                    }
                } else {
                    console.error('Select2 library is not available during addItemRow');
                }
            }, 300);

            // Listeners for Select2
            $select.on('select2:select', function(e) {
                var selectedValue = e.params.data.id;
                var isDuplicate = false;
                var currentSelect = $(this);

                // Find the unit data to get the ID and UID
                var selectedUnit = unitsData.find(u => u.name === selectedValue);
                if (selectedUnit) {
                    $row.find('.item-unit-id').val(selectedUnit.id);
                    $row.find('.item-unit-uid').val(selectedUnit.uid);
                }

                $('#items_table tbody tr').each(function() {
                    var otherSelect = $(this).find('.item-unit-select-init');
                    if (otherSelect.length && otherSelect[0] !== currentSelect[0]) {
                        if (otherSelect.val() === selectedValue) {
                            isDuplicate = true;
                            return false;
                        }
                    }
                });

                if (isDuplicate) {
                    Swal.fire({
                        title: 'Duplicate Unit',
                        text: 'This unit is already added to the list.',
                        icon: 'warning',
                        confirmButtonColor: '#405189'
                    });
                    currentSelect.val(null).trigger('change');
                    $row.find('.item-unit-id').val('');
                    $row.find('.item-unit-uid').val('');
                }
            });

            // Handle clear
            $select.on('select2:unselect', function() {
                $row.find('.item-unit-id').val('');
                $row.find('.item-unit-uid').val('');
            });
        }

        // Initialize any existing rows on tab show
        $('button[data-bs-target="#step2"]').on('shown.bs.tab', function() {
            setTimeout(function() {
                $('#items_table .item-unit-select-init').each(function() {
                    if (!$(this).hasClass('select2-hidden-accessible') && typeof $.fn.select2 === 'function') {
                        $(this).select2({
                            placeholder: "Pilih Unit / Peralatan",
                            width: '100%',
                            allowClear: true
                        });
                    }
                });
            }, 200);
        });

        // ==========================================
        // Units & Pricing Logic
        // ==========================================
        
        // Fetch Units through Backend Proxy to bypass CORS/Auth
        var unitsData = [];
        const unitsProxyRoute = "{{ route('quotations.units') }}";
        
        console.log('Fetching units via proxy:', unitsProxyRoute);

        $.get(unitsProxyRoute).done(function(data) {
            console.log('Units fetched through proxy:', data);
            // Handle both flat array and Laravel-style { data: [...] }
            if (Array.isArray(data)) {
                unitsData = data;
            } else if (data && Array.isArray(data.data)) {
                unitsData = data.data;
            } else {
                unitsData = [];
            }

            // Load Existing Items if in Edit Mode
            @if(isset($quotation))
                loadExistingItems();
            @endif
        }).fail(function(xhr) {
            console.log('Proxy fetch failed:', xhr.status, xhr.statusText);
            @if(isset($quotation))
                loadExistingItems(); // Still try to load items even if proxy fails
            @endif
        });

        function loadExistingItems() {
            console.log('Loading existing items...');
            @if(isset($quotation))
                @foreach($quotation->items as $item)
                    addItemRow({
                        unit_name: "{{ $item->unit_name }}",
                        rate: "{{ $item->rate }}",
                        quantity: "{{ $item->quantity }}",
                        duration: "{{ $item->duration }}"
                    });
                @endforeach
                
                // Finalize recalculation
                setTimeout(function() {
                    calculateGrandTotal();
                    recalculateSimulation();
                }, 1000);
            @endif
        }
        
        $('#add_item_btn').click(function() {
            addItemRow();
        });
        
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            calculateGrandTotal();
        });
        
        $(document).on('input change', '.item-rate, .item-qty, .item-duration', function() {
            var row = $(this).closest('tr');
            
            if ($(this).hasClass('item-rate')) {
                var rawValue = this.value.replace(/[^0-9]/g, '');
                this.value = formatNumberID(rawValue);
            }

            calculateRow(row);
            calculateGrandTotal();
        });

        $(document).on('keydown', '.item-rate, .item-qty, .item-duration', function(e) {
            var invalidChars = ['e', 'E', '+', '-'];
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });



        // ==========================================
        // Profit Planning Logic
        // ==========================================
        $('#profit_margin_percent').on('input', function() {
            recalculateSimulation();
        });
        
        function recalculateSimulation() {
            var hpp = window.currentHpp || 0;
            var margin = parseFloat($('#profit_margin_percent').val()) || 0;
            var projectValue = parseFloat($('#analysis_item_total').data('value')) || 0;
            
            $('#margin_display').text(margin + '%');
            $('#summary_margin').text(margin + '%');
            $('#summary_hpp').text(formatCurrency(hpp));
            
            var targetSellingPrice = 0;
            if (hpp > 0) {
                targetSellingPrice = hpp * (1 + (margin / 100));
            } else {
                targetSellingPrice = projectValue;
            }
            
            var targetProfit = targetSellingPrice - hpp;
            
            $('#sim_selling').text(formatCurrency(targetSellingPrice));
            $('#sim_profit').text(formatCurrency(targetProfit));
            $('#analysis_target_total').text(formatCurrency(targetSellingPrice));
            $('#sim_hpp').text(formatCurrency(hpp));
            
            var diff = projectValue - targetSellingPrice;
            var statusBadge = $('#margin_status_badge');
            
            if (Math.abs(diff) < 1000) {
                 statusBadge.removeClass().addClass('badge bg-success').text('Balanced');
                 $('#summary_total').text(formatCurrency(projectValue)); 
            } else if (projectValue > targetSellingPrice) {
                 var extra = projectValue - targetSellingPrice;
                 statusBadge.removeClass().addClass('badge bg-success').text('Surplus: ' + formatCurrency(extra));
                 $('#summary_total').text(formatCurrency(projectValue)); 
            } else {
                 var deficit = targetSellingPrice - projectValue;
                 statusBadge.removeClass().addClass('badge bg-danger').text('Deficit: ' + formatCurrency(deficit));
                 $('#summary_total').text(formatCurrency(projectValue)); 
            }
        }

        
        $('#quotationForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var btn = form.find('button[type="submit"]');
            
            btn.prop('disabled', true);
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: (function() {
                    // Get all form data as an array
                    var formData = form.serializeArray();
                    
                    // Sanitize numeric fields by removing thousand separators
                    $.each(formData, function(i, field) {
                        // Rate has dots as thousand separators (formatted by JS)
                        // Quantity and Duration use type="number" which use dots as decimals
                        if (field.name.includes('[rate]')) {
                            field.value = field.value.toString().replace(/\./g, '');
                        }
                    });
                    
                    return $.param(formData);
                })(),
                success: function(response) {
                    Swal.fire({
                        title: 'Success', 
                        text: response.message, 
                        icon: 'success'
                    }).then(() => {
                        if (response.redirect) window.location.href = response.redirect;
                    });
                },
                error: function(xhr) {
                    btn.prop('disabled', false);
                     var msg = xhr.responseJSON?.message || 'Submission failed';
                     if(xhr.responseJSON?.errors) {
                         msg = Object.values(xhr.responseJSON.errors)[0][0];
                     }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });

    });
</script>
@endpush

@endsection
