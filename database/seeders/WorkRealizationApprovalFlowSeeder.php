<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class WorkRealizationApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'WorkRealization')->exists()) {
            $this->command->info('WorkRealization Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'WorkRealization',
            'name' => 'Work Realization Approval',
            'description' => 'Approval untuk realisasi pekerjaan per periode (agregasi dari Timesheet). '
                          . 'Biasanya multi-level: PM → Operasional → Finance.',
            'is_active' => true,
        ]);

        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('WorkRealization Approval Flow seeded.');
    }
}
