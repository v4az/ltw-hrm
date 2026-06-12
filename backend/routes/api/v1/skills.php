<?php

use App\Http\Controllers\Api\V1\Skill\SkillController;
use Illuminate\Support\Facades\Route;

Route::prefix('skills')->group(function (): void {
    Route::get('/', [SkillController::class, 'index']);
    Route::post('/', [SkillController::class, 'store']);
    Route::put('{id}', [SkillController::class, 'update']);
    Route::delete('{id}', [SkillController::class, 'destroy']);
});

Route::prefix('employees/{id}/skills')->group(function (): void {
    Route::get('/', [SkillController::class, 'employeeSkills']);
    Route::post('/', [SkillController::class, 'attachSkill']);
    Route::delete('{skillId}', [SkillController::class, 'detachSkill']);
});
