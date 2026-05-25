<?php

namespace App\Models;

use App\Enums\UnitTransferStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class UnitTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'transfer_number',
        'source_project_id',
        'source_unit_request_id',
        'destination_project_id',
        'transfer_date',
        'notes',
        'attachment_path',
        'status',
        'created_by',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'status'        => UnitTransferStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }

            if (empty($model->transfer_number)) {
                $last = self::withTrashed()->orderBy('id', 'desc')->first();
                $next = $last ? ((int) substr($last->transfer_number, 2)) + 1 : 1;
                $model->transfer_number = 'UT' . str_pad($next, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function sourceProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'source_project_id');
    }

    public function destinationProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'destination_project_id');
    }

    public function sourceUnitRequest(): BelongsTo
    {
        return $this->belongsTo(UnitRequest::class, 'source_unit_request_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(UnitTransferItem::class, 'unit_transfer_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function canEdit(): bool
    {
        return $this->status === UnitTransferStatus::DRAFT;
    }

    public function canComplete(): bool
    {
        return $this->status === UnitTransferStatus::DRAFT;
    }

    public function isEditable(): bool
    {
        return $this->canEdit();
    }
}
