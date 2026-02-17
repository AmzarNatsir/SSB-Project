<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ApprovalFlow;
use App\Enums\ApproverType;

class NegotiationApprovalFlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if exists
        if (ApprovalFlow::where('code', 'NEGOTIATION')->exists()) {
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'NEGOTIATION',
            'name' => 'Price Negotiation Approval',
            'description' => 'Approval process for price negotiations.',
            'is_active' => true,
        ]);

        // Level 1: Operational Manager (Placeholder)
        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER, // Or ROLE if implemented
            'approver_user_id' => 1, // Default Admin/User
            'is_mandatory' => true,
        ]);

        // Level 2: Director (Placeholder)
        $flow->levels()->create([
            'level_number' => 2,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1, // Default Admin/User
            'is_mandatory' => true,
        ]);
        
        $this->command->info('Negotiation Approval Flow seeded successfully.');
    }
}
