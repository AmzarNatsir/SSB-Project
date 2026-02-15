<?php

namespace App\Enums;

enum ApproverType: string
{
    case USER = 'USER';
    case ROLE = 'ROLE';
    case DEPARTMENT = 'DEPARTMENT';

    public function label(): string
    {
        return match($this) {
            self::USER => 'Specific User',
            self::ROLE => 'Specific Role',
            self::DEPARTMENT => 'Department Head',
        };
    }
}
