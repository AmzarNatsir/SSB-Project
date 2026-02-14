<?php

namespace App\Application\Survey\Listeners;

use App\Domain\Survey\Events\SurveyCreated;
use App\Models\SurveyHistory;
use Illuminate\Support\Facades\Log;

class LogSurveyActivity
{
    /**
     * Handle the event.
     */
    public function handle(SurveyCreated $event): void
    {
        try {
            SurveyHistory::create([
                'survey_id' => $event->survey->id,
                'user_id' => $event->survey->created_by,
                'event_type' => 'survey_created',
                'new_values' => [
                    'project_id' => $event->survey->project_id,
                    'status' => $event->survey->status,
                    'is_skipped' => $event->survey->is_skipped,
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log survey activity', [
                'survey_id' => $event->survey->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
