<?php

namespace App\Http\Controllers;

use App\Enums\TimesheetJournalStatus;
use App\Models\Project;
use App\Models\TimesheetEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuelUsageReportController extends Controller
{
    public function index(Request $request)
    {
        // Default date range: 1st day of current month until today
        $startDate   = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate     = $request->input('end_date', Carbon::now()->toDateString());
        $projectId   = $request->input('project_id');
        $unitName    = $request->input('unit_name');
        $operatorName = $request->input('operator_name');
        $status      = $request->input('status', 'APPROVED');

        // ─── 1. KPI Totals ─────────────────────────────────────────────────
        $totalsQuery = $this->baseAggQuery($startDate, $endDate, $projectId, $unitName, $operatorName, $status);
        $totals = $totalsQuery
            ->select(DB::raw('
                SUM(te.fuel_consumed_liter)  AS total_fuel,
                SUM(te.working_hours)         AS total_working_hours,
                SUM(te.hm_total)              AS total_hm
            '))
            ->first();

        $totalFuel         = (float) ($totals->total_fuel ?? 0);
        $totalWorkingHours = (float) ($totals->total_working_hours ?? 0);
        $totalHm           = (float) ($totals->total_hm ?? 0);
        $avgLitersPerHour  = $totalWorkingHours > 0 ? round($totalFuel / $totalWorkingHours, 2) : 0;
        $avgLitersPerHm    = $totalHm > 0 ? round($totalFuel / $totalHm, 2) : 0;

        // ─── 2. Chart: Daily fuel trend ────────────────────────────────────
        $dailyFuel = $this->baseAggQuery($startDate, $endDate, $projectId, $unitName, $operatorName, $status)
            ->select(DB::raw('tj.journal_date, SUM(te.fuel_consumed_liter) AS total_fuel'))
            ->groupBy('tj.journal_date')
            ->orderBy('tj.journal_date')
            ->get()
            ->map(fn ($r) => [
                'date' => Carbon::parse($r->journal_date)->format('d M Y'),
                'fuel' => round((float) $r->total_fuel, 2),
            ]);

        // ─── 3. Chart: Fuel per project ────────────────────────────────────
        $projectFuel = $this->baseAggQuery($startDate, $endDate, $projectId, $unitName, $operatorName, $status)
            ->join('projects AS p', 'tj.project_id', '=', 'p.id')
            ->select(DB::raw('p.project_name, SUM(te.fuel_consumed_liter) AS total_fuel'))
            ->groupBy('p.id', 'p.project_name')
            ->orderByDesc('total_fuel')
            ->get()
            ->map(fn ($r) => [
                'name' => $r->project_name,
                'fuel' => round((float) $r->total_fuel, 2),
            ]);

        // ─── 4. Chart: Fuel per activity code ─────────────────────────────
        $activityFuel = $this->baseAggQuery($startDate, $endDate, $projectId, $unitName, $operatorName, $status)
            ->select(DB::raw('te.activity_code, SUM(te.fuel_consumed_liter) AS total_fuel'))
            ->groupBy('te.activity_code')
            ->orderByDesc('total_fuel')
            ->get()
            ->map(fn ($r) => [
                'activity' => $r->activity_code,
                'fuel'     => round((float) $r->total_fuel, 2),
            ]);

        // ─── 5. Chart: Top 5 units ─────────────────────────────────────────
        $unitFuel = $this->baseAggQuery($startDate, $endDate, $projectId, $unitName, $operatorName, $status)
            ->select(DB::raw('te.unit_name, SUM(te.fuel_consumed_liter) AS total_fuel'))
            ->groupBy('te.unit_name')
            ->orderByDesc('total_fuel')
            ->limit(5)
            ->get()
            ->map(fn ($r) => [
                'name' => $r->unit_name ?: 'Alat Tidak Dikenal',
                'fuel' => round((float) $r->total_fuel, 2),
            ]);

        // ─── 6. Filter dropdowns ───────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_code', 'project_name']);

        $units = TimesheetEntry::select('unit_name')
            ->distinct()
            ->whereNotNull('unit_name')
            ->where('unit_name', '<>', '')
            ->orderBy('unit_name')
            ->pluck('unit_name');

        $operators = TimesheetEntry::select('operator_name')
            ->distinct()
            ->whereNotNull('operator_name')
            ->where('operator_name', '<>', '')
            ->orderBy('operator_name')
            ->pluck('operator_name');

        // ─── 7. Paginated entries (Eloquent + eager loading) ───────────────
        $entriesQuery = TimesheetEntry::with(['timesheetJournal.project', 'timesheetJournal.contract'])
            ->join('timesheet_journals', 'timesheet_entries.timesheet_journal_id', '=', 'timesheet_journals.id')
            ->select('timesheet_entries.*');

        if (!empty($projectId)) {
            $entriesQuery->where('timesheet_journals.project_id', $projectId);
        }
        if (!empty($startDate)) {
            $entriesQuery->whereDate('timesheet_journals.journal_date', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $entriesQuery->whereDate('timesheet_journals.journal_date', '<=', $endDate);
        }
        if (!empty($unitName)) {
            $entriesQuery->where('timesheet_entries.unit_name', $unitName);
        }
        if (!empty($operatorName)) {
            $entriesQuery->where('timesheet_entries.operator_name', $operatorName);
        }
        if ($status !== 'ALL') {
            $entriesQuery->where('timesheet_journals.status', $status);
        }

        $entries = $entriesQuery
            ->orderBy('timesheet_journals.journal_date', 'desc')
            ->orderBy('timesheet_entries.id', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('reports.fuel-usage', compact(
            'entries', 'totalFuel', 'totalWorkingHours', 'totalHm',
            'avgLitersPerHour', 'avgLitersPerHm',
            'dailyFuel', 'projectFuel', 'activityFuel', 'unitFuel',
            'projects', 'units', 'operators',
            'startDate', 'endDate', 'projectId', 'unitName', 'operatorName', 'status'
        ));
    }

    /**
     * Return a fresh DB::table query already joined + filtered.
     * Uses table aliases: te = timesheet_entries, tj = timesheet_journals.
     * Callers only need to add SELECT + GROUP BY on top.
     */
    private function baseAggQuery(
        string $startDate,
        string $endDate,
        ?string $projectId,
        ?string $unitName,
        ?string $operatorName,
        string $status
    ) {
        $q = DB::table('timesheet_entries AS te')
            ->join('timesheet_journals AS tj', 'te.timesheet_journal_id', '=', 'tj.id');

        if (!empty($projectId)) {
            $q->where('tj.project_id', $projectId);
        }
        if (!empty($startDate)) {
            $q->whereDate('tj.journal_date', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $q->whereDate('tj.journal_date', '<=', $endDate);
        }
        if (!empty($unitName)) {
            $q->where('te.unit_name', $unitName);
        }
        if (!empty($operatorName)) {
            $q->where('te.operator_name', $operatorName);
        }
        if ($status !== 'ALL') {
            $q->where('tj.status', $status);
        }

        return $q;
    }

    /**
     * CSV export – streams the filtered entries as a UTF-8 BOM CSV file.
     */
    public function export(Request $request)
    {
        $startDate    = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate      = $request->input('end_date', Carbon::now()->toDateString());
        $projectId    = $request->input('project_id');
        $unitName     = $request->input('unit_name');
        $operatorName = $request->input('operator_name');
        $status       = $request->input('status', 'APPROVED');

        $entries = $this->baseAggQuery($startDate, $endDate, $projectId, $unitName, $operatorName, $status)
            ->join('projects AS p', 'tj.project_id', '=', 'p.id')
            ->leftJoin('contracts AS c', 'tj.contract_id', '=', 'c.id')
            ->select([
                'tj.journal_number',
                'tj.journal_date',
                'tj.shift',
                'tj.status',
                'p.project_name',
                'c.contract_number',
                'te.unit_name',
                'te.operator_name',
                'te.activity_code',
                'te.hm_start',
                'te.hm_end',
                'te.hm_total',
                'te.working_hours',
                'te.fuel_consumed_liter',
                'te.remarks',
            ])
            ->orderBy('tj.journal_date', 'desc')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_penggunaan_bbm_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($entries) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM so Excel opens correctly
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Nomor Jurnal', 'Tanggal', 'Shift', 'Status', 'Proyek', 'Kontrak',
                'Nama Unit', 'Nama Operator', 'Aktivitas',
                'HM Awal', 'HM Akhir', 'Total HM', 'Jam Kerja',
                'BBM Terpakai (Liter)', 'Efisiensi (L/Jam)', 'Keterangan',
            ]);

            foreach ($entries as $row) {
                $efficiency = $row->working_hours > 0
                    ? round((float) $row->fuel_consumed_liter / (float) $row->working_hours, 2)
                    : 0;

                fputcsv($file, [
                    $row->journal_number,
                    $row->journal_date ? Carbon::parse($row->journal_date)->format('Y-m-d') : '-',
                    $row->shift,
                    $row->status,
                    $row->project_name,
                    $row->contract_number ?: '-',
                    $row->unit_name,
                    $row->operator_name,
                    $row->activity_code,
                    $row->hm_start,
                    $row->hm_end,
                    $row->hm_total,
                    $row->working_hours,
                    $row->fuel_consumed_liter,
                    $efficiency,
                    $row->remarks ?: '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
