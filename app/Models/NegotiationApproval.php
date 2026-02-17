<?php

namespace App\Models;

use App\Enums\ApprovalDecision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NegotiationApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'negotiation_id',
        'level',
        'approver_id',
        'status',
        'remarks',
        'decided_at',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
        // 'status' => ApprovalDecision::class // Reusing existing enum if applicable, or generic string
    ];

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
