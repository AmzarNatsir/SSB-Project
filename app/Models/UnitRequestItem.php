<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_request_id',
        'quotation_item_id',
        'equipment_id',
        'unit_name',
        'qty',
        'duration_days',
        'remarks',
        'unit_ready',
        'operator_id',
        'operator_name',
    ];

    protected $casts = [
        'qty' => 'integer',
        'duration_days' => 'integer',
        'unit_ready' => 'boolean',
    ];


    // Relationships
    public function unitRequest(): BelongsTo
    {
        return $this->belongsTo(UnitRequest::class);
    }

    public function quotationItem(): BelongsTo
    {
        return $this->belongsTo(QuotationItem::class);
    }

    // Equipment relationship - uncomment when Equipment model is available
    // public function equipment(): BelongsTo
    // {
    //     return $this->belongsTo(Equipment::class);
    // }
}
