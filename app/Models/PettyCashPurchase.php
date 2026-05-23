<?php

namespace App\Models;

use App\Enums\PettyCashPurchaseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PettyCashPurchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'purchase_number',
        'petty_cash_request_id',
        'expense_category_id',
        'project_id',
        'purchase_order_number',
        'purchase_date',
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
        'purchase_date'          => 'date',
        'approved_at'            => 'datetime',
        'current_approval_level' => 'integer',
        'amount'                 => 'decimal:2',
        'status'                 => PettyCashPurchaseStatus::class,
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
        return $this->hasMany(PettyCashPurchaseApproval::class)->orderBy('level');
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            PettyCashPurchaseStatus::DRAFT,
            PettyCashPurchaseStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === PettyCashPurchaseStatus::SUBMITTED;
    }
}
