<?php

use App\Http\Controllers\Api\V1\Attendance\AttendanceController;
use App\Http\Controllers\Api\V1\Attendance\OvertimeController;
use Illuminate\Support\Facades\Route;

Route::prefix('attendance')->group(function (): void {
    Route::post('check-in', [AttendanceController::class, 'checkIn']);
    Route::post('check-out', [AttendanceController::class, 'checkOut']);
    Route::get('today', [AttendanceController::class, 'today']);
    Route::get('summary', [AttendanceController::class, 'summary']);
    Route::post('manual', [AttendanceController::class, 'manual']);
    Route::get('late', [AttendanceController::class, 'late']);
    Route::get('absent', [AttendanceController::class, 'absent']);
    Route::post('overtime', [OvertimeController::class, 'submit']);
    Route::get('overtime', [OvertimeController::class, 'index']);
    Route::put('overtime/{id}/approve', [OvertimeController::class, 'approve']);
    Route::put('overtime/{id}/reject', [OvertimeController::class, 'reject']);
    Route::get('employee/{employeeId}', [AttendanceController::class, 'employeeHistory']);
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('{id}', [AttendanceController::class, 'show']);
    Route::put('{id}', [AttendanceController::class, 'update']);
    Route::delete('{id}', [AttendanceController::class, 'destroy']);
});
