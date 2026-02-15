<?php

namespace Database\Seeders;

use App\Models\ProjectBudgetApprovalTier;
use Illuminate\Database\Seeder;

class ProjectBudgetApprovalTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'level' => 1,
                'role_name' => 'Project Manager',
                'min_amount' => 0,
                'max_amount' => null,
            ],
            [
                'level' => 2,
                'role_name' => 'Operations Manager',
                'min_amount' => 0,
                'max_amount' => null,
            ],
            [
                'level' => 3,
                'role_name' => 'Director',
                'min_amount' => 0,
                'max_amount' => null,
            ],
        ];

        foreach ($tiers as $tier) {
            ProjectBudgetApprovalTier::updateOrCreate(
                ['level' => $tier['level']],
                $tier
            );
        }
    }
}
