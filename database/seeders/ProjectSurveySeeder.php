<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectSurvey;
use App\Models\ProjectSurveyTeam;
use App\Models\ProjectSurveyScore;
use App\Models\ProjectSurveyApproval;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSurveySeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        if ($projects->isEmpty()) {
            $this->command->warn("No projects found, skipping ProjectSurveySeeder.");
            return;
        }

        // Ensure we have at least 3 users for team assignment
        $users = User::all();
        if ($users->count() < 3) {
            // Seed a few dummy users
            $dummyData = [
                ['name' => 'John Project', 'email' => 'john.project@mail.com'],
                ['name' => 'Mike Workshop', 'email' => 'mike.workshop@mail.com'],
                ['name' => 'Sara HSE', 'email' => 'sara.hse@mail.com'],
            ];
            foreach ($dummyData as $u) {
                User::firstOrCreate(
                    ['email' => $u['email']],
                    [
                        'name' => $u['name'],
                        'password' => bcrypt('password'),
                        'email_verified_at' => now(),
                    ]
                );
            }
            $users = User::all();
        }

        $userIds = $users->pluck('id')->toArray();
        $statuses = [
            'DRAFT', 'SURVEY_PLANNED', 'SURVEY_IN_PROGRESS', 
            'PROJECT_FEASIBLE', 'COMPLETED', 'PROJECT_CANCELLED', 
            'REJECTED', 'SURVEY_SKIPPED'
        ];

        // Seed 15 surveys
        for ($i = 0; $i < 15; $i++) {
            $project = $projects->random();
            $status = $statuses[$i % count($statuses)];
            $isSkipped = ($status === 'SURVEY_SKIPPED');
            $scheduledAt = Carbon::create(2026, 6, rand(1, 12), rand(8, 17), 0, 0);

            // 1. Create Project Survey
            $survey = new ProjectSurvey();
            $survey->uid = (string) Str::uuid();
            $survey->project_id = $project->id;
            $survey->status = $status;
            $survey->is_skipped = $isSkipped;
            $survey->skip_reason = $isSkipped ? 'Proyek dianggap minor dan tidak memerlukan kunjungan langsung.' : null;
            $survey->scheduled_at = $isSkipped ? null : $scheduledAt;
            $survey->created_by = $userIds[0];
            $survey->save();

            if ($isSkipped) {
                continue;
            }

            // 2. Assign Surveyor Team
            $depts = ['PROJECT', 'WORKSHOP', 'HSE'];
            foreach ($depts as $idx => $dept) {
                ProjectSurveyTeam::create([
                    'uid' => (string) Str::uuid(),
                    'survey_id' => $survey->id,
                    'user_id' => $userIds[$idx % count($userIds)],
                    'department' => $dept,
                ]);
            }

            // 3. Set Scores if survey has progressed beyond PLANNED
            if (!in_array($status, ['DRAFT', 'SURVEY_PLANNED'])) {
                $scoresList = [
                    'PROJECT' => ['score' => rand(70, 95), 'weight' => 40],
                    'WORKSHOP' => ['score' => rand(65, 95), 'weight' => 30],
                    'HSE' => ['score' => rand(60, 90), 'weight' => 30],
                ];

                $totalWeighted = 0;
                foreach ($scoresList as $dept => $s) {
                    $weighted = $s['score'] * ($s['weight'] / 100);
                    $totalWeighted += $weighted;

                    ProjectSurveyScore::create([
                        'uid' => (string) Str::uuid(),
                        'survey_id' => $survey->id,
                        'department' => $dept,
                        'score' => $s['score'],
                        'weight' => $s['weight'],
                        'weighted_score' => $weighted,
                        'notes' => 'Catatan penilaian departemen ' . $dept,
                    ]);
                }

                // Update final results
                $survey->total_score = $totalWeighted;
                $survey->is_feasible = ($totalWeighted >= 70);
                $survey->save();
            }

            // 4. Create Approvals
            if (in_array($status, ['PROJECT_FEASIBLE', 'COMPLETED', 'REJECTED'])) {
                $steps = ['PRE_SURVEY_APPROVAL', 'MANAGER_OPS', 'MANAGER_PROJECT'];
                foreach ($steps as $idx => $step) {
                    $appStatus = 'APPROVED';
                    if ($status === 'REJECTED' && $step === 'MANAGER_PROJECT') {
                        $appStatus = 'REJECTED';
                    }

                    ProjectSurveyApproval::create([
                        'uid' => (string) Str::uuid(),
                        'survey_id' => $survey->id,
                        'approver_id' => $userIds[$idx % count($userIds)],
                        'step' => $step,
                        'status' => $appStatus,
                        'notes' => 'Persetujuan otomatis langkah ' . $step,
                    ]);
                }
            }
        }

        $this->command->info("Seeded 15 Project Survey logs successfully!");
    }
}
