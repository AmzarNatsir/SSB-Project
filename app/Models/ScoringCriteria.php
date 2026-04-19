<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScoringCriteria extends Model
{
    protected $table = 'scoring_criteria';
    protected $fillable = [
        'name',
        'weighting',
    ];

    /**
     * Relasi ke scoring_options
     */
    public function options(): HasMany
    {
        return $this->hasMany(ScoringOption::class, 'criteria_id');
    }
}
