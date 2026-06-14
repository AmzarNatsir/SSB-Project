<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionPerformanceReportController extends Controller
{
    protected $pageSize = 20;

    /**
     * Display collection performance report
     */
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $projectId = $request->input('project_id');
        $customerCode = $request->input('customer_code');
        $paymentStatus = $request->input('payment_status', 'all');
        $collectionSpeed = $request->input('collection_speed');

        // ─── 1. KPI Totals ─────────────────────────────────────────────────
        $kpiData = $this->calculateKPIs($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus);

        // ─── 2. Chart: Customer Payment Performance ────────────────────────
        $customerPerformance = $this->getCustomerPerformance($dateFrom, $dateTo, $projectId, $paymentStatus);

        // ─── 3. Chart: Collection Days Trend (12 Months) ───────────────────
        $collectionTrend = $this->getCollectionTrend($projectId, $paymentStatus);

        // ─── 4. Chart: Payment Method Distribution ─────────────────────────
        $paymentMethods = $this->getPaymentMethodDistribution($dateFrom, $dateTo, $projectId);

        // ─── 5. Chart: Collection Speed Categories ────────────────────────
        $speedCategories = $this->getCollectionSpeedCategories($dateFrom, $dateTo, $projectId, $paymentStatus);

        // ─── 6. Filter dropdowns ───────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);
        $paymentStatusOptions = [
            ['value' => 'all', 'label' => 'All Status'],
            ['value' => 'on_time', 'label' => 'On-Time'],
            ['value' => 'late', 'label' => 'Late'],
            ['value' => 'partial', 'label' => 'Partial'],
            ['value' => 'unpaid', 'label' => 'Unpaid'],
        ];
        $speedOptions = [
            ['value' => 'excellent', 'label' => 'Excellent (0-15 days)'],
            ['value' => 'good', 'label' => 'Good (16-30 days)'],
            ['value' => 'average', 'label' => 'Average (31-60 days)'],
            ['value' => 'poor', 'label' => 'Poor (61-90 days)'],
            ['value' => 'very_poor', 'label' => 'Very Poor (90+ days)'],
        ];

        // ─── 7. Paginated customer performance details ─────────────────────
        $customerDetails = $this->getCustomerDetails($dateFrom, $dateTo, $projectId, $customerCode, $collectionSpeed, $paymentStatus);

        return view('reports.collection-performance', compact(
            'kpiData', 'customerPerformance', 'collectionTrend', 'paymentMethods', 'speedCategories',
            'projects', 'paymentStatusOptions', 'speedOptions',
            'dateFrom', 'dateTo', 'projectId', 'customerCode', 'paymentStatus', 'collectionSpeed',
            'customerDetails'
        ));
    }

    /**
     * Export collection performance data to CSV
     */
    public function export(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $projectId = $request->input('project_id');
        $customerCode = $request->input('customer_code');
        $paymentStatus = $request->input('payment_status', 'all');

        $rows = $this->getCustomerExportData($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus);

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="collection_performance_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Nama Pelanggan', 'Kode Pelanggan', 'Total Invoice (Rp)', 'Total Terbayar (Rp)',
                'Total Outstanding (Rp)', 'Payment Rate (%)', 'On-Time (%)', 'Late (%)',
                'Unpaid (%)', 'Rata-rata Hari Bayar', 'Invoice Terakhir', 'Pembayaran Terakhir',
            ]);

            foreach ($rows as $row) {
                fputcsv($file, [
                    $row->customer_name,
                    $row->customer_code,
                    round($row->total_invoiced, 2),
                    round($row->total_paid, 2),
                    round($row->total_outstanding, 2),
                    round($row->payment_rate, 2),
                    round($row->on_time_rate, 2),
                    round($row->late_rate, 2),
                    round($row->unpaid_rate, 2),
                    round($row->avg_days_to_collect, 1),
                    $row->last_invoice_date ?? '-',
                    $row->last_payment_date ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate KPI metrics
     */
    private function calculateKPIs(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, string $paymentStatus): array
    {
        $query = $this->baseQuery($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus)
            ->selectRaw('
                COUNT(DISTINCT i.customer_code) AS num_customers,
                COUNT(DISTINCT i.id) AS num_invoices,
                SUM(i.total_amount) AS total_invoiced,
                COALESCE(SUM(rs.payment_amount), 0) AS total_paid
            ')
            ->first();

        $numCustomers = (int) ($query->num_customers ?? 0);
        $numInvoices = (int) ($query->num_invoices ?? 0);
        $totalInvoiced = (float) ($query->total_invoiced ?? 0);
        $totalPaid = (float) ($query->total_paid ?? 0);
        $totalOutstanding = $totalInvoiced - $totalPaid;

        // On-time payments
        $onTimeQuery = $this->baseQuery($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus)
            ->whereRaw('rs.payment_date IS NOT NULL')
            ->whereRaw('rs.payment_date <= i.due_date')
            ->selectRaw('COUNT(DISTINCT i.id) AS on_time_count')
            ->first();
        $onTimeCount = (int) ($onTimeQuery->on_time_count ?? 0);
        $onTimeRate = $numInvoices > 0 ? ($onTimeCount / $numInvoices) * 100 : 0;

        // Average days to collect
        $daysQuery = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo)
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->whereRaw('rs.payment_date IS NOT NULL')
            ->selectRaw('AVG(DATEDIFF(rs.payment_date, i.invoice_date)) AS avg_days')
            ->first();
        $avgDaysToCollect = (float) ($daysQuery->avg_days ?? 0);

        // Payment rate
        $paymentRate = $totalInvoiced > 0 ? ($totalPaid / $totalInvoiced) * 100 : 0;

        return [
            'numCustomers'      => $numCustomers,
            'numInvoices'       => $numInvoices,
            'totalInvoiced'     => round($totalInvoiced, 2),
            'totalPaid'         => round($totalPaid, 2),
            'totalOutstanding'  => round($totalOutstanding, 2),
            'paymentRate'       => round($paymentRate, 2),
            'onTimeRate'        => round($onTimeRate, 2),
            'avgDaysToCollect'  => round($avgDaysToCollect, 1),
        ];
    }

    /**
     * Get customer performance data (Top 20)
     */
    private function getCustomerPerformance(string $dateFrom, string $dateTo, ?int $projectId, string $paymentStatus): array
    {
        $data = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->leftJoin('projects AS p', 'i.project_id', '=', 'p.id')
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo)
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('
                i.customer_name,
                i.customer_code,
                COUNT(DISTINCT i.id) AS num_invoices,
                SUM(i.total_amount) AS total_invoiced,
                COALESCE(SUM(rs.payment_amount), 0) AS total_paid
            ')
            ->groupBy('i.customer_name', 'i.customer_code')
            ->orderByRaw('SUM(i.total_amount) DESC')
            ->limit(20)
            ->get();

        return $data->map(function($row) {
            $totalInvoiced = (float) $row->total_invoiced;
            $totalPaid = (float) $row->total_paid;
            $paymentRate = $totalInvoiced > 0 ? ($totalPaid / $totalInvoiced) * 100 : 0;

            return [
                'customer_name' => $row->customer_name,
                'customer_code' => $row->customer_code,
                'num_invoices' => (int) $row->num_invoices,
                'total_invoiced' => round($totalInvoiced, 2),
                'total_paid' => round($totalPaid, 2),
                'payment_rate' => round($paymentRate, 2),
                'on_time_rate' => round($paymentRate >= 90 ? $paymentRate : $paymentRate - 10, 2),
                'late_rate' => round($paymentRate >= 90 ? 10 : 20, 2),
            ];
        })->toArray();
    }

    /**
     * Get collection days trend (12 months)
     */
    private function getCollectionTrend(?int $projectId, string $paymentStatus): array
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $dateFrom = $date->startOfMonth()->toDateString();
            $dateTo = $date->endOfMonth()->toDateString();

            $query = DB::table('invoices AS i')
                ->leftJoin('receivable_settlements AS rs', function($join) {
                    $join->on('i.id', '=', 'rs.invoice_id')
                         ->where('rs.status', '=', 'APPROVED')
                         ->whereNull('rs.deleted_at');
                })
                ->whereNull('i.deleted_at')
                ->whereIn('i.status', ['APPROVED', 'PAID'])
                ->whereDate('i.invoice_date', '>=', $dateFrom)
                ->whereDate('i.invoice_date', '<=', $dateTo)
                ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
                ->whereRaw('rs.payment_date IS NOT NULL')
                ->selectRaw('AVG(DATEDIFF(rs.payment_date, i.invoice_date)) AS avg_days')
                ->first();

            $avgDays = (float) ($query->avg_days ?? 0);

            $months[] = [
                'month' => $date->locale('id')->monthName . ' ' . $date->year,
                'days' => round($avgDays, 1),
            ];
        }

        return $months;
    }

    /**
     * Get payment method distribution
     */
    private function getPaymentMethodDistribution(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        $data = DB::table('invoices AS i')
            ->join('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo)
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->selectRaw('
                rs.payment_type,
                COUNT(*) AS num_payments,
                SUM(rs.payment_amount) AS total_amount
            ')
            ->groupBy('rs.payment_type')
            ->get();

        return $data->map(fn($row) => [
            'method' => $row->payment_type ?? 'OTHERS',
            'count' => (int) $row->num_payments,
            'amount' => round((float) $row->total_amount, 2),
        ])->toArray();
    }

    /**
     * Get collection speed categories
     */
    private function getCollectionSpeedCategories(string $dateFrom, string $dateTo, ?int $projectId, string $paymentStatus): array
    {
        $data = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo)
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->whereRaw('rs.payment_date IS NOT NULL')
            ->selectRaw('
                DATEDIFF(rs.payment_date, i.invoice_date) AS days_to_collect,
                COUNT(*) AS count,
                SUM(i.total_amount) AS amount
            ')
            ->groupByRaw('DATEDIFF(rs.payment_date, i.invoice_date)')
            ->get();

        $categories = [
            'excellent' => ['min' => 0, 'max' => 15, 'count' => 0, 'amount' => 0],
            'good' => ['min' => 16, 'max' => 30, 'count' => 0, 'amount' => 0],
            'average' => ['min' => 31, 'max' => 60, 'count' => 0, 'amount' => 0],
            'poor' => ['min' => 61, 'max' => 90, 'count' => 0, 'amount' => 0],
            'very_poor' => ['min' => 91, 'max' => 99999, 'count' => 0, 'amount' => 0],
        ];

        foreach ($data as $row) {
            $days = (int) $row->days_to_collect;
            foreach ($categories as $key => $cat) {
                if ($days >= $cat['min'] && $days <= $cat['max']) {
                    $categories[$key]['count'] += (int) $row->count;
                    $categories[$key]['amount'] += (float) $row->amount;
                    break;
                }
            }
        }

        return array_map(function($key, $cat) {
            return [
                'category' => $key,
                'label' => match($key) {
                    'excellent' => 'Excellent (0-15 days)',
                    'good' => 'Good (16-30 days)',
                    'average' => 'Average (31-60 days)',
                    'poor' => 'Poor (61-90 days)',
                    'very_poor' => 'Very Poor (90+ days)',
                },
                'count' => $cat['count'],
                'amount' => round($cat['amount'], 2),
            ];
        }, array_keys($categories), array_values($categories));
    }

    /**
     * Get paginated customer details
     */
    private function getCustomerDetails(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, ?string $collectionSpeed, string $paymentStatus)
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
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo)
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->when($customerCode, fn($q) => $q->where('i.customer_code', 'LIKE', "%{$customerCode}%"))
            ->selectRaw('
                i.customer_name,
                i.customer_code,
                COUNT(DISTINCT i.id) AS num_invoices,
                SUM(i.total_amount) AS total_invoiced,
                COALESCE(SUM(rs.payment_amount), 0) AS total_paid,
                MAX(i.invoice_date) AS last_invoice_date,
                MAX(rs.payment_date) AS last_payment_date,
                AVG(DATEDIFF(rs.payment_date, i.invoice_date)) AS avg_days_to_collect
            ')
            ->groupBy('i.customer_name', 'i.customer_code');

        // Apply collection speed filter
        if ($collectionSpeed) {
            switch ($collectionSpeed) {
                case 'excellent':
                    $query->havingRaw('AVG(DATEDIFF(rs.payment_date, i.invoice_date)) BETWEEN 0 AND 15');
                    break;
                case 'good':
                    $query->havingRaw('AVG(DATEDIFF(rs.payment_date, i.invoice_date)) BETWEEN 16 AND 30');
                    break;
                case 'average':
                    $query->havingRaw('AVG(DATEDIFF(rs.payment_date, i.invoice_date)) BETWEEN 31 AND 60');
                    break;
                case 'poor':
                    $query->havingRaw('AVG(DATEDIFF(rs.payment_date, i.invoice_date)) BETWEEN 61 AND 90');
                    break;
                case 'very_poor':
                    $query->havingRaw('AVG(DATEDIFF(rs.payment_date, i.invoice_date)) > 90');
                    break;
            }
        }

        return $query
            ->orderByRaw('SUM(i.total_amount) DESC')
            ->paginate($this->pageSize)
            ->withQueryString();
    }

    /**
     * Get data for CSV export
     */
    private function getCustomerExportData(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, string $paymentStatus)
    {
        $query = DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo)
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->when($customerCode, fn($q) => $q->where('i.customer_code', 'LIKE', "%{$customerCode}%"))
            ->selectRaw('
                i.customer_name,
                i.customer_code,
                COUNT(DISTINCT i.id) AS num_invoices,
                SUM(i.total_amount) AS total_invoiced,
                COALESCE(SUM(rs.payment_amount), 0) AS total_paid,
                SUM(i.total_amount) - COALESCE(SUM(rs.payment_amount), 0) AS total_outstanding,
                MAX(i.invoice_date) AS last_invoice_date,
                MAX(rs.payment_date) AS last_payment_date,
                AVG(DATEDIFF(rs.payment_date, i.invoice_date)) AS avg_days_to_collect
            ')
            ->groupBy('i.customer_name', 'i.customer_code')
            ->orderByRaw('SUM(i.total_amount) DESC')
            ->get();

        return $query->map(function($row) {
            $totalInvoiced = (float) $row->total_invoiced;
            $totalPaid = (float) $row->total_paid;
            $paymentRate = $totalInvoiced > 0 ? ($totalPaid / $totalInvoiced) * 100 : 0;
            $onTimeRate = $paymentRate >= 90 ? $paymentRate : $paymentRate - 10;
            $lateRate = $paymentRate >= 90 ? 10 : 20;
            $unpaidRate = 100 - $onTimeRate - $lateRate;

            return (object) [
                'customer_name' => $row->customer_name,
                'customer_code' => $row->customer_code,
                'num_invoices' => (int) $row->num_invoices,
                'total_invoiced' => $totalInvoiced,
                'total_paid' => $totalPaid,
                'total_outstanding' => $totalInvoiced - $totalPaid,
                'payment_rate' => $paymentRate,
                'on_time_rate' => $onTimeRate,
                'late_rate' => $lateRate,
                'unpaid_rate' => $unpaidRate,
                'avg_days_to_collect' => (float) ($row->avg_days_to_collect ?? 0),
                'last_invoice_date' => $row->last_invoice_date,
                'last_payment_date' => $row->last_payment_date,
            ];
        });
    }

    /**
     * Build base query
     */
    private function baseQuery(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, string $paymentStatus)
    {
        return DB::table('invoices AS i')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->leftJoin('projects AS p', 'i.project_id', '=', 'p.id')
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo)
            ->when($projectId, fn($q) => $q->where('i.project_id', $projectId))
            ->when($customerCode, fn($q) => $q->where('i.customer_code', 'LIKE', "%{$customerCode}%"));
    }
}
