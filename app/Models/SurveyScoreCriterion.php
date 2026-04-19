<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyScoreCriterion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function surveyScore()
    {
        return $this->belongsTo(ProjectSurveyScore::class, 'survey_score_id');
    }
}
