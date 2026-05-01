<?php

namespace App\Services;

use App\Models\ProjectSurvey;
use App\Repositories\Interfaces\IProjectSurveyRepository;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProjectSurveyService
{
    protected $repository;

    // Constants for Status
    const STATUS_DRAFT = 'DRAFT';
    const STATUS_SURVEY_PLANNED = 'SURVEY_PLANNED';
    const STATUS_SURVEY_APPROVED = 'SURVEY_APPROVED';
    const STATUS_IN_PROGRESS = 'SURVEY_IN_PROGRESS';
    const STATUS_SUBMITTED = 'SURVEY_SUBMITTED';
    const STATUS_FEASIBLE = 'PROJECT_FEASIBLE';
    const STATUS_REVISION = 'REVISION_REQUIRED';
    const STATUS_CANCELLED = 'PROJECT_CANCELLED';
    const STATUS_SKIPPED = 'SURVEY_SKIPPED';

    public function __construct(IProjectSurveyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllSurveys()
    {
        return $this->repository->getAll();
    }

    public function getSurveyQuery()
    {
        return $this->repository->getQuery();
    }

    public function getSurveyByUid($uid)
    {
        return $this->repository->getByUid($uid);
    }

    public function createSurvey($data)
    {
        // Handle skip logic
        if (isset($data['is_skipped']) && $data['is_skipped']) {
            $data['status'] = self::STATUS_SKIPPED;
        } else {
            $data['status'] = self::STATUS_DRAFT;
        }
        
        return $this->repository->create($data);
    }

    public function scheduleSurvey($uid, $data)
    {
        $survey = $this->repository->getByUid($uid);
        if (!$survey) throw new Exception("Survey not found");

        $this->repository->update($survey, [
            'scheduled_at' => $data['scheduled_at'],
            'notes' => $data['notes'] ?? null,
            'status' => self::STATUS_SURVEY_PLANNED
        ]);

        // Handle team assignment if provided
        if (isset($data['teams']) && is_array($data['teams']) && count($data['teams']) > 0) {
            // Fetch flow settings to resolve departments
            $flowSettings = \App\Models\SurveyorFlow::with('role.users')->get();
            
            // Build a map of user_id => department
            $userDeptMap = [];
            foreach ($flowSettings as $flow) {
                if ($flow->surveyor_type->value === 'USER' && $flow->user_id) {
                    // Assign user to dept. If user exists in multiple depts, the last one wins (or we could store an array)
                    // But usually, one surveyor covers one specific functional area in this setup.
                    $userDeptMap[$flow->user_id] = $flow->department;
                } elseif ($flow->surveyor_type->value === 'ROLE' && $flow->role) {
                    foreach ($flow->role->users as $u) {
                        $userDeptMap[$u->id] = $flow->department;
                    }
                }
            }

            // Transform user IDs to team data format using the map
            $teamData = collect($data['teams'])->map(function($userId) use ($userDeptMap) {
                return [
                    'user_id' => $userId,
                    'department' => $userDeptMap[$userId] ?? 'SURVEY_TEAM'
                ];
            })->toArray();
            
            $this->repository->assignTeam($survey, $teamData);
        }
        
        return $survey;
    }

    public function submitScore($uid, $department, $data)
    {
        $survey = $this->repository->getByUid($uid);
        if (!$survey) throw new Exception("Survey not found");

        // $data should contain ['score' => 85, 'notes' => 'Good']
        // Weight is fixed per department: Project=40, Workshop=30, HSE=30
        $weights = [
            'PROJECT' => 40,
            'WORKSHOP' => 30,
            'HSE' => 30
        ];

        $weight = $weights[strtoupper($department)] ?? 0;
        
        $scoreData = [
            'score' => $data['score'],
            'weight' => $weight,
            'notes' => $data['notes'] ?? null
        ];

        $this->repository->updateScores($survey, strtoupper($department), $scoreData);

        // Update main status if distinct
        if ($survey->status !== self::STATUS_IN_PROGRESS) {
            $this->repository->update($survey, ['status' => self::STATUS_IN_PROGRESS]);
        }
        
        return $survey;
    }

    public function calculateFinalResult($uid)
    {
        $survey = $this->repository->getByUid($uid);
        if (!$survey) throw new Exception("Survey not found");

        $scores = $survey->scores;
        
        // Ensure all 3 departments have scored? 
        // For now, calculate what we have.
        
        $totalWeightedScore = $scores->sum('weighted_score');
        
        // Feasibility Rule: e.g., > 70 is feasible
        $isFeasible = $totalWeightedScore >= 70;

        $this->repository->update($survey, [
            'total_score' => $totalWeightedScore,
            'is_feasible' => $isFeasible,
            'status' => self::STATUS_SUBMITTED
        ]);

        return $survey;
    }

    public function processApproval($uid, $step, $status, $notes = null)
    {
        $survey = $this->repository->getByUid($uid);
        if (!$survey) throw new Exception("Survey not found");

        $this->repository->addApproval($survey, [
            'approver_id' => Auth::id(),
            'step' => $step,
            'status' => $status,
            'notes' => $notes
        ]);

        // State Machine Logic
        if ($status === 'REJECTED') {
            $this->repository->update($survey, ['status' => self::STATUS_CANCELLED]);
        } elseif ($status === 'REVISION') {
            $this->repository->update($survey, ['status' => self::STATUS_REVISION]);
        } elseif ($status === 'APPROVED') {
            // Check if all approvals needed are done
            // Simplified: If Manager Project approves (Final Step)
            if ($step === 'MANAGER_PROJECT') {
                $status = $survey->is_feasible ? self::STATUS_FEASIBLE : self::STATUS_CANCELLED;
                $this->repository->update($survey, ['status' => $status]);
            } elseif ($step === 'MANAGER_OPS' && $survey->status === self::STATUS_SURVEY_PLANNED) {
                 $this->repository->update($survey, ['status' => self::STATUS_SURVEY_APPROVED]);
            }
        }

        return $survey;
    }
}
