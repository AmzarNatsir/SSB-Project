<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NegotiationRound extends Model
{
    use HasFactory;

    protected $fillable = [
        'negotiation_id',
        'round_number',
        'client_offer_value',
        'company_counter_offer',
        'meeting_date',
        'summary_notes',
        'attachment_path',
        'created_by',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'client_offer_value' => 'decimal:2',
        'company_counter_offer' => 'decimal:2',
    ];

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
