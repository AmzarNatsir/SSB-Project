<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectBudgetRevision extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_budget_id',
        'revision_no',
        'reasons',
        'revised_by',
        'revised_at',
    ];

    protected $casts = [
        'revised_at' => 'datetime',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(ProjectBudget::class, 'project_budget_id');
    }

    public function reviser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revised_by');
    }
}
