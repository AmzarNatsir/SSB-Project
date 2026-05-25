<?php

namespace App\Models;

use App\Enums\ProjectUnitReturnStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProjectUnitReturn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'ppu_number',
        'project_id',
        'unit_request_id',
        'contract_id',
        'return_date',
        'demobilization_date',
        'notes',
        'attachment_path',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'return_date'         => 'date',
        'demobilization_date' => 'date',
        'approved_at'         => 'datetime',
        'status'              => ProjectUnitReturnStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }

            if (empty($model->ppu_number)) {
                $last = self::withTrashed()->orderBy('id', 'desc')->first();
                $next = $last ? ((int) substr($last->ppu_number, 3)) + 1 : 1;
                $model->ppu_number = 'PPU' . str_pad($next, 6, '0', STR_PAD_LEFT);
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

    public function unitRequest(): BelongsTo
    {
        return $this->belongsTo(UnitRequest::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProjectUnitReturnItem::class, 'unit_return_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(ProjectUnitReturnApproval::class, 'unit_return_id')->orderBy('level', 'asc');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            ProjectUnitReturnStatus::DRAFT,
            ProjectUnitReturnStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === ProjectUnitReturnStatus::SUBMITTED;
    }

    public function canComplete(): bool
    {
        return in_array($this->status, [
            ProjectUnitReturnStatus::DRAFT,
            ProjectUnitReturnStatus::APPROVED,
        ]);
    }

    public function isEditable(): bool
    {
        return $this->canEdit();
    }
}
