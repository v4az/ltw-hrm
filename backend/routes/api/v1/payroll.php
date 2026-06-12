<?php

use App\Http\Controllers\Api\V1\Payroll\PayrollController;
use App\Http\Controllers\Api\V1\Payroll\PayslipController;
use Illuminate\Support\Facades\Route;

Route::prefix('payroll')->group(function (): void {
    Route::post('generate', [PayrollController::class, 'generate']);
    Route::get('summary', [PayrollController::class, 'summary']);
    Route::get('/', [PayrollController::class, 'index']);
    Route::get('{id}', [PayrollController::class, 'show']);
    Route::put('{id}', [PayrollController::class, 'update']);
    Route::delete('{id}', [PayrollController::class, 'destroy']);
    Route::post('{id}/approve', [PayrollController::class, 'approve']);
    Route::post('{id}/disburse', [PayrollController::class, 'disburse']);
    Route::get('{id}/payslips', [PayrollController::class, 'payslips']);
});

Route::prefix('payslips')->group(function (): void {
    Route::get('employee/{employeeId}', [PayslipController::class, 'employeeList']);
    Route::get('{id}', [PayslipController::class, 'show']);
    Route::get('{id}/download', [PayslipController::class, 'download']);
});
