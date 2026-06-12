<?php

use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function (): void {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::put('{id}', [UserController::class, 'update']);
    Route::delete('{id}', [UserController::class, 'destroy']);
    Route::patch('{id}/activate', [UserController::class, 'activate']);
    Route::patch('{id}/deactivate', [UserController::class, 'deactivate']);
    Route::patch('{id}/reset-password', [UserController::class, 'resetPassword']);
    Route::get('{id}/sessions', [UserController::class, 'sessions']);
    Route::delete('{id}/sessions/{sessionId}', [UserController::class, 'revokeSession']);
});
