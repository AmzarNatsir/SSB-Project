<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExecutiveDashboardController extends Controller
{
    /**
     * Display executive dashboard
     */
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $projectId = $request->input('project_id');

        // ─── KPI Metrics with Targets ─────────────────────────────────────
        $kpiData = $this->calculateKPIsWithTargets($dateFrom, $dateTo, $projectId);

        // ─── Performance Metrics ────────────────────────────────────────────
        $performanceData = $this->getPerformanceMetrics($dateFrom, $dateTo, $projectId);

        // ─── Trend Data (12 months) ────────────────────────────────────────
        $trendData = $this->getTrendData($projectId);

        // ─── Top Issues/Alerts ──────────────────────────────────────────────
        $alerts = $this->getAlerts($dateFrom, $dateTo, $projectId);

        // ─── Filter options ────────────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);

        return view('dashboard', compact(
            'kpiData', 'performanceData', 'trendData', 'alerts',
            'projects', 'dateFrom', 'dateTo', 'projectId'
        ));
    }

    /**
     * Calculate KPIs with target comparison
     */
    private function calculateKPIsWithTargets(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        // ─── A/R Metrics ───────────────────────────────────────────────────
        $arQuery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('
                SUM(i.total_amount) AS total_invoiced,
                SUM(COALESCE(rs.payment_amount, 0)) AS total_paid
            ')
            ->first();

        $totalInvoiced = (float) ($arQuery->total_invoiced ?? 0);
        $totalPaid = (float) ($arQuery->total_paid ?? 0);
        $totalOutstanding = $totalInvoiced - $totalPaid;
        $collectionRate = $totalInvoiced > 0 ? ($totalPaid / $totalInvoiced) * 100 : 0;

        // ─── Bad Debt Metrics ──────────────────────────────────────────────
        $badDebtQuery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount - COALESCE(rs.payment_amount, 0)) AS amount')
            ->first();

        $badDebtExposure = (float) ($badDebtQuery->amount ?? 0);
        $badDebtPercent = $totalOutstanding > 0 ? ($badDebtExposure / $totalOutstanding) * 100 : 0;

        // ─── Petty Cash Metrics ────────────────────────────────────────────
        $pettyCashQuery = DB::table('petty_cash_requests AS pcr')
            ->whereNull('pcr.deleted_at')
            ->where('pcr.status', 'approved')
            ->when($projectId, fn($q) => $q->where('pcr.project_id', $projectId))
            ->selectRaw('SUM(pcr.requested_amount) AS total')
            ->first();

        $pettyCashAllocated = (float) ($pettyCashQuery->total ?? 0);

        $pettyCashUsedQuery = DB::table('petty_cash_purchases AS pcp')
            ->whereNull('pcp.deleted_at')
            ->where('pcp.status', 'approved')
            ->whereBetween('pcp.purchase_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('pcp.project_id', $projectId))
            ->selectRaw('SUM(pcp.amount) AS total')
            ->first();

        $pettyCashUsed = (float) ($pettyCashUsedQuery->total ?? 0);
        $pettyCashUtilization = $pettyCashAllocated > 0 ? ($pettyCashUsed / $pettyCashAllocated) * 100 : 0;

        // ─── Targets (dapat dari config atau hardcoded untuk sekarang) ─────
        $targets = [
            'collection_rate' => 85.0,      // Target 85% collection rate
            'bad_debt_percent' => 10.0,     // Target max 10% bad debt
            'petty_cash_util' => 80.0,      // Target 80% utilization
            'dso' => 30,                    // Target DSO 30 days
        ];

        // ─── Performance Status ─────────────────────────────────────────────
        $collectionStatus = $collectionRate >= $targets['collection_rate'] ? 'good' :
                           ($collectionRate >= $targets['collection_rate'] - 10 ? 'warning' : 'danger');
        $badDebtStatus = $badDebtPercent <= $targets['bad_debt_percent'] ? 'good' :
                        ($badDebtPercent <= $targets['bad_debt_percent'] + 5 ? 'warning' : 'danger');
        $pettyCashStatus = $pettyCashUtilization <= $targets['petty_cash_util'] ? 'good' : 'warning';

        return [
            'total_invoiced'        => round($totalInvoiced, 2),
            'total_paid'            => round($totalPaid, 2),
            'total_outstanding'     => round($totalOutstanding, 2),
            'collection_rate'       => round($collectionRate, 2),
            'collection_status'     => $collectionStatus,
            'collection_target'     => $targets['collection_rate'],

            'bad_debt_exposure'     => round($badDebtExposure, 2),
            'bad_debt_percent'      => round($badDebtPercent, 2),
            'bad_debt_status'       => $badDebtStatus,
            'bad_debt_target'       => $targets['bad_debt_percent'],

            'petty_cash_allocated'  => round($pettyCashAllocated, 2),
            'petty_cash_used'       => round($pettyCashUsed, 2),
            'petty_cash_util'       => round($pettyCashUtilization, 2),
            'petty_cash_status'     => $pettyCashStatus,
            'petty_cash_target'     => $targets['petty_cash_util'],
        ];
    }

    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        // DSO calculation using subquery
        $dsoSubquery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereBetween('i.invoice_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('i.id, i.invoice_date, DATEDIFF(MAX(COALESCE(rs.payment_date, NOW())), i.invoice_date) AS days_to_pay')
            ->groupBy('i.id', 'i.invoice_date');

        $dsoQuery = DB::query()
            ->fromSub($dsoSubquery, 'dso_calc')
            ->selectRaw('AVG(days_to_pay) AS dso')
            ->first();

        $dso = (int) ($dsoQuery->dso ?? 0);

        // On-time payment rate
        $onTimeQuery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereBetween('i.invoice_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('
                COUNT(CASE WHEN rs.payment_date <= i.due_date THEN 1 END) AS on_time,
                COUNT(DISTINCT i.id) AS total
            ')
            ->first();

        $onTimeRate = ($onTimeQuery->total > 0) ?
                     (($onTimeQuery->on_time / $onTimeQuery->total) * 100) : 0;

        // Number of customers
        $customerCount = DB::table('invoices')
            ->whereNull('deleted_at')
            ->whereIn('status', ['APPROVED', 'PAID'])
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->selectRaw('COUNT(DISTINCT customer_code) AS count')
            ->first()
            ->count ?? 0;

        // Number of projects with A/R
        $projectCount = DB::table('invoices')
            ->whereNull('deleted_at')
            ->whereIn('status', ['APPROVED', 'PAID'])
            ->selectRaw('COUNT(DISTINCT project_id) AS count')
            ->first()
            ->count ?? 0;

        return [
            'dso' => $dso,
            'dso_target' => 30,
            'on_time_rate' => round($onTimeRate, 2),
            'on_time_target' => 85.0,
            'customer_count' => $customerCount,
            'project_count' => $projectCount,
        ];
    }

    /**
     * Get trend data (12 months)
     */
    private function getTrendData(?int $projectId): array
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startMonth = $date->copy()->startOfMonth();
            $endMonth = $date->copy()->endOfMonth();

            // Collection rate trend
            $collectionQuery = DB::table('invoices AS i')
                ->leftJoin('receivable_settlements AS rs', function($join) {
                    $join->on('i.id', '=', 'rs.invoice_id')
                         ->where('rs.status', '=', 'APPROVED')
                         ->whereNull('rs.deleted_at');
                })
                ->whereNull('i.deleted_at')
                ->whereIn('i.status', ['APPROVED', 'PAID'])
                ->whereDate('i.invoice_date', '>=', $startMonth)
                ->whereDate('i.invoice_date', '<=', $endMonth)
                ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
                ->selectRaw('
                    SUM(i.total_amount) AS total_invoiced,
                    SUM(COALESCE(rs.payment_amount, 0)) AS total_paid
                ')
                ->first();

            $totalInvoiced = (float) ($collectionQuery->total_invoiced ?? 0);
            $totalPaid = (float) ($collectionQuery->total_paid ?? 0);
            $collectionRate = $totalInvoiced > 0 ? ($totalPaid / $totalInvoiced) * 100 : 0;

            // Bad debt trend
            $badDebtQuery = DB::table('invoices AS i')
                ->leftJoin('receivable_settlements AS rs', function($join) {
                    $join->on('i.id', '=', 'rs.invoice_id')
                         ->where('rs.status', '=', 'APPROVED')
                         ->whereNull('rs.deleted_at');
                })
                ->whereNull('i.deleted_at')
                ->whereIn('i.status', ['APPROVED', 'PAID'])
                ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
                ->whereDate('i.invoice_date', '>=', $startMonth)
                ->whereDate('i.invoice_date', '<=', $endMonth)
                ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
                ->selectRaw('SUM(i.total_amount) AS total_bad_debt')
                ->first();

            $badDebt = (float) ($badDebtQuery->total_bad_debt ?? 0);
            $badDebtPercent = $totalInvoiced > 0 ? ($badDebt / $totalInvoiced) * 100 : 0;

            $months[] = [
                'month' => $date->locale('id')->monthName . ' ' . $date->year,
                'collection_rate' => round($collectionRate, 2),
                'bad_debt_percent' => round($badDebtPercent, 2),
            ];
        }

        return $months;
    }

    /**
     * Get alerts for critical issues
     */
    private function getAlerts(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        $alerts = [];

        // Alert 1: Overdue invoices
        $overdueQuery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('i.total_amount - COALESCE(rs.payment_amount, 0) > 0')
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 180')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('COUNT(DISTINCT i.id) AS count, SUM(i.total_amount - COALESCE(rs.payment_amount, 0)) AS amount')
            ->first();

        $overdueCount = (int) ($overdueQuery->count ?? 0);
        if ($overdueCount > 0) {
            $alerts[] = [
                'type' => 'danger',
                'title' => 'Critical: Very Old Overdue Invoices',
                'message' => "Ada {$overdueCount} invoices yang overdue lebih dari 180 hari dengan total Rp " .
                             number_format((float) ($overdueQuery->amount ?? 0), 0, ',', '.'),
                'action' => 'Lihat Bad Debt Analysis',
                'route' => 'bad-debt-analysis',
            ];
        }

        // Alert 2: High bad debt percentage
        $allArQuery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount) AS total_invoiced')
            ->first();

        $badDebtQuery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount - COALESCE(rs.payment_amount, 0)) AS amount')
            ->first();

        $totalInvoiced = (float) ($allArQuery->total_invoiced ?? 1);
        $badDebt = (float) ($badDebtQuery->amount ?? 0);
        $badDebtPercent = ($badDebt / $totalInvoiced) * 100;

        if ($badDebtPercent > 15) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'High Bad Debt Exposure',
                'message' => "Bad debt exposure mencapai {$badDebtPercent}% dari total invoiced amount",
                'action' => 'Review Bad Debt Analysis',
                'route' => 'bad-debt-analysis',
            ];
        }

        // Alert 3: Low collection rate
        $allArQuery2 = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('
                SUM(i.total_amount) AS total_invoiced,
                SUM(COALESCE(rs.payment_amount, 0)) AS total_paid
            ')
            ->first();

        $totalInvoiced2 = (float) ($allArQuery2->total_invoiced ?? 1);
        $totalPaid = (float) ($allArQuery2->total_paid ?? 0);
        $collectionRate = ($totalPaid / $totalInvoiced2) * 100;

        if ($collectionRate < 75) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Below Target Collection Rate',
                'message' => "Collection rate hanya {$collectionRate}% (target: 85%)",
                'action' => 'Review Collection Performance',
                'route' => 'collection-performance',
            ];
        }

        return $alerts;
    }
}
