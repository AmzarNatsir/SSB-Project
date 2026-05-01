<?php

namespace App\Models;

use App\Enums\BudgetStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectBudget extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'project_id',
        'version',
        'status',
        'total_labor_cost',
        'total_equipment_cost',
        'total_maintenance_cost',
        'total_operational_cost',
        'total_mobilization_cost',
        'total_other_cost',
        'total_hpp',
        'profit_margin_percent',
        'selling_price',
        'baseline_locked_at',
        'current_approval_level',
        'created_by',
        'updated_by',
        'attachments',
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

    protected $casts = [
        'status' => BudgetStatus::class,
        'baseline_locked_at' => 'datetime',
        'total_labor_cost' => 'decimal:2',
        'total_equipment_cost' => 'decimal:2',
        'total_maintenance_cost' => 'decimal:2',
        'total_operational_cost' => 'decimal:2',
        'total_mobilization_cost' => 'decimal:2',
        'total_other_cost' => 'decimal:2',
        'total_hpp' => 'decimal:2',
        'profit_margin_percent' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'current_approval_level' => 'integer',
        'attachments' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProjectBudgetItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(ProjectBudgetApproval::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ProjectBudgetRevision::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeBaselineApproved($query)
    {
        return $query->where('status', BudgetStatus::BASELINE_APPROVED);
    }

    public function scopeActive($query)
    {
        // Get the latest version for each project? Or just non-deleted which is handled by SoftDeletes
        return $query; 
    }
    
    // Logic
    public function isLocked(): bool
    {
        // If project is in AMENDMENT status, unlock for editing
        if ($this->project && $this->project->project_status === 'AMENDMENT') {
            return false;
        }

        return $this->status === BudgetStatus::BASELINE_APPROVED;
    }
    
    public function calculateTotals()
    {
        // Ensure relationships are loaded or calculate from DB
        // This might be better in the Service/Repository to avoid N+1 if iterating
        // But for a single model:
        $items = $this->items;
        
        $this->total_labor_cost = $items->where('category', 'LABOR')->sum('total_cost');
        $this->total_equipment_cost = $items->where('category', 'EQUIPMENT')->sum('total_cost');
        $this->total_maintenance_cost = $items->where('category', 'MAINTENANCE')->sum('total_cost');
        $this->total_operational_cost = $items->where('category', 'OPERATIONAL')->sum('total_cost');
        $this->total_mobilization_cost = $items->where('category', 'MOBILIZATION')->sum('total_cost');
        $this->total_other_cost = $items->where('category', 'OTHER')->sum('total_cost');
        
        $this->total_hpp = $this->total_labor_cost + 
                           $this->total_equipment_cost + 
                           $this->total_maintenance_cost + 
                           $this->total_operational_cost + 
                           $this->total_mobilization_cost + 
                           $this->total_other_cost;
                           
        if ($this->profit_margin_percent > 0) {
            $this->selling_price = $this->total_hpp * (1 + ($this->profit_margin_percent / 100));
        } else {
            $this->selling_price = $this->total_hpp;
        }
        
        $this->save();
    }
}
