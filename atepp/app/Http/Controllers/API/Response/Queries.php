<?php

namespace App\Http\Controllers\Api\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\DB;

use App\Models\ResponseModel;

class Queries extends Controller
{
    public function get_response_by_endpoint_id(Request $request, $id) 
    {
        try{
            $user_id = $request->user()->id;

            $res = ResponseModel::get_response_by_endpoint_id($id, $user_id);

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

    public function stats_general_response_time(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = ResponseModel::select(DB::raw("
                    CASE
                        WHEN response_time < 1000 THEN 'Fast'
                        WHEN response_time < 3000 THEN 'Normal'
                        ELSE 'Slow'
                    END AS context,
                    COUNT(1) AS total
                "))
                ->groupBy('context')
                ->where('response.created_by',$user_id)
                ->get();

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

    public function stats_general_status_code(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = ResponseModel::select(DB::raw("
                    response_method,
                    CASE
                        WHEN response_status >= 100 AND response_status < 200 THEN 100
                        WHEN response_status >= 200 AND response_status < 300 THEN 200
                        WHEN response_status >= 300 AND response_status < 400 THEN 300
                        WHEN response_status >= 400 AND response_status < 500 THEN 400
                        WHEN response_status >= 500 AND response_status < 600 THEN 500
                        ELSE '0'
                    END AS response_general_status,
                    COUNT(1) AS total
                "))
                ->groupBy('response_method')
                ->groupBy('response_general_status')
                ->where('response.created_by',$user_id)
                ->get();

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
