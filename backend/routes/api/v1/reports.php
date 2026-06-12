<?php

use App\Http\Controllers\Api\V1\Report\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->group(function (): void {
    Route::get('dashboard', [ReportController::class, 'dashboard']);
    Route::get('employees', [ReportController::class, 'employees']);
    Route::get('attendance', [ReportController::class, 'attendance']);
    Route::get('leaves', [ReportController::class, 'leaves']);
    Route::get('payroll', [ReportController::class, 'payroll']);
    Route::get('performance', [ReportController::class, 'performance']);
    Route::get('recruitment', [ReportController::class, 'recruitment']);
    Route::get('training', [ReportController::class, 'training']);
    Route::get('turnover', [ReportController::class, 'turnover']);
    Route::post('custom', [ReportController::class, 'custom']);
    Route::post('export', [ReportController::class, 'export']);
});
