<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkforceFormationApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'workforce_formation_id',
        'level',
        'approver_id',
        'status',
        'remarks',
        'approved_at',
    ];

    protected $casts = [
        'level' => 'integer',
        'approved_at' => 'datetime',
    ];

    public function workforceFormation(): BelongsTo
    {
        return $this->belongsTo(WorkforceFormation::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
