@php $page = 'project-survey'; @endphp
@extends('layout.mainlayout')
@section('content')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Project Feasibility Survey</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Survey List</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                    <div class="mb-2">
                        <a href="{{ route('project-survey.create') }}" class="btn btn-primary d-flex align-items-center">
                            <i class="ti ti-plus-circle me-2"></i>Initiate New Survey
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Survey Statistics Cards -->
            <div class="row mb-3">
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-1">Total Surveys</h6>
                                    <h3 class="mb-0" id="stat-total">-</h3>
                                </div>
                                <div class="avatar avatar-lg bg-primary-transparent rounded">
                                    <i class="ti ti-clipboard-list fs-24"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-1">In Progress</h6>
                                    <h3 class="mb-0" id="stat-progress">-</h3>
                                </div>
                                <div class="avatar avatar-lg bg-warning-transparent rounded">
                                    <i class="ti ti-clock fs-24"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-1">Feasible</h6>
                                    <h3 class="mb-0" id="stat-feasible">-</h3>
                                </div>
                                <div class="avatar avatar-lg bg-success-transparent rounded">
                                    <i class="ti ti-check-circle fs-24"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted mb-1">Pending Approval</h6>
                                    <h3 class="mb-0" id="stat-pending">-</h3>
                                </div>
                                <div class="avatar avatar-lg bg-info-transparent rounded">
                                    <i class="ti ti-hourglass fs-24"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Survey Statistics Cards -->

            <!-- Survey List -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="mb-0">Survey Requests</h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" id="filter-status" style="width: 150px;">
                            <option value="">All Status</option>
                            <option value="DRAFT">Draft</option>
                            <option value="SCHEDULED">Scheduled</option>
                            <option value="IN_PROGRESS">In Progress</option>
                            <option value="SCORING">Scoring</option>
                            <option value="PENDING_APPROVAL">Pending Approval</option>
                            <option value="APPROVED">Approved</option>
                            <option value="COMPLETED">Completed</option>
                            <option value="REJECTED">Rejected</option>
                            <option value="SKIPPED">Skipped</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ajax-datatable" id="survey-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Scheduled</th>
                                    <th>Score</th>
                                    <th>Feasibility</th>
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
            <!-- /Survey List -->

        </div>
    </div>
    <!-- /Page Wrapper -->

    @push('scripts')
    <script src="{{ URL::asset('build/js/survey/survey-list.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Survey List Manager
            const surveyList = new SurveyListManager({
                tableSelector: '#survey-table',
                filterSelector: '#filter-status',
                statsSelectors: {
                    total: '#stat-total',
                    progress: '#stat-progress',
                    feasible: '#stat-feasible',
                    pending: '#stat-pending'
                }
            });
            
            surveyList.init();
        });
    </script>
    @endpush

@endsection
