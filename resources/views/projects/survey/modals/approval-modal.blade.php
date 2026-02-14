<!-- Approval Action Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('project-survey.status', $survey->uid) }}" method="POST" id="approvalForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-check-circle me-2"></i>Approval Action
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="step" id="approveStep">
                    
                    <div class="mb-3">
                        <label class="form-label">Decision <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required id="approvalStatus">
                            <option value="">Select decision...</option>
                            <option value="APPROVED">✓ Approve</option>
                            <option value="REVISION">↻ Request Revision</option>
                            <option value="REJECTED">✗ Reject</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comments <span class="text-danger">*</span></label>
                        <textarea name="notes" 
                                  class="form-control" 
                                  rows="4" 
                                  required
                                  placeholder="Provide detailed comments for your decision..."></textarea>
                    </div>

                    <div class="alert alert-warning" id="rejectWarning" style="display: none;">
                        <i class="ti ti-alert-triangle me-2"></i>
                        <strong>Warning:</strong> Rejecting this survey will cancel the project feasibility assessment.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="approvalSubmit">
                        <i class="ti ti-check me-1"></i>Submit Decision
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const approvalModal = document.getElementById('approvalModal');
    const approvalStatus = document.getElementById('approvalStatus');
    const rejectWarning = document.getElementById('rejectWarning');
    const submitBtn = document.getElementById('approvalSubmit');
    
    // Show warning for rejection
    approvalStatus?.addEventListener('change', function() {
        if (this.value === 'REJECTED') {
            rejectWarning.style.display = 'block';
            submitBtn.className = 'btn btn-danger';
            submitBtn.innerHTML = '<i class="ti ti-x me-1"></i>Confirm Rejection';
        } else if (this.value === 'APPROVED') {
            rejectWarning.style.display = 'none';
            submitBtn.className = 'btn btn-success';
            submitBtn.innerHTML = '<i class="ti ti-check me-1"></i>Confirm Approval';
        } else {
            rejectWarning.style.display = 'none';
            submitBtn.className = 'btn btn-primary';
            submitBtn.innerHTML = '<i class="ti ti-check me-1"></i>Submit Decision';
        }
    });
    
    // Populate step when modal opens
    approvalModal?.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const step = button.getAttribute('data-step');
        document.getElementById('approveStep').value = step;
    });
});
</script>
