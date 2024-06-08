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
            $check = DictionaryModel::get_availability_dct($request->dictionary_name,'variable',$user_id,null,'create');

            if(!$check){
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
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'dictionary failed to created',
                ], Response::HTTP_CONFLICT);
            }
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function put_dictionary(Request $request, $id) 
    {
        try{
            $user_id = $request->user()->id;
            $check = DictionaryModel::get_availability_dct($request->dictionary_name,'variable',$user_id,$id,'update');

            if(!$check){
                $res = DictionaryModel::where('id',$id)
                ->update([
                    'dictionary_name' => $request->dictionary_name, 
                    'dictionary_value'  => $request->dictionary_value, 
                    'updated_at' => date('Y-m-d H:i:s'), 
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'dictionary updated',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'dictionary failed to updated',
                ], Response::HTTP_CONFLICT);
            }
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete_dictionary(Request $request, $id) 
    {
        try{
            $res = DictionaryModel::destroy($id);

            if($res > 0){
                return response()->json([
                    'status' => 'success',
                    'message' => 'dictionary deleted',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'dictionary failed to deleted',
                ], Response::HTTP_NOT_FOUND);
            }
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
