<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class WorkforceFormationApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'WorkforceFormation')->exists()) {
            $this->command->info('WorkforceFormation Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'WorkforceFormation',
            'name' => 'Workforce Formation Approval',
            'description' => 'Approval untuk pembentukan tim/personel lapangan per proyek.',
            'is_active' => true,
        ]);

        // Level 1: Project Manager (default ke user pertama; admin bisa update via UI Approval Matrix)
        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('WorkforceFormation Approval Flow seeded.');
    }
}
