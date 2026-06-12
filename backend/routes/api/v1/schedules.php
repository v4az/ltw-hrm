<?php

use App\Http\Controllers\Api\V1\Schedule\ScheduleController;
use App\Http\Controllers\Api\V1\Schedule\ShiftController;
use Illuminate\Support\Facades\Route;

Route::prefix('schedules')->group(function (): void {
    Route::get('/', [ScheduleController::class, 'index']);
    Route::post('/', [ScheduleController::class, 'store']);
    Route::get('{id}', [ScheduleController::class, 'show']);
    Route::put('{id}', [ScheduleController::class, 'update']);
    Route::delete('{id}', [ScheduleController::class, 'destroy']);
    Route::post('{id}/assign', [ScheduleController::class, 'assign']);
});

Route::prefix('shifts')->group(function (): void {
    Route::post('swap', [ShiftController::class, 'swap']);
    Route::put('swap/{id}/approve', [ShiftController::class, 'approveSwap']);
    Route::get('/', [ShiftController::class, 'index']);
    Route::post('/', [ShiftController::class, 'store']);
    Route::get('{id}', [ShiftController::class, 'show']);
    Route::put('{id}', [ShiftController::class, 'update']);
    Route::delete('{id}', [ShiftController::class, 'destroy']);
});
