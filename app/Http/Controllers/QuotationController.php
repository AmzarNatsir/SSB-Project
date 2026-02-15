<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Project;
use App\Services\QuotationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuotationController extends Controller
{
    protected $service;

    public function __construct(QuotationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $quotations = Quotation::with(['project', 'budget'])
            ->latest()
            ->paginate(10);
            
        $kpi = [
            'draft' => Quotation::where('status', 'DRAFT')->count(),
            'pending' => Quotation::where('status', 'SUBMITTED')->count(),
            'approved' => Quotation::where('status', 'APPROVED')->count(),
            'sent' => Quotation::where('status', 'SENT')->count(),
            'value' => Quotation::sum('selling_price'),
        ];

        return view('quotations.index', compact('quotations', 'kpi'));
    }

    public function create()
    {
        // Projects that have an approved budget baseline (conceptually)
        // For now, listing all active projects 
        $projects = Project::with('latest_budget')->get(); // Should scope to those with budgets
        return view('quotations.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'project_budget_id' => 'nullable|exists:project_budgets,id',
            'items' => 'required|array',
            'items.*.unit_name' => 'required|string',
            'items.*.rate' => 'required|numeric',
            'items.*.quantity' => 'required|numeric',
            'items.*.duration' => 'required|numeric',
        ]);

        $quotation = $this->service->create($validated);

        return response()->json([
            'message' => 'Quotation created successfully',
            'redirect' => route('quotations.show', $quotation->uid)
        ]);
    }

    public function show(Quotation $quotation)
    {
        $quotation->load('items', 'project', 'budget');
        return view('quotations.show', compact('quotation'));
    }
    
    public function update(Request $request, Quotation $quotation)
    {
        // Flexible update for Wizard steps
        $data = $request->all();
        $this->service->update($quotation, $data);
        
        return response()->json(['message' => 'Saved', 'quotation' => $quotation]);
    }

    public function submit(Quotation $quotation)
    {
        try {
            $this->service->submit($quotation);
            return back()->with('success', 'Quotation submitted for approval.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function pdf(Quotation $quotation)
    {
        $pdf = $this->service->generatePdf($quotation);
        return $pdf->stream("Quote-{$quotation->uid}.pdf");
    }
    
    // Proxy for Units API to avoid CORS if frontend calls direct
    public function getUnits()
    {
        $apiUrl = config('services.workshop.api_url');
        $token = config('services.workshop.api_token');
        $endpoint = rtrim($apiUrl, '/') . '/units';
        
        try {
            $request = Http::timeout(5);
            
            if ($token) {
                $request->withToken($token);
            }
            
            $response = $request->get($endpoint);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return response()->json([
                'error' => 'External API error',
                'status' => $response->status(),
                'details' => $response->body()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Connection failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
