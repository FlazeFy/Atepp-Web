<?php

namespace App\Http\Controllers\Api\Response;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\Models\ResponseModel;
use App\Models\BotModel;
use App\Models\EndpointModel;

use App\Helpers\Generator;
use App\Helpers\Converter;

class Commands extends Controller
{
    public function post_response(Request $request) 
    {
        try{
            $user_id = $request->user()->id;
            $bots = BotModel::get_user_bots($user_id);
            
            $res = ResponseModel::create([
                'id' => Generator::get_uuid(), 
                'endpoint_id' => $request->endpoint_id, 
                'response_status' => $request->response_status, 
                'response_method' => $request->response_method,  
                'response_time' => $request->response_time, 
                'response_body' => $request->response_body,  
                'response_env' => $request->response_env,  
                'created_at' => date('Y-m-d H:i:s'), 
                'created_by' => $user_id, 
            ]);

            if($bots && $res){
                $endpoint = EndpointModel::select('endpoint_url')->where('id',$request->endpoint_id)->first();
                $response_time = Converter::to_two_digit_decimal($request->response_time);
                $responseBody = json_decode($request->response_body, true);
                $prettyResponseBody = json_encode($responseBody, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $escapedResponseBody = htmlspecialchars($prettyResponseBody);
                $formattedResponseBody = "<pre>{$escapedResponseBody}</pre>";

                foreach($bots as $dt){
                    $response = Telegram::sendMessage([
                        'chat_id' => $dt->bot_id,
                        'text' => "Hello $dt->username, You have run an endpoint. This is the detail :\n\nURL : $endpoint->endpoint_url\nMethod : $request->response_method\nStatus : $request->response_status\nTime Taken : $response_time ms\n\n<b>Body</b>\n$formattedResponseBody",
                        'parse_mode' => 'HTML'
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'response created',
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
