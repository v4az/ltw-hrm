<?php

use App\Http\Controllers\Api\V1\Performance\GoalController;
use App\Http\Controllers\Api\V1\Performance\KpiController;
use App\Http\Controllers\Api\V1\Performance\PerformanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('performances')->group(function (): void {
    Route::get('employee/{employeeId}', [PerformanceController::class, 'employeeReviews']);
    Route::get('/', [PerformanceController::class, 'index']);
    Route::post('/', [PerformanceController::class, 'store']);
    Route::get('{id}', [PerformanceController::class, 'show']);
    Route::put('{id}', [PerformanceController::class, 'update']);
    Route::delete('{id}', [PerformanceController::class, 'destroy']);
    Route::post('{id}/submit', [PerformanceController::class, 'submit']);
    Route::post('{id}/approve', [PerformanceController::class, 'approve']);
    Route::post('{id}/feedback', [PerformanceController::class, 'feedback']);
});

Route::prefix('kpis')->group(function (): void {
    Route::get('/', [KpiController::class, 'index']);
    Route::post('/', [KpiController::class, 'store']);
    Route::put('{id}', [KpiController::class, 'update']);
    Route::delete('{id}', [KpiController::class, 'destroy']);
});

Route::prefix('goals')->group(function (): void {
    Route::get('/', [GoalController::class, 'index']);
    Route::post('/', [GoalController::class, 'store']);
    Route::get('{id}', [GoalController::class, 'show']);
    Route::put('{id}', [GoalController::class, 'update']);
    Route::delete('{id}', [GoalController::class, 'destroy']);
    Route::post('{id}/progress', [GoalController::class, 'updateProgress']);
});
