<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\Models\TestModel;
use App\Models\BotModel;

use App\Helpers\Generator;
use App\Helpers\Converter;

class Commands extends Controller
{
    public function post_test(Request $request, $id) 
    {
        try{
            $user_id = $request->user()->id;
            $bots = BotModel::get_user_bots($user_id);
            $test_collection = $request->test_collection;
            $i = 0;
            $msg_format = "";

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

                    $msg_format .= "Test Name : ".$dt['test_name']."\nExpected : ".$dt['test_expected']."\nResult : ".$dt['test_result']."\nNotes : ".$dt['test_notes'];
                }
                $msg_format .= "\nAt ".date('Y-m-d H:i:s')."\n\n";
            }

            if($bots && $i > 0){
                foreach($bots as $dt){
                    $response = Telegram::sendMessage([
                        'chat_id' => $dt->bot_id,
                        'text' => "Hello $dt->username, An Endpoint has been tested with url $request->endpoint_url\n\n<b>Here's the detail :</b>\n\n$msg_format",
                        'parse_mode' => 'HTML'
                    ]);
                }
            }
            
            return response()->json([
                'status' => 'success',
                'message' => "Test Saved $i/".count($test_collection)
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
