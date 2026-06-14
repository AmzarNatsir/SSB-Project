<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SparePartUsage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SparePartUsageController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  REPORT  (GET /deal-reports)
    // ─────────────────────────────────────────────────────────────────────────
    public function report(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date',   Carbon::now()->toDateString());
        $projectId = $request->input('project_id');
        $status    = $request->input('status', 'ALL');

        // ─── KPI totals ───────────────────────────────────────────────────
        $totals = $this->baseAgg($startDate, $endDate, $projectId, $status)
            ->select(DB::raw('
                COUNT(*)                        AS total_records,
                SUM(spu.quantity)               AS total_qty,
                SUM(spu.total_price)            AS total_cost,
                COUNT(DISTINCT spu.project_id)  AS total_projects,
                COUNT(DISTINCT spu.unit_name)   AS total_units
            '))
            ->first();

        $totalRecords  = (int)   ($totals->total_records  ?? 0);
        $totalQty      = (float) ($totals->total_qty      ?? 0);
        $totalCost     = (float) ($totals->total_cost     ?? 0);
        $totalProjects = (int)   ($totals->total_projects ?? 0);

        // ─── Chart 1: Daily usage cost ────────────────────────────────────
        $dailyCost = $this->baseAgg($startDate, $endDate, $projectId, $status)
            ->select(DB::raw('spu.usage_date, SUM(spu.total_price) AS total_cost, SUM(spu.quantity) AS total_qty'))
            ->groupBy('spu.usage_date')
            ->orderBy('spu.usage_date')
            ->get()
            ->map(fn ($r) => [
                'date' => Carbon::parse($r->usage_date)->format('d M Y'),
                'cost' => round((float) $r->total_cost, 2),
                'qty'  => round((float) $r->total_qty, 3),
            ]);

        // ─── Chart 2: Cost per project ────────────────────────────────────
        $projectCost = $this->baseAgg($startDate, $endDate, $projectId, $status)
            ->join('projects AS p', 'spu.project_id', '=', 'p.id')
            ->select(DB::raw('p.project_name, SUM(spu.total_price) AS total_cost'))
            ->groupBy('p.id', 'p.project_name')
            ->orderByDesc('total_cost')
            ->get()
            ->map(fn ($r) => [
                'name' => $r->project_name,
                'cost' => round((float) $r->total_cost, 2),
            ]);

        // ─── Chart 3: Top 8 parts by cost ────────────────────────────────
        $topParts = $this->baseAgg($startDate, $endDate, $projectId, $status)
            ->select(DB::raw('spu.part_name, SUM(spu.total_price) AS total_cost, SUM(spu.quantity) AS total_qty'))
            ->groupBy('spu.part_name')
            ->orderByDesc('total_cost')
            ->limit(8)
            ->get()
            ->map(fn ($r) => [
                'name' => $r->part_name,
                'cost' => round((float) $r->total_cost, 2),
                'qty'  => round((float) $r->total_qty, 3),
            ]);

        // ─── Chart 4: Cost by category ────────────────────────────────────
        $categoryCost = $this->baseAgg($startDate, $endDate, $projectId, $status)
            ->select(DB::raw('COALESCE(spu.part_category, "Tidak Dikategorikan") AS cat, SUM(spu.total_price) AS total_cost'))
            ->groupBy('cat')
            ->orderByDesc('total_cost')
            ->get()
            ->map(fn ($r) => [
                'category' => $r->cat,
                'cost'     => round((float) $r->total_cost, 2),
            ]);

        // ─── Filter dropdowns ─────────────────────────────────────────────
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);

        $categories = SparePartUsage::whereNotNull('part_category')
            ->where('part_category', '<>', '')
            ->distinct()
            ->orderBy('part_category')
            ->pluck('part_category');

        // ─── Paginated table ──────────────────────────────────────────────
        $entries = SparePartUsage::with('project', 'creator')
            ->when($projectId, fn ($q) => $q->where('project_id', $projectId))
            ->when($startDate, fn ($q) => $q->whereDate('usage_date', '>=', $startDate))
            ->when($endDate,   fn ($q) => $q->whereDate('usage_date', '<=', $endDate))
            ->when($status !== 'ALL', fn ($q) => $q->where('status', $status))
            ->orderByDesc('usage_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('reports.spare-part-usage', compact(
            'entries', 'totalRecords', 'totalQty', 'totalCost', 'totalProjects',
            'dailyCost', 'projectCost', 'topParts', 'categoryCost',
            'projects', 'categories',
            'startDate', 'endDate', 'projectId', 'status'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  CSV EXPORT  (GET /deal-reports/export)
    // ─────────────────────────────────────────────────────────────────────────
    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date',   Carbon::now()->toDateString());
        $projectId = $request->input('project_id');
        $status    = $request->input('status', 'ALL');

        $rows = $this->baseAgg($startDate, $endDate, $projectId, $status)
            ->join('projects AS p', 'spu.project_id', '=', 'p.id')
            ->join('users AS u', 'spu.created_by', '=', 'u.id')
            ->select([
                'spu.usage_number', 'spu.usage_date', 'p.project_name',
                'spu.unit_name', 'spu.equipment_code',
                'spu.part_name', 'spu.part_number', 'spu.part_category',
                'spu.quantity', 'spu.unit_of_measure',
                'spu.unit_price', 'spu.total_price',
                'spu.vendor_name', 'spu.purchase_order_number',
                'spu.status', 'spu.description', 'u.name AS creator_name',
            ])
            ->orderBy('spu.usage_date', 'desc')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_spare_part_' . now()->format('YmdHis') . '.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($rows) {
            $f = fopen('php://output', 'w');
            fprintf($f, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($f, [
                'No. Pemakaian', 'Tanggal', 'Proyek', 'Unit / Alat', 'Kode Alat',
                'Nama Spare Part', 'Part Number', 'Kategori',
                'Qty', 'Satuan', 'Harga Satuan (Rp)', 'Total (Rp)',
                'Vendor / Pemasok', 'No. PO', 'Status', 'Keterangan', 'Dibuat Oleh',
            ]);
            foreach ($rows as $r) {
                fputcsv($f, [
                    $r->usage_number,
                    $r->usage_date ? Carbon::parse($r->usage_date)->format('Y-m-d') : '-',
                    $r->project_name,
                    $r->unit_name  ?: '-',
                    $r->equipment_code ?: '-',
                    $r->part_name,
                    $r->part_number   ?: '-',
                    $r->part_category ?: '-',
                    $r->quantity,
                    $r->unit_of_measure,
                    $r->unit_price  ?? 0,
                    $r->total_price ?? 0,
                    $r->vendor_name ?: '-',
                    $r->purchase_order_number ?: '-',
                    $r->status,
                    $r->description ?: '',
                    $r->creator_name,
                ]);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  CRUD: index / create / store / show / edit / update / destroy
    // ─────────────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = SparePartUsage::with('project', 'creator')
            ->when($request->input('q'), fn ($q, $s) =>
                $q->where('usage_number', 'like', "%$s%")
                  ->orWhere('part_name', 'like', "%$s%")
                  ->orWhereHas('project', fn ($p) => $p->where('project_name', 'like', "%$s%"))
            )
            ->when($request->input('project_id'), fn ($q, $v) => $q->where('project_id', $v))
            ->when($request->input('start_date'),  fn ($q, $v) => $q->whereDate('usage_date', '>=', $v))
            ->when($request->input('end_date'),    fn ($q, $v) => $q->whereDate('usage_date', '<=', $v))
            ->when($request->input('status'), fn ($q, $v) => $q->where('status', $v))
            ->orderByDesc('usage_date')->orderByDesc('id');

        $items    = $query->paginate(20)->withQueryString();
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);

        $stats = [
            'total'    => SparePartUsage::count(),
            'draft'    => SparePartUsage::where('status', 'DRAFT')->count(),
            'approved' => SparePartUsage::where('status', 'APPROVED')->count(),
        ];

        return view('spare-part-usages.index', compact('items', 'projects', 'stats'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);
        return view('spare-part-usages.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();

        $spu = SparePartUsage::create($data);

        return redirect()->route('spare-part-usages.show', $spu->uid)
            ->with('success', "Pemakaian spare part {$spu->usage_number} berhasil disimpan.");
    }

    public function show(SparePartUsage $sparePartUsage)
    {
        $sparePartUsage->load('project', 'creator', 'approver');
        return view('spare-part-usages.show', ['spu' => $sparePartUsage]);
    }

    public function edit(SparePartUsage $sparePartUsage)
    {
        if (! $sparePartUsage->canEdit()) {
            return redirect()->route('spare-part-usages.show', $sparePartUsage->uid)
                ->with('error', "Data dengan status {$sparePartUsage->status} tidak bisa diedit.");
        }
        $projects = Project::orderBy('project_name')->get(['id', 'project_name']);
        return view('spare-part-usages.edit', ['spu' => $sparePartUsage, 'projects' => $projects]);
    }

    public function update(Request $request, SparePartUsage $sparePartUsage)
    {
        if (! $sparePartUsage->canEdit()) {
            return back()->with('error', 'Data tidak bisa diubah pada status ini.');
        }
        $sparePartUsage->update($this->validated($request));
        return redirect()->route('spare-part-usages.show', $sparePartUsage->uid)
            ->with('success', 'Data spare part berhasil diperbarui.');
    }

    public function destroy(SparePartUsage $sparePartUsage)
    {
        if ($sparePartUsage->status !== 'DRAFT') {
            return back()->with('error', 'Hanya data Draft yang bisa dihapus.');
        }
        $sparePartUsage->delete();
        return redirect()->route('spare-part-usages.index')->with('success', 'Data spare part dihapus.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────────────────────────────────
    private function baseAgg(string $startDate, string $endDate, ?string $projectId, string $status)
    {
        $q = DB::table('spare_part_usages AS spu')
            ->whereNull('spu.deleted_at')
            ->whereDate('spu.usage_date', '>=', $startDate)
            ->whereDate('spu.usage_date', '<=', $endDate);

        if (!empty($projectId)) {
            $q->where('spu.project_id', $projectId);
        }
        if ($status !== 'ALL') {
            $q->where('spu.status', $status);
        }

        return $q;
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'project_id'           => 'required|exists:projects,id',
            'unit_name'            => 'nullable|string|max:200',
            'equipment_code'       => 'nullable|string|max:100',
            'usage_date'           => 'required|date',
            'part_name'            => 'required|string|max:200',
            'part_number'          => 'nullable|string|max:100',
            'part_category'        => 'nullable|string|max:100',
            'quantity'             => 'required|numeric|min:0.001',
            'unit_of_measure'      => 'required|string|max:30',
            'unit_price'           => 'nullable|numeric|min:0',
            'vendor_name'          => 'nullable|string|max:200',
            'purchase_order_number'=> 'nullable|string|max:100',
            'description'          => 'nullable|string|max:2000',
        ]);

        // derive total_price from qty × unit_price
        $data['total_price'] = (($data['quantity'] ?? 0) * ($data['unit_price'] ?? 0)) ?: null;

        return $data;
    }
}
