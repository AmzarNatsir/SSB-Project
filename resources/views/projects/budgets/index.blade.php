<?php $page = 'budgets'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Project Budgets (Anggaran Proyek)</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Budgets</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="{{ route('budgets.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="ti ti-plus-circle me-2"></i>Create Budget
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Budget List -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Budget List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Project Name</th>
                                    <th>Version</th>
                                    <th>Status</th>
                                    <th>Total HPP</th>
                                    <th>Selling Price</th>
                                    <th>Margin</th>
                                    <th>Created By</th>
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
            <!-- /Budget List -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Initialize DataTable
                var table = $('.ajax-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('budgets.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'project_name', name: 'project.project_name' },
                        { data: 'version', name: 'version' },
                        { data: 'status', name: 'status' },
                        { data: 'total_hpp', name: 'total_hpp' },
                        { data: 'selling_price', name: 'selling_price' },
                        { data: 'profit_margin_percent', name: 'profit_margin_percent' },
                        { data: 'created_by_name', name: 'creator.name' },
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ],
                    order: [[2, 'desc']] // Sort by version desc by default? Or created_at using hidden column
                });

                // Toast Configuration
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });

                @if(session('success'))
                    Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
                @endif

                @if(session('error'))
                    Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
                @endif
                                        });
        </script>
    @endpush

@endsection