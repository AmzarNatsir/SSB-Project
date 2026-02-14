<!-- Score Submission Modal -->
<div class="modal fade" id="scoreModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('project-survey.score', $survey->uid) }}" method="POST" id="scoreForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-calculator me-2"></i>Submit Department Score
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="department" id="scoreDept">
                    
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        Department: <strong id="deptLabel"></strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Overall Score (0-100) <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="score" 
                               id="scoreInput"
                               class="form-control form-control-lg" 
                               min="0" 
                               max="100" 
                               step="0.1"
                               required>
                        <div class="mt-2">
                            <div class="progress" style="height: 25px;">
                                <div id="scoreProgress" 
                                     class="progress-bar" 
                                     role="progressbar" 
                                     style="width: 0%">
                                    0
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Detailed Criteria Scores (Optional)</label>
                        <div id="criteriaScores">
                            <!-- Dynamically populated based on department -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assessment Notes <span class="text-danger">*</span></label>
                        <textarea name="notes" 
                                  class="form-control" 
                                  rows="4" 
                                  required
                                  placeholder="Provide detailed justification for the score..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check me-1"></i>Submit Score
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scoreModal = document.getElementById('scoreModal');
    const scoreInput = document.getElementById('scoreInput');
    const scoreProgress = document.getElementById('scoreProgress');
    
    // Update progress bar as score changes
    scoreInput?.addEventListener('input', function() {
        const value = this.value || 0;
        scoreProgress.style.width = value + '%';
        scoreProgress.textContent = value;
        
        // Change color based on score
        scoreProgress.className = 'progress-bar';
        if (value >= 90) {
            scoreProgress.classList.add('bg-success');
        } else if (value >= 70) {
            scoreProgress.classList.add('bg-warning');
        } else {
            scoreProgress.classList.add('bg-danger');
        }
    });
    
    // Populate department when modal opens
    scoreModal?.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const dept = button.getAttribute('data-dept');
        document.getElementById('scoreDept').value = dept;
        document.getElementById('deptLabel').textContent = dept;
    });
});
</script>
