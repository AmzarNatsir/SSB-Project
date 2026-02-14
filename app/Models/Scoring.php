<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Scoring extends Model
{
    protected $table = 'scoring';
    protected $fillable = [
        'uid',
        'kebutuhan',
        'skor_min',
        'skor_max',
        'bobot',
        'keterangan_skor',
        'nama_departemen',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }
}
