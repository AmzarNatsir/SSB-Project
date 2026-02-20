<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitRequestApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_request_id',
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

    // Relationships
    public function unitRequest(): BelongsTo
    {
        return $this->belongsTo(UnitRequest::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
