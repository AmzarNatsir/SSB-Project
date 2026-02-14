<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'request_date',
        'project_categories_id',
        'project_sub_categories_id',
        'project_code',
        'project_number',
        'project_name',
        'project_location',
        'project_coordinates',
        'user_name',
        'user_code',
        'user_address',
        'job_type',
        'taxpayer_id',
        'email',
        'phone_number',
        'pic_id',
        'scope_of_work',
        'start_date',
        'end_date',
        'duration_of_work',
        'bank_account',
        'project_value',
        'project_status',
        'description',
        'equipment_rental_rates_hm_id',
    ];

    protected $casts = [
        'request_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'project_value' => 'double',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
            
            // Auto-generate project code and number if not set
            if (empty($model->project_code)) {
                $model->generateProjectCode();
            }

            // Auto-calculate duration if dates are set
            if ($model->start_date && $model->end_date) {
                $model->calculateDuration();
            }
        });

        static::updating(function ($model) {
            // Recalculate duration if dates change
            if ($model->isDirty(['start_date', 'end_date']) && $model->start_date && $model->end_date) {
                $model->calculateDuration();
            }
        });
    }

    /**
     * Generate project code based on category and subcategory
     */
    public function generateProjectCode()
    {
        $year = date('y'); // 2-digit year
        $category = $this->category;

        if (!$category) {
            return;
        }

        // Check if it's a Profit Project
        if (strtoupper($category->code) === 'P') {
            // Profit Project: P{YY}-{NNN}
            $prefix = "P{$year}";
            $lastProject = self::where('project_number', 'like', "{$prefix}-%")
                ->orderBy('id', 'desc')
                ->first();
            
            $nextNumber = $lastProject ? (int)substr($lastProject->project_number, -3) + 1 : 1;
            $sequenceNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $this->project_number = "{$prefix}-{$sequenceNumber}";
        } else {
            // Non-Profit Project: X{YY}.{A|B|C}-{NNN}
            $subCategory = $this->subCategory;
            $subCode = $subCategory ? strtoupper(substr($subCategory->code, 0, 1)) : 'A';
            
            $prefix = "X{$year}.{$subCode}";
            $lastProject = self::where('project_number', 'like', "{$prefix}-%")
                ->orderBy('id', 'desc')
                ->first();
            
            $nextNumber = $lastProject ? (int)substr($lastProject->project_number, -3) + 1 : 1;
            $sequenceNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $this->project_number = "{$prefix}-{$sequenceNumber}";
        }
        
        // Update project_code to comply with unique constraint
        // Using project_number as project_code since it is unique
        $this->project_code = $this->project_number;
    }

    /**
     * Calculate duration of work in days
     */
    public function calculateDuration()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $this->duration_of_work = $start->diffInDays($end) + 1; // +1 to include both start and end day
        }
    }

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_categories_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(ProjectSubCategory::class, 'project_sub_categories_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function equipmentRentalRate()
    {
        return $this->belongsTo(EquimentRentalRatesHM::class, 'equipment_rental_rates_hm_id');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    /**
     * Get the surveys for the project
     */
    public function surveys()
    {
        return $this->hasMany(\App\Models\ProjectSurvey::class, 'project_id');
    }
}
