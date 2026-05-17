<?php

namespace App\Enums;

enum WorkforceFormationStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED = 'APPROVED';
    case ACTIVE = 'ACTIVE';
    case REVISED = 'REVISED';
    case ENDED = 'ENDED';
    case REJECTED = 'REJECTED';

    public function label(): string
    {
        return match($this) {
            self::DRAFT     => 'Draft',
            self::SUBMITTED => 'Diajukan',
            self::APPROVED  => 'Disetujui',
            self::ACTIVE    => 'Aktif',
            self::REVISED   => 'Direvisi',
            self::ENDED     => 'Berakhir',
            self::REJECTED  => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT     => 'secondary',
            self::SUBMITTED => 'info',
            self::APPROVED  => 'primary',
            self::ACTIVE    => 'success',
            self::REVISED   => 'warning',
            self::ENDED     => 'dark',
            self::REJECTED  => 'danger',
        };
    }

    public function canTransitionTo(self $newStatus): bool
    {
        return match($this) {
            self::DRAFT     => $newStatus === self::SUBMITTED,
            self::SUBMITTED => in_array($newStatus, [self::APPROVED, self::REJECTED]),
            self::APPROVED  => $newStatus === self::ACTIVE,
            self::ACTIVE    => in_array($newStatus, [self::REVISED, self::ENDED]),
            self::REVISED   => $newStatus === self::SUBMITTED,
            self::REJECTED  => $newStatus === self::SUBMITTED,
            self::ENDED     => false,
        };
    }
}
