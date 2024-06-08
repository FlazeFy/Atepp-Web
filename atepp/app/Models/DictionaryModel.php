<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionaryModel extends Model
{
    use HasFactory;
    //use HasUuids;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'dictionary';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'dictionary_type', 'dictionary_name', 'dictionary_value', 'created_at', 'created_by','updated_at'];

    public static function get_availability_dct($name, $type, $user_id, $id, $ctx){
        if($ctx == 'create'){
            $check = DictionaryModel::selectRaw('1')
                ->where('dictionary_name',$name)
                ->where('dictionary_type',$type)
                ->where('created_by',$user_id)
                ->first();
        } else if($ctx == 'update'){
            $check = DictionaryModel::selectRaw('1')
                ->where('dictionary_name',$name)
                ->where('dictionary_type',$type)
                ->where('created_by',$user_id)
                ->whereNot('id',$id)
                ->first();
        }
        
        if($check){
            return true;
        } else {
            return false;
        }
    }
}
