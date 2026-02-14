@php $page = 'project-survey'; @endphp
@extends('layout.mainlayout')
@section('content')

    <div class="page-wrapper">
        <div class="content">
            
            <!-- Header with Status Badge -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">Survey Details</h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('project-survey.index') }}">Surveys</a></li>
                            <li class="breadcrumb-item active">{{ $survey->project->project_name ?? 'Details' }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    @include('projects.survey.partials.status-badge', ['status' => $survey->status])
                </div>
            </div>

            <!-- Workflow Progress Bar -->
            @include('projects.survey.partials.workflow-progress', ['survey' => $survey])

            <!-- Main Content Row -->
            <div class="row">
                <!-- Left Column: Survey Information -->
                <div class="col-lg-8">
                    
                    <!-- Project Information Card -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ti ti-building me-2"></i>Project Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Project Name:</strong> {{ $survey->project->project_name ?? '-' }}</p>
                                    <p class="mb-2"><strong>Project Code:</strong> {{ $survey->project->project_code ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Created By:</strong> {{ $survey->creator->name ?? '-' }}</p>
                                    <p class="mb-2"><strong>Created At:</strong> {{ $survey->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($survey->is_skipped)
                                <div class="alert alert-warning mt-3 mb-0">
                                    <strong><i class="ti ti-alert-triangle me-2"></i>Survey Skipped</strong>
                                    <p class="mb-0 mt-1">{{ $survey->skip_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Schedule Card -->
                    @include('projects.survey.partials.schedule-card', ['survey' => $survey])

                    <!-- Scoring Card -->
                    @include('projects.survey.partials.scoring-card', ['survey' => $survey])

                    <!-- Feasibility Result Card -->
                    @if($survey->total_score !== null)
                        @include('projects.survey.partials.feasibility-card', ['survey' => $survey])
                    @endif

                    <!-- Documents Card -->
                    @include('projects.survey.partials.document-card', ['survey' => $survey])

                </div>

                <!-- Right Column: Workflow & Actions -->
                <div class="col-lg-4">
                    
                    <!-- Next Action Card -->
                    @include('projects.survey.partials.next-action-card', ['survey' => $survey])

                    <!-- Approval Timeline -->
                    @include('projects.survey.partials.approval-timeline', ['survey' => $survey])

                    <!-- Activity History -->
                    @include('projects.survey.partials.activity-history', ['survey' => $survey])

                </div>
            </div>

        </div>
    </div>

    <!-- Modals -->
    @include('projects.survey.modals.schedule-modal', ['survey' => $survey])
    @include('projects.survey.modals.score-modal', ['survey' => $survey])
    @include('projects.survey.modals.approval-modal', ['survey' => $survey])
    @include('projects.survey.modals.document-upload-modal', ['survey' => $survey])

    @push('scripts')
    <script src="{{ URL::asset('build/js/survey/survey-detail.js') }}"></script>
    <script>
        $(document).ready(function() {
            const surveyDetail = new SurveyDetailManager({
                surveyUid: '{{ $survey->uid }}',
                currentStatus: '{{ $survey->status }}'
            });
            
            surveyDetail.init();
        });
        
        // SweetAlert confirmation for Start Survey
        function confirmStartSurvey() {
            Swal.fire({
                title: 'Start Survey Execution?',
                text: 'Once started, you can begin submitting department scores. This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-play me-1"></i> Yes, Start Survey',
                cancelButtonText: '<i class="ti ti-x me-1"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    document.getElementById('startSurveyForm').submit();
                }
            });
        }
        
        // SweetAlert confirmation for Proceed to Execution
        function proceedToExecution() {
            Swal.fire({
                title: 'Proceed to Project Execution?',
                html: '<p class="mb-2">This project has been assessed as <strong class="text-success">FEASIBLE</strong>.</p>' +
                      '<p class="mb-0">This will:</p>' +
                      '<ul class="text-start mt-2">' +
                      '<li>Create approval workflow (simulated)</li>' +
                      '<li>Auto-approve for testing</li>' +
                      '<li>Mark survey as COMPLETED</li>' +
                      '<li>Update project status to COMPLETED</li>' +
                      '</ul>',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-rocket me-1"></i> Yes, Proceed',
                cancelButtonText: '<i class="ti ti-x me-1"></i> Not Yet',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("project-survey.proceed", $survey->uid) }}';
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        
        // SweetAlert confirmation for Delete Document
        function confirmDeleteDocument(documentId) {
            Swal.fire({
                title: 'Delete Document?',
                text: 'This action cannot be undone. The file will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-trash me-1"></i> Yes, Delete',
                cancelButtonText: '<i class="ti ti-x me-1"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteDocForm-' + documentId).submit();
                }
            });
        }
        
        // Show approval modal (Approve/Reject)
        function showApprovalModal(step, action) {
            const isApprove = action === 'approve';
            const stepName = step === 'MANAGER_OPS' ? 'Manager Operations' : 'Manager Project';
            
            Swal.fire({
                title: isApprove ? 'Approve Survey?' : 'Reject Survey?',
                html: `<p class="mb-2">You are about to <strong>${isApprove ? 'approve' : 'reject'}</strong> this survey as <strong>${stepName}</strong>.</p>` +
                      `<textarea id="approvalNotes" class="form-control mt-3" placeholder="${isApprove ? 'Optional notes...' : 'Reason for rejection (required)...'}" rows="3"></textarea>`,
                icon: isApprove ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonColor: isApprove ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `<i class="ti ti-${isApprove ? 'check' : 'x'} me-1"></i> Yes, ${isApprove ? 'Approve' : 'Reject'}`,
                cancelButtonText: '<i class="ti ti-x me-1"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: `btn btn-${isApprove ? 'success' : 'danger'}`,
                    cancelButton: 'btn btn-secondary'
                },
                preConfirm: () => {
                    const notes = document.getElementById('approvalNotes').value;
                    if (!isApprove && !notes) {
                        Swal.showValidationMessage('Please provide a reason for rejection');
                        return false;
                    }
                    return notes;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create and submit form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = isApprove 
                        ? '{{ route("project-survey.approve", $survey->uid) }}'
                        : '{{ route("project-survey.reject", $survey->uid) }}';
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    
                    const stepInput = document.createElement('input');
                    stepInput.type = 'hidden';
                    stepInput.name = 'step';
                    stepInput.value = step;
                    form.appendChild(stepInput);
                    
                    if (result.value) {
                        const notesInput = document.createElement('input');
                        notesInput.type = 'hidden';
                        notesInput.name = 'notes';
                        notesInput.value = result.value;
                        form.appendChild(notesInput);
                    }
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        // Show pre-survey approval modal
        function showPreSurveyApprovalModal() {
            Swal.fire({
                title: 'Approve Survey Execution?',
                html: '<p class="mb-2">Approve this survey to allow the team to start execution and submit scores.</p>' +
                      '<textarea id="preApprovalNotes" class="form-control mt-3" placeholder="Optional notes..." rows="3"></textarea>',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonColor: '#28a745',
                denyButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-check me-1"></i> Approve',
                denyButtonText: '<i class="ti ti-x me-1"></i> Reject',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-success',
                    denyButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                preConfirm: () => {
                    return document.getElementById('preApprovalNotes').value;
                },
                preDeny: () => {
                    const notes = document.getElementById('preApprovalNotes').value;
                    if (!notes) {
                        Swal.showValidationMessage('Please provide a reason for rejection');
                        return false;
                    }
                    return notes;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitPreApprovalForm('approve', result.value);
                } else if (result.isDenied) {
                    submitPreApprovalForm('reject', result.value);
                }
            });
        }

        function submitPreApprovalForm(action, notes) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = action === 'approve'
                ? '{{ route("project-survey.approve-execution", $survey->uid) }}'
                : '{{ route("project-survey.reject-execution", $survey->uid) }}';
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            
            if (notes) {
                const notesInput = document.createElement('input');
                notesInput.type = 'hidden';
                notesInput.name = 'notes';
                notesInput.value = notes;
                form.appendChild(notesInput);
            }
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    @endpush

@endsection
