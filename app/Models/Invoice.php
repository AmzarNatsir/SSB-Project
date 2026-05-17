<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'invoice_number',
        'project_id',
        'contract_id',
        'work_realization_id',
        'customer_name',
        'customer_code',
        'customer_address',
        'customer_taxpayer_id',
        'invoice_date',
        'due_date',
        'period_start',
        'period_end',
        'subtotal',
        'ppn_rate',
        'ppn_amount',
        'pph_rate',
        'pph_amount',
        'total_amount',
        'faktur_pajak_number',
        'faktur_pajak_path',
        'notes',
        'status',
        'current_approval_level',
        'created_by',
        'approved_by',
        'approved_at',
        'paid_date',
        'payment_notes',
    ];

    protected $casts = [
        'invoice_date'  => 'date',
        'due_date'      => 'date',
        'period_start'  => 'date',
        'period_end'    => 'date',
        'paid_date'     => 'date',
        'approved_at'   => 'datetime',
        'current_approval_level' => 'integer',
        'subtotal'      => 'decimal:2',
        'ppn_rate'      => 'decimal:2',
        'ppn_amount'    => 'decimal:2',
        'pph_rate'      => 'decimal:2',
        'pph_amount'    => 'decimal:2',
        'total_amount'  => 'decimal:2',
        'status'        => InvoiceStatus::class,
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

    public function workRealization(): BelongsTo
    {
        return $this->belongsTo(WorkRealization::class);
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
        return $this->hasMany(InvoiceApproval::class)->orderBy('level');
    }

    public function settlements(): HasMany
    {
        return $this->hasMany(ReceivableSettlement::class)->orderBy('payment_date');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            InvoiceStatus::DRAFT,
            InvoiceStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === InvoiceStatus::SUBMITTED;
    }

    public function canMarkPaid(): bool
    {
        return $this->status === InvoiceStatus::APPROVED;
    }
}
