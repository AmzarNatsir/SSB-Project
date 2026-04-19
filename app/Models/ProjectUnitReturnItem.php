<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUnitReturnItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_return_id',
        'project_unit_id',
        'equipment_id',
        'notes',
    ];

    public function unitReturn(): BelongsTo
    {
        return $this->belongsTo(ProjectUnitReturn::class, 'unit_return_id');
    }
}
