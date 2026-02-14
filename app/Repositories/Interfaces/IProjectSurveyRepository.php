<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectSurvey;
use Illuminate\Database\Eloquent\Collection;

interface IProjectSurveyRepository
{
    public function getAll();
    public function getQuery();
    public function getByUid(string $uid): ?ProjectSurvey;
    public function create(array $data): ProjectSurvey;
    public function update(ProjectSurvey $survey, array $data): bool;
    public function delete(ProjectSurvey $survey): bool;
    
    // Relationship management
    public function assignTeam(ProjectSurvey $survey, array $teamData);
    public function updateScores(ProjectSurvey $survey, string $department, array $scores);
    public function addDocument(ProjectSurvey $survey, array $documentData);
    public function addApproval(ProjectSurvey $survey, array $approvalData);
}
