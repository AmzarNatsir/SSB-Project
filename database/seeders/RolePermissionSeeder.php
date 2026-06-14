<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // All permissions
        $allPermissions = [
            'view_dashboard', 'view_executive_dashboard',
            'manage_project_categories', 'manage_equipment_rates', 'manage_scoring',
            'manage_approval_flows', 'manage_surveyor_flows', 'manage_settings',
            'view_projects', 'create_projects', 'edit_projects', 'delete_projects',
            'view_project_surveys', 'view_budgets', 'create_budgets', 'edit_budgets',
            'view_quotations', 'view_negotiations', 'view_agreements', 'view_contracts',
            'view_unit_requests', 'view_unit_replacements', 'view_unit_returns', 'view_unit_transfers',
            'view_workforce_formations', 'view_unit_formations', 'view_timesheets', 'view_work_realizations',
            'view_invoices', 'view_receivables', 'view_receivable_settlements',
            'view_petty_cash_categories', 'view_petty_cash_requests', 'view_petty_cash_payments', 'view_petty_cash_purchases',
            'view_fuel_usage_report', 'view_survey_results_report', 'view_budget_realization_report', 'view_project_realization_report',
            'view_ar_aging_report', 'view_collection_performance_report', 'view_bad_debt_analysis_report', 'view_petty_cash_transaction_report',
            'manage_users', 'manage_roles', 'manage_permissions',
        ];

        // Create permissions
        $permissionIds = [];
        foreach ($allPermissions as $perm) {
            $existing = DB::table('permissions')->where('name', $perm)->first();
            if (!$existing) {
                DB::table('permissions')->insert([
                    'name' => $perm,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $existing = DB::table('permissions')->where('name', $perm)->first();
            }
            $permissionIds[$perm] = $existing->id;
        }

        echo "\n✓ Created/Verified " . count($permissionIds) . " permissions\n";

        // Role permissions mapping
        $rolePermissions = [
            'Super Admin' => $allPermissions,
            'Admin' => [
                'view_dashboard', 'view_executive_dashboard',
                'view_projects', 'create_projects', 'edit_projects', 'delete_projects',
                'view_project_surveys', 'view_budgets', 'create_budgets', 'edit_budgets',
                'view_quotations', 'view_negotiations', 'view_agreements', 'view_contracts',
                'view_unit_requests', 'view_unit_replacements', 'view_unit_returns', 'view_unit_transfers',
                'view_workforce_formations', 'view_unit_formations', 'view_timesheets', 'view_work_realizations',
                'view_invoices', 'view_receivables', 'view_receivable_settlements',
                'view_petty_cash_categories', 'view_petty_cash_requests', 'view_petty_cash_payments', 'view_petty_cash_purchases',
                'view_fuel_usage_report', 'view_survey_results_report', 'view_budget_realization_report', 'view_project_realization_report',
                'view_ar_aging_report', 'view_collection_performance_report', 'view_bad_debt_analysis_report', 'view_petty_cash_transaction_report',
            ],
            'Direktur' => ['view_dashboard', 'view_projects', 'view_budgets', 'view_quotations', 'view_negotiations', 'view_agreements', 'view_contracts', 'view_invoices', 'view_receivables', 'view_fuel_usage_report', 'view_survey_results_report', 'view_budget_realization_report', 'view_project_realization_report', 'view_ar_aging_report', 'view_collection_performance_report', 'view_bad_debt_analysis_report', 'view_executive_dashboard'],
            'Manajer Proyek' => ['view_dashboard', 'view_projects', 'view_project_surveys', 'view_budgets', 'view_quotations', 'view_negotiations', 'view_agreements', 'view_contracts', 'view_unit_requests', 'view_unit_replacements', 'view_unit_returns', 'view_unit_transfers', 'view_workforce_formations', 'view_unit_formations', 'view_timesheets', 'view_work_realizations', 'view_invoices', 'view_receivables', 'view_receivable_settlements', 'view_petty_cash_requests', 'view_petty_cash_payments', 'view_petty_cash_purchases', 'view_ar_aging_report', 'view_collection_performance_report', 'view_bad_debt_analysis_report', 'view_petty_cash_transaction_report'],
            'Manajer Operasional' => ['view_dashboard', 'view_unit_requests', 'view_unit_replacements', 'view_unit_returns', 'view_unit_transfers', 'view_workforce_formations', 'view_unit_formations', 'view_timesheets', 'view_work_realizations', 'view_petty_cash_categories', 'view_petty_cash_requests', 'view_petty_cash_payments', 'view_petty_cash_purchases', 'view_ar_aging_report', 'view_bad_debt_analysis_report', 'view_petty_cash_transaction_report'],
            'Surveyor Project' => ['view_dashboard', 'view_project_surveys', 'view_timesheets'],
            'Surveyor HSE' => ['view_dashboard', 'view_project_surveys'],
            'Surveyor Warehouse' => ['view_dashboard', 'view_unit_transfers'],
            'User' => ['view_dashboard'],
        ];

        // Assign permissions to roles
        foreach ($rolePermissions as $roleName => $permissions) {
            $role = DB::table('roles')->where('name', $roleName)->first();
            if (!$role) {
                echo "⚠ Role '$roleName' not found\n";
                continue;
            }

            DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

            $toInsert = [];
            $inserted_perms = [];
            foreach ($permissions as $perm) {
                if (isset($permissionIds[$perm]) && !in_array($permissionIds[$perm], $inserted_perms)) {
                    $toInsert[] = ['permission_id' => $permissionIds[$perm], 'role_id' => $role->id];
                    $inserted_perms[] = $permissionIds[$perm];
                }
            }

            if (!empty($toInsert)) {
                DB::table('role_has_permissions')->insert($toInsert);
                echo "✓ {$roleName}: " . count($toInsert) . " permissions\n";
            }
        }

        echo "\n✅ Seeder Complete!\n";
    }
}
