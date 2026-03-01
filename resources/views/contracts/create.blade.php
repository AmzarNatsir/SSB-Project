<?php $page = 'final-contracts'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Create Final Project Contract</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('final-contracts.index') }}">Final Contracts</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- /Page Header -->

            <form action="{{ route('final-contracts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-primary">Project Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Select Project (Negotiation Approved) <span class="text-danger">*</span></label>
                                        <select name="project_id" id="project_id" class="select form-control @error('project_id') is-invalid @enderror" required>
                                            <option value="">-- Select Project --</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                    {{ $project->project_number }} - {{ $project->project_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Client Name</label>
                                        <input type="text" id="client_name" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Client Code</label>
                                        <input type="text" id="client_code" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Client Address</label>
                                        <textarea id="client_address" class="form-control" rows="2" readonly></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Project Location</label>
                                        <input type="text" id="project_location" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Company Account</label>
                                        <input type="text" id="bank_account" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Scope of Work</label>
                                        <textarea id="scope_of_work" class="form-control" rows="3" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-primary">Unit Item List (Quotation Items)</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="items_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Unit Item</th>
                                                <th>QTY</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items_body">
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted small">Select a project to load items.</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="bg-light fw-bold" id="items_foot" style="display: none;">
                                            <tr>
                                                <td colspan="3" class="text-end">Final Agreed Price:</td>
                                                <td colspan="2" id="agreed_value_display" class="text-primary fs-16">Rp 0</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 text-primary">Contract Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Contract Effective Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contract Expiration Date <span class="text-danger">*</span></label>
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Upload Contract File (PDF/DOC)</label>
                                    <div class="form-file">
                                        <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                                        <small class="text-muted">Max file size: 10MB</small>
                                    </div>
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-device-floppy me-1"></i>Save Contract
                                </button>
                                <a href="{{ route('final-contracts.index') }}" class="btn btn-light w-100">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Page Wrapper -->

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#project_id').on('change', function() {
                const projectId = $(this).val();
                if (!projectId) {
                    resetForm();
                    return;
                }

                showLoading();

                $.ajax({
                    url: "{{ route('final-contracts.load-data') }}",
                    method: "GET",
                    data: { project_id: projectId },
                    success: function(response) {
                        $('#client_name').val(response.user_name);
                        $('#client_code').val(response.user_code);
                        $('#client_address').val(response.user_address);
                        $('#project_location').val(response.project_location);
                        $('#bank_account').val(response.bank_account);
                        $('#scope_of_work').val(response.scope_of_work);
                        
                        renderItems(response.items, response.agreed_value);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Loading Data',
                            text: xhr.responseJSON?.error || 'Something went wrong.'
                        });
                        resetForm();
                    }
                });
            });

            function renderItems(items, agreedValue) {
                let html = '';
                items.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.unit_name}</td>
                            <td>${item.quantity}</td>
                            <td>Rp ${formatNumber(item.rate)}</td>
                            <td>Rp ${formatNumber(item.total_price)}</td>
                            <td>${item.duration} ${item.duration_unit || 'MONTH'}</td>
                        </tr>
                    `;
                });
                $('#items_body').html(html);
                $('#agreed_value_display').text('Rp ' + formatNumber(agreedValue));
                $('#items_foot').show();
            }

            function resetForm() {
                $('#client_name, #client_code, #client_address, #project_location, #bank_account, #scope_of_work').val('');
                $('#items_body').html('<tr><td colspan="5" class="text-center py-4 text-muted small">Select a project to load items.</td></tr>');
                $('#items_foot').hide();
            }

            function showLoading() {
                $('#items_body').html('<tr><td colspan="5" class="text-center py-4"><span class="spinner-border spinner-border-sm me-1 text-primary"></span> Loading data...</td></tr>');
            }

            function formatNumber(num) {
                return new Number(num).toLocaleString('id-ID');
            }

            // Trigger change if there's an old value (e.g. after validation error)
            if ($('#project_id').val()) {
                $('#project_id').trigger('change');
            }
        });
    </script>
    @endpush

@endsection
