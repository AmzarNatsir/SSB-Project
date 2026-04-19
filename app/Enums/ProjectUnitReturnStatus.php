<?php

namespace App\Enums;

enum ProjectUnitReturnStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case COMPLETED = 'COMPLETED';

    public function label(): string
    {
        return match($this) {
            self::DRAFT     => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::APPROVED  => 'Approved',
            self::REJECTED  => 'Rejected',
            self::COMPLETED => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT     => 'secondary',
            self::SUBMITTED => 'info',
            self::APPROVED  => 'success',
            self::REJECTED  => 'danger',
            self::COMPLETED => 'primary',
        };
    }
}
