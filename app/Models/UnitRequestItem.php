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
        'contract_item_id',
        'equipment_id',
        'unit_name',
        'qty',
        'duration_days',
        'remarks',
        'unit_ready',
        'operator_id',
        'operator_name',
        'replaced_at',
        'replaced_by_item_id',
        'returned_at',
        'returned_by_item_id',
        'returned_qty',
        'transferred_at',
        'transferred_by_item_id',
        'transferred_qty',
        'source_unit_transfer_item_id',
    ];

    protected $casts = [
        'qty' => 'integer',
        'duration_days' => 'integer',
        'unit_ready' => 'boolean',
        'replaced_at' => 'datetime',
        'returned_at' => 'datetime',
        'returned_qty' => 'decimal:2',
        'transferred_at' => 'datetime',
        'transferred_qty' => 'decimal:2',
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

    public function contractItem(): BelongsTo
    {
        return $this->belongsTo(ContractItem::class);
    }

    public function replacedByItem(): BelongsTo
    {
        return $this->belongsTo(UnitReplacementItem::class, 'replaced_by_item_id');
    }

    public function returnedByItem(): BelongsTo
    {
        return $this->belongsTo(ProjectUnitReturnItem::class, 'returned_by_item_id');
    }

    public function transferredByItem(): BelongsTo
    {
        return $this->belongsTo(UnitTransferItem::class, 'transferred_by_item_id');
    }

    public function returnItems()
    {
        return $this->hasMany(ProjectUnitReturnItem::class, 'original_unit_request_item_id');
    }

    public function transferItems()
    {
        return $this->hasMany(UnitTransferItem::class, 'original_unit_request_item_id');
    }

    public function sourceUnitTransferItem(): BelongsTo
    {
        return $this->belongsTo(UnitTransferItem::class, 'source_unit_transfer_item_id');
    }

    public function isReplaced(): bool
    {
        return $this->replaced_at !== null;
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }

    public function remainingQty(): float
    {
        return max(0, (float) $this->qty - (float) $this->returned_qty - (float) $this->transferred_qty);
    }

    public function isFullyReturned(): bool
    {
        return $this->remainingQty() <= 0;
    }

    public function isTransferred(): bool
    {
        return $this->transferred_at !== null;
    }

    // Equipment relationship - uncomment when Equipment model is available
    // public function equipment(): BelongsTo
    // {
    //     return $this->belongsTo(Equipment::class);
    // }
}
