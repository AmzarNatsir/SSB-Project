<?php

namespace App\Models;

use App\Enums\UnitReplacementStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitReplacement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'project_id',
        'unit_request_id',
        'contract_id',
        'replacement_number',
        'replacement_date',
        'mobilization_date',
        'cause',
        'status',
        'notes',
        'attachment_path',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'replacement_date' => 'date',
        'mobilization_date' => 'date',
        'approved_at' => 'datetime',
        'status' => UnitReplacementStatus::class,
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

    public function unitRequest(): BelongsTo
    {
        return $this->belongsTo(UnitRequest::class);
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

    public function items(): HasMany
    {
        return $this->hasMany(UnitReplacementItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(UnitReplacementApproval::class)->orderBy('level', 'asc');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            UnitReplacementStatus::DRAFT,
            UnitReplacementStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return in_array($this->status, [
            UnitReplacementStatus::DRAFT,
            UnitReplacementStatus::REJECTED,
        ]);
    }

    public function canApprove(): bool
    {
        return $this->status === UnitReplacementStatus::SUBMITTED;
    }

    public function canForward(): bool
    {
        return $this->status === UnitReplacementStatus::APPROVED;
    }

    public function isEditable(): bool
    {
        return $this->canEdit();
    }
}
