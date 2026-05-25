<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitTransferItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_transfer_id',
        'original_unit_request_item_id',
        'unit_name',
        'equipment_code',
        'qty',
        'operator_id',
        'operator_name',
        'notes',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
    ];

    public function unitTransfer(): BelongsTo
    {
        return $this->belongsTo(UnitTransfer::class, 'unit_transfer_id');
    }

    public function originalUnitRequestItem(): BelongsTo
    {
        return $this->belongsTo(UnitRequestItem::class, 'original_unit_request_item_id');
    }
}
