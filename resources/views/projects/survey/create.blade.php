<?php $page = 'project-survey'; ?>
@extends('layout.mainlayout')
@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Initiate Project Survey</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('project-survey.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Select Project <span class="text-danger">*</span></label>
                                            <select name="project_id" class="form-select select2" required>
                                                <option value="">-- Choose Project --</option>
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->project_name }} ({{ $project->project_code ?? '-' }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" type="checkbox" id="skipSurvey" name="is_skipped" value="1">
                                            <label class="form-check-label" for="skipSurvey">Skip Survey (Direct Activation Request)</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-none" id="skipReasonDiv">
                                        <div class="mb-3">
                                            <label class="form-label">Reason for Skipping <span class="text-danger">*</span></label>
                                            <textarea name="skip_reason" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-end mt-3">
                                    <a href="{{ route('project-survey.index') }}" class="btn btn-light me-2">Cancel</a>
                                    <button type="submit" id="btnProceed" class="btn btn-primary">Proceed</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Survey create page loaded');
            
            // Initialize Select2
            $('.select2').select2({
                placeholder: '-- Choose Project --',
                allowClear: true
            });
            
            // Skip survey toggle
            $('#skipSurvey').change(function() {
                if($(this).is(':checked')) {
                    $('#skipReasonDiv').removeClass('d-none');
                    $('textarea[name="skip_reason"]').prop('required', true);
                } else {
                    $('#skipReasonDiv').addClass('d-none');
                    $('textarea[name="skip_reason"]').prop('required', false);
                }
            });
            
            // Form validation before submission
            $('form').on('submit', function(e) {
                const projectId = $('select[name="project_id"]').val();
                const isSkipped = $('#skipSurvey').is(':checked');
                const skipReason = $('textarea[name="skip_reason"]').val();
                
                // Validation
                if (!projectId) {
                    e.preventDefault();
                    alert('Please select a project');
                    return false;
                }
                
                if (isSkipped && !skipReason) {
                    e.preventDefault();
                    alert('Please provide a reason for skipping the survey');
                    return false;
                }
                
                // Let the form submit naturally
                return true;
            });
        });
    </script>
    @endpush

@endsection
