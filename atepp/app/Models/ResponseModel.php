<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseModel extends Model
{
    use HasFactory;
    //use HasUuids;
    public $incrementing = false;

    protected $table = 'response';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'endpoint_id', 'response_status', 'response_method', 'response_time', 'response_body', 'response_env', 'created_at', 'created_by'];

    public static function get_response_by_endpoint_id($id){
        $res = ResponseModel::select('response_status', 'endpoint_name', 'response_time', 'response_method', 'response_body', 'response_env', 'response.created_at')
            ->join('endpoint', 'endpoint.id', '=', 'response.endpoint_id')
            ->where('response.created_by', 'dc4d52ec-afb1-11ed-afa1-0242ac120002')
            ->where('endpoint_id',$id)
            ->orderBy('response.created_at', 'desc')
            ->get();

        return $res;
    }
}
