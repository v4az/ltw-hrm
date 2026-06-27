<?php

use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function (): void {
    Route::get('/', [UserController::class, 'index'])->middleware('permission:users.view');
    Route::post('/', [UserController::class, 'store'])->middleware('permission:users.create');
    Route::get('{id}', [UserController::class, 'show'])->middleware('permission:users.view');
    Route::put('{id}', [UserController::class, 'update'])->middleware('permission:users.update');
    Route::delete('{id}', [UserController::class, 'destroy'])->middleware('permission:users.delete');
    Route::patch('{id}/activate', [UserController::class, 'activate'])->middleware('permission:users.manage');
    Route::patch('{id}/deactivate', [UserController::class, 'deactivate'])->middleware('permission:users.manage');
    Route::patch('{id}/reset-password', [UserController::class, 'resetPassword'])->middleware('permission:users.manage');
    Route::get('{id}/sessions', [UserController::class, 'sessions'])->middleware('permission:users.manage');
    Route::delete('{id}/sessions/{sessionId}', [UserController::class, 'revokeSession'])->middleware('permission:users.manage');
});
