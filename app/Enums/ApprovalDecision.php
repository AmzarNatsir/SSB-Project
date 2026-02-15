<?php

namespace App\Enums;

enum ApprovalDecision: string
{
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case REVISION = 'REVISION';

    public function label(): string
    {
        return match($this) {
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::REVISION => 'Revision Requested',
        };
    }
}
