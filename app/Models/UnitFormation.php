<?php

namespace App\Models;

use App\Enums\UnitFormationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UnitFormation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'formation_number',
        'project_id',
        'contract_id',
        'unit_request_id',
        'effective_date',
        'end_date',
        'status',
        'current_approval_level',
        'notes',
        'attachment_path',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'current_approval_level' => 'integer',
        'status' => UnitFormationStatus::class,
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

    public function unitRequest(): BelongsTo
    {
        return $this->belongsTo(UnitRequest::class);
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
        return $this->hasMany(UnitFormationItem::class);
    }

    public function activeItems(): HasMany
    {
        return $this->items()->whereIn('status', ['READY', 'ACTIVE']);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(UnitFormationApproval::class)->orderBy('level');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            UnitFormationStatus::DRAFT,
            UnitFormationStatus::REJECTED,
            UnitFormationStatus::REVISED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === UnitFormationStatus::SUBMITTED;
    }

    public function canActivate(): bool
    {
        return $this->status === UnitFormationStatus::APPROVED;
    }

    public function canRevise(): bool
    {
        return $this->status === UnitFormationStatus::ACTIVE;
    }

    public function canEnd(): bool
    {
        return $this->status === UnitFormationStatus::ACTIVE;
    }
}
