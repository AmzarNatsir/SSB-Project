<?php

namespace App\Domain\Survey\Services;

use App\Domain\Survey\ValueObjects\FeasibilityResult;
use App\Models\Scoring;
use App\Enums\SurveyDepartment;

class ScoringEngine
{
    private const FEASIBILITY_THRESHOLD = 70.0;

    /**
     * Get weights from database mapped to Enum values
     */
    public function getWeights(): array
    {
        $scoringData = Scoring::all();
        $weights = [];
        
        foreach (SurveyDepartment::cases() as $case) {
            $found = $scoringData->where('nama_departemen', $case->label())->first();
            if ($found) {
                // Bobot in DB is usually 0-100, we need fraction 0.0-1.0
                $weights[$case->value] = (float)$found->bobot / 100;
            } else {
                $weights[$case->value] = 0;
            }
        }
        
        return $weights;
    }

    /**
     * Get weight for a specific department
     */
    public function getWeight(string $department): float
    {
        $weights = $this->getWeights();
        return $weights[strtoupper($department)] ?? 0.0;
    }

    /**
     * Calculate total weighted score from department scores
     */
    public function calculateTotalScore(array $departmentScores): float
    {
        $totalScore = 0.0;
        $weights = $this->getWeights();
        
        foreach ($departmentScores as $department => $score) {
            $weight = $weights[$department] ?? 0;
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
        $weights = $this->getWeights();
        $requiredDepts = array_keys(array_filter($weights, fn($w) => $w > 0));

        foreach ($requiredDepts as $dept) {
            if (!isset($scores[$dept])) {
                return false;
            }
            if ($scores[$dept] < 0 || $scores[$dept] > 100) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Get feasibility threshold
     */
    public function getThreshold(): float
    {
        return self::FEASIBILITY_THRESHOLD;
    }
}
