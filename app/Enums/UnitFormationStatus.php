<?php

namespace App\Enums;

enum UnitFormationStatus: string
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
}
