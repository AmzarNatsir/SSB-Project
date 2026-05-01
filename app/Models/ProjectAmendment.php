<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectAmendment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'amendment_number',
        'reason',
        'status',
        'requested_by',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(ProjectHistory::class, 'amendment_id');
    }
}
