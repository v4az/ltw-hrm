<?php

use App\Http\Controllers\Api\V1\Setting\AuditLogController;
use App\Http\Controllers\Api\V1\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->group(function (): void {
    Route::get('company', [SettingController::class, 'company']);
    Route::put('company', [SettingController::class, 'updateCompany']);
    Route::get('working-hours', [SettingController::class, 'workingHours']);
    Route::put('working-hours', [SettingController::class, 'updateWorkingHours']);
    Route::get('/', [SettingController::class, 'index']);
    Route::put('/', [SettingController::class, 'update']);
});

Route::prefix('audit-logs')->group(function (): void {
    Route::get('user/{userId}', [AuditLogController::class, 'userTrail']);
    Route::get('/', [AuditLogController::class, 'index']);
    Route::get('{id}', [AuditLogController::class, 'show']);
});
