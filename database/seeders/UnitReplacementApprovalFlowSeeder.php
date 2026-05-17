<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class UnitReplacementApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'UnitReplacement')->exists()) {
            $this->command->info('UnitReplacement Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'UnitReplacement',
            'name' => 'PTU (Penggantian Unit) Approval',
            'description' => 'Approval untuk penggantian unit alat berat di proyek (PTU).',
            'is_active' => true,
        ]);

        // Single-level approval (default user ID 1; admin update via UI Approval Matrix)
        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('UnitReplacement Approval Flow seeded.');
    }
}
