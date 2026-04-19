<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScoringOption extends Model
{
    protected $table = 'scoring_options';

    protected $fillable = [
        'criteria_id',
        'label',
        'score',
        'description',
    ];

    /**
     * Relasi ke scoring_criteria
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(ScoringCriteria::class, 'criteria_id');
    }
}
