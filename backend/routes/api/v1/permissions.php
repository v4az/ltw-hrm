<?php

use App\Http\Controllers\Api\V1\Role\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('permissions')->group(function (): void {
    Route::get('/', [PermissionController::class, 'index'])->middleware('permission:permissions.view');
    Route::post('/', [PermissionController::class, 'store'])->middleware('permission:permissions.manage');
    Route::get('{id}', [PermissionController::class, 'show'])->middleware('permission:permissions.view');
    Route::put('{id}', [PermissionController::class, 'update'])->middleware('permission:permissions.manage');
    Route::delete('{id}', [PermissionController::class, 'destroy'])->middleware('permission:permissions.manage');
});
