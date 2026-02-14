<?php

namespace App\Domain\Survey\ValueObjects;

use InvalidArgumentException;

final class SurveyStatus
{
    private const DRAFT = 'DRAFT';
    private const SCHEDULED = 'SCHEDULED';
    private const IN_PROGRESS = 'IN_PROGRESS';
    private const SCORING = 'SCORING';
    private const PENDING_APPROVAL = 'PENDING_APPROVAL';
    private const APPROVED = 'APPROVED';
    private const COMPLETED = 'COMPLETED';
    private const REJECTED = 'REJECTED';
    private const SKIPPED = 'SKIPPED';
    
    private const VALID_STATUSES = [
        self::DRAFT,
        self::SCHEDULED,
        self::IN_PROGRESS,
        self::SCORING,
        self::PENDING_APPROVAL,
        self::APPROVED,
        self::COMPLETED,
        self::REJECTED,
        self::SKIPPED,
    ];
    
    private const TRANSITIONS = [
        self::DRAFT => [self::SCHEDULED, self::SKIPPED],
        self::SCHEDULED => [self::IN_PROGRESS],
        self::IN_PROGRESS => [self::SCORING],
        self::SCORING => [self::PENDING_APPROVAL],
        self::PENDING_APPROVAL => [self::APPROVED, self::REJECTED],
        self::APPROVED => [self::COMPLETED],
    ];
    
    private function __construct(private string $value)
    {
        if (!in_array($value, self::VALID_STATUSES, true)) {
            throw new InvalidArgumentException("Invalid survey status: {$value}");
        }
    }
    
    public static function fromString(string $status): self
    {
        return new self($status);
    }
    
    public static function draft(): self
    {
        return new self(self::DRAFT);
    }
    
    public static function scheduled(): self
    {
        return new self(self::SCHEDULED);
    }
    
    public static function inProgress(): self
    {
        return new self(self::IN_PROGRESS);
    }
    
    public static function scoring(): self
    {
        return new self(self::SCORING);
    }
    
    public static function pendingApproval(): self
    {
        return new self(self::PENDING_APPROVAL);
    }
    
    public static function approved(): self
    {
        return new self(self::APPROVED);
    }
    
    public static function completed(): self
    {
        return new self(self::COMPLETED);
    }
    
    public static function rejected(): self
    {
        return new self(self::REJECTED);
    }
    
    public static function skipped(): self
    {
        return new self(self::SKIPPED);
    }
    
    public function canTransitionTo(SurveyStatus $newStatus): bool
    {
        return in_array($newStatus->value, self::TRANSITIONS[$this->value] ?? [], true);
    }
    
    public function toString(): string
    {
        return $this->value;
    }
    
    public function equals(SurveyStatus $other): bool
    {
        return $this->value === $other->value;
    }
    
    public function isDraft(): bool
    {
        return $this->value === self::DRAFT;
    }
    
    public function isCompleted(): bool
    {
        return $this->value === self::COMPLETED;
    }
    
    public function isSkipped(): bool
    {
        return $this->value === self::SKIPPED;
    }
    
    public function isPendingApproval(): bool
    {
        return $this->value === self::PENDING_APPROVAL;
    }
}
