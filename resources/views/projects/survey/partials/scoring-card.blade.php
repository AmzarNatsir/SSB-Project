@php
    $departments = ['PROJECT' => 40, 'WORKSHOP' => 30, 'HSE' => 30];
    $canSubmitScore = in_array($survey->status, ['IN_PROGRESS', 'SCORING']);
@endphp

<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="ti ti-calculator me-2"></i>Department Scoring
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Department</th>
                        <th width="15%">Weight</th>
                        <th width="15%">Raw Score</th>
                        <th width="15%">Weighted</th>
                        <th width="15%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $dept => $weight)
                        @php 
                            $score = $survey->scores->where('department', $dept)->first();
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $dept }}</strong>
                                @if($score)
                                    <br><small class="text-muted">By: {{ $score->submitter->name ?? '-' }}</small>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $weight }}%</span></td>
                            <td>
                                @if($score)
                                    <span class="badge bg-primary">{{ number_format($score->score, 1) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($score)
                                    <strong>{{ number_format($score->weighted_score, 2) }}</strong>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($score)
                                    <span class="badge bg-success">
                                        <i class="ti ti-check me-1"></i>Submitted
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="ti ti-clock me-1"></i>Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($canSubmitScore && !$score)
                                    <button class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#scoreModal"
                                        data-dept="{{ $dept }}">
                                        <i class="ti ti-plus me-1"></i>Submit
                                    </button>
                                @elseif($score)
                                    <button class="btn btn-sm btn-outline-info" 
                                        onclick="viewScoreDetails('{{ $score->id }}')">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="table-active">
                        <td colspan="3" class="text-end"><strong>Total Weighted Score</strong></td>
                        <td colspan="3">
                            @if($survey->total_score !== null)
                                <h5 class="mb-0">
                                    <span class="badge {{ $survey->total_score >= 70 ? 'bg-success' : 'bg-danger' }}">
                                        {{ number_format($survey->total_score, 2) }}
                                    </span>
                                </h5>
                            @else
                                <span class="text-muted">Not calculated yet</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($survey->total_score !== null)
            <div class="mt-3">
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar {{ $survey->total_score >= 70 ? 'bg-success' : 'bg-danger' }}" 
                         role="progressbar" 
                         style="width: {{ $survey->total_score }}%"
                         aria-valuenow="{{ $survey->total_score }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        {{ number_format($survey->total_score, 1) }}%
                    </div>
                </div>
                <small class="text-muted">Feasibility Threshold: 70%</small>
            </div>
        @endif
    </div>
</div>
