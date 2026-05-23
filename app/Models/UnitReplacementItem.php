<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitReplacementItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_replacement_id',
        'original_unit_request_item_id',
        'original_unit_name',
        'original_equipment_code',
        'replacement_workshop_unit_id',
        'replacement_unit_name',
        'replacement_equipment_code',
        'replacement_qty',
        'replacement_duration_days',
        'reason',
        'unit_ready',
        'operator_id',
        'operator_name',
        'remarks',
    ];

    protected $casts = [
        'replacement_qty' => 'decimal:2',
        'replacement_duration_days' => 'integer',
        'replacement_workshop_unit_id' => 'integer',
        'unit_ready' => 'boolean',
    ];

    public function unitReplacement(): BelongsTo
    {
        return $this->belongsTo(UnitReplacement::class);
    }

    public function originalUnitRequestItem(): BelongsTo
    {
        return $this->belongsTo(UnitRequestItem::class, 'original_unit_request_item_id');
    }
}
