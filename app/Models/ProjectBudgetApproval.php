<?php

namespace App\Models;

use App\Enums\ApprovalDecision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectBudgetApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_budget_id',
        'level',
        'approver_id',
        'decision',
        'notes',
        'decided_at',
    ];

    protected $casts = [
        'decision' => ApprovalDecision::class,
        'decided_at' => 'datetime',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(ProjectBudget::class, 'project_budget_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
