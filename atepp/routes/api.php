<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Project\Queries as QueriesProjectApi;
use App\Http\Controllers\Api\Project\Commands as CommandsProjectApi;

Route::prefix('/v1/project')->group(function () {
    Route::get('/endpoint/list', [QueriesProjectApi::class, 'get_all_endpoint']);
    Route::post('/endpoint/check', [CommandsProjectApi::class, 'check_endpoint']);
    Route::post('/endpoint', [CommandsProjectApi::class, 'post_endpoint']);
});