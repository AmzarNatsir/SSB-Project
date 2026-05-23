<?php

namespace App\Enums;

enum UnitRequestStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case FORWARDED_TO_WORKSHOP = 'FORWARDED_TO_WORKSHOP';
    case APPROVED_FROM_WORKSHOP = 'APPROVED_FROM_WORKSHOP';
    case REJECTED_FROM_WORKSHOP = 'REJECTED_FROM_WORKSHOP';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Diajukan',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
            self::FORWARDED_TO_WORKSHOP => 'Diteruskan ke Workshop',
            self::APPROVED_FROM_WORKSHOP => 'Disetujui Workshop',
            self::REJECTED_FROM_WORKSHOP => 'Ditolak Workshop',
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
            self::APPROVED_FROM_WORKSHOP => 'success',
            self::REJECTED_FROM_WORKSHOP => 'danger',
        };
    }

    public function canTransitionTo(UnitRequestStatus $newStatus): bool
    {
        return match($this) {
            self::DRAFT => $newStatus === self::SUBMITTED,
            self::SUBMITTED => in_array($newStatus, [self::APPROVED, self::REJECTED]),
            self::REJECTED => $newStatus === self::SUBMITTED,
            self::APPROVED => $newStatus === self::FORWARDED_TO_WORKSHOP,
            self::FORWARDED_TO_WORKSHOP => in_array($newStatus, [
                self::APPROVED_FROM_WORKSHOP,
                self::REJECTED_FROM_WORKSHOP,
            ]),
            self::APPROVED_FROM_WORKSHOP, self::REJECTED_FROM_WORKSHOP => false,
        };
    }
}
