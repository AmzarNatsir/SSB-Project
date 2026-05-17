<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class TimesheetApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'TimesheetJournal')->exists()) {
            $this->command->info('TimesheetJournal Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'TimesheetJournal',
            'name' => 'Timesheet Journal Approval',
            'description' => 'Approval untuk timesheet harian operasional unit di proyek. '
                          . 'Biasanya 1-level (Pengawas/Supervisor) atau 2-level (Foreman → Project Manager).',
            'is_active' => true,
        ]);

        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('TimesheetJournal Approval Flow seeded.');
    }
}
