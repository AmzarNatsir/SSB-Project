<!-- Score Submission Modal -->
<div class="modal fade" id="scoreModal-{{ $dept_key ?? '' }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('project-survey.score', $survey->uid) }}" method="POST" id="scoreForm-{{ $dept_key ?? '' }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-calculator me-2"></i>Submit Department Score
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="department" value="{{ $dept_key ?? '' }}">
                    
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        Department: <strong>{{ $dept_key ?? '' }}</strong>
                    </div>

                    <div class="mb-4">
                        <label class="form-label mb-3 fw-bold">Evaluation Criteria <span class="text-danger">*</span></label>
                        
                        @if(isset($scoringCriteria) && $scoringCriteria->count() > 0)
                            <div class="accordion" id="criteriaAccordion">
                            @foreach($scoringCriteria as $index => $criteria)
                                @php
                                    $maxOptionScore = $criteria->options->max('score') ?? 0;
                                    $maxCriteriaPoints = $maxOptionScore * $criteria->weighting;
                                @endphp
                                <div class="accordion-item border mb-2 rounded shadow-sm">
                                    <div class="accordion-header" id="heading{{ $criteria->id }}">
                                        <button class="accordion-button collapsed px-3 py-2 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $criteria->id }}" style="font-weight: 500;">
                                            <div class="d-flex w-100 justify-content-between align-items-center me-3">
                                                <span>{{ $index + 1 }}. {{ $criteria->name }}</span>
                                                <span class="badge bg-secondary">Weight: {{ $criteria->weighting }}</span>
                                            </div>
                                        </button>
                                    </div>
                                    <div id="collapse{{ $criteria->id }}" class="accordion-collapse collapse show">
                                        <div class="accordion-body px-3 py-2">
                                            <div class="row g-2">
                                                @foreach($criteria->options as $option)
                                                @php
                                                    $isChecked = false;
                                                    if (isset($scoreRecord) && $scoreRecord) {
                                                        $critMatch = $scoreRecord->criteria->where('criterion_name', $criteria->name)->first();
                                                        if ($critMatch && $critMatch->justification == ($option->label . ' (' . $option->score . ' pts)')) {
                                                            $isChecked = true;
                                                        }
                                                    }
                                                @endphp
                                                <div class="col-md-12">
                                                    <div class="form-check border p-2 rounded option-card hover-bg-light" style="cursor: pointer;" onclick="document.getElementById('option{{ $option->id }}-{{ $dept_key ?? '' }}').click()">
                                                        <input class="form-check-input criteria-radio mt-1 ms-1" 
                                                            type="radio" 
                                                            name="criteria_scores[{{ $criteria->id }}]" 
                                                            id="option{{ $option->id }}-{{ $dept_key ?? '' }}" 
                                                            value="{{ $option->id }}" 
                                                            data-points="{{ $option->score * $criteria->weighting }}"
                                                            data-maxpoints="{{ $maxCriteriaPoints }}"
                                                            {{ $isChecked ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label w-100 ms-2" for="option{{ $option->id }}-{{ $dept_key ?? '' }}" style="cursor: pointer;">
                                                            <div class="d-flex justify-content-between">
                                                                <strong class="text-dark">{{ $option->label }}</strong>
                                                                <span class="badge bg-info">{{ $option->score }} pts</span>
                                                            </div>
                                                            <small class="text-muted d-block mt-1">{{ $option->description }}</small>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                No Scoring Criteria available. Please set up the Scoring Plan Project in Master Data first.
                            </div>
                        @endif
                    </div>

                    <div class="mb-4 bg-light p-3 rounded border">
                        <label class="form-label fw-bold mb-2">Estimated Score Progress <small class="text-muted fw-normal">(Calculated automatically)</small></label>
                        <div class="progress" style="height: 25px;">
                            <div id="scoreProgress" 
                                 class="progress-bar bg-secondary" 
                                 role="progressbar" 
                                 style="width: 0%">
                                0%
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assessment Notes <span class="text-danger">*</span></label>
                        <textarea name="notes" 
                                  class="form-control" 
                                  rows="4" 
                                  required
                                  placeholder="Provide detailed justification for the score...">{{ isset($scoreRecord) && $scoreRecord ? $scoreRecord->notes : '' }}</textarea>
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
    const scoreModal = document.getElementById('scoreModal-{{ $dept_key ?? '' }}');
    if (!scoreModal) return;
    
    const radios = scoreModal.querySelectorAll('.criteria-radio');
    const scoreProgress = scoreModal.querySelector('#scoreProgress');
    
    function calculateTotalProgress() {
        if (!scoreProgress) return;
        let earned = 0;
        let max = 0;
        
        const selected = scoreModal.querySelectorAll('.criteria-radio:checked');
        selected.forEach(radio => {
            earned += parseFloat(radio.getAttribute('data-points') || 0);
        });
        
        const names = new Set();
        radios.forEach(radio => {
            if (!names.has(radio.name)) {
                names.add(radio.name);
                max += parseFloat(radio.getAttribute('data-maxpoints') || 0);
            }
        });
        
        let percentage = 0;
        if (max > 0) {
            percentage = (earned / max) * 100;
        }
        
        percentage = percentage.toFixed(1);
        
        scoreProgress.style.width = percentage + '%';
        scoreProgress.textContent = percentage + '%';
        
        scoreProgress.className = 'progress-bar';
        if (percentage >= 90) {
            scoreProgress.classList.add('bg-success');
        } else if (percentage >= 70) {
            scoreProgress.classList.add('bg-warning');
        } else {
            scoreProgress.classList.add('bg-danger');
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', calculateTotalProgress);
    });
    
    // Auto calculate on load if editing
    setTimeout(calculateTotalProgress, 100);
});
</script>
