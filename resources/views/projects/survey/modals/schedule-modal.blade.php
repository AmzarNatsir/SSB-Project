<!-- Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('project-survey.schedule', $survey->uid) }}" method="POST" id="scheduleForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-calendar-event me-2"></i>Set Survey Schedule
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Scheduled Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="scheduled_date" 
                                   class="form-control" 
                                   required
                                   min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Scheduled Time <span class="text-danger">*</span></label>
                            <input type="time" 
                                   name="scheduled_time" 
                                   class="form-control" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Survey Team Members</label>
                        <select name="teams[]" 
                                class="form-select select2" 
                                multiple 
                                data-placeholder="Select team members">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select users who will conduct the survey</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Additional instructions or notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Save Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
