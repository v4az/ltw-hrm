<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    // Public routes.
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('resend-verification', [AuthController::class, 'resendVerification']);
    Route::post('2fa/verify', [AuthController::class, 'verify2fa']);

    // Authenticated routes (access-scoped token required).
    Route::middleware(['auth:sanctum', 'abilities:access'])->group(function (): void {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('2fa/enable', [AuthController::class, 'enable2fa']);
        Route::post('2fa/disable', [AuthController::class, 'disable2fa']);
    });
});
