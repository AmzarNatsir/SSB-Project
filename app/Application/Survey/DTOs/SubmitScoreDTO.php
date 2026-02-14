<?php

namespace App\Application\Survey\DTOs;

use Illuminate\Http\Request;

class SubmitScoreDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $department,
        public readonly float $score,
        public readonly array $criteriaScores = [],
        public readonly ?string $notes = null
    ) {}
    
    public static function fromRequest(Request $request): self
    {
        return new self(
            userId: $request->user()->id,
            department: $request->input('department'),
            score: (float) $request->input('score'),
            criteriaScores: $request->input('criteria_scores', []),
            notes: $request->input('notes')
        );
    }
}
