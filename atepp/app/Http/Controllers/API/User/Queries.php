<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Res;
use Illuminate\Support\Facades\DB;

use App\Models\UserModel;

class Queries extends Controller
{
    public function get_my_profile(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = UserModel::find($user_id);

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
