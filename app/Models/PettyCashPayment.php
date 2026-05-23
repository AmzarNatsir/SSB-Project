<?php

namespace App\Models;

use App\Enums\PettyCashPaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PettyCashPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'payment_number',
        'petty_cash_request_id',
        'expense_category_id',
        'project_id',
        'payment_date',
        'description',
        'amount',
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
        'current_approval_level' => 'integer',
        'amount'                 => 'decimal:2',
        'status'                 => PettyCashPaymentStatus::class,
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

    public function request(): BelongsTo
    {
        return $this->belongsTo(PettyCashRequest::class, 'petty_cash_request_id');
    }

    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(PettyCashExpenseCategory::class, 'expense_category_id');
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

    public function approvals(): HasMany
    {
        return $this->hasMany(PettyCashPaymentApproval::class)->orderBy('level');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            PettyCashPaymentStatus::DRAFT,
            PettyCashPaymentStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === PettyCashPaymentStatus::SUBMITTED;
    }
}
