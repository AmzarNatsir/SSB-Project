<?php

namespace App\Models;

use App\Enums\WorkRealizationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WorkRealization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'realization_number',
        'project_id',
        'contract_id',
        'period_start',
        'period_end',
        'status',
        'current_approval_level',
        'total_realized_amount',
        'pa_ma_attachment_path',
        'safety_attachment_path',
        'berita_acara_attachment_path',
        'notes',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'approved_at' => 'datetime',
        'current_approval_level' => 'integer',
        'total_realized_amount' => 'decimal:2',
        'status' => WorkRealizationStatus::class,
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

    public function items(): HasMany
    {
        return $this->hasMany(WorkRealizationItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(WorkRealizationApproval::class)->orderBy('level');
    }

    public function invoice(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            WorkRealizationStatus::DRAFT,
            WorkRealizationStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === WorkRealizationStatus::SUBMITTED;
    }
}
