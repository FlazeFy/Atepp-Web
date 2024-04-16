<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Project\Queries as QueriesProjectApi;

use App\Http\Controllers\Api\Endpoint\Queries as QueriesEndpointApi;
use App\Http\Controllers\Api\Endpoint\Commands as CommandsEndpointApi;

Route::prefix('/v1/project')->group(function () {
    Route::get('/', [QueriesProjectApi::class, 'get_all_project']);

    Route::get('/endpoint/list', [QueriesEndpointApi::class, 'get_all_endpoint']);
    Route::post('/endpoint/check', [CommandsEndpointApi::class, 'check_endpoint']);
    Route::post('/endpoint', [CommandsEndpointApi::class, 'post_endpoint']);
});