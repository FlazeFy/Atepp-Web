<?php

namespace App\Http\Controllers\Api\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Services\FirebaseService;


class Queries extends Controller
{
    public function get_my_warehouse(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $firebaseService = new FirebaseService();
            $res = $firebaseService->getFileList("endpoint/docs/$user_id/");

            return response()->json([
                'status' => 'success',
                'message' => 'warehouse fetched',
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
