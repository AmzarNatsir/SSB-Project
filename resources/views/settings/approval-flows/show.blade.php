<?php $page = 'approval-flows'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Configure Approval Flow: {{ $flow->name }}</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('approval-flows.index') }}">Approval Matrix</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $flow->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <button type="button" class="btn btn-primary d-flex align-items-center" id="add-level-btn">
                        <i class="ti ti-plus me-1"></i>Add Approval Level
                    </button>
                    <button type="button" class="btn btn-success d-flex align-items-center" id="save-flow-btn">
                        <i class="ti ti-device-floppy me-1"></i>Save Matrix
                    </button>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0" id="levels-table">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 80px;">Level</th>
                                    <th>Approver Type</th>
                                    <th>Approver Target</th>
                                    <th>Requirement</th>
                                    <th style="width: 100px;">SLA (Hours)</th>
                                    <th style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="levels-body">
                                @forelse($flow->levels as $level)
                                <tr class="level-row" data-id="{{ $level->id }}">
                                    <td class="level-number fw-bold">{{ $level->level_number }}</td>
                                    <td>
                                        <select class="form-select select-approver-type" name="levels[{{ $loop->index }}][approver_type]">
                                            @foreach(\App\Enums\ApproverType::cases() as $type)
                                                <option value="{{ $type->value }}" {{ $level->approver_type == $type ? 'selected' : '' }}>
                                                    {{ $type->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="target-container">
                                            @if($level->approver_type == \App\Enums\ApproverType::USER)
                                                <select class="form-control select2 select-target select-user" name="levels[{{ $loop->index }}][approver_user_id]">
                                                    <option value="">Select User</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ $level->approver_user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif($level->approver_type == \App\Enums\ApproverType::ROLE)
                                                <select class="form-control select2 select-target select-role" name="levels[{{ $loop->index }}][approver_role_id]">
                                                    <option value="">Select Role</option>
                                                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                        <option value="{{ $role->id }}" {{ $level->approver_role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <span class="text-muted italic">Dynamic resolution by department</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="levels[{{ $loop->index }}][is_mandatory]" value="1" {{ $level->is_mandatory ? 'checked' : '' }}>
                                            <label class="form-check-label">Mandatory</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="levels[{{ $loop->index }}][sla_hours]" value="{{ $level->sla_hours }}" min="0">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-icon btn-sm btn-danger remove-level-btn">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="no-levels-msg">
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ti ti-layers-off fs-40 mb-2"></i>
                                            <p>No approval levels configured for this flow.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Template for new row -->
    <template id="level-row-template">
        <tr class="level-row">
            <td class="level-number fw-bold"></td>
            <td>
                <select class="form-select select-approver-type" name="levels[INDEX][approver_type]">
                    @foreach(\App\Enums\ApproverType::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <div class="target-container">
                    <select class="form-control select-target select-user" name="levels[INDEX][approver_user_id]">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="levels[INDEX][is_mandatory]" value="1" checked>
                    <label class="form-check-label">Mandatory</label>
                </div>
            </td>
            <td>
                <input type="number" class="form-control" name="levels[INDEX][sla_hours]" value="24" min="0">
            </td>
            <td>
                <button type="button" class="btn btn-icon btn-sm btn-danger remove-level-btn">
                    <i class="ti ti-trash"></i>
                </button>
            </td>
        </tr>
    </template>

    @push('scripts')
    <script>
        $(document).ready(function() {
            function initializeSelect2(container) {
                if ($.fn.select2) {
                    container.find('.select2').select2({
                        width: '100%',
                        dropdownParent: container.closest('.card') || $('body')
                    });
                    
                    // Specific initialization for target selectors that might not have select2 class yet
                    container.find('.select-target').select2({
                        width: '100%'
                    });
                }
            }

            function updateLevelNumbers() {
                $('.level-row').each(function(index) {
                    $(this).find('.level-number').text(index + 1);
                    // Update field names to maintain sequence
                    $(this).find('select, input').each(function() {
                        let name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/levels\[\d+\]/, 'levels[' + index + ']'));
                        }
                    });
                });
                
                if ($('.level-row').length > 0) {
                    $('#no-levels-msg').hide();
                } else {
                    $('#no-levels-msg').show();
                }
            }

            // Handle Approver Type Change
            $('body').on('change', '.select-approver-type', function() {
                const row = $(this).closest('tr');
                const type = $(this).val();
                const container = row.find('.target-container');
                const index = $('.level-row').index(row);
                
                let html = '';
                if (type === 'USER') {
                    html = `<select class="form-control select-target select-user" name="levels[${index}][approver_user_id]">
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>`;
                } else if (type === 'ROLE') {
                    html = `<select class="form-control select-target select-role" name="levels[${index}][approver_role_id]">
                                <option value="">Select Role</option>
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>`;
                } else {
                    html = '<span class="text-muted italic">Dynamic resolution by department</span>';
                }
                
                container.html(html);
                if (type !== 'DEPARTMENT') {
                    initializeSelect2(container);
                }
            });

            // Initial Select2 for existing rows
            initializeSelect2($('#levels-body'));

            $('#add-level-btn').on('click', function() {
                let index = $('.level-row').length;
                let template = $('#level-row-template').html();
                let html = template.replace(/INDEX/g, index);
                let $newRow = $(html);
                $('#levels-body').append($newRow);
                updateLevelNumbers();
                initializeSelect2($newRow);
            });

            $('body').on('click', '.remove-level-btn', function() {
                $(this).closest('tr').remove();
                updateLevelNumbers();
            });

            $('#save-flow-btn').on('click', function() {
                let btn = $(this);
                let originalHtml = btn.html();
                
                // Basic data collection
                let formData = {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    levels: []
                };

                $('.level-row').each(function() {
                    let row = $(this);
                    let type = row.find('.select-approver-type').val();
                    let targetId = null;
                    
                    if (type === 'USER') {
                        targetId = row.find('.select-user').val();
                    } else if (type === 'ROLE') {
                        targetId = row.find('.select-role').val();
                    }

                    formData.levels.push({
                        approver_type: type,
                        approver_user_id: type === 'USER' ? targetId : null,
                        approver_role_id: type === 'ROLE' ? targetId : null,
                        is_mandatory: row.find('.form-check-input').is(':checked') ? 1 : 0,
                        sla_hours: row.find('input[type="number"]').val()
                    });
                });

                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

                $.ajax({
                    url: "{{ route('approval-flows.update', $flow->id) }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message || 'Something went wrong!'
                        });
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });
        });
    </script>
    @endpush

@endsection
