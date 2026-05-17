<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Enums\ReceivableSettlementStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ReceivableSettlement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'settlement_number',
        'project_id',
        'invoice_id',
        'deposit_receivable_id',
        'customer_name',
        'payment_date',
        'payment_amount',
        'payment_type',
        'payment_reference',
        'deposit_amount',
        'invoice_total',
        'total_settled',
        'remaining',
        'description',
        'attachment_path',
        'status',
        'current_approval_level',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'payment_date'           => 'date',
        'approved_at'            => 'datetime',
        'payment_amount'         => 'decimal:2',
        'deposit_amount'         => 'decimal:2',
        'invoice_total'          => 'decimal:2',
        'total_settled'          => 'decimal:2',
        'remaining'              => 'decimal:2',
        'current_approval_level' => 'integer',
        'status'                 => ReceivableSettlementStatus::class,
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

    public function depositReceivable(): BelongsTo
    {
        return $this->belongsTo(Receivable::class, 'deposit_receivable_id');
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
        return $this->hasMany(ReceivableSettlementApproval::class)->orderBy('level');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            ReceivableSettlementStatus::DRAFT,
            ReceivableSettlementStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === ReceivableSettlementStatus::SUBMITTED;
    }
}
