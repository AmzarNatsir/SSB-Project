@php
    use App\Models\SurveyHistory;
    $history = SurveyHistory::where('survey_id', $survey->id)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
@endphp

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="ti ti-history me-2"></i>Activity History
        </h5>
    </div>
    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
        @if($history->count() > 0)
            <ul class="activity-list">
                @foreach($history as $item)
                    <li class="activity-item">
                        <div class="activity-icon bg-primary-transparent">
                            <i class="ti ti-{{ $item->event_type === 'survey_created' ? 'plus' : 'edit' }}"></i>
                        </div>
                        <div class="activity-content">
                            <p class="mb-1">
                                <strong>{{ ucwords(str_replace('_', ' ', $item->event_type)) }}</strong>
                            </p>
                            <small class="text-muted">
                                <i class="ti ti-user me-1"></i>{{ $item->user->name ?? 'System' }}
                                <span class="mx-1">•</span>
                                {{ $item->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center text-muted py-3">
                <i class="ti ti-inbox fs-32 mb-2 d-block"></i>
                <p class="mb-0">No activity recorded</p>
            </div>
        @endif
    </div>
</div>

<style>
.activity-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.activity-item {
    display: flex;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #e9ecef;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}
</style>
