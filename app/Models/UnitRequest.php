<?php

namespace App\Models;

use App\Enums\UnitRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'project_id',
        'quotation_id',
        'negotiation_id',
        'request_number',
        'request_date',
        'mobilization_date',
        'status',
        'notes',
        'attachment_path',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'request_date' => 'date',
        'mobilization_date' => 'date',
        'approved_at' => 'datetime',
        'status' => UnitRequestStatus::class,
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

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(UnitRequestItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(UnitRequestApproval::class)->orderBy('level', 'asc');
    }

    // Business Logic Helpers
    public function canEdit(): bool
    {
        return in_array($this->status, [
            UnitRequestStatus::DRAFT,
            UnitRequestStatus::REJECTED
        ]);
    }

    public function canSubmit(): bool
    {
        return in_array($this->status, [
            UnitRequestStatus::DRAFT,
            UnitRequestStatus::REJECTED
        ]);
    }

    public function canApprove(): bool
    {
        return $this->status === UnitRequestStatus::SUBMITTED;
    }

    public function canForward(): bool
    {
        return $this->status === UnitRequestStatus::APPROVED;
    }

    public function isEditable(): bool
    {
        return $this->canEdit();
    }
}
