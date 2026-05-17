<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class ReceivableApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'Receivable')->exists()) {
            $this->command->info('Receivable Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'Receivable',
            'name' => 'Receivable Approval',
            'description' => 'Approval untuk Penerimaan Dana dari customer (Uang Muka / Pelunasan Invoice). '
                          . 'Biasanya 1-2 level: Finance/Bendahara → Manager.',
            'is_active' => true,
        ]);

        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('Receivable Approval Flow seeded.');
    }
}
