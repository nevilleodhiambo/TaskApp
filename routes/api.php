<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);


Route::controller(ProjectController::class)->group(function () {
    Route::post('project', 'store');
    Route::put('project', 'update');
    // Route::put('project/{id}', 'update']);
    Route::get('projects', 'index');
    Route::post('/projects/pinned', 'pinnedProject');
    Route::get('projects/{slug}', 'getProject');
    Route::get('/count/projects', 'countProject');
});

Route::controller(MemberController::class)->group(function () {
    Route::post('member', 'store');
    Route::put('member', 'update');
    Route::get('members', 'index');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('tasks', 'createTask');
    Route::post('task/task_not_started_to_pending', 'taskNotStartedToPending');
    Route::post('task/task_not_started_to_completed', 'taskNotStartedToCompleted');
    Route::post('task/task_pending_to_completed', 'taskPendingToCompleted');
    Route::post('task/task_pending_to_not_started', 'taskPendingToNotStarted');
    Route::post('task/task_completed_to_pending', 'taskCompletedToPending');
    Route::post('task/task_completed_to_not_started', 'taskCompletedToNotStarted');
});
