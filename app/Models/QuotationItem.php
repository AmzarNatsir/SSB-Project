<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'unit_name',
        'unit_id',
        'rate',
        'quantity',
        'duration',
        'duration_unit',
        'total_price',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'quantity' => 'decimal:2',
        'duration' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_price = $model->rate * $model->quantity * $model->duration;
        });
    }
}
