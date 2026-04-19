<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory()->create([
        //     'name' => 'Administrator',
        //     'email' => [EMAIL_ADDRESS]',
        // ]);
        $this->call(RolePermissionSeeder::class);
        $this->call(ProjectBudgetApprovalTierSeeder::class);
        $this->call(UnitRequestApprovalFlowSeeder::class);
    }
}
