<?php

namespace App\Enums;

enum ContractStatus: string
{
    case DRAFT = 'DRAFT';
    case ACTIVE = 'ACTIVE';
    case EXPIRED = 'EXPIRED';
    case TERMINATED = 'TERMINATED';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::EXPIRED => 'Expired',
            self::TERMINATED => 'Terminated',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::ACTIVE => 'success',
            self::EXPIRED => 'warning',
            self::TERMINATED => 'danger',
        };
    }
}
