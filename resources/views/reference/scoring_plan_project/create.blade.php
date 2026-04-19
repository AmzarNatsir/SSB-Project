<?php $page = 'scoring_plan_project'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Add Scoring Plan Project</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('scoring-plan-project.index') }}">Scoring Plan Project</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add New</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body bg-light-50">
                            <form action="{{ route('scoring-plan-project.store') }}" method="POST">
                                @csrf
                                <!-- Header Form -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title">Criteria Header</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Kriteria <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Profil Calon User" required>
                                                    @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Bobot <span class="text-danger">*</span></label>
                                                    <input type="text" name="weighting" class="form-control numeric-input" value="{{ old('weighting') }}" placeholder="Contoh: 8" required>
                                                    @error('weighting')<span class="text-danger small">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Detail Form -->
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Scoring Options (Detail)</h5>
                                        <button type="button" class="btn btn-sm btn-primary" id="add-option-btn">
                                            <i class="ti ti-plus me-1"></i> Add Option
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        @if($errors->has('options'))
                                            <div class="alert alert-danger">{{ $errors->first('options') }}</div>
                                        @endif
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0" id="options-table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th style="min-width: 150px;">Label <span class="text-danger">*</span></th>
                                                        <th style="min-width: 100px;">Score <span class="text-danger">*</span></th>
                                                        <th>Deskripsi <span class="text-danger">*</span></th>
                                                        <th style="width: 80px;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $oldOptions = old('options', [['label' => '', 'score' => '', 'description' => '']]); @endphp
                                                    @foreach($oldOptions as $index => $option)
                                                    <tr class="option-row">
                                                        <td>
                                                            <input type="text" name="options[{{ $index }}][label]" class="form-control" value="{{ $option['label'] }}" placeholder="Kurang/Cukup/Bagus" required>
                                                            @error("options.$index.label")<span class="text-danger small">{{ $message }}</span>@enderror
                                                        </td>
                                                        <td>
                                                            <input type="text" name="options[{{ $index }}][score]" class="form-control numeric-input" value="{{ $option['score'] }}" placeholder="1/2/3" required>
                                                            @error("options.$index.score")<span class="text-danger small">{{ $message }}</span>@enderror
                                                        </td>
                                                        <td>
                                                            <textarea name="options[{{ $index }}][description]" class="form-control" rows="2" placeholder="Deskripsi opsi..." required>{{ $option['description'] }}</textarea>
                                                            @error("options.$index.description")<span class="text-danger small">{{ $message }}</span>@enderror
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-danger remove-option-btn"><i class="ti ti-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('scoring-plan-project.index') }}" class="btn btn-light me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /Page Wrapper -->

    @push('scripts')
    <script>
        $(document).ready(function() {
            let optionIndex = {{ count($oldOptions) }};

            $('#add-option-btn').click(function() {
                var newRow = `
                    <tr class="option-row">
                        <td>
                            <input type="text" name="options[${optionIndex}][label]" class="form-control" placeholder="Kurang/Cukup/Bagus" required>
                        </td>
                        <td>
                            <input type="text" name="options[${optionIndex}][score]" class="form-control numeric-input" placeholder="1/2/3" required>
                        </td>
                        <td>
                            <textarea name="options[${optionIndex}][description]" class="form-control" rows="2" placeholder="Deskripsi opsi..." required></textarea>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-option-btn"><i class="ti ti-trash"></i></button>
                        </td>
                    </tr>
                `;
                $('#options-table tbody').append(newRow);
                optionIndex++;
            });

            $(document).on('click', '.remove-option-btn', function() {
                if ($('#options-table tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Minimal harus ada 1 opsi penilaian!',
                    });
                }
            });

            // Numeric-only validation
            $(document).on('input', '.numeric-input', function() {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });

            // Toast Configuration & Form Submit Confirmation
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            @if(session('error'))
                Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
            @endif

            $('form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                Swal.fire({
                    title: "Konfirmasi Simpan",
                    text: "Apakah Anda yakin ingin menyimpan data ini?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Simpan!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush

@endsection
