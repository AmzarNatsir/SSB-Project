<?php

namespace App\Enums;

enum UnitRequestStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case FORWARDED_TO_WORKSHOP = 'FORWARDED_TO_WORKSHOP';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::FORWARDED_TO_WORKSHOP => 'Forwarded to Workshop',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::SUBMITTED => 'info',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            self::FORWARDED_TO_WORKSHOP => 'primary',
        };
    }

    public function canTransitionTo(UnitRequestStatus $newStatus): bool
    {
        return match($this) {
            self::DRAFT => $newStatus === self::SUBMITTED,
            self::SUBMITTED => in_array($newStatus, [self::APPROVED, self::REJECTED]),
            self::REJECTED => $newStatus === self::SUBMITTED,
            self::APPROVED => $newStatus === self::FORWARDED_TO_WORKSHOP,
            self::FORWARDED_TO_WORKSHOP => false,
        };
    }
}
