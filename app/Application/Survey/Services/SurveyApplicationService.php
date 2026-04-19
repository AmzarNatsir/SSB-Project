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
            
            \Log::info('Workflow check passed, calculating detailed score');
            
            // Use application's master data instead of static frontend score
            $criteriaList = \App\Models\ScoringCriteria::with('options')->get();
            $totalEarnedPoints = 0;
            $totalMaxPoints = 0;
            $detailedScores = [];
            
            foreach ($criteriaList as $criteria) {
                // Determine max score for this criteria
                $maxOptionScore = $criteria->options->max('score') ?? 0;
                $maxCriteriaPoints = $maxOptionScore * $criteria->weighting;
                $totalMaxPoints += $maxCriteriaPoints;
                
                // Determine selected score
                $selectedOptionId = $dto->criteriaScores[$criteria->id] ?? null;
                $earnedPoints = 0;
                $optionTitle = 'N/A';
                $optionScore = 0;
                
                if ($selectedOptionId) {
                    $selectedOption = $criteria->options->firstWhere('id', $selectedOptionId);
                    if ($selectedOption) {
                        $optionScore = $selectedOption->score;
                        $earnedPoints = $optionScore * $criteria->weighting;
                        $optionTitle = $selectedOption->label;
                    }
                }
                
                $totalEarnedPoints += $earnedPoints;
                
                $detailedScores[] = [
                    'criterion_name' => $criteria->name,
                    'score' => $earnedPoints,
                    'max_score' => $maxCriteriaPoints,
                    'justification' => $optionTitle . ' (' . $optionScore . ' pts)'
                ];
            }
            
            // Calculate final percentage 0-100
            $finalPercentageScore = ($totalMaxPoints > 0) ? ($totalEarnedPoints / $totalMaxPoints) * 100 : 0;
            $finalPercentageScore = round($finalPercentageScore, 1);
            
            $weight = $this->scoringEngine->getWeight($dto->department);
            $weightedScore = $finalPercentageScore * $weight;
            
            // Create or update score record
            $score = $survey->scores()->updateOrCreate(
                ['department' => $dto->department],
                [
                    'score' => $finalPercentageScore,
                    'weight' => $weight * 100,
                    'weighted_score' => $weightedScore,
                    'notes' => $dto->notes,
                ]
            );
            
            // Delete existing detailed criteria records if any, then insert new
            $score->criteria()->delete();
            foreach ($detailedScores as $detail) {
                $score->criteria()->create($detail);
            }
            
            \Log::info('Score record created or updated', [
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
