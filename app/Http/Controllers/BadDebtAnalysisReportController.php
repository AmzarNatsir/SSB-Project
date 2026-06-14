<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BadDebtAnalysisReportController extends Controller
{
    protected $pageSize = 20;

    /**
     * Display bad debt analysis report
     */
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $projectId = $request->input('project_id');
        $riskLevel = $request->input('risk_level');
        $agingCategory = $request->input('aging_category');

        // ─── 1. KPI Totals ─────────────────────────────────────────────────
        $kpiData = $this->calculateKPIs($dateFrom, $dateTo, $projectId);

        // ─── 2. Chart: Bad Debt Aging Analysis ──────────────────────────────
        $agingAnalysis = $this->getBadDebtAgingAnalysis($dateFrom, $dateTo, $projectId);

        // ─── 3. Chart: Bad Debt Trend (12 Months) ───────────────────────────
        $badDebtTrend = $this->getBadDebtTrend($projectId);

        // ─── 4. Chart: Risk by Customer (Top 10) ────────────────────────────
        $topRiskCustomers = $this->getTopRiskCustomers($dateFrom, $dateTo, $projectId);

        // ─── 5. Chart: Risk Level Distribution ──────────────────────────────
        $riskDistribution = $this->getRiskDistribution($dateFrom, $dateTo, $projectId);

        // ─── 6. Filter dropdowns ───────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);
        $riskLevelOptions = [
            ['value' => 'all', 'label' => 'All Levels'],
            ['value' => 'low', 'label' => 'LOW (0-5%)'],
            ['value' => 'medium', 'label' => 'MEDIUM (5-15%)'],
            ['value' => 'high', 'label' => 'HIGH (15-30%)'],
            ['value' => 'critical', 'label' => 'CRITICAL (30%+)'],
        ];
        $agingCategoryOptions = [
            ['value' => 'all', 'label' => 'All Aging'],
            ['value' => '90_180', 'label' => '90-180 Days (10% Reserve)'],
            ['value' => '181_365', 'label' => '181-365 Days (50% Reserve)'],
            ['value' => '365_plus', 'label' => '365+ Days (100% Reserve)'],
        ];

        // ─── 7. Paginated at-risk invoices ─────────────────────────────────
        $atRiskInvoices = $this->getAtRiskInvoices($dateFrom, $dateTo, $projectId, $riskLevel, $agingCategory);

        return view('reports.bad-debt-analysis', compact(
            'kpiData', 'agingAnalysis', 'badDebtTrend', 'topRiskCustomers', 'riskDistribution',
            'projects', 'riskLevelOptions', 'agingCategoryOptions',
            'dateFrom', 'dateTo', 'projectId', 'riskLevel', 'agingCategory',
            'atRiskInvoices'
        ));
    }

    /**
     * Export bad debt analysis data to CSV
     */
    public function export(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $projectId = $request->input('project_id');

        $rows = $this->getAtRiskInvoicesForExport($dateFrom, $dateTo, $projectId);

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="bad_debt_analysis_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'No. Invoice', 'Pelanggan', 'Tgl Invoice', 'Tgl Jatuh Tempo', 'Hari Overdue',
                'Jumlah Outstanding (Rp)', 'Risk Level', 'Reserve % ', 'Reserve Amount (Rp)',
                'Usia Piutang', 'Last Payment Date',
            ]);

            foreach ($rows as $index => $row) {
                fputcsv($file, [
                    $row->invoice_number,
                    $row->customer_name,
                    $row->invoice_date,
                    $row->due_date,
                    $row->days_overdue,
                    round($row->outstanding_amount, 2),
                    $row->risk_level,
                    $row->reserve_percent,
                    round($row->reserve_amount, 2),
                    $row->aging_category,
                    $row->last_payment_date ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate KPI metrics for bad debt
     */
    private function calculateKPIs(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        // Subquery to get total paid per invoice
        $paidSubquery = DB::table('receivable_settlements')
            ->select('invoice_id', DB::raw('SUM(payment_amount) AS total_paid'))
            ->where('status', '=', 'APPROVED')
            ->whereNull('deleted_at')
            ->groupBy('invoice_id');

        // Total outstanding
        $totalQuery = DB::table('invoices AS i')
            ->leftJoinSub($paidSubquery, 'paid', function($join) {
                $join->on('i.id', '=', 'paid.invoice_id');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount - COALESCE(paid.total_paid, 0)) AS total_outstanding')
            ->first();

        $totalOutstanding = (float) ($totalQuery->total_outstanding ?? 0);

        // Bad debt exposure (90+ days)
        $badDebtQuery = DB::table('invoices AS i')
            ->leftJoinSub($paidSubquery, 'paid', function($join) {
                $join->on('i.id', '=', 'paid.invoice_id');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('
                COUNT(DISTINCT i.id) AS num_at_risk,
                SUM(i.total_amount - COALESCE(paid.total_paid, 0)) AS bad_debt_exposure
            ')
            ->first();

        $numAtRisk = (int) ($badDebtQuery->num_at_risk ?? 0);
        $badDebtExposure = (float) ($badDebtQuery->bad_debt_exposure ?? 0);

        // Potential write-off (365+ days)
        $writeOffQuery = DB::table('invoices AS i')
            ->leftJoinSub($paidSubquery, 'paid', function($join) {
                $join->on('i.id', '=', 'paid.invoice_id');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 365')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount - COALESCE(paid.total_paid, 0)) AS writeoff_amount')
            ->first();

        $writeOffAmount = (float) ($writeOffQuery->writeoff_amount ?? 0);

        // Bad debt risk percentage
        $badDebtRiskPercent = $totalOutstanding > 0 ? ($badDebtExposure / $totalOutstanding) * 100 : 0;

        // Calculate allowance for doubtful accounts (AFDA)
        $afda = $this->calculateAFDA($projectId);

        // Avg days overdue for at-risk
        $avgDaysQuery = DB::table('invoices AS i')
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('AVG(DATEDIFF(NOW(), i.due_date)) AS avg_days')
            ->first();

        $avgDaysOverdue = (float) ($avgDaysQuery->avg_days ?? 0);

        return [
            'totalOutstanding'  => round($totalOutstanding, 2),
            'badDebtExposure'   => round($badDebtExposure, 2),
            'badDebtRiskPercent' => round($badDebtRiskPercent, 2),
            'numAtRisk'         => $numAtRisk,
            'writeOffAmount'    => round($writeOffAmount, 2),
            'avgDaysOverdue'    => round($avgDaysOverdue, 1),
            'afda'              => round($afda, 2),
        ];
    }

    /**
     * Get bad debt aging analysis
     */
    private function getBadDebtAgingAnalysis(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        return [
            [
                'category' => '90-180 Days',
                'outstanding' => $this->getOutstandingByAging(90, 180, $projectId),
                'reserve_percent' => 10,
                'reserve_amount' => $this->getOutstandingByAging(90, 180, $projectId) * 0.10,
                'num_invoices' => $this->getInvoiceCountByAging(90, 180, $projectId),
            ],
            [
                'category' => '181-365 Days',
                'outstanding' => $this->getOutstandingByAging(181, 365, $projectId),
                'reserve_percent' => 50,
                'reserve_amount' => $this->getOutstandingByAging(181, 365, $projectId) * 0.50,
                'num_invoices' => $this->getInvoiceCountByAging(181, 365, $projectId),
            ],
            [
                'category' => '365+ Days',
                'outstanding' => $this->getOutstandingByAging(366, 99999, $projectId),
                'reserve_percent' => 100,
                'reserve_amount' => $this->getOutstandingByAging(366, 99999, $projectId) * 1.00,
                'num_invoices' => $this->getInvoiceCountByAging(366, 99999, $projectId),
            ],
        ];
    }

    /**
     * Get bad debt trend (12 months)
     */
    private function getBadDebtTrend(?int $projectId): array
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $days90 = $this->getOutstandingByAgingForMonth($date, 90, 180, $projectId);
            $days180 = $this->getOutstandingByAgingForMonth($date, 181, 365, $projectId);
            $days365 = $this->getOutstandingByAgingForMonth($date, 366, 99999, $projectId);

            $months[] = [
                'month' => $date->locale('id')->monthName . ' ' . $date->year,
                'days_90_180' => round($days90, 2),
                'days_181_365' => round($days180, 2),
                'days_365_plus' => round($days365, 2),
            ];
        }

        return $months;
    }

    /**
     * Get top risk customers (Top 10)
     */
    private function getTopRiskCustomers(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        $paidSubquery = DB::table('receivable_settlements')
            ->select('invoice_id', DB::raw('SUM(payment_amount) AS total_paid'))
            ->where('status', '=', 'APPROVED')
            ->whereNull('deleted_at')
            ->groupBy('invoice_id');

        $data = DB::table('invoices AS i')
            ->leftJoinSub($paidSubquery, 'paid', function($join) {
                $join->on('i.id', '=', 'paid.invoice_id');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('
                i.customer_name,
                i.customer_code,
                SUM(i.total_amount - COALESCE(paid.total_paid, 0)) AS exposure,
                MAX(DATEDIFF(NOW(), i.due_date)) AS oldest_days
            ')
            ->groupBy('i.customer_name', 'i.customer_code')
            ->orderByRaw('SUM(i.total_amount - COALESCE(paid.total_paid, 0)) DESC')
            ->limit(10)
            ->get();

        return $data->map(fn($row) => [
            'customer_name' => $row->customer_name,
            'customer_code' => $row->customer_code,
            'exposure' => round((float) $row->exposure, 2),
            'oldest_days' => (int) $row->oldest_days,
        ])->toArray();
    }

    /**
     * Get risk level distribution
     */
    private function getRiskDistribution(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        $paidSubquery = DB::table('receivable_settlements')
            ->select('invoice_id', DB::raw('SUM(payment_amount) AS total_paid'))
            ->where('status', '=', 'APPROVED')
            ->whereNull('deleted_at')
            ->groupBy('invoice_id');

        $totalOutstanding = DB::table('invoices AS i')
            ->leftJoinSub($paidSubquery, 'paid', function($join) {
                $join->on('i.id', '=', 'paid.invoice_id');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount - COALESCE(paid.total_paid, 0)) AS total')
            ->first();

        $total = (float) ($totalOutstanding->total ?? 1);

        $badDebt90 = $this->getOutstandingByAging(90, 999999, $projectId);
        $badDebtPercent = ($badDebt90 / $total) * 100;

        return [
            [
                'level' => 'LOW',
                'percent' => round(max(0, 100 - $badDebtPercent), 2),
                'range' => '0-5%',
            ],
            [
                'level' => 'MEDIUM',
                'percent' => round(max(0, min(10, $badDebtPercent)), 2),
                'range' => '5-15%',
            ],
            [
                'level' => 'HIGH',
                'percent' => round(max(0, min(15, $badDebtPercent - 10)), 2),
                'range' => '15-30%',
            ],
            [
                'level' => 'CRITICAL',
                'percent' => round(max(0, $badDebtPercent - 30), 2),
                'range' => '30%+',
            ],
        ];
    }

    /**
     * Get paginated at-risk invoices
     */
    private function getAtRiskInvoices(string $dateFrom, string $dateTo, ?int $projectId, ?string $riskLevel, ?string $agingCategory)
    {
        $query = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->leftJoin('projects AS p', 'i.project_id', '=', 'p.id')
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->select([
                'i.id',
                'i.invoice_number',
                'i.customer_name',
                'i.customer_code',
                'i.invoice_date',
                'i.due_date',
                'i.total_amount',
                'i.status',
                'p.project_name',
                DB::raw('COALESCE(SUM(rs.payment_amount), 0) AS paid_amount'),
                DB::raw('i.total_amount - COALESCE(SUM(rs.payment_amount), 0) AS outstanding_amount'),
                DB::raw('DATEDIFF(NOW(), i.due_date) AS days_overdue'),
                DB::raw('MAX(rs.payment_date) AS last_payment_date'),
            ])
            ->groupBy('i.id', 'i.invoice_number', 'i.customer_name', 'i.customer_code',
                      'i.invoice_date', 'i.due_date', 'i.total_amount', 'i.status', 'p.project_name');

        // Apply aging category filter
        if ($agingCategory && $agingCategory !== 'all') {
            switch ($agingCategory) {
                case '90_180':
                    $query->havingRaw('DATEDIFF(NOW(), i.due_date) BETWEEN 90 AND 180');
                    break;
                case '181_365':
                    $query->havingRaw('DATEDIFF(NOW(), i.due_date) BETWEEN 181 AND 365');
                    break;
                case '365_plus':
                    $query->havingRaw('DATEDIFF(NOW(), i.due_date) > 365');
                    break;
            }
        }

        return $query
            ->orderBy('i.due_date', 'asc')
            ->paginate($this->pageSize)
            ->withQueryString();
    }

    /**
     * Get data for CSV export
     */
    private function getAtRiskInvoicesForExport(string $dateFrom, string $dateTo, ?int $projectId)
    {
        $query = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->leftJoin('projects AS p', 'i.project_id', '=', 'p.id')
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 90')
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->select([
                'i.invoice_number',
                'i.customer_name',
                'i.invoice_date',
                'i.due_date',
                'i.total_amount',
                DB::raw('COALESCE(SUM(rs.payment_amount), 0) AS paid_amount'),
                DB::raw('i.total_amount - COALESCE(SUM(rs.payment_amount), 0) AS outstanding_amount'),
                DB::raw('DATEDIFF(NOW(), i.due_date) AS days_overdue'),
                DB::raw('MAX(rs.payment_date) AS last_payment_date'),
            ])
            ->groupBy('i.id', 'i.invoice_number', 'i.customer_name',
                      'i.invoice_date', 'i.due_date', 'i.total_amount')
            ->orderBy('i.due_date', 'asc')
            ->get();

        return $query->map(function($row) {
            $daysOverdue = (int) $row->days_overdue;
            if ($daysOverdue > 365) {
                $aging = '365+ Days';
                $reserve = 100;
            } elseif ($daysOverdue > 180) {
                $aging = '181-365 Days';
                $reserve = 50;
            } else {
                $aging = '90-180 Days';
                $reserve = 10;
            }

            return (object) [
                'invoice_number' => $row->invoice_number,
                'customer_name' => $row->customer_name,
                'invoice_date' => $row->invoice_date,
                'due_date' => $row->due_date,
                'days_overdue' => $daysOverdue,
                'outstanding_amount' => (float) $row->outstanding_amount,
                'risk_level' => $this->getRiskLevelName($daysOverdue),
                'reserve_percent' => $reserve,
                'reserve_amount' => ((float) $row->outstanding_amount) * ($reserve / 100),
                'aging_category' => $aging,
                'last_payment_date' => $row->last_payment_date,
            ];
        });
    }

    /**
     * Helper: Get outstanding by aging range
     */
    private function getOutstandingByAging(int $minDays, int $maxDays, ?int $projectId): float
    {
        $paidSubquery = DB::table('receivable_settlements')
            ->select('invoice_id', DB::raw('SUM(payment_amount) AS total_paid'))
            ->where('status', '=', 'APPROVED')
            ->whereNull('deleted_at')
            ->groupBy('invoice_id');

        $result = DB::table('invoices AS i')
            ->leftJoinSub($paidSubquery, 'paid', function($join) {
                $join->on('i.id', '=', 'paid.invoice_id');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw("DATEDIFF(NOW(), i.due_date) BETWEEN {$minDays} AND {$maxDays}")
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount - COALESCE(paid.total_paid, 0)) AS amount')
            ->first();

        return (float) ($result->amount ?? 0);
    }

    /**
     * Helper: Get invoice count by aging range
     */
    private function getInvoiceCountByAging(int $minDays, int $maxDays, ?int $projectId): int
    {
        $result = DB::table('invoices AS i')
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereRaw("DATEDIFF(NOW(), i.due_date) BETWEEN {$minDays} AND {$maxDays}")
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('COUNT(DISTINCT i.id) AS count')
            ->first();

        return (int) ($result->count ?? 0);
    }

    /**
     * Helper: Get outstanding by aging for specific month
     */
    private function getOutstandingByAgingForMonth(Carbon $date, int $minDays, int $maxDays, ?int $projectId): float
    {
        $paidSubquery = DB::table('receivable_settlements')
            ->select('invoice_id', DB::raw('SUM(payment_amount) AS total_paid'))
            ->where('status', '=', 'APPROVED')
            ->whereNull('deleted_at')
            ->groupBy('invoice_id');

        $result = DB::table('invoices AS i')
            ->leftJoinSub($paidSubquery, 'paid', function($join) {
                $join->on('i.id', '=', 'paid.invoice_id');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereYear('i.invoice_date', $date->year)
            ->whereMonth('i.invoice_date', $date->month)
            ->whereRaw("DATEDIFF(NOW(), i.due_date) BETWEEN {$minDays} AND {$maxDays}")
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('SUM(i.total_amount - COALESCE(paid.total_paid, 0)) AS amount')
            ->first();

        return (float) ($result->amount ?? 0);
    }

    /**
     * Helper: Calculate AFDA (Allowance for Doubtful Accounts)
     */
    private function calculateAFDA(?int $projectId): float
    {
        $a90_180 = $this->getOutstandingByAging(90, 180, $projectId) * 0.10;
        $a181_365 = $this->getOutstandingByAging(181, 365, $projectId) * 0.50;
        $a365_plus = $this->getOutstandingByAging(366, 99999, $projectId) * 1.00;

        return $a90_180 + $a181_365 + $a365_plus;
    }

    /**
     * Helper: Get risk level name based on days overdue
     */
    private function getRiskLevelName(int $daysOverdue): string
    {
        if ($daysOverdue <= 60) {
            return 'LOW';
        } elseif ($daysOverdue <= 90) {
            return 'MEDIUM';
        } elseif ($daysOverdue <= 180) {
            return 'HIGH';
        } else {
            return 'CRITICAL';
        }
    }
}
