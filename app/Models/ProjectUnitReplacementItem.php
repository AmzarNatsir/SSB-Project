<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUnitReplacementItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_replacement_id',
        'old_unit_id',
        'old_unit_name',
        'replacement_unit_id',
        'replacement_unit_name',
        'notes',
    ];

    public function unitReplacement(): BelongsTo
    {
        return $this->belongsTo(ProjectUnitReplacement::class, 'unit_replacement_id');
    }
}

