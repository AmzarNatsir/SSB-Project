<?php

namespace App\Domain\Survey\Events;

use App\Models\ProjectSurvey;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SurveyCompleted
{
    use Dispatchable, SerializesModels;
    
    public function __construct(
        public ProjectSurvey $survey
    ) {}
}
