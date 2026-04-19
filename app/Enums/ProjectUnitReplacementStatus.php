<?php

namespace App\Enums;

enum ProjectUnitReplacementStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case COMPLETED = 'COMPLETED';

    public function label(): string
    {
        return match($this) {
            self::DRAFT     => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::APPROVED  => 'Approved',
            self::REJECTED  => 'Rejected',
            self::COMPLETED => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT     => 'secondary',
            self::SUBMITTED => 'info',
            self::APPROVED  => 'success',
            self::REJECTED  => 'danger',
            self::COMPLETED => 'primary',
        };
    }

    public function canTransitionTo(self $new): bool
    {
        return match($this) {
            self::DRAFT     => $new === self::SUBMITTED,
            self::SUBMITTED => in_array($new, [self::APPROVED, self::REJECTED]),
            self::REJECTED  => $new === self::SUBMITTED,
            self::APPROVED  => $new === self::COMPLETED,
            self::COMPLETED => false,
        };
    }
}

