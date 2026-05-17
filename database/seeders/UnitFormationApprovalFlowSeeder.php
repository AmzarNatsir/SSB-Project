<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class UnitFormationApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'UnitFormation')->exists()) {
            $this->command->info('UnitFormation Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'UnitFormation',
            'name' => 'SK Penetapan Unit Approval',
            'description' => 'Approval untuk penetapan unit alat berat & operator yang dioperasikan di proyek.',
            'is_active' => true,
        ]);

        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('UnitFormation Approval Flow seeded.');
    }
}
