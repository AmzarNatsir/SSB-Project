<?php

namespace App\Models;

use App\Enums\ApprovalDecision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotationApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'level',
        'approver_id',
        'decision',
        'notes',
        'decided_at',
    ];

    protected $casts = [
        'decision' => ApprovalDecision::class,
        'decided_at' => 'datetime',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
