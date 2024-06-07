<?php

namespace App\Http\Controllers\Api\Bot;

use App\Models\BotModel;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class Queries extends Controller
{
    public function get_my_service(Request $request)
    {
        try{
            $user_id = $request->user()->id;
            $res = BotModel::get_user_bots($user_id);

            return response()->json([
                'status' => 'success',
                'message' => 'service fetched',
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
