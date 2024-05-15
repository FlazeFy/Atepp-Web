<?php

namespace App\Http\Controllers\Api\Dictionary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\DictionaryModel;

class Queries extends Controller
{
    public function get_my_variable(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = DictionaryModel::select('id','dictionary_name','dictionary_value','created_at')
                ->where('dictionary_type','variable')
                ->where('created_by',$user_id)
                ->paginate(20);

            return response()->json([
                'status' => 'success',
                'message' => 'dictionary fetched',
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
