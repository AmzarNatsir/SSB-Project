<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class ReceivableSettlementApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        if (ApprovalFlow::where('code', 'ReceivableSettlement')->exists()) {
            $this->command->info('ReceivableSettlement Approval Flow already exists. Skipping.');
            return;
        }

        $flow = ApprovalFlow::create([
            'code' => 'ReceivableSettlement',
            'name' => 'Receivable Settlement Approval',
            'description' => 'Approval untuk Pelunasan Piutang. Alokasi DP + pembayaran baru. '
                          . 'Saat di-approve, Invoice akan otomatis Lunas jika ter-cover penuh.',
            'is_active' => true,
        ]);

        $flow->levels()->create([
            'level_number' => 1,
            'approver_type' => ApproverType::USER,
            'approver_user_id' => 1,
            'is_mandatory' => true,
        ]);

        $this->command->info('ReceivableSettlement Approval Flow seeded.');
    }
}
