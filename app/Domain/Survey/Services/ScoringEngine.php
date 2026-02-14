<?php

namespace App\Domain\Survey\Services;

use App\Domain\Survey\ValueObjects\FeasibilityResult;

class ScoringEngine
{
    private const WEIGHTS = [
        'PROJECT' => 0.40,
        'WORKSHOP' => 0.30,
        'HSE' => 0.30,
    ];
    
    private const FEASIBILITY_THRESHOLD = 70.0;
    
    /**
     * Calculate total weighted score from department scores
     */
    public function calculateTotalScore(array $departmentScores): float
    {
        $totalScore = 0.0;
        
        foreach ($departmentScores as $department => $score) {
            $weight = self::WEIGHTS[$department] ?? 0;
            $totalScore += $score * $weight;
        }
        
        return round($totalScore, 2);
    }
    
    /**
     * Determine project feasibility based on total score
     */
    public function determineFeasibility(float $totalScore): FeasibilityResult
    {
        $isFeasible = $totalScore >= self::FEASIBILITY_THRESHOLD;
        
        return new FeasibilityResult(
            isFeasible: $isFeasible,
            score: $totalScore,
            threshold: self::FEASIBILITY_THRESHOLD,
            recommendation: $this->getRecommendation($totalScore)
        );
    }
    
    /**
     * Get recommendation based on score
     */
    private function getRecommendation(float $score): string
    {
        return match(true) {
            $score >= 90 => 'Highly Feasible - Proceed immediately with full confidence',
            $score >= 80 => 'Feasible - Proceed with confidence',
            $score >= 70 => 'Feasible - Minor improvements recommended before proceeding',
            $score >= 60 => 'Marginal - Significant improvements required',
            $score >= 50 => 'Not Feasible - Major revisions needed',
            default => 'Not Feasible - Project requires fundamental redesign'
        };
    }
    
    /**
     * Validate that all required department scores are present and valid
     */
    public function validateScores(array $scores): bool
    {
        $requiredDepartments = array_keys(self::WEIGHTS);
        
        foreach ($requiredDepartments as $dept) {
            if (!isset($scores[$dept]) || $scores[$dept] < 0 || $scores[$dept] > 100) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get weight for a specific department
     */
    public function getWeight(string $department): float
    {
        return self::WEIGHTS[$department] ?? 0.0;
    }
    
    /**
     * Get all department weights
     */
    public function getWeights(): array
    {
        return self::WEIGHTS;
    }
    
    /**
     * Get feasibility threshold
     */
    public function getThreshold(): float
    {
        return self::FEASIBILITY_THRESHOLD;
    }
}
