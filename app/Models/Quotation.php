<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'project_id',
        'project_budget_id',
        'status',
        'total_project_value',
        'quotation_price',
        'profit_value',
        'profit_margin_percent',
        'selling_price',
        'valid_until',
        'terms_conditions',
        'current_approval_level',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'total_project_value' => 'decimal:2',
        'quotation_price' => 'decimal:2',
        'profit_value' => 'decimal:2',
        'profit_margin_percent' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'valid_until' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uid)) {
                $model->uid = (string) str()->uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(ProjectBudget::class, 'project_budget_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(QuotationApproval::class)->orderBy('created_at', 'desc');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    // Logic for recalculating totals based on items and margin
    public function calculateTotals($manualMargin = null)
    {
        $this->total_project_value = $this->items()->sum('total_price');
        
        if ($this->budget) {
             $this->quotation_price = $this->budget->total_hpp ?? 0;
        }

        $this->profit_value = $this->total_project_value - $this->quotation_price;
        
        if ($manualMargin !== null) {
            $this->profit_margin_percent = $manualMargin;
        } else {
            if ($this->quotation_price > 0) {
                $this->profit_margin_percent = ($this->profit_value / $this->quotation_price) * 100;
            } else {
                $this->profit_margin_percent = 100;
            }
        }
        
        // Clamp to 0-100 to avoid database range errors
        $this->profit_margin_percent = max(0, min(100, $this->profit_margin_percent));
        
        $this->selling_price = $this->total_project_value;

        $this->save();
    }

    public function isLocked(): bool
    {
        // If project is in AMENDMENT status, unlock for editing
        if ($this->project && $this->project->project_status === 'AMENDMENT') {
            return false;
        }

        return in_array($this->status, ['APPROVED', 'SENT']);
    }
}
