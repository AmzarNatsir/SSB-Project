<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\ProjectSubCategoryController;
use App\Http\Controllers\ScoringController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/index', function () {
        return view('index');
    })->name('dashboard');

    Route::resource('project-category', ProjectCategoryController::class);
    Route::resource('project-sub-category', ProjectSubCategoryController::class);
    Route::resource('equipment-rental-rates-hm', \App\Http\Controllers\EquipmentRentalRatesHMController::class);
    Route::resource('scoring', ScoringController::class);
    Route::get('scoring-plan-project/full-view', [\App\Http\Controllers\ScoringPlanProjectController::class, 'fullView'])->name('scoring-plan-project.full-view');
    Route::get('scoring-plan-project/export-pdf', [\App\Http\Controllers\ScoringPlanProjectController::class, 'exportPdf'])->name('scoring-plan-project.export-pdf');
    Route::resource('scoring-plan-project', \App\Http\Controllers\ScoringPlanProjectController::class);
    Route::resource('project-survey', \App\Http\Controllers\ProjectSurveyController::class);
    Route::post('project-survey/{uid}/start', [\App\Http\Controllers\ProjectSurveyController::class, 'startSurvey'])->name('project-survey.start');
    Route::post('project-survey/{uid}/schedule', [\App\Http\Controllers\ProjectSurveyController::class, 'updateSchedule'])->name('project-survey.schedule');
    Route::post('project-survey/{uid}/score', [\App\Http\Controllers\ProjectSurveyController::class, 'storeScore'])->name('project-survey.score');
    Route::get('project-survey/{uid}/score/{department}/pdf', [\App\Http\Controllers\ProjectSurveyController::class, 'exportDepartmentScorePdf'])->name('project-survey.score-pdf');
    Route::get('project-survey/{uid}/report/pdf', [\App\Http\Controllers\ProjectSurveyController::class, 'exportAllDepartmentsPdf'])->name('project-survey.report-pdf');
    Route::get('project-surveys/summary/excel', [\App\Http\Controllers\ProjectSurveyController::class, 'exportSummaryExcel'])->name('project-surveys.summary-excel');
    Route::post('project-survey/{uid}/status', [\App\Http\Controllers\ProjectSurveyController::class, 'updateStatus'])->name('project-survey.status');
    Route::post('project-survey/{uid}/approve-execution', [\App\Http\Controllers\ProjectSurveyController::class, 'approveSurveyExecution'])->name('project-survey.approve-execution');
    Route::post('project-survey/{uid}/reject-execution', [\App\Http\Controllers\ProjectSurveyController::class, 'rejectSurveyExecution'])->name('project-survey.reject-execution');
    Route::post('project-survey/{uid}/proceed', [\App\Http\Controllers\ProjectSurveyController::class, 'proceedToExecution'])->name('project-survey.proceed');
    Route::post('project-survey/{uid}/approve', [\App\Http\Controllers\ProjectSurveyController::class, 'approveSurvey'])->name('project-survey.approve');
    Route::post('project-survey/{uid}/reject', [\App\Http\Controllers\ProjectSurveyController::class, 'rejectSurvey'])->name('project-survey.reject');
    Route::post('project-survey/{uid}/document', [\App\Http\Controllers\ProjectSurveyController::class, 'uploadDocument'])->name('project-survey.document.upload');
    Route::delete('project-survey/{uid}/document/{documentId}', [\App\Http\Controllers\ProjectSurveyController::class, 'deleteDocument'])->name('project-survey.document.delete');
    Route::get('project-survey/{uid}/document/{documentId}/download', [\App\Http\Controllers\ProjectSurveyController::class, 'downloadDocument'])->name('project-survey.document.download');

    Route::get('projects/search', [\App\Http\Controllers\ProjectController::class, 'search'])->name('projects.search');
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::get('projects/{id}/data', [\App\Http\Controllers\ProjectController::class, 'getProject'])->name('projects.data');
    Route::post('projects/{id}/upload-image', [\App\Http\Controllers\ProjectController::class, 'uploadImage'])->name('projects.upload-image');
    Route::delete('project-images/{id}', [\App\Http\Controllers\ProjectController::class, 'deleteImage'])->name('project-images.delete');
    Route::get('storage/projects/{project_id}/{filename}', [\App\Http\Controllers\ProjectController::class, 'serveImage'])->name('projects.serve-image');

    // Project Amendments
    Route::post('project-amendments', [\App\Http\Controllers\ProjectAmendmentController::class, 'store'])->name('project-amendments.store');
    Route::post('project-amendments/{id}/finalize', [\App\Http\Controllers\ProjectAmendmentController::class, 'finalize'])->name('project-amendments.finalize');

    // API Routes for Survey Statistics
    Route::prefix('api/v1')->group(function () {
        Route::get('surveys/stats/dashboard', [\App\Http\Controllers\Api\V1\SurveyStatsController::class, 'dashboard']);
        Route::get('surveys/{uid}/status', [\App\Http\Controllers\Api\V1\SurveyStatsController::class, 'status']);
        Route::get('surveys/scores/{id}', [\App\Http\Controllers\Api\V1\SurveyStatsController::class, 'scoreDetails']);

        // Employee proxy (data dari API_EMPLOYEE) — untuk dropdown Workforce/Unit Formation/Timesheet
        Route::get('employees/search', [\App\Http\Controllers\Api\V1\EmployeeController::class, 'search'])->name('employees.search');
        Route::get('employees/{id}', [\App\Http\Controllers\Api\V1\EmployeeController::class, 'show'])->name('employees.show');
        Route::get('employees/{id}/photo', [\App\Http\Controllers\Api\V1\EmployeeController::class, 'photo'])
            ->where('id', '[0-9]+')
            ->name('employees.photo');

        // Unit proxy (data dari API_WORKSHOP) — untuk dropdown Unit Formation/Timesheet
        Route::get('units/search', [\App\Http\Controllers\Api\V1\UnitController::class, 'search'])->name('units.search');
        Route::get('units/{id}', [\App\Http\Controllers\Api\V1\UnitController::class, 'show'])->name('units.show');
    });

    // Project Budgets
    Route::resource('budgets', \App\Http\Controllers\ProjectBudgetController::class)->parameters(['budgets' => 'uid']);
    Route::post('budgets/{uid}/submit', [\App\Http\Controllers\ProjectBudgetController::class, 'submit'])->name('budgets.submit');
    Route::post('budgets/{uid}/approve', [\App\Http\Controllers\ProjectBudgetController::class, 'approve'])->name('budgets.approve');
    Route::post('budgets/{uid}/revise', [\App\Http\Controllers\ProjectBudgetController::class, 'revise'])->name('budgets.revise');
    Route::delete('budgets/{uid}/items/{itemId}', [\App\Http\Controllers\ProjectBudgetController::class, 'deleteItem'])->name('budgets.items.destroy');
    Route::get('projects/{projectId}/budget-history', [\App\Http\Controllers\ProjectBudgetController::class, 'history'])->name('projects.budget-history');

    // Approval Flows
    Route::resource('approval-flows', \App\Http\Controllers\ApprovalFlowController::class);

    // Surveyor Flows
    Route::get('surveyor-flows', [\App\Http\Controllers\SurveyorFlowController::class, 'index'])->name('surveyor-flows.index');
    Route::put('surveyor-flows', [\App\Http\Controllers\SurveyorFlowController::class, 'update'])->name('surveyor-flows.update-all');
    Route::delete('surveyor-flows/{department}', [\App\Http\Controllers\SurveyorFlowController::class, 'destroy'])->name('surveyor-flows.destroy');

    // User Management
    Route::resource('roles-permissions', \App\Http\Controllers\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    Route::resource('manage-users', \App\Http\Controllers\UserController::class);

    // Quotations
    Route::resource('quotations', \App\Http\Controllers\QuotationController::class)->parameters(['quotations' => 'quotation']);
    Route::post('quotations/{quotation}/submit', [\App\Http\Controllers\QuotationController::class, 'submit'])->name('quotations.submit');
    Route::post('quotations/{quotation}/approve', [\App\Http\Controllers\QuotationController::class, 'approve'])->name('quotations.approve');
    Route::get('quotations/{quotation}/pdf', [\App\Http\Controllers\QuotationController::class, 'pdf'])->name('quotations.pdf');
    // Helper for Units (if needed)
    // Helper for Units (if needed)
    Route::get('api/proxy/units', [\App\Http\Controllers\QuotationController::class, 'getUnits'])->name('quotations.units');

    // Negotiations
    Route::resource('negotiations', \App\Http\Controllers\NegotiationController::class)->parameters(['negotiations' => 'negotiation']);
    Route::post('negotiations/{negotiation}/submit', [\App\Http\Controllers\NegotiationController::class, 'submit'])->name('negotiations.submit');
    Route::post('negotiations/{negotiation}/approve', [\App\Http\Controllers\NegotiationController::class, 'approve'])->name('negotiations.approve');
    Route::get('negotiations/{negotiation}/letter', [\App\Http\Controllers\NegotiationController::class, 'downloadLetter'])->name('negotiations.letter');

    // Unit Requests
    Route::resource('unit-requests', \App\Http\Controllers\UnitRequestController::class)->parameters(['unit-requests' => 'unitRequest']);
    Route::post('unit-requests/{unitRequest}/submit', [\App\Http\Controllers\UnitRequestController::class, 'submit'])->name('unit-requests.submit');
    Route::post('unit-requests/{unitRequest}/approve', [\App\Http\Controllers\UnitRequestController::class, 'approve'])->name('unit-requests.approve');
    Route::post('unit-requests/{unitRequest}/forward', [\App\Http\Controllers\UnitRequestController::class, 'forwardToWorkshop'])->name('unit-requests.forward');
    Route::get('unit-requests/{unitRequest}/attachment', [\App\Http\Controllers\UnitRequestController::class, 'downloadAttachment'])->name('unit-requests.attachment');
    Route::get('api/unit-requests/eligible-contracts', [\App\Http\Controllers\UnitRequestController::class, 'eligibleContracts'])->name('unit-requests.eligible-contracts');

    // Final Contracts
    Route::resource('final-contracts', \App\Http\Controllers\ContractController::class)->parameters(['final-contracts' => 'uid']);
    Route::get('api/final-contracts/load-data', [\App\Http\Controllers\ContractController::class, 'loadData'])->name('final-contracts.load-data');
    Route::get('api/final-contracts/eligible-negotiations', [\App\Http\Controllers\ContractController::class, 'eligibleNegotiations'])->name('final-contracts.eligible-negotiations');

    // Unit Replacements (PTU)
    Route::get('api/unit-replacements/eligible-unit-requests', [\App\Http\Controllers\UnitReplacementController::class, 'eligibleUnitRequests'])->name('unit-replacements.eligible-unit-requests');
    Route::get('api/unit-replacements/replacement-candidates', [\App\Http\Controllers\UnitReplacementController::class, 'replacementCandidates'])->name('unit-replacements.replacement-candidates');
    Route::resource('unit-replacements', \App\Http\Controllers\UnitReplacementController::class)->parameters(['unit-replacements' => 'unitReplacement']);
    Route::post('unit-replacements/{unitReplacement}/submit', [\App\Http\Controllers\UnitReplacementController::class, 'submit'])->name('unit-replacements.submit');
    Route::post('unit-replacements/{unitReplacement}/approve', [\App\Http\Controllers\UnitReplacementController::class, 'approve'])->name('unit-replacements.approve');
    Route::post('unit-replacements/{unitReplacement}/forward', [\App\Http\Controllers\UnitReplacementController::class, 'forwardToWorkshop'])->name('unit-replacements.forward');
    Route::post('unit-replacements/{unitReplacement}/workshop-decision', [\App\Http\Controllers\UnitReplacementController::class, 'workshopDecision'])->name('unit-replacements.workshop-decision');
    Route::get('unit-replacements/{unitReplacement}/attachment', [\App\Http\Controllers\UnitReplacementController::class, 'downloadAttachment'])->name('unit-replacements.attachment');

    // Work Realization (agregasi billing per periode)
    Route::resource('work-realizations', \App\Http\Controllers\WorkRealizationController::class)
        ->parameters(['work-realizations' => 'workRealization']);
    Route::post('work-realizations/{workRealization}/submit',     [\App\Http\Controllers\WorkRealizationController::class, 'submit'])->name('work-realizations.submit');
    Route::post('work-realizations/{workRealization}/approve',    [\App\Http\Controllers\WorkRealizationController::class, 'approve'])->name('work-realizations.approve');
    Route::post('work-realizations/{workRealization}/regenerate', [\App\Http\Controllers\WorkRealizationController::class, 'regenerate'])->name('work-realizations.regenerate');
    Route::get('work-realizations/{workRealization}/attachment/{type}', [\App\Http\Controllers\WorkRealizationController::class, 'downloadAttachment'])->name('work-realizations.attachment');
    Route::get('api/work-realizations/project/{project}/contracts', [\App\Http\Controllers\WorkRealizationController::class, 'projectContracts'])->name('work-realizations.project-contracts');

    // Invoice (tagihan ke customer, generated dari Work Realization Approved)
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::post('invoices/{invoice}/submit',     [\App\Http\Controllers\InvoiceController::class, 'submit'])->name('invoices.submit');
    Route::post('invoices/{invoice}/approve',    [\App\Http\Controllers\InvoiceController::class, 'approve'])->name('invoices.approve');
    Route::post('invoices/{invoice}/mark-paid',  [\App\Http\Controllers\InvoiceController::class, 'markPaid'])->name('invoices.mark-paid');
    Route::get('invoices/{invoice}/faktur-pajak', [\App\Http\Controllers\InvoiceController::class, 'downloadFakturPajak'])->name('invoices.faktur-pajak');

    // Receivable (penerimaan dana dari customer: uang muka / pelunasan invoice)
    Route::resource('receivables', \App\Http\Controllers\ReceivableController::class);
    Route::post('receivables/{receivable}/submit',  [\App\Http\Controllers\ReceivableController::class, 'submit'])->name('receivables.submit');
    Route::post('receivables/{receivable}/approve', [\App\Http\Controllers\ReceivableController::class, 'approve'])->name('receivables.approve');
    Route::get('receivables/{receivable}/attachment', [\App\Http\Controllers\ReceivableController::class, 'downloadAttachment'])->name('receivables.attachment');
    Route::get('api/receivables/project/{project}/invoices', [\App\Http\Controllers\ReceivableController::class, 'projectInvoices'])->name('receivables.project-invoices');

    // Receivable Settlement (alokasi DP + pembayaran baru untuk melunasi Invoice)
    Route::resource('receivable-settlements', \App\Http\Controllers\ReceivableSettlementController::class)
        ->parameters(['receivable-settlements' => 'receivableSettlement']);
    Route::post('receivable-settlements/{receivableSettlement}/submit',  [\App\Http\Controllers\ReceivableSettlementController::class, 'submit'])->name('receivable-settlements.submit');
    Route::post('receivable-settlements/{receivableSettlement}/approve', [\App\Http\Controllers\ReceivableSettlementController::class, 'approve'])->name('receivable-settlements.approve');
    Route::get('receivable-settlements/{receivableSettlement}/attachment', [\App\Http\Controllers\ReceivableSettlementController::class, 'downloadAttachment'])->name('receivable-settlements.attachment');
    Route::get('api/receivable-settlements/project/{project}/invoices', [\App\Http\Controllers\ReceivableSettlementController::class, 'projectInvoices'])->name('receivable-settlements.project-invoices');
    Route::get('api/receivable-settlements/project/{project}/deposits', [\App\Http\Controllers\ReceivableSettlementController::class, 'projectDeposits'])->name('receivable-settlements.project-deposits');

    // Petty Cash — Master Jenis Biaya (CRUD)
    Route::resource('petty-cash-categories', \App\Http\Controllers\PettyCashExpenseCategoryController::class)
        ->parameters(['petty-cash-categories' => 'pettyCashCategory'])
        ->only(['index', 'store', 'update', 'destroy']);

    // Petty Cash Request (permintaan kas kecil)
    Route::resource('petty-cash-requests', \App\Http\Controllers\PettyCashRequestController::class)
        ->parameters(['petty-cash-requests' => 'pettyCashRequest']);
    Route::post('petty-cash-requests/{pettyCashRequest}/submit',  [\App\Http\Controllers\PettyCashRequestController::class, 'submit'])->name('petty-cash-requests.submit');
    Route::post('petty-cash-requests/{pettyCashRequest}/approve', [\App\Http\Controllers\PettyCashRequestController::class, 'approve'])->name('petty-cash-requests.approve');
    Route::post('petty-cash-requests/{pettyCashRequest}/close',   [\App\Http\Controllers\PettyCashRequestController::class, 'close'])->name('petty-cash-requests.close');
    Route::get('petty-cash-requests/{pettyCashRequest}/attachment', [\App\Http\Controllers\PettyCashRequestController::class, 'downloadAttachment'])->name('petty-cash-requests.attachment');

    // Petty Cash Payment (pembayaran biaya dari Permintaan)
    Route::resource('petty-cash-payments', \App\Http\Controllers\PettyCashPaymentController::class)
        ->parameters(['petty-cash-payments' => 'pettyCashPayment']);
    Route::post('petty-cash-payments/{pettyCashPayment}/submit',  [\App\Http\Controllers\PettyCashPaymentController::class, 'submit'])->name('petty-cash-payments.submit');
    Route::post('petty-cash-payments/{pettyCashPayment}/approve', [\App\Http\Controllers\PettyCashPaymentController::class, 'approve'])->name('petty-cash-payments.approve');
    Route::get('petty-cash-payments/{pettyCashPayment}/attachment', [\App\Http\Controllers\PettyCashPaymentController::class, 'downloadAttachment'])->name('petty-cash-payments.attachment');

    // Petty Cash Purchase (pembelian tunai dari Permintaan)
    Route::resource('petty-cash-purchases', \App\Http\Controllers\PettyCashPurchaseController::class)
        ->parameters(['petty-cash-purchases' => 'pettyCashPurchase']);
    Route::post('petty-cash-purchases/{pettyCashPurchase}/submit',  [\App\Http\Controllers\PettyCashPurchaseController::class, 'submit'])->name('petty-cash-purchases.submit');
    Route::post('petty-cash-purchases/{pettyCashPurchase}/approve', [\App\Http\Controllers\PettyCashPurchaseController::class, 'approve'])->name('petty-cash-purchases.approve');
    Route::get('petty-cash-purchases/{pettyCashPurchase}/attachment', [\App\Http\Controllers\PettyCashPurchaseController::class, 'downloadAttachment'])->name('petty-cash-purchases.attachment');

    // Timesheet Journal (log harian operasional)
    Route::resource('timesheets', \App\Http\Controllers\TimesheetController::class)
        ->parameters(['timesheets' => 'timesheet']);
    Route::post('timesheets/{timesheet}/submit',  [\App\Http\Controllers\TimesheetController::class, 'submit'])->name('timesheets.submit');
    Route::post('timesheets/{timesheet}/approve', [\App\Http\Controllers\TimesheetController::class, 'approve'])->name('timesheets.approve');
    Route::get('api/timesheets/available-units',  [\App\Http\Controllers\TimesheetController::class, 'availableUnits'])->name('timesheets.available-units');

    // Unit Formation (SK Penetapan Unit & Operator)
    Route::resource('unit-formations', \App\Http\Controllers\UnitFormationController::class)
        ->parameters(['unit-formations' => 'unitFormation']);
    Route::post('unit-formations/{unitFormation}/submit',   [\App\Http\Controllers\UnitFormationController::class, 'submit'])->name('unit-formations.submit');
    Route::post('unit-formations/{unitFormation}/approve',  [\App\Http\Controllers\UnitFormationController::class, 'approve'])->name('unit-formations.approve');
    Route::post('unit-formations/{unitFormation}/activate', [\App\Http\Controllers\UnitFormationController::class, 'activate'])->name('unit-formations.activate');
    Route::post('unit-formations/{unitFormation}/revise',   [\App\Http\Controllers\UnitFormationController::class, 'revise'])->name('unit-formations.revise');
    Route::post('unit-formations/{unitFormation}/end',      [\App\Http\Controllers\UnitFormationController::class, 'end'])->name('unit-formations.end');
    Route::get('unit-formations/{unitFormation}/attachment',[\App\Http\Controllers\UnitFormationController::class, 'downloadAttachment'])->name('unit-formations.attachment');
    Route::get('api/contracts/{contract}/items',            [\App\Http\Controllers\UnitFormationController::class, 'contractItems'])->name('unit-formations.contract-items');

    // Workforce Formation
    Route::resource('workforce-formations', \App\Http\Controllers\WorkforceFormationController::class)
        ->parameters(['workforce-formations' => 'workforceFormation']);
    Route::post('workforce-formations/{workforceFormation}/submit',   [\App\Http\Controllers\WorkforceFormationController::class, 'submit'])->name('workforce-formations.submit');
    Route::post('workforce-formations/{workforceFormation}/approve',  [\App\Http\Controllers\WorkforceFormationController::class, 'approve'])->name('workforce-formations.approve');
    Route::post('workforce-formations/{workforceFormation}/activate', [\App\Http\Controllers\WorkforceFormationController::class, 'activate'])->name('workforce-formations.activate');
    Route::post('workforce-formations/{workforceFormation}/revise',   [\App\Http\Controllers\WorkforceFormationController::class, 'revise'])->name('workforce-formations.revise');
    Route::post('workforce-formations/{workforceFormation}/end',      [\App\Http\Controllers\WorkforceFormationController::class, 'end'])->name('workforce-formations.end');
    Route::get('workforce-formations/{workforceFormation}/attachment',[\App\Http\Controllers\WorkforceFormationController::class, 'downloadAttachment'])->name('workforce-formations.attachment');
    Route::get('api/projects/{project}/active-contracts',             [\App\Http\Controllers\WorkforceFormationController::class, 'projectContracts'])->name('workforce-formations.project-contracts');

    // Unit Returns (PPU)
    Route::resource('unit-returns', \App\Http\Controllers\ProjectUnitReturnController::class)->parameters(['unit-returns' => 'unitReturn']);
    Route::post('unit-returns/{unitReturn}/submit', [\App\Http\Controllers\ProjectUnitReturnController::class, 'submit'])->name('unit-returns.submit');
    Route::post('unit-returns/{unitReturn}/approve', [\App\Http\Controllers\ProjectUnitReturnController::class, 'approve'])->name('unit-returns.approve');
    Route::post('unit-returns/{unitReturn}/complete', [\App\Http\Controllers\ProjectUnitReturnController::class, 'complete'])->name('unit-returns.complete');
    Route::get('unit-returns/{unitReturn}/attachment', [\App\Http\Controllers\ProjectUnitReturnController::class, 'downloadAttachment'])->name('unit-returns.attachment');

    // ... other protected routes
});


// Temporary: explicit index route for redirection to work if named 'dashboard'
// Route::get('/index', function () { return view('index'); })->name('index');
