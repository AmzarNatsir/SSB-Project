<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class UnitRequestApprovalFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Idempotent: skip if already seeded
        if (ApprovalFlow::where('code', 'UnitRequest')->exists()) {
            $this->command->info('UnitRequest Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code'        => 'UnitRequest',
            'name'        => 'Unit Request Approval',
            'description' => 'Project Manager approval for unit/equipment requests.',
            'is_active'   => true,
        ]);

        // Level 1: Project Manager
        $flow->levels()->create([
            'level_number'     => 1,
            'approver_type'    => ApproverType::USER,
            'approver_user_id' => 1, // Default to first user; update via Approval Flow admin UI
            'is_mandatory'     => true,
        ]);

        $this->command->info('UnitRequest Approval Flow seeded successfully.');
    }
}
