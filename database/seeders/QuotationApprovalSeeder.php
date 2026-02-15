<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuotationApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if flow exists
        $flowId = DB::table('approval_flows')->where('code', 'QUOTATION')->value('id');

        if (!$flowId) {
            $flowId = DB::table('approval_flows')->insertGetId([
                'code' => 'QUOTATION',
                'name' => 'Quotation Approval',
                'description' => 'Approval process for Client Quotations',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Level 1: Project Manager (Role-based example)
            // Assuming role ID 1 is Admin/Super or we use null for now and manually assign in UI testing
            // Let's create a generic level 1
            DB::table('approval_flow_levels')->insert([
                'approval_flow_id' => $flowId,
                'level_number' => 1,
                'approver_type' => 'ROLE', // or USER
                'approver_role_id' => 1, // Assuming Supervisor/Manager role
                'is_mandatory' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            // Level 2: Director
            DB::table('approval_flow_levels')->insert([
                'approval_flow_id' => $flowId,
                'level_number' => 2,
                'approver_type' => 'ROLE',
                'approver_role_id' => 2, // Assuming Director role
                'is_mandatory' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
