<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectSurveyScore extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'score' => 'decimal:2',
        'weight' => 'decimal:2',
        'weighted_score' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }

    public function survey()
    {
        return $this->belongsTo(ProjectSurvey::class, 'survey_id');
    }

    public function criteria()
    {
        return $this->hasMany(SurveyScoreCriterion::class, 'survey_score_id');
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
