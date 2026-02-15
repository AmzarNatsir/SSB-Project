<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'view_projects', 'create_projects', 'edit_projects', 'delete_projects',
            'view_budgets', 'create_budgets', 'edit_budgets', 'approve_budgets',
            'manage_users', 'manage_roles', 'manage_settings'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and assign created permissions

        // 1. Super Admin
        $roleSuperAdmin = Role::create(['name' => 'Super Admin']);
        $roleSuperAdmin->givePermissionTo(Permission::all());

        // 2. Admin
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo('view dashboard');
        $roleAdmin->givePermissionTo('manage users');

        // 3. User
        $roleUser = Role::create(['name' => 'User']);
        $roleUser->givePermissionTo('view dashboard');

        // Create Default Super Admin User
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($roleSuperAdmin);
    }
}
