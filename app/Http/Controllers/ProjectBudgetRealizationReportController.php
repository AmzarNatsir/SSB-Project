<?php

namespace App\Http\Controllers;

use App\Enums\BudgetStatus;
use App\Models\Project;
use App\Models\ProjectBudget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectBudgetRealizationReportController extends Controller
{
    public function index(Request $request)
    {
        $year      = (int) $request->input('year', now()->year);
        $projectId = $request->input('project_id');
        $status    = $request->input('status', 'ALL');

        // ─── 1. KPI Totals ─────────────────────────────────────────────────
        $totals = $this->baseQuery($year, $projectId, $status)
            ->selectRaw('
                COUNT(*) AS total_count,
                SUM(pb.total_hpp) AS total_hpp,
                SUM(pb.selling_price) AS total_selling_price,
                AVG(pb.profit_margin_percent) AS avg_margin
            ')
            ->first();

        $totalCount        = (int) ($totals->total_count ?? 0);
        $totalHpp          = (float) ($totals->total_hpp ?? 0);
        $totalSellingPrice = (float) ($totals->total_selling_price ?? 0);
        $avgMargin         = round((float) ($totals->avg_margin ?? 0), 2);

        // ─── 2. Chart: Budget by Status (Donut) ───────────────────────────
        $statusDist = DB::table('project_budgets AS pb')
            ->whereNull('pb.deleted_at')
            ->whereYear('pb.created_at', $year)
            ->when($projectId, fn ($q) => $q->where('pb.project_id', $projectId))
            ->selectRaw('pb.status, COUNT(*) AS cnt')
            ->groupBy('pb.status')
            ->orderBy('pb.status')
            ->get()
            ->map(fn ($r) => [
                'label' => BudgetStatus::from($r->status)->label(),
                'count' => (int) $r->cnt,
                'color' => BudgetStatus::from($r->status)->color(),
            ]);

        // ─── 3. Chart: Cost Category Breakdown (Bar) ──────────────────────
        $categoryBreakdown = $this->baseQuery($year, $projectId, $status)
            ->selectRaw('
                SUM(pb.total_labor_cost)        AS labor,
                SUM(pb.total_equipment_cost)    AS equipment,
                SUM(pb.total_maintenance_cost)  AS maintenance,
                SUM(pb.total_operational_cost)  AS operational,
                SUM(pb.total_mobilization_cost) AS mobilization,
                SUM(pb.total_other_cost)        AS other_cost
            ')
            ->first();

        // ─── 4. Chart: HPP per Project – Top 10 (Horizontal Bar) ──────────
        $projectBudget = DB::table('project_budgets AS pb')
            ->join('projects AS p', 'pb.project_id', '=', 'p.id')
            ->whereNull('pb.deleted_at')
            ->whereYear('pb.created_at', $year)
            ->when($status !== 'ALL', fn ($q) => $q->where('pb.status', $status))
            ->selectRaw('p.project_name, SUM(pb.total_hpp) AS total_hpp, SUM(pb.selling_price) AS total_sp')
            ->groupBy('p.id', 'p.project_name')
            ->orderByDesc('total_hpp')
            ->limit(10)
            ->get()
            ->map(fn ($r) => [
                'name' => $r->project_name,
                'hpp'  => round((float) $r->total_hpp, 0),
                'sp'   => round((float) $r->total_sp, 0),
            ]);

        // ─── 5. Chart: Monthly Budget Trend ───────────────────────────────
        $monthlyRaw = DB::table('project_budgets AS pb')
            ->whereNull('pb.deleted_at')
            ->whereYear('pb.created_at', $year)
            ->when($projectId, fn ($q) => $q->where('pb.project_id', $projectId))
            ->when($status !== 'ALL', fn ($q) => $q->where('pb.status', $status))
            ->selectRaw('MONTH(pb.created_at) AS month_num, SUM(pb.total_hpp) AS total_hpp, COUNT(*) AS cnt')
            ->groupByRaw('MONTH(pb.created_at)')
            ->orderBy('month_num')
            ->get()
            ->keyBy('month_num');

        $months = collect(range(1, 12))->map(fn ($m) => [
            'label' => Carbon::create($year, $m, 1)->locale('id')->monthName,
            'hpp'   => round((float) ($monthlyRaw->get($m)?->total_hpp ?? 0), 0),
            'count' => (int) ($monthlyRaw->get($m)?->cnt ?? 0),
        ]);

        // ─── 6. Filter dropdowns ───────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);
        $years    = DB::table('project_budgets')
            ->whereNull('deleted_at')
            ->selectRaw('YEAR(created_at) AS yr')
            ->groupByRaw('YEAR(created_at)')
            ->orderByDesc('yr')
            ->pluck('yr');

        if ($years->isEmpty()) {
            $years = collect([now()->year]);
        }

        // ─── 7. Paginated budget list ──────────────────────────────────────
        $budgetsQuery = ProjectBudget::with(['project', 'creator'])
            ->whereYear('created_at', $year);

        if ($projectId) {
            $budgetsQuery->where('project_id', $projectId);
        }
        if ($status !== 'ALL') {
            $budgetsQuery->where('status', $status);
        }

        $budgets = $budgetsQuery
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('reports.project-budget-realization', compact(
            'totalCount', 'totalHpp', 'totalSellingPrice', 'avgMargin',
            'statusDist', 'categoryBreakdown', 'projectBudget', 'months',
            'projects', 'years',
            'year', 'projectId', 'status',
            'budgets'
        ));
    }

    public function export(Request $request)
    {
        $year      = (int) $request->input('year', now()->year);
        $projectId = $request->input('project_id');
        $status    = $request->input('status', 'ALL');

        $rows = DB::table('project_budgets AS pb')
            ->join('projects AS p', 'pb.project_id', '=', 'p.id')
            ->leftJoin('users AS u', 'pb.created_by', '=', 'u.id')
            ->whereNull('pb.deleted_at')
            ->whereYear('pb.created_at', $year)
            ->when($projectId, fn ($q) => $q->where('pb.project_id', $projectId))
            ->when($status !== 'ALL', fn ($q) => $q->where('pb.status', $status))
            ->select([
                'p.project_name',
                'pb.version',
                'pb.status',
                'pb.total_labor_cost',
                'pb.total_equipment_cost',
                'pb.total_maintenance_cost',
                'pb.total_operational_cost',
                'pb.total_mobilization_cost',
                'pb.total_other_cost',
                'pb.total_hpp',
                'pb.profit_margin_percent',
                'pb.selling_price',
                'u.name AS created_by_name',
                'pb.created_at',
            ])
            ->orderByDesc('pb.created_at')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_anggaran_proyek_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'No', 'Proyek', 'Versi', 'Status',
                'Biaya Tenaga Kerja', 'Biaya Alat Berat', 'Biaya Pemeliharaan',
                'Biaya Operasional', 'Biaya Mobilisasi', 'Biaya Lainnya',
                'Total HPP', 'Margin (%)', 'Harga Jual',
                'Dibuat Oleh', 'Tanggal',
            ]);

            foreach ($rows as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    $row->project_name,
                    $row->version,
                    BudgetStatus::from($row->status)->label(),
                    $row->total_labor_cost,
                    $row->total_equipment_cost,
                    $row->total_maintenance_cost,
                    $row->total_operational_cost,
                    $row->total_mobilization_cost,
                    $row->total_other_cost,
                    $row->total_hpp,
                    $row->profit_margin_percent,
                    $row->selling_price,
                    $row->created_by_name ?? '-',
                    $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function baseQuery(int $year, ?string $projectId, string $status)
    {
        return DB::table('project_budgets AS pb')
            ->join('projects AS p', 'pb.project_id', '=', 'p.id')
            ->whereNull('pb.deleted_at')
            ->whereYear('pb.created_at', $year)
            ->when($projectId, fn ($q) => $q->where('pb.project_id', $projectId))
            ->when($status !== 'ALL', fn ($q) => $q->where('pb.status', $status));
    }
}
