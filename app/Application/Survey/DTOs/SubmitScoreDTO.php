<?php

namespace App\Application\Survey\DTOs;

use Illuminate\Http\Request;

class SubmitScoreDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $department,
        public readonly array $criteriaScores = [],
        public readonly ?string $notes = null,
        public readonly float $score = 0.0
    ) {}
    
    public static function fromRequest(Request $request): self
    {
        return new self(
            userId: $request->user()->id,
            department: $request->input('department'),
            criteriaScores: $request->input('criteria_scores', []),
            notes: $request->input('notes'),
            score: 0.0 // This will be calculated in the application service
        );
    }
}
