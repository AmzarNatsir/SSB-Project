<?php

namespace App\Enums;

enum SurveyDepartment: string
{
    case PROJECT  = 'PROJECT';
    case WORKSHOP = 'WORKSHOP';
    case HSE      = 'HSE';
    case FINANCE  = 'FINANCE';
    case HRD      = 'HRD';

    public function label(): string
    {
        return match($this) {
            self::PROJECT  => 'Departemen Project',
            self::WORKSHOP => 'Departemen Workshop',
            self::HSE      => 'Departemen HSE',
            self::FINANCE  => 'Departemen Finance',
            self::HRD      => 'Departemen HRD',
        };
    }
}
