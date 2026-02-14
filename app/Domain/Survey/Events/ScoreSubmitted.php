<?php

namespace App\Domain\Survey\Events;

use App\Models\ProjectSurvey;
use App\Models\ProjectSurveyScore;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoreSubmitted
{
    use Dispatchable, SerializesModels;
    
    public function __construct(
        public ProjectSurvey $survey,
        public ProjectSurveyScore $score
    ) {}
}
