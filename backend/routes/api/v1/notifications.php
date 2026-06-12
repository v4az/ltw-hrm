<?php

use App\Http\Controllers\Api\V1\Notification\AnnouncementController;
use App\Http\Controllers\Api\V1\Notification\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->group(function (): void {
    Route::get('/', [NotificationController::class, 'index']);
    Route::post('send', [NotificationController::class, 'send']);
    Route::put('read-all', [NotificationController::class, 'markAllRead']);
    Route::get('{id}', [NotificationController::class, 'show']);
    Route::put('{id}/read', [NotificationController::class, 'markRead']);
    Route::delete('{id}', [NotificationController::class, 'destroy']);
});

Route::prefix('announcements')->group(function (): void {
    Route::get('/', [AnnouncementController::class, 'index']);
    Route::post('/', [AnnouncementController::class, 'store']);
    Route::put('{id}', [AnnouncementController::class, 'update']);
    Route::delete('{id}', [AnnouncementController::class, 'destroy']);
});
