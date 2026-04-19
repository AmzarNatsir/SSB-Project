<?php

namespace App\Models;

use App\Enums\ProjectUnitReplacementStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProjectUnitReplacement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'ptu_number',
        'project_id',
        'replacement_date',
        'mobilization_date',
        'replacement_reason',
        'attachment_path',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'replacement_date'  => 'date',
        'mobilization_date' => 'date',
        'approved_at'       => 'datetime',
        'status'            => ProjectUnitReplacementStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }

            if (empty($model->ptu_number)) {
                $last = self::withTrashed()->orderBy('id', 'desc')->first();
                $next = $last ? ((int) substr($last->ptu_number, 3)) + 1 : 1;
                $model->ptu_number = 'PTU' . str_pad($next, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProjectUnitReplacementItem::class, 'unit_replacement_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Business logic
    public function canEdit(): bool
    {
        return in_array($this->status, [
            ProjectUnitReplacementStatus::DRAFT,
            ProjectUnitReplacementStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === ProjectUnitReplacementStatus::SUBMITTED;
    }

    public function canComplete(): bool
    {
        return $this->status === ProjectUnitReplacementStatus::APPROVED;
    }
}

