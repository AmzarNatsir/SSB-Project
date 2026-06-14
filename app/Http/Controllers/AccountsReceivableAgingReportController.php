<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsReceivableAgingReportController extends Controller
{
    protected $pageSize = 20;

    protected $agingBuckets = [
        'current'  => ['label' => 'Current (0-30)', 'min' => -9999, 'max' => 0],
        '1_30'     => ['label' => '1-30 Days', 'min' => 1, 'max' => 30],
        '31_60'    => ['label' => '31-60 Days', 'min' => 31, 'max' => 60],
        '61_90'    => ['label' => '61-90 Days', 'min' => 61, 'max' => 90],
        '91_120'   => ['label' => '91-120 Days', 'min' => 91, 'max' => 120],
        '121_plus' => ['label' => '121+ Days', 'min' => 121, 'max' => 9999],
    ];

    /**
     * Display accounts receivable aging report
     */
    public function index(Request $request)
    {
        $dateFrom   = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo     = $request->input('date_to', now()->toDateString());
        $projectId  = $request->input('project_id');
        $customerCode = $request->input('customer_code');
        $agingBucket = $request->input('aging_bucket');
        $paymentStatus = $request->input('payment_status', 'all');

        // ─── 1. KPI Totals ─────────────────────────────────────────────────
        $kpiData = $this->calculateKPIs($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus);

        // ─── 2. Chart: Aging Bucket Distribution ───────────────────────────
        $agingBuckets = $this->getAgingBuckets($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus);

        // ─── 3. Chart: DSO Trend (Last 12 months) ──────────────────────────
        $dsoTrend = $this->getAgingTrend($projectId, $customerCode, $paymentStatus);

        // ─── 4. Chart: Top 10 Overdue Customers ────────────────────────────
        $topOverdueCustomers = $this->getTopOverdueCustomers($dateFrom, $dateTo, $projectId, $paymentStatus);

        // ─── 5. Filter dropdowns ───────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);
        $paymentStatusOptions = [
            ['value' => 'all', 'label' => 'All Status'],
            ['value' => 'unpaid', 'label' => 'Unpaid'],
            ['value' => 'partial', 'label' => 'Partial Payment'],
            ['value' => 'paid', 'label' => 'Paid'],
        ];

        // ─── 6. Paginated aging detail table ───────────────────────────────
        $agingDetails = $this->getAgingDetails($dateFrom, $dateTo, $projectId, $customerCode, $agingBucket, $paymentStatus);

        return view('reports.accounts-receivable-aging', compact(
            'kpiData', 'agingBuckets', 'dsoTrend', 'topOverdueCustomers',
            'projects', 'paymentStatusOptions',
            'dateFrom', 'dateTo', 'projectId', 'customerCode', 'agingBucket', 'paymentStatus',
            'agingDetails'
        ));
    }

    /**
     * Export filtered AR aging data to CSV
     */
    public function export(Request $request)
    {
        $dateFrom   = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo     = $request->input('date_to', now()->toDateString());
        $projectId  = $request->input('project_id');
        $customerCode = $request->input('customer_code');
        $paymentStatus = $request->input('payment_status', 'all');

        $rows = $this->baseAgingQuery($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus)
            ->select([
                'p.project_name',
                'i.invoice_number',
                'i.customer_name',
                'i.customer_code',
                'i.invoice_date',
                'i.due_date',
                'i.total_amount',
                'i.status',
            ])
            ->orderBy('i.due_date', 'asc')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="ar_aging_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Proyek', 'No. Invoice', 'Pelanggan', 'Kode Pelanggan',
                'Tgl Invoice', 'Tgl Jatuh Tempo', 'Jumlah (Rp)',
                'Hari Overdue', 'Kategori Usia', 'Jumlah Terbayar (Rp)',
                'Sisa Hutang (Rp)', 'Persentase Terbayar (%)', 'Status',
            ]);

            foreach ($rows as $row) {
                $daysOverdue = $this->getDaysOverdue($row->due_date);
                $bucket = $this->getAgingBucketName($daysOverdue);

                $paidAmount = DB::table('receivable_settlements')
                    ->where('invoice_id', DB::table('invoices')->where('invoice_number', $row->invoice_number)->first()->id ?? 0)
                    ->where('status', 'APPROVED')
                    ->whereNull('deleted_at')
                    ->sum('payment_amount');

                $outstanding = $row->total_amount - $paidAmount;
                $paymentPercent = $row->total_amount > 0 ? ($paidAmount / $row->total_amount) * 100 : 0;

                fputcsv($file, [
                    $row->project_name,
                    $row->invoice_number,
                    $row->customer_name,
                    $row->customer_code,
                    $row->invoice_date,
                    $row->due_date,
                    round($row->total_amount, 2),
                    max(0, $daysOverdue),
                    $bucket,
                    round($paidAmount, 2),
                    round($outstanding, 2),
                    round($paymentPercent, 2),
                    $row->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate KPI metrics: total outstanding, overdue, DSO, collection rate
     */
    private function calculateKPIs(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, string $paymentStatus): array
    {
        $query = $this->baseAgingQuery($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus)
            ->selectRaw('
                COUNT(DISTINCT i.id) AS num_invoices,
                SUM(i.total_amount) AS total_invoiced,
                COALESCE(SUM(rs.payment_amount), 0) AS total_paid
            ')
            ->first();

        $totalInvoiced = (float) ($query->total_invoiced ?? 0);
        $totalPaid = (float) ($query->total_paid ?? 0);
        $totalOutstanding = $totalInvoiced - $totalPaid;
        $numInvoices = (int) ($query->num_invoices ?? 0);

        // Calculate overdue
        $overdueQuery = $this->baseAgingQuery($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus)
            ->selectRaw('
                SUM(i.total_amount - COALESCE(rs.payment_amount, 0)) AS overdue_amount
            ')
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 0')
            ->first();

        $totalOverdue = (float) ($overdueQuery->overdue_amount ?? 0);

        // Calculate DSO (Days Sales Outstanding)
        $dso = 0;
        if ($totalInvoiced > 0) {
            $daysDiff = Carbon::parse($dateTo)->diffInDays(Carbon::parse($dateFrom)) + 1;
            $dailySales = $totalInvoiced / ($daysDiff > 0 ? $daysDiff : 1);
            $dso = $dailySales > 0 ? $totalOutstanding / $dailySales : 0;
        }

        // Calculate collection rate
        $collectionRate = ($totalInvoiced > 0) ? ($totalPaid / $totalInvoiced) * 100 : 0;

        // Calculate overdue percentage
        $overduePercent = ($totalOutstanding > 0) ? ($totalOverdue / $totalOutstanding) * 100 : 0;

        return [
            'numInvoices'       => $numInvoices,
            'totalOutstanding'  => round($totalOutstanding, 2),
            'totalOverdue'      => round($totalOverdue, 2),
            'totalPaid'         => round($totalPaid, 2),
            'dso'               => round($dso, 1),
            'collectionRate'    => round($collectionRate, 2),
            'overduePercent'    => round($overduePercent, 2),
        ];
    }

    /**
     * Get aging bucket distribution
     */
    private function getAgingBuckets(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, string $paymentStatus): array
    {
        $data = $this->baseAgingQuery($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus)
            ->selectRaw('
                DATEDIFF(NOW(), i.due_date) AS days_overdue,
                SUM(i.total_amount - COALESCE(rs.payment_amount, 0)) AS outstanding_amount,
                COUNT(DISTINCT i.id) AS num_invoices
            ')
            ->groupByRaw('DATEDIFF(NOW(), i.due_date)')
            ->get()
            ->toArray();

        $buckets = array_map(fn($b) => [
            'label' => 'Count',
            'current' => 0,
            '1_30' => 0,
            '31_60' => 0,
            '61_90' => 0,
            '91_120' => 0,
            '121_plus' => 0,
        ], range(0, 5));

        $bucketSummary = [
            'current'  => 0,
            '1_30'     => 0,
            '31_60'    => 0,
            '61_90'    => 0,
            '91_120'   => 0,
            '121_plus' => 0,
        ];

        foreach ($data as $row) {
            $daysOverdue = (int) $row['days_overdue'];
            $amount = (float) $row['outstanding_amount'];

            if ($daysOverdue <= 0) {
                $bucketSummary['current'] += $amount;
            } elseif ($daysOverdue <= 30) {
                $bucketSummary['1_30'] += $amount;
            } elseif ($daysOverdue <= 60) {
                $bucketSummary['31_60'] += $amount;
            } elseif ($daysOverdue <= 90) {
                $bucketSummary['61_90'] += $amount;
            } elseif ($daysOverdue <= 120) {
                $bucketSummary['91_120'] += $amount;
            } else {
                $bucketSummary['121_plus'] += $amount;
            }
        }

        return array_map(function($key, $bucket) use ($bucketSummary) {
            return [
                'label' => $bucket['label'],
                'amount' => round($bucketSummary[$key], 2),
                'key' => $key,
            ];
        }, array_keys($this->agingBuckets), array_values($this->agingBuckets));
    }

    /**
     * Get DSO trend (last 12 months)
     */
    private function getAgingTrend(?int $projectId, ?string $customerCode, string $paymentStatus): array
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $dateFrom = $date->startOfMonth()->toDateString();
            $dateTo = $date->endOfMonth()->toDateString();

            $kpi = $this->calculateKPIs($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus);

            $months[] = [
                'month' => $date->locale('id')->monthName . ' ' . $date->year,
                'dso' => $kpi['dso'],
                'outstanding' => $kpi['totalOutstanding'],
            ];
        }

        return $months;
    }

    /**
     * Get top overdue customers
     */
    private function getTopOverdueCustomers(string $dateFrom, string $dateTo, ?int $projectId, string $paymentStatus): array
    {
        $data = $this->baseAgingQuery($dateFrom, $dateTo, $projectId, null, $paymentStatus)
            ->whereRaw('DATEDIFF(NOW(), i.due_date) > 0')
            ->selectRaw('
                i.customer_name,
                i.customer_code,
                SUM(i.total_amount - COALESCE(rs.payment_amount, 0)) AS overdue_amount,
                COUNT(DISTINCT i.id) AS num_invoices,
                MAX(DATEDIFF(NOW(), i.due_date)) AS oldest_days_overdue
            ')
            ->groupBy('i.customer_name', 'i.customer_code')
            ->orderByRaw('SUM(i.total_amount - COALESCE(rs.payment_amount, 0)) DESC')
            ->limit(10)
            ->get();

        return $data->map(fn($row) => [
            'customer_name' => $row->customer_name,
            'customer_code' => $row->customer_code,
            'overdue_amount' => round((float) $row->overdue_amount, 2),
            'num_invoices' => (int) $row->num_invoices,
            'oldest_days' => (int) $row->oldest_days_overdue,
        ])->toArray();
    }

    /**
     * Get paginated aging details
     */
    private function getAgingDetails(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, ?string $agingBucket, string $paymentStatus)
    {
        $query = $this->baseAgingQuery($dateFrom, $dateTo, $projectId, $customerCode, $paymentStatus)
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
            ])
            ->groupBy('i.id', 'i.invoice_number', 'i.customer_name', 'i.customer_code',
                      'i.invoice_date', 'i.due_date', 'i.total_amount', 'i.status',
                      'p.project_name');

        // Apply aging bucket filter if provided
        if ($agingBucket && isset($this->agingBuckets[$agingBucket])) {
            $bucket = $this->agingBuckets[$agingBucket];
            $query->whereRaw("DATEDIFF(NOW(), i.due_date) >= {$bucket['min']}")
                  ->whereRaw("DATEDIFF(NOW(), i.due_date) <= {$bucket['max']}");
        }

        return $query
            ->orderBy('i.due_date', 'asc')
            ->orderBy('i.id', 'desc')
            ->paginate($this->pageSize)
            ->withQueryString();
    }

    /**
     * Build base aging query with filters
     */
    private function baseAgingQuery(string $dateFrom, string $dateTo, ?int $projectId, ?string $customerCode, string $paymentStatus)
    {
        $query = DB::table('invoices AS i')
            ->join('projects AS p', 'i.project_id', '=', 'p.id')
            ->leftJoin('receivable_settlements AS rs', function($join) {
                $join->on('i.id', '=', 'rs.invoice_id')
                     ->where('rs.status', '=', 'APPROVED')
                     ->whereNull('rs.deleted_at');
            })
            ->whereNull('i.deleted_at')
            ->whereIn('i.status', ['APPROVED', 'PAID'])
            ->whereDate('i.invoice_date', '>=', $dateFrom)
            ->whereDate('i.invoice_date', '<=', $dateTo);

        if ($projectId) {
            $query->where('i.project_id', $projectId);
        }

        if ($customerCode) {
            $query->where('i.customer_code', 'LIKE', "%{$customerCode}%");
        }

        // Apply payment status filter
        if ($paymentStatus === 'paid') {
            $query->where('i.status', 'PAID');
        } elseif ($paymentStatus === 'unpaid') {
            $query->whereRaw('COALESCE(SUM(rs.payment_amount), 0) = 0');
        } elseif ($paymentStatus === 'partial') {
            $query->whereRaw('COALESCE(SUM(rs.payment_amount), 0) > 0')
                  ->whereRaw('COALESCE(SUM(rs.payment_amount), 0) < i.total_amount');
        }

        return $query;
    }

    /**
     * Calculate days overdue
     */
    private function getDaysOverdue(string $dueDate): int
    {
        return Carbon::parse($dueDate)->diffInDays(now(), false);
    }

    /**
     * Get aging bucket name from days overdue
     */
    private function getAgingBucketName(int $daysOverdue): string
    {
        if ($daysOverdue <= 0) {
            return 'Current';
        } elseif ($daysOverdue <= 30) {
            return '1-30 Days';
        } elseif ($daysOverdue <= 60) {
            return '31-60 Days';
        } elseif ($daysOverdue <= 90) {
            return '61-90 Days';
        } elseif ($daysOverdue <= 120) {
            return '91-120 Days';
        } else {
            return '121+ Days';
        }
    }
}
