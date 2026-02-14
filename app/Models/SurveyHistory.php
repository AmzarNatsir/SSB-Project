<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyHistory extends Model
{
    protected $table = 'survey_history';
    
    protected $fillable = [
        'survey_id',
        'user_id',
        'event_type',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
    
    /**
     * Get the survey that owns the history record
     */
    public function survey()
    {
        return $this->belongsTo(ProjectSurvey::class, 'survey_id');
    }
    
    /**
     * Get the user who performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
