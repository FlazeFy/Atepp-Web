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

use App\Http\Controllers\Api\Comment\Queries as QueriesCommentApi;

use App\Http\Controllers\Api\Dictionary\Queries as QueriesDctApi;
use App\Http\Controllers\Api\Dictionary\Commands as CommandDctApi;

use App\Http\Controllers\Api\User\Queries as QueriesUserApi;
use App\Http\Controllers\Api\User\Commands as CommandsUserApi;

use App\Http\Controllers\Api\Bot\Queries as QueriesBotApi;

use App\Http\Controllers\Api\Test\Commands as CommandsTestApi;
use App\Http\Controllers\Api\Test\Queries as QueriesTestApi;

######################### Public Route #########################

Route::post('/v1/login', [CommandAuthApi::class, 'login']);

######################### Private Route #########################

Route::get('/v1/logout', [QueryAuthApi::class, 'logout'])->middleware(['auth:sanctum']);

Route::prefix('/v1/project')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [QueriesProjectApi::class, 'get_all_project']);
    Route::post('/', [CommandsProjectApi::class, 'post_project']);
    Route::get('/detail', [QueriesProjectApi::class, 'get_all_project_dashboard']);

    Route::get('/endpoint/list', [QueriesEndpointApi::class, 'get_all_endpoint']);
    Route::get('/endpoint/project/{slug}', [QueriesEndpointApi::class, 'get_endpoint_by_project_slug']);
    Route::get('/endpoint/folder/{slug}', [QueriesEndpointApi::class, 'get_endpoint_by_folder_slug']);
    Route::get('/endpoint/top/{ctx}', [QueriesEndpointApi::class, 'get_top_ten_endpoint_ctx']);
    Route::get('/endpoint/test/{id}', [QueriesTestApi::class, 'get_test_by_endpoint_id']);

    Route::post('/endpoint/check', [CommandsEndpointApi::class, 'check_endpoint']);
    Route::post('/endpoint', [CommandsEndpointApi::class, 'post_endpoint']);
    Route::post('/endpoint/test/{id}', [CommandsTestApi::class, 'post_test']);

    Route::get('/folder/{slug}', [QueriesFolderApi::class, 'get_folder_by_project_slug']);
    Route::post('/folder/{slug}', [CommandsFolderApi::class, 'post_folder']);

    Route::get('/response/{id}', [QueriesResponseApi::class, 'get_response_by_endpoint_id']);
    Route::get('/response/{id}/body', [QueriesResponseApi::class, 'get_response_detail_by_id']);
    Route::post('/response', [CommandsResponseApi::class, 'post_response']);

    Route::get('/working_space', [QueriesProjectApi::class, 'get_working_space']);

    Route::put('/put_project_desc/{slug}', [CommandsProjectApi::class, 'put_project_desc']);
    Route::put('/put_project_info/{slug}', [CommandsProjectApi::class, 'put_project_info']);
});

Route::prefix('/v1/comment')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/by/{endpoint}/{ctx}', [QueriesProjectApi::class, 'get_comment_by_endpoint_ctx']);
    Route::post('/', [CommandsProjectApi::class, 'post_comment']);
});

Route::prefix('/v1/stats')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/response/performance', [QueriesResponseApi::class, 'stats_general_response_time']);
    Route::get('/response/status_code', [QueriesResponseApi::class, 'stats_general_status_code']);
    Route::get('/response/time_history', [QueriesResponseApi::class, 'stats_general_time_history']);

    Route::get('/project/endpoint_method/{slug}', [QueriesProjectApi::class, 'stats_project_endpoint_method']);
    Route::get('/project/activity/{slug}', [QueriesProjectApi::class, 'stats_project_activity']);
});

Route::prefix('/v1/dictionary')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/variable', [QueriesDctApi::class, 'get_my_variable']);

    Route::post('/variable', [CommandDctApi::class, 'post_dictionary']);
    Route::put('/variable/{id}', [CommandDctApi::class, 'put_dictionary']);
    Route::delete('/variable/{id}', [CommandDctApi::class, 'delete_dictionary']);
});

Route::prefix('/v1/user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [QueriesUserApi::class, 'get_my_profile']);

    Route::get('/service', [QueriesBotApi::class, 'get_my_service']);

    Route::put('/edit_profile', [CommandsUserApi::class, 'edit_profile']);
    Route::post('/add_socmed', [CommandsUserApi::class, 'add_socmed_profile']);
    Route::delete('/delete_socmed_idx/{idx}', [CommandsUserApi::class, 'delete_socmed_profile']);
});