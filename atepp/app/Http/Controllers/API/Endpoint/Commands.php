<?php

namespace App\Http\Controllers\Api\Endpoint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\EndpointModel;

use App\Helpers\Generator;

class Commands extends Controller
{
    public function check_endpoint(Request $request) 
    {
        try{
            $res = EndpointModel::check_endpoint($request->endpoint_url);

            return response()->json([
                'status' => 'success',
                'message' => 'endpoint checked',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function post_endpoint(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = EndpointModel::create([
                'id' => Generator::get_uuid(), 
                'endpoint_name' => $request->endpoint_name, 
                'endpoint_desc' => $request->endpoint_desc, 
                'endpoint_url' => $request->endpoint_url, 
                'endpoint_method' => $request->endpoint_method, 
                'created_at' => date('Y-m-d H:i:s'), 
                'created_by' => $user_id, 
                'updated_at' => null, 
                'updated_by' => null, 
                'deleted_at' => null, 
                'deleted_by' => null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'endpoint created',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
