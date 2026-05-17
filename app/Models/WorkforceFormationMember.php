<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkforceFormationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'workforce_formation_id',
        'employee_id',
        'employee_name',
        'position_name',
        'daily_rate',
        'allowance',
        'shift',
        'start_date',
        'end_date',
        'is_active',
        'remarks',
    ];

    protected $casts = [
        'employee_id' => 'integer',
        'daily_rate' => 'decimal:2',
        'allowance' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function workforceFormation(): BelongsTo
    {
        return $this->belongsTo(WorkforceFormation::class);
    }
}
