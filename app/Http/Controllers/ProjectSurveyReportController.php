<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectSurveyReportController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  REPORT DASHBOARD (GET /survey-reports)
    // ─────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $startDate  = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate    = $request->input('end_date',   Carbon::now()->toDateString());
        $projectId  = $request->input('project_id');
        $status     = $request->input('status', 'ALL');
        $isFeasible = $request->input('is_feasible', 'ALL');

        // ─── KPI Totals ───────────────────────────────────────────────────
        $totals = $this->baseAgg($startDate, $endDate, $projectId, $status, $isFeasible)
            ->select(DB::raw('
                COUNT(*) as total_surveys,
                SUM(CASE WHEN status IN ("COMPLETED", "PROJECT_FEASIBLE", "PROJECT_CANCELLED", "REJECTED") THEN 1 ELSE 0 END) as completed_surveys,
                SUM(CASE WHEN is_feasible = 1 THEN 1 ELSE 0 END) as feasible_projects,
                AVG(CASE WHEN status != "DRAFT" AND total_score IS NOT NULL THEN total_score END) as avg_score
            '))
            ->first();

        $totalSurveys     = (int)   ($totals->total_surveys ?? 0);
        $completedSurveys = (int)   ($totals->completed_surveys ?? 0);
        $feasibleProjects = (int)   ($totals->feasible_projects ?? 0);
        $avgScore         = (float) ($totals->avg_score ?? 0);

        // ─── Chart 1: Average Score Trend ─────────────────────────────────
        $scoreTrend = $this->baseAgg($startDate, $endDate, $projectId, $status, $isFeasible)
            ->whereNotNull('total_score')
            ->select(DB::raw('DATE(scheduled_at) as date_val, AVG(total_score) as avg_score'))
            ->groupBy(DB::raw('DATE(scheduled_at)'))
            ->orderBy('date_val')
            ->get()
            ->map(fn($r) => [
                'date'  => Carbon::parse($r->date_val)->format('d M Y'),
                'score' => round((float) $r->avg_score, 2),
            ]);

        // ─── Chart 2: Feasibility Ratio ───────────────────────────────────
        $feasibilityRatio = $this->baseAgg($startDate, $endDate, $projectId, $status, $isFeasible)
            ->select(DB::raw('is_feasible, COUNT(*) as qty'))
            ->groupBy('is_feasible')
            ->get()
            ->map(fn($r) => [
                'label' => $r->is_feasible === 1 ? 'Feasible (Layak)' : ($r->is_feasible === 0 ? 'Not Feasible (Tidak Layak)' : 'Pending'),
                'qty'   => $r->qty
            ]);

        // ─── Chart 3: Status Distribution ─────────────────────────────────
        $statusDist = $this->baseAgg($startDate, $endDate, $projectId, $status, $isFeasible)
            ->select(DB::raw('status, COUNT(*) as qty'))
            ->groupBy('status')
            ->get()
            ->map(fn($r) => [
                'status' => str_replace('_', ' ', $r->status),
                'qty'    => $r->qty
            ]);

        // ─── Chart 4: Average Score per Department ───────────────────────
        $filteredIds = $this->baseAgg($startDate, $endDate, $projectId, $status, $isFeasible)
            ->pluck('id');

        $deptScores = DB::table('project_survey_scores')
            ->whereIn('survey_id', $filteredIds)
            ->select('department', DB::raw('AVG(score) as avg_score'))
            ->groupBy('department')
            ->get()
            ->map(fn($r) => [
                'dept'  => $r->department,
                'score' => round((float) $r->avg_score, 2)
            ]);

        // ─── Filters & Paginated Log Table ───────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);

        $entries = ProjectSurvey::with(['project', 'teams.user', 'scores'])
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->when($startDate, fn($q) => $q->whereDate('scheduled_at', '>=', $startDate))
            ->when($endDate,   fn($q) => $q->whereDate('scheduled_at', '<=', $endDate))
            ->when($status !== 'ALL', fn($q) => $q->where('status', $status))
            ->when($isFeasible !== 'ALL', function($q) use ($isFeasible) {
                if ($isFeasible === 'FEASIBLE') {
                    $q->where('is_feasible', true);
                } elseif ($isFeasible === 'NOT_FEASIBLE') {
                    $q->where('is_feasible', false);
                } elseif ($isFeasible === 'PENDING') {
                    $q->whereNull('is_feasible');
                }
            })
            ->orderByDesc('scheduled_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('reports.project-survey', compact(
            'entries', 'totalSurveys', 'completedSurveys', 'feasibleProjects', 'avgScore',
            'scoreTrend', 'feasibilityRatio', 'statusDist', 'deptScores',
            'projects', 'startDate', 'endDate', 'projectId', 'status', 'isFeasible'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  CSV EXPORT (GET /survey-reports/export)
    // ─────────────────────────────────────────────────────────────────────────
    public function export(Request $request)
    {
        $startDate  = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate    = $request->input('end_date',   Carbon::now()->toDateString());
        $projectId  = $request->input('project_id');
        $status     = $request->input('status', 'ALL');
        $isFeasible = $request->input('is_feasible', 'ALL');

        $rows = ProjectSurvey::with(['project', 'teams.user', 'scores'])
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->when($startDate, fn($q) => $q->whereDate('scheduled_at', '>=', $startDate))
            ->when($endDate,   fn($q) => $q->whereDate('scheduled_at', '<=', $endDate))
            ->when($status !== 'ALL', fn($q) => $q->where('status', $status))
            ->when($isFeasible !== 'ALL', function($q) use ($isFeasible) {
                if ($isFeasible === 'FEASIBLE') {
                    $q->where('is_feasible', true);
                } elseif ($isFeasible === 'NOT_FEASIBLE') {
                    $q->where('is_feasible', false);
                } elseif ($isFeasible === 'PENDING') {
                    $q->whereNull('is_feasible');
                }
            })
            ->orderByDesc('scheduled_at')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_survey_proyek_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($f, [
                'No. Survey', 'Nama Proyek', 'Tanggal Survey', 'Status', 'Kelayakan',
                'Tim Surveyor', 'Nilai PROJECT (40%)', 'Nilai WORKSHOP (30%)', 'Nilai HSE (30%)',
                'Total Score (100%)', 'Keterangan Skip', 'Dibuat Tanggal'
            ]);

            foreach ($rows as $r) {
                $teamNames = $r->teams->map(fn($t) => $t->user?->name . ' (' . $t->department . ')')->implode(', ');
                
                $projectScore  = $r->scores->firstWhere('department', 'PROJECT')?->score ?? '-';
                $workshopScore = $r->scores->firstWhere('department', 'WORKSHOP')?->score ?? '-';
                $hseScore      = $r->scores->firstWhere('department', 'HSE')?->score ?? '-';

                $feasibility = $r->is_feasible === true ? 'Feasible (Layak)' : ($r->is_feasible === false ? 'Not Feasible (Tidak Layak)' : 'Pending');

                fputcsv($f, [
                    $r->uid,
                    $r->project?->project_name ?? '-',
                    $r->scheduled_at ? $r->scheduled_at->format('Y-m-d H:i') : '-',
                    str_replace('_', ' ', $r->status),
                    $feasibility,
                    $teamNames ?: '-',
                    $projectScore,
                    $workshopScore,
                    $hseScore,
                    $r->total_score ?? '-',
                    $r->skip_reason ?: '',
                    $r->created_at->format('Y-m-d H:i')
                ]);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  BASE QUERY AGGREGATOR
    // ─────────────────────────────────────────────────────────────────────────
    private function baseAgg(string $startDate, string $endDate, ?string $projectId, string $status, string $isFeasible)
    {
        $q = DB::table('project_surveys')
            ->whereNull('deleted_at')
            ->whereDate('scheduled_at', '>=', $startDate)
            ->whereDate('scheduled_at', '<=', $endDate);

        if (!empty($projectId)) {
            $q->where('project_id', $projectId);
        }
        if ($status !== 'ALL') {
            $q->where('status', $status);
        }
        if ($isFeasible !== 'ALL') {
            if ($isFeasible === 'FEASIBLE') {
                $q->where('is_feasible', true);
            } elseif ($isFeasible === 'NOT_FEASIBLE') {
                $q->where('is_feasible', false);
            } elseif ($isFeasible === 'PENDING') {
                $q->whereNull('is_feasible');
            }
        }

        return $q;
    }
}
