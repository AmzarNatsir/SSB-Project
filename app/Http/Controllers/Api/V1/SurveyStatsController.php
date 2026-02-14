<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ProjectSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyStatsController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function dashboard()
    {
        $stats = [
            'total' => ProjectSurvey::count(),
            'in_progress' => ProjectSurvey::whereIn('status', ['IN_PROGRESS', 'SCORING'])->count(),
            'feasible' => ProjectSurvey::where('is_feasible', true)->count(),
            'pending_approval' => ProjectSurvey::where('status', 'PENDING_APPROVAL')->count(),
            'completed' => ProjectSurvey::where('status', 'COMPLETED')->count(),
            'rejected' => ProjectSurvey::where('status', 'REJECTED')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get survey status
     */
    public function status($uid)
    {
        $survey = ProjectSurvey::where('uid', $uid)->firstOrFail();
        
        return response()->json([
            'status' => $survey->status,
            'total_score' => $survey->total_score,
            'is_feasible' => $survey->is_feasible,
            'updated_at' => $survey->updated_at->toIso8601String(),
        ]);
    }

    /**
     * Get score details
     */
    public function scoreDetails($scoreId)
    {
        $score = \App\Models\ProjectSurveyScore::with(['survey', 'submitter'])
            ->findOrFail($scoreId);
        
        return response()->json([
            'department' => $score->department,
            'raw_score' => $score->raw_score,
            'weighted_score' => $score->weighted_score,
            'weight_percentage' => $score->weight_percentage,
            'criteria_scores' => $score->criteria_scores,
            'notes' => $score->notes,
            'submitted_by' => $score->submitter->name ?? '-',
            'submitted_at' => $score->submitted_at->format('d M Y H:i'),
        ]);
    }
}
