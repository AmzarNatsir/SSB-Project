<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case DRAFT     = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED  = 'APPROVED';
    case REJECTED  = 'REJECTED';
    case PAID      = 'PAID';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT     => 'Draft',
            self::SUBMITTED => 'Diajukan',
            self::APPROVED  => 'Disetujui',
            self::REJECTED  => 'Ditolak',
            self::PAID      => 'Lunas',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT     => 'secondary',
            self::SUBMITTED => 'info',
            self::APPROVED  => 'success',
            self::REJECTED  => 'danger',
            self::PAID      => 'primary',
        };
    }
}
