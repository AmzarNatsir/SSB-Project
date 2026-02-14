<?php $page = 'equipment-rental-rates-hm'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Equipment Rental Rates HM</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Equipment Rental Rates HM</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#add_item_offcanvas">
                            <i class="ti ti-plus-circle me-2"></i>Add Rate
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Guardians of the Galaxy -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Rental Rate List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Unit Type</th>
                                    <th>HM rates</th>
                                    <th>Market price</th>
                                    <th>Fuel price</th>
                                    <th>Last Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AJAX DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Guardians of the Galaxy -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Item Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_item_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Add Equipment Rental Rate HM</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('equipment-rental-rates-hm.store') }}" method="POST" class="ajax-form">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Jenis Alat <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_alat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tarif HM <span class="text-danger">*</span></label>
                            <input type="text" name="tarif_hm" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Pasar <span class="text-danger">*</span></label>
                            <input type="text" name="harga_pasar" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Fuel <span class="text-danger">*</span></label>
                            <input type="text" name="harga_fuel" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add Item Offcanvas -->

    <!-- Edit Item Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_item_offcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="fw-semibold">Edit Equipment Rental Rate HM</h5>
            <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="edit_item_form" method="POST" class="ajax-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Jenis Alat <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_alat" id="edit_jenis_alat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tarif HM <span class="text-danger">*</span></label>
                            <input type="text" name="tarif_hm" id="edit_tarif_hm" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Pasar <span class="text-danger">*</span></label>
                            <input type="text" name="harga_pasar" id="edit_harga_pasar" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Fuel <span class="text-danger">*</span></label>
                            <input type="text" name="harga_fuel" id="edit_harga_fuel" class="form-control rupiah-input" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit Item Offcanvas -->

    <!-- Hidden Delete Form -->
    <form id="delete_item_form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('.ajax-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('equipment-rental-rates-hm.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'jenis_alat', name: 'jenis_alat'},
                    {data: 'tarif_hm', name: 'tarif_hm'},
                    {data: 'harga_pasar', name: 'harga_pasar'},
                    {data: 'harga_fuel', name: 'harga_fuel'},
                    {data: 'last_update', name: 'last_update'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            // Edit Item
            $('body').on('click', '.edit-item-btn', function() {
                var id = $(this).data('id');
                var jenisAlat = $(this).data('jenis-alat');
                var tarifHm = $(this).data('tarif-hm');
                var hargaPasar = $(this).data('harga-pasar');
                var hargaFuel = $(this).data('harga-fuel');
                
                $('#edit_jenis_alat').val(jenisAlat);
                $('#edit_tarif_hm').val(formatRupiah(tarifHm.toString()));
                $('#edit_harga_pasar').val(formatRupiah(hargaPasar.toString()));
                $('#edit_harga_fuel').val(formatRupiah(hargaFuel.toString()));
                
                $('#edit_item_form').attr('action', '/equipment-rental-rates-hm/' + id);
            });

            // Delete Item
            $('body').on('click', '.delete-item-btn', function() {
                var id = $(this).data('id');
                var deleteForm = $('#delete_item_form');
                
                deleteForm.attr('action', '/equipment-rental-rates-hm/' + id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                    customClass: {
                        confirmButton: "btn btn-primary me-2",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });

            // Toast Configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Rupiah Formatting
            $('body').on('input', '.rupiah-input', function(e) {
                var value = $(this).val();
                $(this).val(formatRupiah(value));
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
    
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            // AJAX Form Submit
            $('.ajax-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find('.btn-submit');
                var originalText = btn.text();
                
                btn.prop('disabled', true);
                btn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        btn.prop('disabled', false);
                        btn.text(originalText);
                        
                        // Close offcanvas
                        $('.offcanvas').offcanvas('hide');
                        
                        // Reload DataTable
                        table.ajax.reload();
                        
                        // Reset forms
                        form[0].reset();

                        Toast.fire({
                            icon: 'success',
                            title: response.success
                        });
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false);
                        btn.text(originalText);
                        
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Something went wrong!';
                        
                        if (errors) {
                            errorMessage = Object.values(errors)[0][0];
                        }

                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                });
            });

            // Handle delete form submit via ajax manually if needed, or leave as standard submit. 
            // The request was specifically for "tambahkan loading di tombol submit di form add dan edit".
            // So standard submit for delete is fine, but since we want "response toast" for everything, let's fix delete too.
            
            $('#delete_item_form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        // Reload DataTable
                        table.ajax.reload();
                        
                        Toast.fire({
                            icon: 'success',
                            title: response.success
                        });
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to delete item.'
                        });
                    }
                });
            });
        });
    </script>
    @endpush

@endsection
