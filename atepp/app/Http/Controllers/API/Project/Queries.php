<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\ProjectModel;

class Queries extends Controller
{
    public function get_all_project(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = ProjectModel::get_all_project($user_id);

            return response()->json([
                'status' => 'success',
                'message' => 'project fetched',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
