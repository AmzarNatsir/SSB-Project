<?php

namespace App\Application\Survey\DTOs;

use Illuminate\Http\Request;

class CreateSurveyDTO
{
    public function __construct(
        public readonly int $projectId,
        public readonly int $userId,
        public readonly bool $isSkipped = false,
        public readonly ?string $skipReason = null,
        public readonly array $metadata = []
    ) {}
    
    public static function fromRequest(Request $request): self
    {
        return new self(
            projectId: $request->input('project_id'),
            userId: $request->user()->id,
            isSkipped: $request->boolean('is_skipped'),
            skipReason: $request->input('skip_reason'),
            metadata: $request->input('metadata', [])
        );
    }
}
