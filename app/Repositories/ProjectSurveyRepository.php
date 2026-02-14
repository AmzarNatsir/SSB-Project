<?php

namespace App\Repositories;

use App\Models\ProjectSurvey;
use App\Models\ProjectSurveyTeam;
use App\Models\ProjectSurveyScore;
use App\Models\ProjectSurveyDocument;
use App\Models\ProjectSurveyApproval;
use App\Repositories\Interfaces\IProjectSurveyRepository;
use Illuminate\Support\Facades\DB;

class ProjectSurveyRepository implements IProjectSurveyRepository
{
    public function getAll()
    {
        return ProjectSurvey::with(['project', 'teams.user', 'approvals.approver'])
            ->latest()
            ->get();
    }

    public function getQuery()
    {
        return ProjectSurvey::with(['project', 'teams.user', 'approvals.approver'])
            ->select('project_surveys.*');
    }

    public function getByUid(string $uid): ?ProjectSurvey
    {
        return ProjectSurvey::where('uid', $uid)
            ->with(['project', 'teams.user', 'scores', 'documents.uploader', 'approvals.approver'])
            ->first();
    }

    public function create(array $data): ProjectSurvey
    {
        return ProjectSurvey::create($data);
    }

    public function update(ProjectSurvey $survey, array $data): bool
    {
        return $survey->update($data);
    }

    public function delete(ProjectSurvey $survey): bool
    {
        return $survey->delete();
    }

    public function assignTeam(ProjectSurvey $survey, array $teamData)
    {
        // $teamData = [['user_id' => 1, 'department' => 'PROJECT'], ...]
        // Wipe existing team for clean slate or handle incrementally
        // For wizard style, we might sync
        
        DB::transaction(function () use ($survey, $teamData) {
            $survey->teams()->delete(); // Remove existing
            foreach ($teamData as $member) {
                ProjectSurveyTeam::create([
                    'survey_id' => $survey->id,
                    'user_id' => $member['user_id'],
                    'department' => $member['department']
                ]);
            }
        });
    }

    public function updateScores(ProjectSurvey $survey, string $department, array $scores)
    {
        // $scores = [['score' => 80, 'weight' => 30, 'notes' => '...']]
        // Usually one score entry per department acting as a summary, 
        // or multiple if detailed items. Reqt says "department scoring".
        // Assuming one summary score per department for now based on formula.
        
        ProjectSurveyScore::updateOrCreate(
            ['survey_id' => $survey->id, 'department' => $department],
            [
                'score' => $scores['score'],
                'weight' => $scores['weight'],
                'weighted_score' => $scores['score'] * ($scores['weight'] / 100),
                'notes' => $scores['notes'] ?? null
            ]
        );
    }

    public function addDocument(ProjectSurvey $survey, array $documentData)
    {
        return ProjectSurveyDocument::create([
            'survey_id' => $survey->id,
            'file_path' => $documentData['file_path'],
            'file_name' => $documentData['file_name'],
            'file_type' => $documentData['file_type'] ?? 'Berita Acara',
            'uploaded_by' => $documentData['uploaded_by']
        ]);
    }

    public function addApproval(ProjectSurvey $survey, array $approvalData)
    {
        return ProjectSurveyApproval::create([
            'survey_id' => $survey->id,
            'approver_id' => $approvalData['approver_id'],
            'step' => $approvalData['step'],
            'status' => $approvalData['status'],
            'notes' => $approvalData['notes'] ?? null
        ]);
    }
}
