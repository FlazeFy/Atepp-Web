<?php

namespace App\Http\Controllers\Api\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;

use App\Models\ResponseModel;

class Queries extends Controller
{
    public function get_response_by_endpoint_id($id) 
    {
        try{
            $res = ResponseModel::get_response_by_endpoint_id($id);

            return response()->json([
                'status' => 'success',
                'message' => 'response fetched',
                'data' => $res
            ], Res::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'something wrong. Please contact admin',
            ], Res::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_response_detail_by_id($id) 
    {
        try{
            $res = ResponseModel::select('response_body')
                ->where('id',$id)
                ->first();

            return response()->json([
                'status' => 'success',
                'message' => 'response fetched',
                'data' => $res
            ], Res::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'something wrong. Please contact admin',
            ], Res::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
