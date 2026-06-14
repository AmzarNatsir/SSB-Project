<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SparePartUsage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'usage_number',
        'project_id',
        'unit_name',
        'equipment_code',
        'usage_date',
        'part_name',
        'part_number',
        'part_category',
        'quantity',
        'unit_of_measure',
        'unit_price',
        'total_price',
        'vendor_name',
        'purchase_order_number',
        'description',
        'attachment_path',
        'status',
        'current_approval_level',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'usage_date'             => 'date',
        'approved_at'            => 'datetime',
        'quantity'               => 'decimal:3',
        'unit_price'             => 'decimal:2',
        'total_price'            => 'decimal:2',
        'current_approval_level' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }
            if (empty($model->usage_number)) {
                $model->usage_number = self::generateNumber();
            }
            // Auto-calculate total price
            if ($model->quantity && $model->unit_price) {
                $model->total_price = $model->quantity * $model->unit_price;
            }
        });
        static::updating(function (self $model) {
            if ($model->isDirty(['quantity', 'unit_price'])) {
                $model->total_price = ($model->quantity ?? 0) * ($model->unit_price ?? 0);
            }
        });
    }

    public static function generateNumber(): string
    {
        $year  = now()->format('Y');
        $month = now()->format('m');
        $prefix = "SPU/{$year}/{$month}/";
        $last = self::withTrashed()
            ->where('usage_number', 'like', "{$prefix}%")
            ->orderByDesc('id')
            ->value('usage_number');

        $seq = $last ? ((int) substr($last, -3)) + 1 : 1;
        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
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
        return in_array($this->status, ['DRAFT', 'REJECTED']);
    }
}
