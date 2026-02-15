<?php

namespace App\Models;

use App\Enums\BudgetCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectBudgetItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_budget_id',
        'category',
        'item_name',
        'qty',
        'units',
        'unit_cost',
        'total_cost',
        'description',
    ];

    protected $casts = [
        'category' => BudgetCategory::class,
        'qty' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(ProjectBudget::class, 'project_budget_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->total_cost = $item->qty * $item->unit_cost;
        });
        
        static::saved(function ($item) {
             // Optional: trigger budget recalculation event or job
             // $item->budget->calculateTotals(); 
             // Ideally avoided in model events for performance, handled in Service
        });
    }
}
