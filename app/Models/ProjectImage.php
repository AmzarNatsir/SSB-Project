<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'project_id',
        'file_image',
        'file_path',
        'description',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }

    /**
     * Relationship to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
