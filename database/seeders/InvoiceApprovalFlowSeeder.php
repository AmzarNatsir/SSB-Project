<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class InvoiceApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'Invoice')->exists()) {
            $this->command->info('Invoice Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'Invoice',
            'name' => 'Invoice Approval',
            'description' => 'Approval untuk Invoice tagihan ke customer. '
                          . 'Biasanya multi-level: Finance → Manager → Direktur.',
            'is_active' => true,
        ]);

        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('Invoice Approval Flow seeded.');
    }
}
