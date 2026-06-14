<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectPettyCashTransactionReportController extends Controller
{
    protected $pageSize = 20;

    /**
     * Display petty cash transaction report
     */
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $projectId = $request->input('project_id');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');

        // ─── 1. KPI Totals ─────────────────────────────────────────────────
        $kpiData = $this->calculateKPIs($dateFrom, $dateTo, $projectId);

        // ─── 2. Chart: Petty Cash Balance Trend (12 Months) ─────────────────
        $balanceTrend = $this->getBalanceTrend($projectId);

        // ─── 3. Chart: Usage by Expense Category ────────────────────────────
        $usageByCategory = $this->getUsageByCategory($dateFrom, $dateTo, $projectId);

        // ─── 4. Chart: Usage by Project ─────────────────────────────────────
        $usageByProject = $this->getUsageByProject($dateFrom, $dateTo);

        // ─── 5. Chart: Transaction Status Distribution ──────────────────────
        $statusDistribution = $this->getStatusDistribution($dateFrom, $dateTo, $projectId);

        // ─── 6. Filter dropdowns ───────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);

        $categories = DB::table('petty_cash_expense_categories')
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get(['id', 'code', 'name']);

        $statusOptions = [
            ['value' => 'all', 'label' => 'All Status'],
            ['value' => 'pending', 'label' => 'Pending'],
            ['value' => 'approved', 'label' => 'Approved'],
            ['value' => 'reconciled', 'label' => 'Reconciled'],
            ['value' => 'rejected', 'label' => 'Rejected'],
        ];

        // ─── 7. Paginated transactions ──────────────────────────────────────
        $transactions = $this->getTransactions($dateFrom, $dateTo, $projectId, $categoryId, $status);

        return view('reports.project-petty-cash-transaction', compact(
            'kpiData', 'balanceTrend', 'usageByCategory', 'usageByProject', 'statusDistribution',
            'projects', 'categories', 'statusOptions',
            'dateFrom', 'dateTo', 'projectId', 'categoryId', 'status',
            'transactions'
        ));
    }

    /**
     * Export petty cash transaction data to CSV
     */
    public function export(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subMonths(12)->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        $projectId = $request->input('project_id');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');

        $rows = $this->getTransactionsForExport($dateFrom, $dateTo, $projectId, $categoryId, $status);

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="petty_cash_transaction_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Nomor Transaksi', 'Tgl Transaksi', 'Proyek', 'Kategori', 'Deskripsi',
                'Jumlah (Rp)', 'Status', 'Dibuat Oleh', 'Disetujui Oleh', 'Tgl Persetujuan',
            ]);

            foreach ($rows as $row) {
                fputcsv($file, [
                    $row->transaction_number,
                    $row->transaction_date,
                    $row->project_name,
                    $row->category_name,
                    $row->description,
                    round($row->amount, 2),
                    strtoupper($row->status),
                    $row->created_by_name,
                    $row->approved_by_name ?? '-',
                    $row->approved_at ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate KPI metrics for petty cash
     */
    private function calculateKPIs(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        // Total allocated
        $allocatedQuery = DB::table('petty_cash_requests AS pcr')
            ->whereNull('pcr.deleted_at')
            ->where('pcr.status', 'approved')
            ->when($projectId, fn($q) => $q->where('pcr.project_id', $projectId))
            ->selectRaw('SUM(pcr.requested_amount) AS total')
            ->first();

        $totalAllocated = (float) ($allocatedQuery->total ?? 0);

        // Total used
        $usedQuery = DB::table('petty_cash_purchases AS pcp')
            ->whereNull('pcp.deleted_at')
            ->where('pcp.status', 'approved')
            ->whereBetween('pcp.purchase_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('pcp.project_id', $projectId))
            ->selectRaw('SUM(pcp.amount) AS total')
            ->first();

        $totalUsed = (float) ($usedQuery->total ?? 0);

        // Total transactions
        $transactionCount = DB::table('petty_cash_purchases')
            ->whereNull('deleted_at')
            ->where('status', 'approved')
            ->whereBetween('purchase_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->count();

        // Number of projects with petty cash
        $projectsWithPCQuery = DB::table('petty_cash_requests')
            ->whereNull('deleted_at')
            ->where('status', 'approved')
            ->selectRaw('COUNT(DISTINCT project_id) AS count')
            ->first();

        $numProjects = (int) ($projectsWithPCQuery->count ?? 0);

        // Available balance
        $availableBalance = $totalAllocated - $totalUsed;

        // Utilization percentage
        $utilizationPercent = $totalAllocated > 0 ? ($totalUsed / $totalAllocated) * 100 : 0;

        return [
            'totalAllocated'      => round($totalAllocated, 2),
            'totalUsed'           => round($totalUsed, 2),
            'availableBalance'    => round($availableBalance, 2),
            'transactionCount'    => $transactionCount,
            'numProjects'         => $numProjects,
            'utilizationPercent'  => round($utilizationPercent, 2),
        ];
    }

    /**
     * Get petty cash balance trend (12 months)
     */
    private function getBalanceTrend(?int $projectId): array
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $endDate = $date->copy()->endOfMonth();

            $allocated = DB::table('petty_cash_requests AS pcr')
                ->whereNull('pcr.deleted_at')
                ->where('pcr.status', 'approved')
                ->whereDate('pcr.request_date', '<=', $endDate)
                ->when($projectId, fn($q) => $q->where('pcr.project_id', $projectId))
                ->sum('pcr.requested_amount');

            $used = DB::table('petty_cash_purchases AS pcp')
                ->whereNull('pcp.deleted_at')
                ->where('pcp.status', 'approved')
                ->whereDate('pcp.purchase_date', '<=', $endDate)
                ->when($projectId, fn($q) => $q->where('pcp.project_id', $projectId))
                ->sum('pcp.amount');

            $months[] = [
                'month' => $date->locale('id')->monthName . ' ' . $date->year,
                'allocated' => round($allocated, 2),
                'used' => round($used, 2),
                'balance' => round($allocated - $used, 2),
            ];
        }

        return $months;
    }

    /**
     * Get usage by expense category
     */
    private function getUsageByCategory(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        $data = DB::table('petty_cash_purchases AS pcp')
            ->leftJoin('petty_cash_expense_categories AS pce', 'pcp.expense_category_id', '=', 'pce.id')
            ->whereNull('pcp.deleted_at')
            ->where('pcp.status', 'approved')
            ->whereBetween('pcp.purchase_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('pcp.project_id', $projectId))
            ->selectRaw('
                COALESCE(pce.name, "Uncategorized") AS category,
                SUM(pcp.amount) AS amount,
                COUNT(pcp.id) AS count
            ')
            ->groupBy('pce.id', 'pce.name')
            ->orderByDesc('amount')
            ->limit(10)
            ->get();

        return $data->map(fn($row) => [
            'category' => $row->category,
            'amount' => round((float) $row->amount, 2),
            'count' => (int) $row->count,
        ])->toArray();
    }

    /**
     * Get usage by project
     */
    private function getUsageByProject(string $dateFrom, string $dateTo): array
    {
        $data = DB::table('petty_cash_purchases AS pcp')
            ->leftJoin('projects AS p', 'pcp.project_id', '=', 'p.id')
            ->whereNull('pcp.deleted_at')
            ->where('pcp.status', 'approved')
            ->whereBetween('pcp.purchase_date', [$dateFrom, $dateTo])
            ->selectRaw('
                p.project_name,
                SUM(pcp.amount) AS amount,
                COUNT(pcp.id) AS count
            ')
            ->groupBy('pcp.project_id', 'p.project_name')
            ->orderByDesc('amount')
            ->limit(10)
            ->get();

        return $data->map(fn($row) => [
            'project' => $row->project_name,
            'amount' => round((float) $row->amount, 2),
            'count' => (int) $row->count,
        ])->toArray();
    }

    /**
     * Get transaction status distribution
     */
    private function getStatusDistribution(string $dateFrom, string $dateTo, ?int $projectId): array
    {
        $data = DB::table('petty_cash_purchases')
            ->whereNull('deleted_at')
            ->whereBetween('purchase_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->selectRaw('
                status,
                COUNT(id) AS count,
                SUM(amount) AS amount
            ')
            ->groupBy('status')
            ->get();

        $statuses = ['pending' => 0, 'approved' => 0, 'reconciled' => 0, 'rejected' => 0];
        foreach ($data as $row) {
            $statuses[$row->status] = (int) $row->count;
        }

        return [
            ['status' => 'Pending', 'value' => $statuses['pending'] ?? 0, 'color' => '#FFC107'],
            ['status' => 'Approved', 'value' => $statuses['approved'] ?? 0, 'color' => '#28A745'],
            ['status' => 'Reconciled', 'value' => $statuses['reconciled'] ?? 0, 'color' => '#007BFF'],
            ['status' => 'Rejected', 'value' => $statuses['rejected'] ?? 0, 'color' => '#DC3545'],
        ];
    }

    /**
     * Get paginated transactions
     */
    private function getTransactions(string $dateFrom, string $dateTo, ?int $projectId, ?string $categoryId, ?string $status)
    {
        $query = DB::table('petty_cash_purchases AS pcp')
            ->leftJoin('petty_cash_expense_categories AS pce', 'pcp.expense_category_id', '=', 'pce.id')
            ->leftJoin('projects AS p', 'pcp.project_id', '=', 'p.id')
            ->leftJoin('users AS uc', 'pcp.created_by', '=', 'uc.id')
            ->leftJoin('users AS ua', 'pcp.approved_by', '=', 'ua.id')
            ->whereNull('pcp.deleted_at')
            ->whereBetween('pcp.purchase_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('pcp.project_id', $projectId))
            ->when($categoryId && $categoryId !== 'all', fn($q) => $q->where('pcp.expense_category_id', $categoryId))
            ->when($status && $status !== 'all', fn($q) => $q->where('pcp.status', $status))
            ->select([
                'pcp.id',
                'pcp.purchase_number',
                'pcp.purchase_date',
                'pcp.description',
                'pcp.amount',
                'pcp.status',
                'pce.name AS category_name',
                'p.project_name',
                'uc.name AS created_by_name',
                'ua.name AS approved_by_name',
                'pcp.approved_at',
            ]);

        return $query
            ->orderBy('pcp.purchase_date', 'desc')
            ->paginate($this->pageSize)
            ->withQueryString();
    }

    /**
     * Get transactions for CSV export
     */
    private function getTransactionsForExport(string $dateFrom, string $dateTo, ?int $projectId, ?string $categoryId, ?string $status)
    {
        $query = DB::table('petty_cash_purchases AS pcp')
            ->leftJoin('petty_cash_expense_categories AS pce', 'pcp.expense_category_id', '=', 'pce.id')
            ->leftJoin('projects AS p', 'pcp.project_id', '=', 'p.id')
            ->leftJoin('users AS uc', 'pcp.created_by', '=', 'uc.id')
            ->leftJoin('users AS ua', 'pcp.approved_by', '=', 'ua.id')
            ->whereNull('pcp.deleted_at')
            ->whereBetween('pcp.purchase_date', [$dateFrom, $dateTo])
            ->when($projectId, fn($q) => $q->where('pcp.project_id', $projectId))
            ->when($categoryId && $categoryId !== 'all', fn($q) => $q->where('pcp.expense_category_id', $categoryId))
            ->when($status && $status !== 'all', fn($q) => $q->where('pcp.status', $status))
            ->select([
                'pcp.purchase_number',
                'pcp.purchase_date',
                'p.project_name',
                'pce.name AS category_name',
                'pcp.description',
                'pcp.amount',
                'pcp.status',
                'uc.name AS created_by_name',
                'ua.name AS approved_by_name',
                'pcp.approved_at',
            ])
            ->orderBy('pcp.purchase_date', 'desc')
            ->get();

        return $query->map(function($row) {
            return (object) [
                'transaction_number' => $row->purchase_number,
                'transaction_date' => $row->purchase_date,
                'project_name' => $row->project_name,
                'category_name' => $row->category_name,
                'description' => $row->description,
                'amount' => $row->amount,
                'status' => $row->status,
                'created_by_name' => $row->created_by_name,
                'approved_by_name' => $row->approved_by_name,
                'approved_at' => $row->approved_at,
            ];
        });
    }
}
