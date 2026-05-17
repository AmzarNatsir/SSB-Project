<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitFormationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_formation_id',
        'contract_item_id',
        'equipment_unit_id',
        'assigned_operator_id',
        'unit_name',
        'equipment_code',
        'operator_name',
        'hm_start',
        'hm_target_monthly',
        'status',
        'remarks',
    ];

    protected $casts = [
        'equipment_unit_id' => 'integer',
        'assigned_operator_id' => 'integer',
        'hm_start' => 'decimal:2',
        'hm_target_monthly' => 'decimal:2',
    ];

    public function unitFormation(): BelongsTo
    {
        return $this->belongsTo(UnitFormation::class);
    }

    public function contractItem(): BelongsTo
    {
        return $this->belongsTo(ContractItem::class);
    }
}
