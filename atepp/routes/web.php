<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkingSpaceController;
use App\Http\Controllers\LoginController;

Route::prefix('/')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login/validate', [LoginController::class, 'login_auth']);
});

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('/project')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('project');
    Route::post('/select_project', [ProjectController::class, 'set_open_project']);
});

Route::prefix('/workingspace')->group(function () {
    Route::get('/', [WorkingSpaceController::class, 'index'])->name('workingspace');
});