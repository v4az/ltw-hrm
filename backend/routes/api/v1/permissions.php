<?php

use App\Http\Controllers\Api\V1\Role\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('permissions')->group(function (): void {
    Route::get('/', [PermissionController::class, 'index']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::get('{id}', [PermissionController::class, 'show']);
    Route::put('{id}', [PermissionController::class, 'update']);
    Route::delete('{id}', [PermissionController::class, 'destroy']);
});
