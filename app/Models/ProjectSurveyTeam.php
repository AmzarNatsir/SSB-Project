<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectSurveyTeam extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
