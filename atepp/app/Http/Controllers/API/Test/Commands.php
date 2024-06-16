<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\Models\TestModel;

use App\Helpers\Generator;
use App\Helpers\Converter;

class Commands extends Controller
{
    public function post_test(Request $request, $id) 
    {
        try{
            $user_id = $request->user()->id;
            $test_collection = $request->test_collection;
            $i = 0;

            foreach($test_collection as $dt){
                $res = TestModel::create([
                    'id' => Generator::get_uuid(), 
                    'endpoint_id' => $id, 
                    'test_name' => $dt['test_name'], 
                    'test_expected' => $dt['test_expected'], 
                    'test_result' => $dt['test_result'],  
                    'test_notes' => $dt['test_notes'],  
                    'created_at' => date('Y-m-d H:i:s'), 
                    'created_by' => $user_id
                ]);

                if($res != null){
                    $i++;
                }
            }
            
            return response()->json([
                'status' => 'success',
                'message' => "test created $i/".count($test_collection)
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
