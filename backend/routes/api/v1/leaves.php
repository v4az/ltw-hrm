<?php

use App\Http\Controllers\Api\V1\Leave\LeaveController;
use App\Http\Controllers\Api\V1\Leave\LeaveTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('leaves')->group(function (): void {
    Route::get('calendar', [LeaveController::class, 'calendar']);
    Route::get('pending', [LeaveController::class, 'pending']);
    Route::get('balance/{employeeId}', [LeaveController::class, 'balance']);
    Route::get('employee/{employeeId}', [LeaveController::class, 'employeeHistory']);
    Route::get('types', [LeaveTypeController::class, 'index']);
    Route::post('types', [LeaveTypeController::class, 'store']);
    Route::put('types/{id}', [LeaveTypeController::class, 'update']);
    Route::delete('types/{id}', [LeaveTypeController::class, 'destroy']);
    Route::get('/', [LeaveController::class, 'index']);
    Route::post('/', [LeaveController::class, 'store']);
    Route::get('{id}', [LeaveController::class, 'show']);
    Route::put('{id}', [LeaveController::class, 'update']);
    Route::delete('{id}', [LeaveController::class, 'destroy']);
    Route::post('{id}/approve', [LeaveController::class, 'approve']);
    Route::post('{id}/reject', [LeaveController::class, 'reject']);
});
