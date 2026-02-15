<?php

namespace App\Enums;

enum BudgetStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED_L1 = 'APPROVED_L1';
    case APPROVED_L2 = 'APPROVED_L2';
    // Add more levels if needed dynamically, but these are for status tracking
    case BASELINE_APPROVED = 'BASELINE_APPROVED';
    case REVISION_REQUIRED = 'REVISION_REQUIRED';
    case REJECTED = 'REJECTED';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::APPROVED_L1 => 'Approved (L1)',
            self::APPROVED_L2 => 'Approved (L2)',
            self::BASELINE_APPROVED => 'Baseline Approved',
            self::REVISION_REQUIRED => 'Revision Required',
            self::REJECTED => 'Rejected',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::SUBMITTED => 'info',
            self::APPROVED_L1, self::APPROVED_L2 => 'primary',
            self::BASELINE_APPROVED => 'success',
            self::REVISION_REQUIRED => 'warning',
            self::REJECTED => 'danger',
        };
    }
}
