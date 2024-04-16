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
}