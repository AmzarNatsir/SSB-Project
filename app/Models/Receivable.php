<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Enums\ReceivableStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Receivable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'receivable_number',
        'project_id',
        'invoice_id',
        'customer_name',
        'received_date',
        'amount',
        'payment_type',
        'payment_reference',
        'description',
        'attachment_path',
        'status',
        'current_approval_level',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'received_date'          => 'date',
        'approved_at'            => 'datetime',
        'amount'                 => 'decimal:2',
        'current_approval_level' => 'integer',
        'status'                 => ReceivableStatus::class,
        'payment_type'           => PaymentType::class,
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

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
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
        return $this->hasMany(ReceivableApproval::class)->orderBy('level');
    }

    /**
     * Kalau Receivable ini adalah DP (invoice_id NULL) dan sudah dialokasikan ke settlement.
     */
    public function settlement(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ReceivableSettlement::class, 'deposit_receivable_id');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            ReceivableStatus::DRAFT,
            ReceivableStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === ReceivableStatus::SUBMITTED;
    }
}
