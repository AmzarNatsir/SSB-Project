<?php

namespace App\Http\Controllers;

use App\Models\Negotiation;
use App\Models\Quotation;
use App\Services\NegotiationService;
use App\Services\ApprovalFlowService;
use App\Enums\NegotiationStatus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NegotiationController extends Controller
{
    protected $service;
    protected $flowService;

    public function __construct(NegotiationService $service, ApprovalFlowService $flowService)
    {
        $this->service = $service;
        $this->flowService = $flowService;
    }

    // ... index, create, store ...

    public function show(Negotiation $negotiation)
    {
        $negotiation->load(['project', 'quotation', 'rounds.creator', 'approvals.approver']);
        
        // Resolve Approval Data
        $currentLevel = null;
        $isApprover = false;
        $approverName = '-';

        if ($negotiation->status === NegotiationStatus::SUBMITTED && $negotiation->current_approval_level > 0) {
            $levels = $this->flowService->getLevels('NEGOTIATION');
            $currentLevel = $levels->where('level_number', $negotiation->current_approval_level)->first();
            
            if ($currentLevel) {
                // Check if current user is approver
                $isApprover = $this->flowService->isUserApprover(auth()->id(), $currentLevel);
                
                // Resolve Approver Name for display
                $approverEntity = $this->flowService->resolveApprover($currentLevel);
                $approverName = $approverEntity ? $approverEntity->name : 'Unknown';
                if ($currentLevel->approver_type === \App\Enums\ApproverType::ROLE) {
                    $approverName = $approverEntity->name . ' (Role)'; // Adjust as needed
                }
            }
        }

        return view('negotiations.show', compact('negotiation', 'isApprover', 'approverName', 'currentLevel'));
    }

    // ... update, submit ...

    public function approve(Request $request, Negotiation $negotiation)
    {
        $validated = $request->validate([
            'decision' => 'required|string|in:APPROVED,REJECTED,REVISION',
            'notes' => 'nullable|string',
        ]);

        // Defense in depth: cek user yang login adalah approver yang dikonfigurasi di matriks
        if ($negotiation->status !== NegotiationStatus::SUBMITTED || $negotiation->current_approval_level <= 0) {
            return back()->with('error', 'Negosiasi tidak dalam status yang bisa di-approve.');
        }

        $levels = $this->flowService->getLevels('NEGOTIATION');
        $currentLevel = $levels->where('level_number', $negotiation->current_approval_level)->first();

        if (! $currentLevel || ! $this->flowService->isUserApprover(auth()->id(), $currentLevel)) {
            return back()->with('error', 'Anda tidak memiliki kewenangan untuk approval di level ini.');
        }

        try {
            $this->service->processApproval(
                $negotiation->uid,
                auth()->id(),
                $validated['decision'],
                $validated['notes']
            );
            return back()->with('success', 'Decision recorded.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        // KPIs
        $totalNegotiations = Negotiation::count();
        $negotiatingCount = Negotiation::whereIn('status', [
            NegotiationStatus::NEGOTIATING, 
            NegotiationStatus::SUBMITTED
        ])->count();
        
        $approvedCount = Negotiation::where('status', NegotiationStatus::APPROVED)->count();
        
        // Success Rate
        $closedCount = Negotiation::whereIn('status', [NegotiationStatus::APPROVED, NegotiationStatus::REJECTED])->count();
        $successRate = $closedCount > 0 ? round(($approvedCount / $closedCount) * 100, 1) : 0;

        // List
        $negotiations = Negotiation::with(['project', 'quotation', 'creator'])
            ->latest()
            ->paginate(10);
            
        return view('negotiations.index', compact('negotiations', 'totalNegotiations', 'negotiatingCount', 'approvedCount', 'successRate'));
    }

    public function create(Request $request) 
    {
        // If quotation_id is provided, check if valid and maybe redirect to store/show
        if ($request->has('quotation_id')) {
             $quotation = Quotation::findOrFail($request->query('quotation_id'));
             $negotiation = $this->service->initiate($quotation, auth()->id());
             return redirect()->route('negotiations.show', $negotiation->uid);
        }
        
        // Otherwise show selection form
        // Get quotations that are candidates for negotiation (e.g. Submitted/Approved, and not already in active negotiation)
        // For simplicity getting all Submitted/Approved for now
        $quotations = Quotation::with('project')
            ->whereIn('status', ['SUBMITTED', 'APPROVED']) // As per rules?
            ->get();
            
        return view('negotiations.create', compact('quotations'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quotation_id' => 'required|exists:quotations,id'
        ]);
        
        $quotation = Quotation::findOrFail($validated['quotation_id']);
        $negotiation = $this->service->initiate($quotation, auth()->id());
        
        return redirect()->route('negotiations.show', $negotiation->uid);
    }


    public function update(Request $request, Negotiation $negotiation)
    {
        // Sanitize currency inputs
        $request->merge([
            'client_offer_value' => str_replace('.', '', $request->input('client_offer_value')),
            'company_counter_offer' => str_replace('.', '', $request->input('company_counter_offer')),
        ]);

        // Route for adding a round
        $validated = $request->validate([
            'client_offer_value' => 'required|numeric|min:0',
            'company_counter_offer' => 'required|numeric|min:0',
            'meeting_date' => 'required|date',
            'summary_notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120', // 5MB
        ]);

        try {
            // Handle file upload
            $path = null;
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('negotiations/attachments', 'public');
                $validated['attachment_path'] = $path;
            }

            $this->service->addRound($negotiation->uid, $validated, auth()->id());

            return back()->with('success', 'Negotiation round added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function submit(Negotiation $negotiation)
    {
        try {
            $this->service->submit($negotiation->uid);
            return back()->with('success', 'Negotiation submitted for approval.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    
    public function downloadLetter(Negotiation $negotiation)
    {
        $pdf = $this->service->generateLetter($negotiation);
        $filename = 'Negotiation-Letter-' . str_replace('/', '-', $negotiation->negotiation_number) . '.pdf';
        return $pdf->stream($filename);
    }
}
