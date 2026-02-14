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
    
    // ... other protected routes
});

// Temporary: explicit index route for redirection to work if named 'dashboard'
// Route::get('/index', function () { return view('index'); })->name('index'); 
