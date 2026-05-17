<?php

namespace App\Models;

use App\Enums\TimesheetJournalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TimesheetJournal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'journal_number',
        'project_id',
        'contract_id',
        'journal_date',
        'shift',
        'status',
        'current_approval_level',
        'notes',
        'submitted_by',
        'submitted_at',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'journal_date' => 'date',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'current_approval_level' => 'integer',
        'status' => TimesheetJournalStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            if (empty($model->uid)) {
                $model->uid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(TimesheetEntry::class);
    }

    public function canEdit(): bool
    {
        return in_array($this->status, [
            TimesheetJournalStatus::DRAFT,
            TimesheetJournalStatus::REJECTED,
        ]);
    }

    public function canSubmit(): bool
    {
        return $this->canEdit();
    }

    public function canApprove(): bool
    {
        return $this->status === TimesheetJournalStatus::SUBMITTED;
    }
}
