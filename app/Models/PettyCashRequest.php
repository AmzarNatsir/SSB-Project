<?php

namespace App\Models;

use App\Enums\PettyCashRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PettyCashRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'request_number',
        'project_id',
        'contract_id',
        'request_date',
        'description',
        'requested_amount',
        'used_amount',
        'attachment_path',
        'status',
        'current_approval_level',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'request_date'           => 'date',
        'approved_at'            => 'datetime',
        'current_approval_level' => 'integer',
        'requested_amount'       => 'decimal:2',
        'used_amount'            => 'decimal:2',
        'status'                 => PettyCashRequestStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(PettyCashRequestApproval::class)->orderBy('level');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(PettyCashPayment::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(PettyCashPurchase::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, (float) $this->requested_amount - (float) $this->used_amount);
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            PettyCashRequestStatus::DRAFT,
            PettyCashRequestStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === PettyCashRequestStatus::SUBMITTED;
    }

    public function canBeUsedForPayment(): bool
    {
        return $this->status === PettyCashRequestStatus::APPROVED && $this->remaining_amount > 0;
    }
}
