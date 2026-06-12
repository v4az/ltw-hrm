<?php

use App\Http\Controllers\Api\V1\Position\JobGradeController;
use App\Http\Controllers\Api\V1\Position\PositionController;
use Illuminate\Support\Facades\Route;

Route::prefix('positions')->group(function (): void {
    Route::get('/', [PositionController::class, 'index']);
    Route::post('/', [PositionController::class, 'store']);
    Route::get('{id}', [PositionController::class, 'show']);
    Route::put('{id}', [PositionController::class, 'update']);
    Route::delete('{id}', [PositionController::class, 'destroy']);
    Route::get('{id}/employees', [PositionController::class, 'employees']);
});

Route::prefix('job-grades')->group(function (): void {
    Route::get('/', [JobGradeController::class, 'index']);
    Route::post('/', [JobGradeController::class, 'store']);
    Route::put('{id}', [JobGradeController::class, 'update']);
    Route::delete('{id}', [JobGradeController::class, 'destroy']);
});
