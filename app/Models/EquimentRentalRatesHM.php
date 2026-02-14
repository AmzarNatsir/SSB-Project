<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EquimentRentalRatesHM extends Model
{
    use HasFactory;

    protected $table = 'equipment_rental_rates_hm';

    protected $fillable = [
        'uid',
        'jenis_alat',
        'tarif_hm',
        'harga_pasar',
        'harga_fuel'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }
}
