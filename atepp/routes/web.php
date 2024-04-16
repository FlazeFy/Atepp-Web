<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;

use App\Http\Controllers\Api\Project\Queries as QueriesProjectApi;

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('/project')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('project');
});

Route::prefix('/api/v1/project')->group(function () {
    Route::get('/endpoint/list', [QueriesProjectApi::class, 'get_all_endpoint']);
});