<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\DB;

use App\Models\TestModel;

class Queries extends Controller
{
    public function get_test_by_endpoint_id(Request $request, $id) 
    {
        try{
            $user_id = $request->user()->id;

            $res = TestModel::get_test_by_endpoint_id($id);

            return response()->json([
                'status' => 'success',
                'message' => 'test fetched',
                'data' => $res
            ], Res::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error'.$e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Res::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
