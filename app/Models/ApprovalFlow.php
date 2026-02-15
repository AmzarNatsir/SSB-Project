<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function levels(): HasMany
    {
        return $this->hasMany(ApprovalFlowLevel::class)->orderBy('level_number');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
