<?php

use App\Http\Controllers\Api\V1\Role\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles')->group(function (): void {
    Route::get('/', [RoleController::class, 'index'])->middleware('permission:roles.view');
    Route::post('/', [RoleController::class, 'store'])->middleware('permission:roles.manage');
    Route::get('{id}', [RoleController::class, 'show'])->middleware('permission:roles.view');
    Route::put('{id}', [RoleController::class, 'update'])->middleware('permission:roles.manage');
    Route::delete('{id}', [RoleController::class, 'destroy'])->middleware('permission:roles.manage');
    Route::get('{id}/permissions', [RoleController::class, 'permissions'])->middleware('permission:roles.view');
    Route::post('{id}/permissions', [RoleController::class, 'attachPermissions'])->middleware('permission:roles.manage');
    Route::delete('{id}/permissions/{permissionId}', [RoleController::class, 'detachPermission'])->middleware('permission:roles.manage');
    Route::post('{id}/assign', [RoleController::class, 'assign'])->middleware('permission:roles.manage');
});
