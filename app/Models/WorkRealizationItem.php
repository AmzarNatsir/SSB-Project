<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkRealizationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_realization_id',
        'unit_formation_item_id',
        'contract_item_id',
        'unit_name',
        'equipment_code',
        'operator_name',
        'period_start',
        'period_end',
        'total_hm',
        'timesheet_count',
        'contract_rate',
        'adjusted_rate',
        'rate_adjustment_reason',
        'realized_amount',
        'notes',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_hm' => 'decimal:2',
        'timesheet_count' => 'integer',
        'contract_rate' => 'decimal:2',
        'adjusted_rate' => 'decimal:2',
        'realized_amount' => 'decimal:2',
    ];

    public function workRealization(): BelongsTo
    {
        return $this->belongsTo(WorkRealization::class);
    }

    public function unitFormationItem(): BelongsTo
    {
        return $this->belongsTo(UnitFormationItem::class);
    }

    public function contractItem(): BelongsTo
    {
        return $this->belongsTo(ContractItem::class);
    }
}
