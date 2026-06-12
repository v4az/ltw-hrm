<?php

use App\Http\Controllers\Api\V1\Role\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles')->group(function (): void {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('{id}', [RoleController::class, 'show']);
    Route::put('{id}', [RoleController::class, 'update']);
    Route::delete('{id}', [RoleController::class, 'destroy']);
    Route::get('{id}/permissions', [RoleController::class, 'permissions']);
    Route::post('{id}/permissions', [RoleController::class, 'attachPermissions']);
    Route::delete('{id}/permissions/{permissionId}', [RoleController::class, 'detachPermission']);
    Route::post('{id}/assign', [RoleController::class, 'assign']);
});
