<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'code',
        'name',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }
}
