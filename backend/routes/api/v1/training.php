<?php

use App\Http\Controllers\Api\V1\Training\CertificationController;
use App\Http\Controllers\Api\V1\Training\TrainingController;
use Illuminate\Support\Facades\Route;

Route::prefix('trainings')->group(function (): void {
    Route::get('employee/{employeeId}', [TrainingController::class, 'employeeHistory']);
    Route::get('/', [TrainingController::class, 'index']);
    Route::post('/', [TrainingController::class, 'store']);
    Route::get('{id}', [TrainingController::class, 'show']);
    Route::put('{id}', [TrainingController::class, 'update']);
    Route::delete('{id}', [TrainingController::class, 'destroy']);
    Route::post('{id}/enroll', [TrainingController::class, 'enroll']);
    Route::delete('{id}/enroll/{employeeId}', [TrainingController::class, 'unenroll']);
    Route::get('{id}/participants', [TrainingController::class, 'participants']);
    Route::post('{id}/complete', [TrainingController::class, 'complete']);
});

Route::prefix('certifications')->group(function (): void {
    Route::get('expiring', [CertificationController::class, 'expiring']);
    Route::get('/', [CertificationController::class, 'index']);
    Route::post('/', [CertificationController::class, 'store']);
    Route::put('{id}', [CertificationController::class, 'update']);
    Route::delete('{id}', [CertificationController::class, 'destroy']);
});
