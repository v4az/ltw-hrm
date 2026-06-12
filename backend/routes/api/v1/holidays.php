<?php

use App\Http\Controllers\Api\V1\Holiday\HolidayController;
use Illuminate\Support\Facades\Route;

Route::prefix('holidays')->group(function (): void {
    Route::get('calendar', [HolidayController::class, 'calendar']);
    Route::get('/', [HolidayController::class, 'index']);
    Route::post('/', [HolidayController::class, 'store']);
    Route::put('{id}', [HolidayController::class, 'update']);
    Route::delete('{id}', [HolidayController::class, 'destroy']);
});
