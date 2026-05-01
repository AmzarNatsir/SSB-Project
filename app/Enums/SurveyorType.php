<?php

namespace App\Enums;

enum SurveyorType: string
{
    case USER = 'USER';
    case ROLE = 'ROLE';

    public function label(): string
    {
        return match($this) {
            self::USER => 'Specific User',
            self::ROLE => 'By Role',
        };
    }
}
