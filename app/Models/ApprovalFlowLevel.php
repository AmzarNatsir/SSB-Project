<?php

namespace App\Models;

use App\Enums\ApproverType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalFlowLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_flow_id',
        'level_number',
        'approver_type',
        'approver_user_id',
        'approver_role_id',
        'approver_department_id',
        'is_mandatory',
        'sla_hours',
    ];

    protected $casts = [
        'approver_type' => ApproverType::class,
        'is_mandatory' => 'boolean',
        'level_number' => 'integer',
        'sla_hours' => 'integer',
    ];

    public function flow(): BelongsTo
    {
        return $this->belongsTo(ApprovalFlow::class, 'approval_flow_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_user_id');
    }

    // Role and Department relationships can be added here once those models are available/integrated
}
