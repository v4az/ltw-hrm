<?php

use App\Http\Controllers\Api\V1\Department\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('departments')->group(function (): void {
    Route::get('tree', [DepartmentController::class, 'tree']);
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/', [DepartmentController::class, 'store']);
    Route::get('{id}', [DepartmentController::class, 'show']);
    Route::put('{id}', [DepartmentController::class, 'update']);
    Route::delete('{id}', [DepartmentController::class, 'destroy']);
    Route::get('{id}/employees', [DepartmentController::class, 'employees']);
    Route::post('{id}/assign-head', [DepartmentController::class, 'assignHead']);
});
