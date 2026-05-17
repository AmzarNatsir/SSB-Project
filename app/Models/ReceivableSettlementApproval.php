<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceivableSettlementApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'receivable_settlement_id',
        'level',
        'approver_id',
        'status',
        'remarks',
        'approved_at',
    ];

    protected $casts = [
        'level'       => 'integer',
        'approved_at' => 'datetime',
    ];

    public function settlement(): BelongsTo
    {
        return $this->belongsTo(ReceivableSettlement::class, 'receivable_settlement_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
