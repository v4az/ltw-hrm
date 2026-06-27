<?php

use Illuminate\Support\Facades\Route;

// Public auth routes (no middleware)
Route::prefix('v1')->group(function (): void {
    require __DIR__.'/api/v1/auth.php';
});

// Authenticated routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function (): void {
    require __DIR__.'/api/v1/users.php';
    require __DIR__.'/api/v1/roles.php';
    require __DIR__.'/api/v1/permissions.php';
    require __DIR__.'/api/v1/employees.php';
    require __DIR__.'/api/v1/departments.php';
    require __DIR__.'/api/v1/positions.php';
    require __DIR__.'/api/v1/attendance.php';
    require __DIR__.'/api/v1/leaves.php';
    require __DIR__.'/api/v1/payroll.php';
    require __DIR__.'/api/v1/salaries.php';
    require __DIR__.'/api/v1/performance.php';
    require __DIR__.'/api/v1/recruitment.php';
    require __DIR__.'/api/v1/training.php';
    require __DIR__.'/api/v1/schedules.php';
    require __DIR__.'/api/v1/reports.php';
    require __DIR__.'/api/v1/documents.php';
    require __DIR__.'/api/v1/notifications.php';
    require __DIR__.'/api/v1/settings.php';
});
