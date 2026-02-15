<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Project Budget Flow
        $budgetFlow = \App\Models\ApprovalFlow::create([
            'code' => 'PROJECT_BUDGET',
            'name' => 'Project Budget Approval',
            'description' => 'Multi-level approval for project budgets.',
            'is_active' => true,
        ]);

        $budgetFlow->levels()->create([
            'level_number' => 1,
            'approver_type' => \App\Enums\ApproverType::USER,
            'approver_user_id' => 1, // Defaulting to first user for now
            'is_mandatory' => true,
        ]);

        $budgetFlow->levels()->create([
            'level_number' => 2,
            'approver_type' => \App\Enums\ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        // Project Survey Flow
        \App\Models\ApprovalFlow::create([
            'code' => 'PROJECT_SURVEY',
            'name' => 'Project Survey Approval',
            'description' => 'Approval for project feasibility surveys.',
            'is_active' => true,
        ]);
    }
}
