<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectBudgetApprovalTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'role_name',
        'min_amount',
        'max_amount',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
    ];

    // Helper to find next tier
    public static function getNextTier(int $currentLevel)
    {
        return self::where('level', '>', $currentLevel)
            ->orderBy('level', 'asc')
            ->first();
    }
}
