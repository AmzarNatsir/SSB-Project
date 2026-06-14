<?php

namespace App\Http\Controllers;

use App\Enums\WorkRealizationStatus;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectRealizationReportController extends Controller
{
    /**
     * Display project realization report with KPI cards, charts, and detail table
     */
    public function index(Request $request)
    {
        $periodStart   = $request->input('period_start', now()->startOfMonth()->toDateString());
        $periodEnd     = $request->input('period_end', now()->toDateString());
        $projectId     = $request->input('project_id');
        $budgetCategory = $request->input('budget_category');
        $status        = $request->input('status', WorkRealizationStatus::APPROVED->value);

        // ─── 1. KPI Totals ─────────────────────────────────────────────────
        $kpiData = $this->calculateKPIs($periodStart, $periodEnd, $projectId, $budgetCategory, $status);

        // ─── 2. Chart: Monthly Trend ───────────────────────────────────────
        $monthlyTrend = $this->getMonthlyTrend($periodStart, $periodEnd, $projectId, $budgetCategory, $status);

        // ─── 3. Chart: Category Breakdown ───────────────────────────────────
        $categoryBreakdown = $this->getCategoryBreakdown($periodStart, $periodEnd, $projectId, $budgetCategory, $status);

        // ─── 4. Chart: Budget vs Actual ─────────────────────────────────────
        $budgetVsActual = $this->getBudgetVsActual($projectId, $budgetCategory);

        // ─── 5. Chart: Top Equipment ───────────────────────────────────────
        $topEquipment = $this->getTopEquipment($periodStart, $periodEnd, $projectId, $budgetCategory, $status);

        // ─── 6. Filter dropdowns ───────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);
        $budgetCategories = array_map(fn($e) => ['value' => $e->value, 'label' => $e->label()],
            \App\Enums\BudgetCategory::cases());
        $statusOptions = array_map(fn($e) => ['value' => $e->value, 'label' => $e->label()],
            WorkRealizationStatus::cases());

        // ─── 7. Paginated detail items ─────────────────────────────────────
        $detailItems = $this->getPaginatedEntries($periodStart, $periodEnd, $projectId, $budgetCategory, $status);

        return view('reports.project-realization', compact(
            'kpiData', 'monthlyTrend', 'categoryBreakdown', 'budgetVsActual', 'topEquipment',
            'projects', 'budgetCategories', 'statusOptions',
            'periodStart', 'periodEnd', 'projectId', 'budgetCategory', 'status',
            'detailItems'
        ));
    }

    /**
     * Export filtered project realization data to CSV
     */
    public function export(Request $request)
    {
        $periodStart   = $request->input('period_start', now()->startOfMonth()->toDateString());
        $periodEnd     = $request->input('period_end', now()->toDateString());
        $projectId     = $request->input('project_id');
        $budgetCategory = $request->input('budget_category');
        $status        = $request->input('status', WorkRealizationStatus::APPROVED->value);

        $rows = $this->baseAggQuery($periodStart, $periodEnd, $projectId, $budgetCategory, $status)
            ->select([
                'p.project_name',
                'wr.realization_number',
                'wr.period_start',
                'wr.period_end',
                'wr.status',
                'wri.unit_name',
                'wri.equipment_code',
                'pbi.category',
                'pbi.item_name',
                'pbi.unit_cost',
                'wri.total_hm',
                'wri.realized_amount',
                'pbi.total_cost AS budget_amount',
            ])
            ->orderBy('wr.period_end', 'desc')
            ->orderBy('wr.id', 'desc')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_realisasi_proyek_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Proyek', 'No. Realisasi', 'Periode Start', 'Periode End', 'Status',
                'Unit / Alat', 'Kode Alat', 'Kategori', 'Nama Item',
                'Unit Cost', 'Total HM', 'Realisasi (Rp)', 'Budget (Rp)', 'Variance (Rp)', 'Variance %',
            ]);

            foreach ($rows as $row) {
                $budgetAmount = (float) ($row->budget_amount ?? 0);
                $realizationAmount = (float) ($row->realized_amount ?? 0);
                $variance = $realizationAmount - $budgetAmount;
                $variancePercent = $budgetAmount > 0 ? ($variance / $budgetAmount) * 100 : 0;

                fputcsv($file, [
                    $row->project_name,
                    $row->realization_number,
                    $row->period_start,
                    $row->period_end,
                    $row->status,
                    $row->unit_name ?? '-',
                    $row->equipment_code ?? '-',
                    $row->category ? \App\Enums\BudgetCategory::from($row->category)->label() : '-',
                    $row->item_name ?? '-',
                    $row->unit_cost ?? '-',
                    $row->total_hm ?? '-',
                    round($realizationAmount, 2),
                    round($budgetAmount, 2),
                    round($variance, 2),
                    round($variancePercent, 2),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate KPI metrics: total budget, total realization, percentages, and variance
     */
    private function calculateKPIs(string $periodStart, string $periodEnd, ?int $projectId, ?string $budgetCategory, string $status): array
    {
        // Total realization from work realization items
        $realizationData = $this->baseAggQuery($periodStart, $periodEnd, $projectId, $budgetCategory, $status)
            ->selectRaw('SUM(wri.realized_amount) AS total_realization')
            ->first();

        $totalRealization = (float) ($realizationData->total_realization ?? 0);

        // Total budget from project budget items (BASELINE_APPROVED only)
        $budgetData = DB::table('project_budgets AS pb')
            ->join('projects AS p', 'pb.project_id', '=', 'p.id')
            ->leftJoin('project_budget_items AS pbi', 'pbi.project_budget_id', '=', 'pb.id')
            ->whereNull('pb.deleted_at')
            ->where('pb.status', 'BASELINE_APPROVED')
            ->when($projectId, fn ($q) => $q->where('pb.project_id', $projectId))
            ->when($budgetCategory, fn ($q) => $q->where('pbi.category', $budgetCategory))
            ->selectRaw('SUM(pbi.total_cost) AS total_budget')
            ->first();

        $totalBudget = (float) ($budgetData->total_budget ?? 0);

        // Calculate derived metrics
        $realizationPercent = $totalBudget > 0 ? ($totalRealization / $totalBudget) * 100 : 0;
        $budgetVariance = $totalRealization - $totalBudget;
        $variancePercent = $totalBudget > 0 ? ($budgetVariance / $totalBudget) * 100 : 0;

        return [
            'totalBudget'        => round($totalBudget, 2),
            'totalRealization'   => round($totalRealization, 2),
            'realizationPercent' => round($realizationPercent, 2),
            'budgetVariance'     => round($budgetVariance, 2),
            'variancePercent'    => round($variancePercent, 2),
        ];
    }

    /**
     * Get monthly trend data grouped by month with budget and realization
     */
    private function getMonthlyTrend(string $periodStart, string $periodEnd, ?int $projectId, ?string $budgetCategory, string $status): array
    {
        $data = $this->baseAggQuery($periodStart, $periodEnd, $projectId, $budgetCategory, $status)
            ->selectRaw("DATE_FORMAT(wr.period_start, '%Y-%m') AS month, SUM(wri.realized_amount) AS realization")
            ->groupByRaw("DATE_FORMAT(wr.period_start, '%Y-%m')")
            ->orderBy('month')
            ->get();

        return $data->map(fn($row) => [
            'month' => Carbon::createFromFormat('Y-m', $row->month)->locale('id')->monthName . ' ' . substr($row->month, 0, 4),
            'realization' => round((float) $row->realization, 2),
        ])->toArray();
    }

    /**
     * Get category breakdown: budget and realization grouped by budget category
     */
    private function getCategoryBreakdown(string $periodStart, string $periodEnd, ?int $projectId, ?string $budgetCategory, string $status): array
    {
        $data = $this->baseAggQuery($periodStart, $periodEnd, $projectId, $budgetCategory, $status)
            ->selectRaw('pbi.category, SUM(wri.realized_amount) AS realization, SUM(pbi.total_cost) AS budget')
            ->groupBy('pbi.category')
            ->orderByRaw('SUM(wri.realized_amount) DESC')
            ->get();

        return $data->map(fn($row) => [
            'category'    => $row->category ? \App\Enums\BudgetCategory::from($row->category)->label() : 'Unknown',
            'budget'      => round((float) $row->budget, 2),
            'realization' => round((float) $row->realization, 2),
            'variance'    => round((float) ($row->realization - $row->budget), 2),
        ])->toArray();
    }

    /**
     * Get budget vs actual comparison for selected project
     */
    private function getBudgetVsActual(?int $projectId, ?string $budgetCategory): array
    {
        $budgetQuery = DB::table('project_budgets AS pb')
            ->join('projects AS p', 'pb.project_id', '=', 'p.id')
            ->leftJoin('project_budget_items AS pbi', 'pbi.project_budget_id', '=', 'pb.id')
            ->whereNull('pb.deleted_at')
            ->where('pb.status', 'BASELINE_APPROVED')
            ->when($projectId, fn ($q) => $q->where('pb.project_id', $projectId))
            ->when($budgetCategory, fn ($q) => $q->where('pbi.category', $budgetCategory))
            ->selectRaw('p.project_name, SUM(pbi.total_cost) AS total_budget')
            ->groupBy('p.id', 'p.project_name')
            ->orderByRaw('SUM(pbi.total_cost) DESC')
            ->limit(10)
            ->get();

        return $budgetQuery->map(fn($row) => [
            'label'  => $row->project_name,
            'budget' => round((float) $row->total_budget, 2),
        ])->toArray();
    }

    /**
     * Get top 5 equipment by realized amount
     */
    private function getTopEquipment(string $periodStart, string $periodEnd, ?int $projectId, ?string $budgetCategory, string $status): array
    {
        $data = $this->baseAggQuery($periodStart, $periodEnd, $projectId, $budgetCategory, $status)
            ->selectRaw("COALESCE(wri.unit_name, 'Unknown Unit') AS unit_name, SUM(wri.realized_amount) AS total_realized")
            ->groupBy('wri.unit_name')
            ->orderByRaw('SUM(wri.realized_amount) DESC')
            ->limit(5)
            ->get();

        return $data->map(fn($row) => [
            'unitName' => $row->unit_name,
            'realized' => round((float) $row->total_realized, 2),
        ])->toArray();
    }

    /**
     * Get paginated work realization entries with eager loading
     */
    private function getPaginatedEntries(string $periodStart, string $periodEnd, ?int $projectId, ?string $budgetCategory, string $status)
    {
        $query = DB::table('work_realization_items AS wri')
            ->join('work_realizations AS wr', 'wri.work_realization_id', '=', 'wr.id')
            ->join('projects AS p', 'wr.project_id', '=', 'p.id')
            ->leftJoin('contracts AS c', 'wr.contract_id', '=', 'c.id')
            ->leftJoin('project_budgets AS pb', function ($join) {
                $join->on('pb.project_id', '=', 'wr.project_id')
                     ->where('pb.status', '=', 'BASELINE_APPROVED');
            })
            ->leftJoin('project_budget_items AS pbi', 'pbi.project_budget_id', '=', 'pb.id');

        // Apply filters
        $query->whereNull('wr.deleted_at')
            ->whereDate('wr.period_start', '>=', $periodStart)
            ->whereDate('wr.period_end', '<=', $periodEnd);

        if ($projectId) {
            $query->where('wr.project_id', $projectId);
        }

        if ($budgetCategory) {
            $query->where('pbi.category', $budgetCategory);
        }

        if ($status !== 'ALL') {
            $query->where('wr.status', $status);
        }

        return $query->select([
                'wri.id',
                'wri.work_realization_id',
                'wri.unit_name',
                'wri.equipment_code',
                'wri.total_hm',
                'wri.realized_amount',
                'wr.realization_number',
                'wr.period_start',
                'wr.period_end',
                'wr.status',
                'p.project_name',
                'c.contract_number',
                'pbi.category',
                'pbi.item_name',
                'pbi.total_cost AS budget_amount',
            ])
            ->orderBy('wr.period_end', 'desc')
            ->orderBy('wr.id', 'desc')
            ->paginate(20)
            ->withQueryString();
    }

    /**
     * Build base aggregation query with joins and filters
     */
    private function baseAggQuery(string $periodStart, string $periodEnd, ?int $projectId, ?string $budgetCategory, string $status)
    {
        return DB::table('work_realization_items AS wri')
            ->join('work_realizations AS wr', 'wri.work_realization_id', '=', 'wr.id')
            ->join('projects AS p', 'wr.project_id', '=', 'p.id')
            ->leftJoin('contracts AS c', 'wr.contract_id', '=', 'c.id')
            ->leftJoin('project_budgets AS pb', function ($join) {
                $join->on('pb.project_id', '=', 'wr.project_id')
                     ->where('pb.status', '=', 'BASELINE_APPROVED');
            })
            ->leftJoin('project_budget_items AS pbi', 'pbi.project_budget_id', '=', 'pb.id')
            ->whereNull('wr.deleted_at')
            ->whereDate('wr.period_start', '>=', $periodStart)
            ->whereDate('wr.period_end', '<=', $periodEnd)
            ->when($projectId, fn ($q) => $q->where('wr.project_id', $projectId))
            ->when($budgetCategory, fn ($q) => $q->where('pbi.category', $budgetCategory))
            ->when($status !== 'ALL', fn ($q) => $q->where('wr.status', $status));
    }
}
