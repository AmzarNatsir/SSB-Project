<?php

namespace App\Models;

use App\Enums\SurveyorType;
use App\Enums\SurveyDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyorFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'department',
        'surveyor_type',
        'user_id',
        'role_id',
        'is_active',
    ];

    protected $casts = [
        'surveyor_type' => SurveyorType::class,
        'is_active'     => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
    }

    /**
     * Get the display label of the department
     */
    public function getDepartmentLabelAttribute(): string
    {
        $dept = SurveyDepartment::tryFrom($this->department);
        return $dept ? $dept->label() : $this->department;
    }

    /**
     * Get the resolved surveyor name (user or role)
     */
    public function getSurveyorNameAttribute(): string
    {
        if ($this->surveyor_type === SurveyorType::USER && $this->user) {
            return $this->user->name;
        }
        if ($this->surveyor_type === SurveyorType::ROLE && $this->role) {
            return $this->role->name;
        }
        return '-';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
