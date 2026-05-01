<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProjectSurvey extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'is_skipped' => 'boolean',
        'is_feasible' => 'boolean',
        'scheduled_at' => 'datetime',
        'total_score' => 'decimal:2',
        'metadata' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function teams()
    {
        return $this->hasMany(ProjectSurveyTeam::class, 'survey_id');
    }

    public function scores()
    {
        return $this->hasMany(ProjectSurveyScore::class, 'survey_id');
    }

    public function documents()
    {
        return $this->hasMany(ProjectSurveyDocument::class, 'survey_id');
    }

    public function approvals()
    {
        return $this->hasMany(ProjectSurveyApproval::class, 'survey_id');
    }

    public function isLocked(): bool
    {
        // If project is in AMENDMENT status, unlock for editing
        if ($this->project && $this->project->project_status === 'AMENDMENT') {
            return false;
        }

        return in_array($this->status, ['COMPLETED', 'PROJECT_FEASIBLE']);
    }
}
