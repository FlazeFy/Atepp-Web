<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkingSpaceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DummyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonitoringController;

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

    Route::post('/mode/comment_mode/{status}', [WorkingSpaceController::class, 'toogle_comment_mode']);
});

Route::prefix('/dummy')->group(function () {
    Route::get('/', [DummyController::class, 'index'])->name('dummy');
});

Route::prefix('/profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile');
});