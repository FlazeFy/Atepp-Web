<?php

namespace App\Http\Controllers\Api\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\ResponseModel;

use App\Helpers\Generator;
use App\Helpers\Converter;

class Commands extends Controller
{
    public function post_response(Request $request) 
    {
        try{
            $res = ResponseModel::create([
                'id' => Generator::get_uuid(), 
                'endpoint_id' => $request->endpoint_id, 
                'response_status' => $request->response_status, 
                'response_method' => $request->response_method,  
                'response_time' => $request->response_time, 
                'response_body' => $request->response_body,  
                'response_env' => $request->response_env,  
                'created_at' => date('Y-m-d H:i:s'), 
                'created_by' => 'dc4d52ec-afb1-11ed-afa1-0242ac120002', 
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'response created',
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
