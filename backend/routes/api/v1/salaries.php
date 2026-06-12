<?php

use App\Http\Controllers\Api\V1\Salary\AllowanceController;
use App\Http\Controllers\Api\V1\Salary\BonusController;
use App\Http\Controllers\Api\V1\Salary\DeductionController;
use App\Http\Controllers\Api\V1\Salary\SalaryController;
use App\Http\Controllers\Api\V1\Salary\TaxRuleController;
use Illuminate\Support\Facades\Route;

Route::prefix('salaries')->group(function (): void {
    Route::get('employee/{employeeId}', [SalaryController::class, 'employeeHistory']);
    Route::get('/', [SalaryController::class, 'index']);
    Route::post('/', [SalaryController::class, 'store']);
    Route::get('{id}', [SalaryController::class, 'show']);
    Route::put('{id}', [SalaryController::class, 'update']);
    Route::delete('{id}', [SalaryController::class, 'destroy']);
});

Route::prefix('bonuses')->group(function (): void {
    Route::get('/', [BonusController::class, 'index']);
    Route::post('/', [BonusController::class, 'store']);
    Route::put('{id}', [BonusController::class, 'update']);
    Route::delete('{id}', [BonusController::class, 'destroy']);
});

Route::prefix('allowances')->group(function (): void {
    Route::get('/', [AllowanceController::class, 'index']);
    Route::post('/', [AllowanceController::class, 'store']);
    Route::put('{id}', [AllowanceController::class, 'update']);
    Route::delete('{id}', [AllowanceController::class, 'destroy']);
});

Route::prefix('deductions')->group(function (): void {
    Route::get('/', [DeductionController::class, 'index']);
    Route::post('/', [DeductionController::class, 'store']);
    Route::put('{id}', [DeductionController::class, 'update']);
    Route::delete('{id}', [DeductionController::class, 'destroy']);
});

Route::prefix('tax-rules')->group(function (): void {
    Route::get('/', [TaxRuleController::class, 'index']);
    Route::post('/', [TaxRuleController::class, 'store']);
    Route::put('{id}', [TaxRuleController::class, 'update']);
    Route::delete('{id}', [TaxRuleController::class, 'destroy']);
});
