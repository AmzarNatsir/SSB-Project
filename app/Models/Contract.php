<?php

namespace App\Models;

use App\Enums\ContractStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'contract_number',
        'project_id',
        'negotiation_id',
        'start_date',
        'end_date',
        'attachment_path',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'status' => ContractStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
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

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ContractItem::class);
    }

    public function unitRequests(): HasMany
    {
        return $this->hasMany(UnitRequest::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope for active contracts
     */
    public function scopeActive($query)
    {
        return $query->where('status', ContractStatus::ACTIVE);
    }

    /**
     * Check if contract is expiring soon (within 30 days)
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->status === ContractStatus::ACTIVE 
            && $this->end_date->isFuture() 
            && $this->end_date->diffInDays(now()) <= $days;
    }

    /**
     * Check if contract is locked
     */
    public function isLocked(): bool
    {
        // Jika project sedang dalam status AMENDMENT, contract tidak dikunci
        if ($this->project && $this->project->project_status === 'AMENDMENT') {
            return false;
        }

        return $this->status === ContractStatus::ACTIVE;
    }
}
