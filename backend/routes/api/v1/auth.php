<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (): void {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('resend-verification', [AuthController::class, 'resendVerification']);
    Route::post('change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::post('2fa/enable', [AuthController::class, 'enable2fa'])->middleware('auth:sanctum');
    Route::post('2fa/verify', [AuthController::class, 'verify2fa']);
    Route::post('2fa/disable', [AuthController::class, 'disable2fa'])->middleware('auth:sanctum');
});
