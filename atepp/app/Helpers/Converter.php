<?php
namespace App\Helpers;

class Converter
{
    public static function to_slug($val){
        $res = str_replace(" ","", $val);
        $res = preg_replace('/[!:\\\[\/"`;.\'^£$%&*()}{@#~?><>,|=+¬\]]/', '', $res);
        $res = strtolower($res);
        
        return $res;
    }

    public static function to_two_digit_decimal($val) {
        $res = ceil($val * 100) / 100;

        return $res;
    }
}