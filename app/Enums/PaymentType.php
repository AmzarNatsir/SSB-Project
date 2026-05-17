<?php

namespace App\Enums;

enum PaymentType: string
{
    case TUNAI    = 'TUNAI';
    case TRANSFER = 'TRANSFER';

    public function label(): string
    {
        return match ($this) {
            self::TUNAI    => 'Tunai',
            self::TRANSFER => 'Transfer',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::TUNAI    => 'ti-cash',
            self::TRANSFER => 'ti-building-bank',
        };
    }
}
