<?php

namespace App\Enums;

enum UnitTransferStatus: string
{
    case DRAFT = 'DRAFT';
    case COMPLETED = 'COMPLETED';
    case CANCELLED = 'CANCELLED';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'secondary',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
