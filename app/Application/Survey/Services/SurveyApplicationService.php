<?php

namespace App\Application\Survey\Services;

use App\Models\ProjectSurvey;
use App\Domain\Survey\Services\SurveyWorkflowService;
use App\Domain\Survey\Services\ScoringEngine;
use App\Domain\Survey\Events\SurveyCreated;
use App\Domain\Survey\Events\ScoreSubmitted;
use App\Application\Survey\DTOs\CreateSurveyDTO;
use App\Application\Survey\DTOs\SubmitScoreDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class SurveyApplicationService
{
    public function __construct(
        private SurveyWorkflowService $workflowService,
        private ScoringEngine $scoringEngine
    ) {}
    
    /**
     * Create a new survey
     */
    public function createSurvey(CreateSurveyDTO $dto): ProjectSurvey
    {
        return DB::transaction(function () use ($dto) {
            $survey = ProjectSurvey::create([
                'project_id' => $dto->projectId,
                'created_by' => $dto->userId,
                'status' => 'DRAFT',
                'is_skipped' => $dto->isSkipped,
                'skip_reason' => $dto->skipReason,
                'metadata' => $dto->metadata,
            ]);
            
            // Update project status to indicate survey is initiated
            $project = \App\Models\Project::find($dto->projectId);
            if ($project) {
                $project->update([
                    'project_status' => 'ON PROGRESS'
                ]);
            }
            
            Event::dispatch(new SurveyCreated($survey));
            
            return $survey;
        });
    }
    
    /**
     * Submit a department score
     */
    public function submitScore(string $surveyUid, SubmitScoreDTO $dto): void
    {
        \Log::info('submitScore called', [
            'surveyUid' => $surveyUid,
            'department' => $dto->department,
            'score' => $dto->score,
            'userId' => $dto->userId
        ]);
        
        DB::transaction(function () use ($surveyUid, $dto) {
            $survey = ProjectSurvey::where('uid', $surveyUid)->firstOrFail();
            
            \Log::info('Survey found', [
                'survey_id' => $survey->id,
                'status' => $survey->status
            ]);
            
            if (!$this->workflowService->canSubmitScore($survey, $dto->department)) {
                \Log::error('Cannot submit score - workflow check failed', [
                    'survey_status' => $survey->status,
                    'department' => $dto->department
                ]);
                throw new \DomainException('Cannot submit score at this time');
            }
            
            \Log::info('Workflow check passed, creating score record');
            
            $weight = $this->scoringEngine->getWeight($dto->department);
            $weightedScore = $dto->score * $weight;
            
            // Create score record - using correct field names from migration
            $score = $survey->scores()->create([
                'department' => $dto->department,
                'score' => $dto->score,  // Changed from raw_score
                'weight' => $weight * 100,  // Changed from weight_percentage
                'weighted_score' => $weightedScore,
                'notes' => $dto->notes,
            ]);
            
            \Log::info('Score record created', [
                'score_id' => $score->id,
                'department' => $score->department,
                'score' => $score->score,
                'weighted_score' => $score->weighted_score
            ]);
            
            // Recalculate total score
            $this->recalculateTotalScore($survey);
            
            \Log::info('Total score recalculated', [
                'total_score' => $survey->fresh()->total_score
            ]);
            
            Event::dispatch(new ScoreSubmitted($survey, $score));
        });
        
        \Log::info('submitScore completed successfully');
    }
    
    /**
     * Recalculate survey total score
     */
    private function recalculateTotalScore(ProjectSurvey $survey): void
    {
        $scores = $survey->scores()
            ->pluck('score', 'department')  // Changed from raw_score
            ->toArray();
        
        if ($this->scoringEngine->validateScores($scores)) {
            $totalScore = $this->scoringEngine->calculateTotalScore($scores);
            $feasibility = $this->scoringEngine->determineFeasibility($totalScore);
            
            $survey->update([
                'total_score' => $totalScore,
                'is_feasible' => $feasibility->isFeasible,
                'metadata' => array_merge($survey->metadata ?? [], [
                    'feasibility_recommendation' => $feasibility->recommendation,
                    'last_calculated_at' => now()->toIso8601String(),
                ]),
            ]);
            
            // Update project status based on feasibility
            $project = $survey->project;
            if ($project) {
                $newStatus = $feasibility->isFeasible 
                    ? 'COMPLETED'  // Feasible projects can proceed
                    : 'ON HOLD';   // Non-feasible projects need revision
                    
                $project->update([
                    'project_status' => $newStatus
                ]);
            }
        }
    }
}
