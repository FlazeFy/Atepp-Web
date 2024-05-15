<?php

namespace App\Http\Controllers\Api\Dictionary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\DictionaryModel;

use App\Helpers\Generator;

class Commands extends Controller
{
    public function post_dictionary(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = DictionaryModel::create([
                'id' => Generator::get_uuid(), 
                'dictionary_type' => 'variable', 
                'dictionary_name' => $request->dictionary_name, 
                'dictionary_value'  => $request->dictionary_value, 
                'created_at' => date('Y-m-d H:i:s'), 
                'created_by' => $user_id, 
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'dictionary created',
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
