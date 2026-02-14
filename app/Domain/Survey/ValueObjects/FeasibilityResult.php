<?php

namespace App\Domain\Survey\ValueObjects;

final class FeasibilityResult
{
    public function __construct(
        public readonly bool $isFeasible,
        public readonly float $score,
        public readonly float $threshold,
        public readonly string $recommendation
    ) {}
    
    public function toArray(): array
    {
        return [
            'is_feasible' => $this->isFeasible,
            'score' => $this->score,
            'threshold' => $this->threshold,
            'recommendation' => $this->recommendation,
        ];
    }
}
