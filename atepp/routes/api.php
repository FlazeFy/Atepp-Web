<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Project\Queries as QueriesProjectApi;
use App\Http\Controllers\Api\Project\Commands as CommandsProjectApi;

use App\Http\Controllers\Api\Endpoint\Queries as QueriesEndpointApi;
use App\Http\Controllers\Api\Endpoint\Commands as CommandsEndpointApi;

use App\Http\Controllers\Api\Folder\Queries as QueriesFolderApi;
use App\Http\Controllers\Api\Folder\Commands as CommandsFolderApi;

use App\Http\Controllers\Api\Response\Queries as QueriesResponseApi;
use App\Http\Controllers\Api\Response\Commands as CommandsResponseApi;

use App\Http\Controllers\Api\Auth\Commands as CommandAuthApi;
use App\Http\Controllers\Api\Auth\Queries as QueryAuthApi;

######################### Public Route #########################

Route::post('/v1/login', [CommandAuthApi::class, 'login']);

######################### Private Route #########################

Route::get('/v1/logout', [QueryAuthApi::class, 'logout'])->middleware(['auth:sanctum']);

Route::prefix('/v1/project')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [QueriesProjectApi::class, 'get_all_project']);
    Route::post('/', [CommandsProjectApi::class, 'post_project']);
    Route::get('/detail', [QueriesProjectApi::class, 'get_all_project_dashboard']);

    Route::get('/endpoint/list', [QueriesEndpointApi::class, 'get_all_endpoint']);
    Route::get('/endpoint/folder/{slug}', [QueriesEndpointApi::class, 'get_endpoint_by_folder_slug']);

    Route::post('/endpoint/check', [CommandsEndpointApi::class, 'check_endpoint']);
    Route::post('/endpoint', [CommandsEndpointApi::class, 'post_endpoint']);

    Route::get('/folder/{slug}', [QueriesFolderApi::class, 'get_folder_by_project_slug']);
    Route::post('/folder/{slug}', [CommandsFolderApi::class, 'post_folder']);

    Route::get('/response/{id}', [QueriesResponseApi::class, 'get_response_by_endpoint_id']);
    Route::get('/response/{id}/body', [QueriesResponseApi::class, 'get_response_detail_by_id']);
    Route::post('/response', [CommandsResponseApi::class, 'post_response']);

    Route::get('/working_space', [QueriesProjectApi::class, 'get_working_space']);
});

Route::prefix('/v1/stats')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/response/performance', [QueriesResponseApi::class, 'stats_general_response_time']);
    Route::get('/response/status_code', [QueriesResponseApi::class, 'stats_general_status_code']);
    Route::get('/response/time_history', [QueriesResponseApi::class, 'stats_general_time_history']);
});