<?php

use App\Http\Controllers\Api\V1\Recruitment\ApplicationController;
use App\Http\Controllers\Api\V1\Recruitment\CandidateController;
use App\Http\Controllers\Api\V1\Recruitment\InterviewController;
use App\Http\Controllers\Api\V1\Recruitment\JobController;
use Illuminate\Support\Facades\Route;

Route::prefix('jobs')->group(function (): void {
    Route::get('public', [JobController::class, 'publicList'])->withoutMiddleware('auth:sanctum');
    Route::get('/', [JobController::class, 'index']);
    Route::post('/', [JobController::class, 'store']);
    Route::get('{id}', [JobController::class, 'show']);
    Route::put('{id}', [JobController::class, 'update']);
    Route::delete('{id}', [JobController::class, 'destroy']);
    Route::post('{id}/publish', [JobController::class, 'publish']);
    Route::post('{id}/close', [JobController::class, 'close']);
});

Route::prefix('candidates')->group(function (): void {
    Route::get('/', [CandidateController::class, 'index']);
    Route::post('/', [CandidateController::class, 'store']);
    Route::get('{id}', [CandidateController::class, 'show']);
    Route::put('{id}', [CandidateController::class, 'update']);
    Route::delete('{id}', [CandidateController::class, 'destroy']);
    Route::post('{id}/upload-cv', [CandidateController::class, 'uploadCv']);
});

Route::prefix('applications')->group(function (): void {
    Route::get('/', [ApplicationController::class, 'index']);
    Route::post('/', [ApplicationController::class, 'store']);
    Route::get('{id}', [ApplicationController::class, 'show']);
    Route::put('{id}/status', [ApplicationController::class, 'updateStatus']);
    Route::delete('{id}', [ApplicationController::class, 'destroy']);
    Route::post('{id}/offer', [ApplicationController::class, 'offer']);
    Route::post('{id}/hire', [ApplicationController::class, 'hire']);
    Route::post('{id}/reject', [ApplicationController::class, 'reject']);
});

Route::prefix('interviews')->group(function (): void {
    Route::get('/', [InterviewController::class, 'index']);
    Route::post('/', [InterviewController::class, 'store']);
    Route::get('{id}', [InterviewController::class, 'show']);
    Route::put('{id}', [InterviewController::class, 'update']);
    Route::delete('{id}', [InterviewController::class, 'destroy']);
    Route::post('{id}/feedback', [InterviewController::class, 'feedback']);
});
