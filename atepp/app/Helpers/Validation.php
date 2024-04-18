<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Validator;

class Validation
{
    public static function get_validate_login($request){
        return Validator::make($request->all(), [
            'username' => 'required|min:6|max:30|string',
            'password' => 'required|min:6|string'
        ]);
    }
}
