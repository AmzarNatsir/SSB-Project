<?php $page = 'surveyor-flows'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Pengaturan Surveyor</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pengaturan Surveyor</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <button type="button" class="btn btn-primary d-flex align-items-center" id="add-row-btn">
                        <i class="ti ti-plus me-1"></i>Tambah Mapping
                    </button>
                    <button type="button" class="btn btn-success d-flex align-items-center" id="save-matrix-btn">
                        <i class="ti ti-device-floppy me-1"></i>Simpan Pengaturan
                    </button>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Info Banner -->
            <div class="alert alert-info d-flex align-items-start gap-2 mb-4 border-0 shadow-sm" role="alert">
                <i class="ti ti-info-circle fs-18 mt-1 flex-shrink-0"></i>
                <div>
                    <strong>Tentang Pengaturan Ini</strong><br>
                    <span class="fs-13">Tentukan siapa yang akan menjadi <strong>surveyor</strong> untuk setiap departemen pada tahap survey project. Pilih berdasarkan <em>User</em> spesifik atau <em>Role</em> tertentu. Klik <strong>"+ Tambah Mapping"</strong> untuk menambahkan baris baru.</span>
                </div>
            </div>

            <!-- Matrix Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm bg-primary-transparent text-primary rounded">
                            <i class="ti ti-users-group fs-18"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Matriks Surveyor per Departemen</h5>
                            <span class="fs-12 text-muted" id="row-count-label">
                                {{ $flows->count() }} mapping dikonfigurasi
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0" id="surveyor-matrix-table">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th style="width:240px;">Departemen</th>
                                    <th style="width:200px;">Tipe Surveyor</th>
                                    <th>Target (User / Role)</th>
                                    <th style="width:80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="rows-body">

                                {{-- Render existing saved rows --}}
                                @forelse($flows as $i => $flow)
                                <tr class="mapping-row align-middle">
                                    <td class="row-number fw-semibold text-muted">{{ $i + 1 }}</td>
                                    <td>
                                        <select class="form-select select-department"
                                                name="flows[{{ $i }}][department]">
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->value }}"
                                                    {{ $flow->department === $dept->value ? 'selected' : '' }}>
                                                    {{ $dept->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select select-surveyor-type"
                                                name="flows[{{ $i }}][surveyor_type]">
                                            @foreach($surveyorTypes as $type)
                                                <option value="{{ $type->value }}"
                                                    {{ $flow->surveyor_type->value === $type->value ? 'selected' : '' }}>
                                                    {{ $type->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="target-container">
                                            @if($flow->surveyor_type->value === 'USER')
                                                <select class="form-control select2-target select-user"
                                                        name="flows[{{ $i }}][user_id]">
                                                    <option value="">-- Pilih User --</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $flow->user_id == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select class="form-control select2-target select-role"
                                                        name="flows[{{ $i }}][role_id]">
                                                    <option value="">-- Pilih Role --</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $flow->role_id == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-icon btn-sm btn-danger remove-row-btn"
                                                title="Hapus baris ini">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-state-row">
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ti ti-users-off fs-40 d-block mb-2 text-light-emphasis"></i>
                                            <p class="mb-1">Belum ada mapping surveyor.</p>
                                            <small>Klik <strong>"+ Tambah Mapping"</strong> untuk menambahkan.</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Matrix Card -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    {{-- ── Hidden Row Template (cloned by JS) ─────────────────────────────── --}}
    <template id="row-template">
        <tr class="mapping-row align-middle">
            <td class="row-number fw-semibold text-muted"></td>
            <td>
                <select class="form-select select-department" name="flows[INDEX][department]">
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->value }}">{{ $dept->label() }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-select select-surveyor-type" name="flows[INDEX][surveyor_type]">
                    @foreach($surveyorTypes as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <div class="target-container">
                    {{-- Default: User select rendered here, replaced by JS on type change --}}
                    <select class="form-control select2-target select-user" name="flows[INDEX][user_id]">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td>
                <button type="button"
                        class="btn btn-icon btn-sm btn-danger remove-row-btn"
                        title="Hapus baris ini">
                    <i class="ti ti-trash"></i>
                </button>
            </td>
        </tr>
    </template>

    @push('scripts')
    <script>
        $(document).ready(function () {

            // ── Data injected from Blade ──────────────────────────────────────
            const USERS = @json($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name]));
            const ROLES = @json($roles->map(fn($r) => ['id' => $r->id, 'name' => $r->name]));
            const CSRF  = '{{ csrf_token() }}';

            // ── Helpers ───────────────────────────────────────────────────────

            /** Init Select2 on all .select2-target inside a row element */
            function initSelect2(rowEl) {
                $(rowEl).find('.select2-target').each(function () {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                    $(this).select2({ width: '100%', placeholder: '-- Pilih --' });
                });
            }

            /** Re-number all rows and update field `name` indexes */
            function updateRowNumbers() {
                const rows = $('#rows-body .mapping-row');
                rows.each(function (idx) {
                    $(this).find('.row-number').text(idx + 1);
                    // Update every named input/select in this row
                    $(this).find('[name]').each(function () {
                        const oldName = $(this).attr('name');
                        if (oldName) {
                            $(this).attr('name', oldName.replace(/flows\[\d+\]/, `flows[${idx}]`));
                        }
                    });
                });

                const count = rows.length;
                $('#row-count-label').text(`${count} mapping dikonfigurasi`);

                // Update empty state visibility
                if (count > 0) {
                    $('#empty-state-row').hide();
                } else {
                    // Re-append empty state if all removed
                    if ($('#empty-state-row').length === 0) {
                        $('#rows-body').append(`
                            <tr id="empty-state-row">
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-users-off fs-40 d-block mb-2 text-light-emphasis"></i>
                                        <p class="mb-1">Belum ada mapping surveyor.</p>
                                        <small>Klik <strong>"+ Tambah Mapping"</strong> untuk menambahkan.</small>
                                    </div>
                                </td>
                            </tr>`);
                    } else {
                        $('#empty-state-row').show();
                    }
                }
            }

            /** Disable already-selected department options across all rows */
            function refreshDeptOptions() {
                // Collect all currently chosen values (skip empty)
                const chosen = [];
                $('#rows-body .select-department').each(function () {
                    const val = $(this).val();
                    if (val) chosen.push(val);
                });

                // For each select, enable all first, then disable others' chosen
                $('#rows-body .select-department').each(function () {
                    const thisVal = $(this).val();
                    $(this).find('option').each(function () {
                        const optVal = $(this).val();
                        if (optVal && optVal !== thisVal && chosen.includes(optVal)) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }
                    });
                });
            }

            /** Build target HTML for type USER or ROLE, pre-selecting `selectedId` */
            function buildTargetHtml(type, index, selectedId = null) {
                if (type === 'USER') {
                    const opts = USERS.map(u =>
                        `<option value="${u.id}" ${selectedId == u.id ? 'selected' : ''}>${u.name}</option>`
                    ).join('');
                    return `<select class="form-control select2-target select-user" name="flows[${index}][user_id]">
                                <option value="">-- Pilih User --</option>${opts}
                            </select>`;
                } else {
                    const opts = ROLES.map(r =>
                        `<option value="${r.id}" ${selectedId == r.id ? 'selected' : ''}>${r.name}</option>`
                    ).join('');
                    return `<select class="form-control select2-target select-role" name="flows[${index}][role_id]">
                                <option value="">-- Pilih Role --</option>${opts}
                            </select>`;
                }
            }

            // ── Initialize existing rows ──────────────────────────────────────
            $('#rows-body .mapping-row').each(function () {
                initSelect2(this);
            });
            refreshDeptOptions();

            // ── Add Row ───────────────────────────────────────────────────────
            $('#add-row-btn').on('click', function () {
                $('#empty-state-row').remove();

                const index    = $('#rows-body .mapping-row').length;
                const template = document.getElementById('row-template').innerHTML;
                const html     = template.replace(/INDEX/g, index);
                const $row     = $(html);

                $('#rows-body').append($row);
                updateRowNumbers();
                initSelect2($row[0]);
                refreshDeptOptions();

                // Scroll the new row into view
                $row[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });

            // ── Remove Row ────────────────────────────────────────────────────
            $('body').on('click', '.remove-row-btn', function () {
                $(this).closest('.mapping-row').remove();
                updateRowNumbers();
                refreshDeptOptions();
            });

            // ── Type Change → swap target select ─────────────────────────────
            $('body').on('change', '.select-surveyor-type', function () {
                const $row      = $(this).closest('.mapping-row');
                const index     = $('#rows-body .mapping-row').index($row);
                const type      = $(this).val();
                const $target   = $row.find('.target-container');

                $target.html(buildTargetHtml(type, index));
                initSelect2($row[0]);
            });

            // ── Department Change → refresh disabled options ───────────────
            $('body').on('change', '.select-department', function () {
                refreshDeptOptions();
            });

            // ── Save ──────────────────────────────────────────────────────────
            $('#save-matrix-btn').on('click', function () {
                const $btn        = $(this);
                const originalHtml = $btn.html();

                let flowsData = [];
                let isValid   = true;
                let errorMsg  = '';

                $('#rows-body .mapping-row').each(function (idx) {
                    const $row   = $(this);
                    const dept   = $row.find('.select-department').val();
                    const type   = $row.find('.select-surveyor-type').val();
                    const userId = $row.find('.select-user').val()  || null;
                    const roleId = $row.find('.select-role').val()  || null;

                    if (!dept) {
                        errorMsg = `Baris ke-${idx + 1}: Pilih departemen terlebih dahulu.`;
                        isValid  = false;
                        return false;
                    }
                    if (type === 'USER' && !userId) {
                        errorMsg = `Baris ke-${idx + 1} (${dept}): Pilih user target.`;
                        isValid  = false;
                        return false;
                    }
                    if (type === 'ROLE' && !roleId) {
                        errorMsg = `Baris ke-${idx + 1} (${dept}): Pilih role target.`;
                        isValid  = false;
                        return false;
                    }

                    flowsData.push({
                        department:    dept,
                        surveyor_type: type,
                        user_id:       type === 'USER' ? userId : null,
                        role_id:       type === 'ROLE' ? roleId : null,
                    });
                });

                if (!isValid) {
                    Swal.fire({ icon: 'warning', title: 'Data Tidak Lengkap', text: errorMsg });
                    return;
                }

                $btn.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

                $.ajax({
                    url:    '{{ route("surveyor-flows.update-all") }}',
                    method: 'POST',
                    data: {
                        _token:  CSRF,
                        _method: 'PUT',
                        flows:   flowsData,
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan!',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => location.reload());
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON?.errors;
                        let msg = xhr.responseJSON?.message || 'Terjadi kesalahan!';
                        if (errors) {
                            msg = Object.values(errors).flat().join('<br>');
                        }
                        Swal.fire({ icon: 'error', title: 'Error', html: msg });
                    },
                    complete: function () {
                        $btn.prop('disabled', false).html(originalHtml);
                    },
                });
            });

        });
    </script>
    @endpush

@endsection
