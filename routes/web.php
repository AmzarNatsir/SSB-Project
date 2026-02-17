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
    Route::resource('project-survey', \App\Http\Controllers\ProjectSurveyController::class);
    Route::post('project-survey/{uid}/start', [\App\Http\Controllers\ProjectSurveyController::class, 'startSurvey'])->name('project-survey.start');
    Route::post('project-survey/{uid}/schedule', [\App\Http\Controllers\ProjectSurveyController::class, 'updateSchedule'])->name('project-survey.schedule');
    Route::post('project-survey/{uid}/score', [\App\Http\Controllers\ProjectSurveyController::class, 'storeScore'])->name('project-survey.score');
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
    
    // API Routes for Survey Statistics
    Route::prefix('api/v1')->group(function () {
        Route::get('surveys/stats/dashboard', [\App\Http\Controllers\Api\V1\SurveyStatsController::class, 'dashboard']);
        Route::get('surveys/{uid}/status', [\App\Http\Controllers\Api\V1\SurveyStatsController::class, 'status']);
        Route::get('surveys/scores/{id}', [\App\Http\Controllers\Api\V1\SurveyStatsController::class, 'scoreDetails']);
        
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

    // ... other protected routes
});

// Temporary: explicit index route for redirection to work if named 'dashboard'
// Route::get('/index', function () { return view('index'); })->name('index');
