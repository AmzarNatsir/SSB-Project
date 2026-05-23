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
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pilih Proyek <span class="text-danger">*</span></label>
                                        <select name="project_id" id="project_id" class="select form-control @error('project_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Proyek --</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                    {{ $project->project_number }} - {{ $project->project_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hanya proyek dengan negosiasi Disetujui yang belum memiliki kontrak.</small>
                                        @error('project_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Pilih Negosiasi <span class="text-danger">*</span></label>
                                        <select name="negotiation_id" id="negotiation_id" class="form-control @error('negotiation_id') is-invalid @enderror" required disabled>
                                            <option value="">-- Pilih proyek dulu --</option>
                                        </select>
                                        <small class="text-muted">1 negosiasi = 1 kontrak. Pilih negosiasi yang belum dikonversi.</small>
                                        @error('negotiation_id')
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
            const oldNegotiationId = "{{ old('negotiation_id') }}";

            $('#project_id').on('change', function() {
                const projectId = $(this).val();
                resetForm();
                resetNegotiationDropdown();
                if (!projectId) return;

                $('#negotiation_id').prop('disabled', true).html('<option value="">Memuat...</option>');

                $.ajax({
                    url: "{{ route('final-contracts.eligible-negotiations') }}",
                    method: "GET",
                    data: { project_id: projectId },
                    success: function(response) {
                        const list = response.data || [];
                        if (list.length === 0) {
                            $('#negotiation_id').html('<option value="">Tidak ada negosiasi tersedia</option>').prop('disabled', true);
                            return;
                        }

                        let opts = '<option value="">-- Pilih Negosiasi --</option>';
                        list.forEach(function(n) {
                            const sel = (oldNegotiationId && String(n.id) === String(oldNegotiationId)) ? ' selected' : '';
                            opts += `<option value="${n.id}"${sel}>${n.negotiation_number} — ${n.negotiation_date} (Rp ${formatNumber(n.final_agreed_value)})</option>`;
                        });
                        $('#negotiation_id').html(opts).prop('disabled', false);

                        // Auto-trigger kalau cuma 1 opsi atau ada old value
                        if (list.length === 1) {
                            $('#negotiation_id').val(list[0].id).trigger('change');
                        } else if (oldNegotiationId) {
                            $('#negotiation_id').trigger('change');
                        }
                    },
                    error: function() {
                        $('#negotiation_id').html('<option value="">Gagal memuat</option>').prop('disabled', true);
                    }
                });
            });

            $('#negotiation_id').on('change', function() {
                const projectId = $('#project_id').val();
                const negotiationId = $(this).val();
                if (!projectId || !negotiationId) {
                    resetForm();
                    return;
                }

                showLoading();

                $.ajax({
                    url: "{{ route('final-contracts.load-data') }}",
                    method: "GET",
                    data: { project_id: projectId, negotiation_id: negotiationId },
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
                            title: 'Gagal Memuat Data',
                            text: xhr.responseJSON?.error || 'Terjadi kesalahan.'
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
                $('#items_body').html('<tr><td colspan="5" class="text-center py-4 text-muted small">Pilih proyek & negosiasi untuk memuat data.</td></tr>');
                $('#items_foot').hide();
            }

            function resetNegotiationDropdown() {
                $('#negotiation_id').html('<option value="">-- Pilih proyek dulu --</option>').prop('disabled', true);
            }

            function showLoading() {
                $('#items_body').html('<tr><td colspan="5" class="text-center py-4"><span class="spinner-border spinner-border-sm me-1 text-primary"></span> Memuat data...</td></tr>');
            }

            function formatNumber(num) {
                return new Number(num).toLocaleString('id-ID');
            }

            // Trigger change kalau ada old value (setelah validation error)
            if ($('#project_id').val()) {
                $('#project_id').trigger('change');
            }
        });
    </script>
    @endpush

@endsection
