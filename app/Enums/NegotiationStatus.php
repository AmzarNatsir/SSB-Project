<?php

namespace App\Enums;

enum NegotiationStatus: string
{
    case DRAFT = 'DRAFT';
    case NEGOTIATING = 'NEGOTIATING'; // Rounds in progress
    case SUBMITTED = 'SUBMITTED'; // Waiting for internal approval
    case APPROVED = 'APPROVED'; // Deal sealed
    case REJECTED = 'REJECTED'; // Deal failed or internal rejection

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::NEGOTIATING => 'Negotiating',
            self::SUBMITTED => 'Submitted for Approval',
            self::APPROVED => 'Approved (Deal)',
            self::REJECTED => 'Rejected',
        };
    }
    
    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::NEGOTIATING => 'info',
            self::SUBMITTED => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
