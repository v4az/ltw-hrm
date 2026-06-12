<?php

use App\Http\Controllers\Api\V1\Document\ContractController;
use App\Http\Controllers\Api\V1\Document\DocumentController;
use Illuminate\Support\Facades\Route;

Route::prefix('documents')->group(function (): void {
    Route::get('/', [DocumentController::class, 'index']);
    Route::post('/', [DocumentController::class, 'store']);
    Route::get('{id}', [DocumentController::class, 'show']);
    Route::put('{id}', [DocumentController::class, 'update']);
    Route::delete('{id}', [DocumentController::class, 'destroy']);
    Route::get('{id}/download', [DocumentController::class, 'download']);
});

Route::prefix('contracts')->group(function (): void {
    Route::get('expiring', [ContractController::class, 'expiring']);
    Route::get('/', [ContractController::class, 'index']);
    Route::post('/', [ContractController::class, 'store']);
    Route::get('{id}', [ContractController::class, 'show']);
    Route::put('{id}', [ContractController::class, 'update']);
    Route::delete('{id}', [ContractController::class, 'destroy']);
    Route::post('{id}/sign', [ContractController::class, 'sign']);
});
