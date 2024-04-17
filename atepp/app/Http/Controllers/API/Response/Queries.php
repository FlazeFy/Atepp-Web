<?php

namespace App\Http\Controllers\Api\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\DB;

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

    public function stats_general_response_time() 
    {
        try{
            $res = ResponseModel::select(DB::raw("
                    CASE
                        WHEN response_time < 1000 THEN 'Fast'
                        WHEN response_time < 3000 THEN 'Normal'
                        ELSE 'Slow'
                    END AS context,
                    COUNT(1) AS total
                "))
                ->groupBy('context')
                ->where('response.created_by','dc4d52ec-afb1-11ed-afa1-0242ac120002')
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
