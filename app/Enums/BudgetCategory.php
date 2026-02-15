<?php

namespace App\Enums;

enum BudgetCategory: string
{
    case LABOR = 'LABOR';
    case EQUIPMENT = 'EQUIPMENT';
    case MAINTENANCE = 'MAINTENANCE';
    case OPERATIONAL = 'OPERATIONAL';
    case MOBILIZATION = 'MOBILIZATION';
    case OTHER = 'OTHER';

    public function label(): string
    {
        return match($this) {
            self::LABOR => 'Labor Costs',
            self::EQUIPMENT => 'Equipment Ownership Costs',
            self::MAINTENANCE => 'Maintenance Costs',
            self::OPERATIONAL => 'Operational Costs',
            self::MOBILIZATION => 'Mobilization Costs',
            self::OTHER => 'Other Costs',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::LABOR => 'ti-users',
            self::EQUIPMENT => 'ti-tool',
            self::MAINTENANCE => 'ti-settings',
            self::OPERATIONAL => 'ti-bolt',
            self::MOBILIZATION => 'ti-truck',
            self::OTHER => 'ti-box',
        };
    }
}
