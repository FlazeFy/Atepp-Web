<?php

namespace App\Http\Controllers\Api\Endpoint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\EndpointModel;

class Queries extends Controller
{
    public function get_all_endpoint(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = EndpointModel::get_all_endpoint($user_id);

            return response()->json([
                'status' => 'success',
                'message' => 'endpoint fetched',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_endpoint_by_folder_slug($id)
    {
        try{
            $res = EndpointModel::get_endpoint_by_folder_slug($id);

            return response()->json([
                'status' => 'success',
                'message' => 'endpoint fetched',
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
