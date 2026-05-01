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
                            <input type="date" name="scheduled_date" class="form-control" required
                                min="{{ date('Y-m-d') }}"
                                value="{{ $survey->scheduled_at ? $survey->scheduled_at->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Scheduled Time <span class="text-danger">*</span></label>
                            <input type="time" name="scheduled_time" class="form-control" required
                                value="{{ $survey->scheduled_at ? $survey->scheduled_at->format('H:i') : '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Survey Team Members
                            <span class="text-danger">*</span>
                        </label>
                        <select id="teamMembersSelect" name="teams[]" class="form-control" multiple="multiple" required>
                            @php
                                $existingMemberIds = $survey->teams->pluck('user_id')->toArray();
                            @endphp
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ in_array($user->id, $existingMemberIds) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih satu atau lebih user yang akan melakukan survey</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"
                            placeholder="Additional instructions or notes">{{ $survey->notes }}</textarea>
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

<script>
    // Init Select2 for team members when modal opens
    document.getElementById('scheduleModal').addEventListener('shown.bs.modal', function () {
        if ($.fn.select2) {
            const $select = $('#teamMembersSelect');
            
            $select.select2({
                width: '100%',
                placeholder: 'Pilih anggota tim surveyor...',
                allowClear: true,
                dropdownParent: $('#scheduleModal'),
            });

            // If no teams are currently assigned, pre-select suggested ones
            const existingTeamsCount = {{ $survey->teams->count() }};
            if (existingTeamsCount === 0) {
                const suggestedIds = @json($suggestedSurveyorIds ?? []);
                if (suggestedIds.length > 0) {
                    $select.val(suggestedIds).trigger('change');
                }
            } else {
                // If teams already exist, they are handled by the 'selected' attribute in Blade
                $select.trigger('change');
            }
        }
    });

    // Destroy Select2 when modal closes 
    document.getElementById('scheduleModal').addEventListener('hidden.bs.modal', function () {
        if ($.fn.select2 && $('#teamMembersSelect').hasClass('select2-hidden-accessible')) {
            $('#teamMembersSelect').select2('destroy');
        }
    });
</script>