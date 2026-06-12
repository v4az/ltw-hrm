<?php

use App\Http\Controllers\Api\V1\Employee\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')->group(function (): void {
    Route::post('import', [EmployeeController::class, 'import']);
    Route::get('export', [EmployeeController::class, 'export']);
    Route::get('search', [EmployeeController::class, 'search']);
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::get('{id}', [EmployeeController::class, 'show']);
    Route::put('{id}', [EmployeeController::class, 'update']);
    Route::delete('{id}', [EmployeeController::class, 'destroy']);
    Route::post('{id}/avatar', [EmployeeController::class, 'uploadAvatar']);
    Route::get('{id}/documents', [EmployeeController::class, 'documents']);
    Route::post('{id}/documents', [EmployeeController::class, 'uploadDocument']);
    Route::delete('{id}/documents/{docId}', [EmployeeController::class, 'deleteDocument']);
    Route::get('{id}/history', [EmployeeController::class, 'history']);
    Route::get('{id}/dependents', [EmployeeController::class, 'dependents']);
    Route::post('{id}/dependents', [EmployeeController::class, 'addDependent']);
    Route::put('{id}/dependents/{depId}', [EmployeeController::class, 'updateDependent']);
    Route::delete('{id}/dependents/{depId}', [EmployeeController::class, 'deleteDependent']);
    Route::get('{id}/emergency-contacts', [EmployeeController::class, 'emergencyContacts']);
    Route::post('{id}/emergency-contacts', [EmployeeController::class, 'addEmergencyContact']);
    Route::post('{id}/terminate', [EmployeeController::class, 'terminate']);
    Route::post('{id}/rehire', [EmployeeController::class, 'rehire']);
    Route::get('{id}/org-chart', [EmployeeController::class, 'orgChart']);
});
