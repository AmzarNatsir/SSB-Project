<?php

namespace Database\Seeders;

use App\Enums\ApproverType;
use App\Models\ApprovalFlow;
use Illuminate\Database\Seeder;

class PettyCashApprovalFlowSeeder extends Seeder
{
    public function run(): void
    {
        $flows = [
            [
                'code'        => 'PettyCashRequest',
                'name'        => 'Permintaan Kas Kecil',
                'description' => 'Approval untuk Permintaan Kas Kecil project (dana keluar dari kas besar ke kas kecil project).',
            ],
            [
                'code'        => 'PettyCashPayment',
                'name'        => 'Pembayaran Biaya (Petty Cash)',
                'description' => 'Approval untuk Pembayaran Biaya dari Permintaan Kas Kecil yang Disetujui.',
            ],
            [
                'code'        => 'PettyCashPurchase',
                'name'        => 'Pembelian Tunai (Petty Cash)',
                'description' => 'Approval untuk Pembelian Tunai dari Permintaan Kas Kecil yang Disetujui.',
            ],
        ];

        foreach ($flows as $data) {
            if (ApprovalFlow::where('code', $data['code'])->exists()) {
                $this->command->info("{$data['code']} Approval Flow already exists. Skipping.");
                continue;
            }

            $flow = ApprovalFlow::create([
                'code'        => $data['code'],
                'name'        => $data['name'],
                'description' => $data['description'],
                'is_active'   => true,
            ]);

            $flow->levels()->create([
                'level_number'    => 1,
                'approver_type'   => ApproverType::USER,
                'approver_user_id' => 1,
                'is_mandatory'    => true,
            ]);

            $this->command->info("{$data['code']} Approval Flow seeded.");
        }
    }
}
