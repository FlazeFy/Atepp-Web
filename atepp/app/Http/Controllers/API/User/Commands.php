<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\Models\UserModel;

use App\Helpers\Generator;
use App\Helpers\Converter;

class Commands extends Controller
{
    public function edit_profile(Request $request) 
    {
        try{
            $user_id = $request->user()->id;
            
            $check = UserModel::selectRaw('1')
                ->where('username', $request->username)
                ->whereNot('id',$user_id)
                ->first();

            if($check == null){
                $res = UserModel::where('id',$user_id)
                    ->update([
                        'username' => $request->username, 
                        'email' => $request->email, 
                        'company' => $request->company,  
                        'phone' => $request->phone,  
                        'job' => $request->job, 
                        'updated_at' => date('Y-m-d H:i:s'), 
                    ]);

                if($res > 0){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'user updated',
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'user failed updated',
                    ], Response::HTTP_NOT_FOUND);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'username already taken',
                ], Response::HTTP_CONFLICT);
            }
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function add_socmed_profile(Request $request) 
    {
        try{
            $user_id = $request->user()->id;
            
            $check = UserModel::find($user_id);

            if($check != null){
                $socmed = $check->social_media;

                array_push($socmed, (object)[
                    'socmed_name' => $request->socmed_name,
                    'socmed_url' => $request->socmed_url,
                ]);

                $res = UserModel::where('id',$user_id)
                    ->update([
                        'social_media' => $socmed,
                    ]);

                if($res > 0){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'user socmed updated',
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'user socmed failed updated',
                    ], Response::HTTP_NOT_FOUND);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'account not found',
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
