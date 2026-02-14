<?php

namespace App\Domain\Survey\Services;

use App\Models\ProjectSurvey;
use App\Domain\Survey\ValueObjects\SurveyStatus;
use App\Domain\Survey\Exceptions\InvalidSurveyStateException;

class SurveyWorkflowService
{
    public function __construct(
        private ScoringEngine $scoringEngine
    ) {}
    
    /**
     * Transition survey to a new status with validation
     */
    public function transitionTo(ProjectSurvey $survey, SurveyStatus $newStatus): void
    {
        $currentStatus = SurveyStatus::fromString($survey->status);
        
        if (!$currentStatus->canTransitionTo($newStatus)) {
            throw new InvalidSurveyStateException(
                "Cannot transition from {$currentStatus->toString()} to {$newStatus->toString()}"
            );
        }
        
        $survey->status = $newStatus->toString();
    }
    
    /**
     * Check if a department can submit a score
     */
    public function canSubmitScore(ProjectSurvey $survey, string $department): bool
    {
        $validStatuses = ['IN_PROGRESS', 'SCORING'];
        
        if (!in_array($survey->status, $validStatuses)) {
            return false;
        }
        
        // Check if department hasn't already submitted
        return !$survey->scores()
            ->where('department', $department)
            ->exists();
    }
    
    /**
     * Check if survey can request approval
     */
    public function canRequestApproval(ProjectSurvey $survey): bool
    {
        // All departments must have submitted scores
        $requiredDepartments = array_keys($this->scoringEngine->getWeights());
        $submittedDepartments = $survey->scores()
            ->pluck('department')
            ->unique()
            ->toArray();
        
        return count(array_diff($requiredDepartments, $submittedDepartments)) === 0;
    }
    
    /**
     * Determine if survey should be auto-approved
     */
    public function shouldAutoApprove(ProjectSurvey $survey): bool
    {
        // Auto-approve if score is exceptionally high
        return $survey->total_score >= 95.0;
    }
    
    /**
     * Check if survey can be completed
     */
    public function canComplete(ProjectSurvey $survey): bool
    {
        return $survey->status === 'APPROVED' && $survey->is_feasible === true;
    }
    
    /**
     * Get next required action for survey
     */
    public function getNextAction(ProjectSurvey $survey): string
    {
        return match($survey->status) {
            'DRAFT' => 'Schedule survey or skip',
            'SCHEDULED' => 'Start survey execution',
            'IN_PROGRESS' => 'Submit department scores',
            'SCORING' => 'Complete all department scoring',
            'PENDING_APPROVAL' => 'Await manager approval',
            'APPROVED' => 'Complete survey',
            'COMPLETED' => 'No action required',
            'REJECTED' => 'Review and revise',
            'SKIPPED' => 'No action required',
            default => 'Unknown status'
        };
    }
}
