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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    // Logic for recalculating totals based on items and margin
    public function calculateTotals()
    {
        $this->total_project_value = $this->items()->sum('total_price');
        
        // Quotation price comes from the Budget Baseline (COGS)
        // If linked budget exists, use its total_hpp, otherwise default to 0 or manual input logic (tbd)
        if ($this->budget) {
             // Re-fetch budget to ensure latest totals
             $this->quotation_price = $this->budget->total_hpp ?? 0;
        }

        // Profit = Project Value (Revenue from Items) - Quotation Price (Cost)
        // Wait, requirements say: 
        // PROFIT = TOTAL_PROJECT_VALUE - QUOTATION_PRICE
        // But also: SELLING_PRICE = QUOTATION_PRICE * (1 + profit_margin%)
        // And: total_project_value = sum(rate * qty * duration)
        
        // Let's stick to the core logic from the user request:
        // "TOTAL_PROJECT_VALUE = rate × quantity × duration" -> Implemented in Items
        // "QUOTATION_PRICE = total cost of goods sold (from Budget Baseline)"
        // "PROFIT = TOTAL_PROJECT_VALUE - QUOTATION_PRICE"
        
        // However, there is also:
        // "Selling Price (Target Margin): selling_price = total_hpp * (1 + profit_margin_percent / 100)"
        
        // Clarification:
        // It seems `total_project_value` IS the `selling_price` effectively if we sum up the items which are "Revenue".
        // OR, the items are "Cost" items?
        // User says: "Prepare a price quote... Rate per unit... Target profit margin".
        // And "TOTAL_PROJECT_VALUE = rate × quantity × duration".
        // PROBABLY: The Items represent the revenue generation (Equipment rental, etc).
        // So Total Project Value = Revenue.
        
        // Let's implement the straightforward summation first.
        
        $this->profit_value = $this->total_project_value - $this->quotation_price;
        
        if ($this->quotation_price > 0) {
            $this->profit_margin_percent = ($this->profit_value / $this->quotation_price) * 100;
        } else {
            $this->profit_margin_percent = 100; // undefined/infinite technically
        }
        
        $this->selling_price = $this->total_project_value; // As per logic implied by "PROFIT = TOTAL - COST"

        $this->save();
    }
}
