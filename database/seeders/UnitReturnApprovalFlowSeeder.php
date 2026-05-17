<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class UnitReturnApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'UnitReturn')->exists()) {
            $this->command->info('UnitReturn Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'UnitReturn',
            'name' => 'PPU (Pengembalian Unit) Approval',
            'description' => 'Approval untuk pengembalian unit alat berat dari proyek (PPU).',
            'is_active' => true,
        ]);

        // Single-level approval (default user ID 1; admin update via UI Approval Matrix)
        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('UnitReturn Approval Flow seeded.');
    }
}
