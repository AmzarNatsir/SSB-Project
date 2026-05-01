<?php

namespace App\Models;

use App\Enums\NegotiationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Negotiation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'project_id',
        'quotation_id',
        'negotiation_number',
        'negotiation_date',
        'client_offer_value',
        'company_offer_value',
        'final_agreed_value',
        'status',
        'notes',
        'created_by',
        'approved_by',
        'approved_at',
        'current_approval_level',
    ];

    protected $casts = [
        'negotiation_date' => 'date',
        'approved_at' => 'datetime',
        'status' => NegotiationStatus::class,
        'client_offer_value' => 'decimal:2',
        'company_offer_value' => 'decimal:2',
        'final_agreed_value' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = (string) str()->uuid();
            }
        });
    }
    
    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(NegotiationRound::class)->orderBy('round_number', 'asc');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(NegotiationApproval::class)->orderBy('level', 'asc');
    }
    
    // Helper to check if can add round
    public function canAddRound(): bool
    {
        // Jika project sedang dalam status AMENDMENT, allow adding rounds
        if ($this->project && $this->project->project_status === 'AMENDMENT') {
            return true;
        }

        return in_array($this->status, [NegotiationStatus::DRAFT, NegotiationStatus::NEGOTIATING]);
    }

    public function isLocked(): bool
    {
        // If project is in AMENDMENT status, unlock for editing
        if ($this->project && $this->project->project_status === 'AMENDMENT') {
            return false;
        }

        return $this->status === NegotiationStatus::APPROVED;
    }
}
