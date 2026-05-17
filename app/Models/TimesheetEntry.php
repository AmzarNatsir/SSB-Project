<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimesheetEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'timesheet_journal_id',
        'unit_formation_item_id',
        'equipment_unit_id',
        'operator_employee_id',
        'unit_name',
        'operator_name',
        'activity_code',
        'hm_start',
        'hm_end',
        // hm_total is generated column (storedAs), tidak boleh di-fillable
        'operating_start_time',
        'operating_end_time',
        'working_hours',
        'idle_start_time',
        'idle_end_time',
        'idle_reason',
        'idle_hours',
        'breakdown_start_time',
        'breakdown_end_time',
        'breakdown_reason',
        'breakdown_hours',
        'fuel_consumed_liter',
        'trip_count',
        'tonnage',
        'remarks',
    ];

    protected $casts = [
        'equipment_unit_id' => 'integer',
        'operator_employee_id' => 'integer',
        'hm_start' => 'decimal:2',
        'hm_end' => 'decimal:2',
        'hm_total' => 'decimal:2',
        'working_hours' => 'decimal:2',
        'idle_hours' => 'decimal:2',
        'breakdown_hours' => 'decimal:2',
        'fuel_consumed_liter' => 'decimal:2',
        'trip_count' => 'integer',
        'tonnage' => 'decimal:2',
        // TIME field di-cast sebagai datetime supaya bisa di-format(); Eloquent handle string TIME otomatis
    ];

    public function timesheetJournal(): BelongsTo
    {
        return $this->belongsTo(TimesheetJournal::class);
    }

    public function unitFormationItem(): BelongsTo
    {
        return $this->belongsTo(UnitFormationItem::class);
    }
}
