<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndpointModel extends Model
{
    use HasFactory;
    //use HasUuids;
    public $incrementing = false;

    protected $table = 'endpoint';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'project_id', 'endpoint_name', 'endpoint_desc', 'endpoint_url', 'endpoint_method', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'];

    public static function get_all_endpoint(){
        $res = EndpointModel::select('id','endpoint_name', 'endpoint_desc', 'endpoint_url', 'endpoint_method')
            ->where('created_by', 'dc4d52ec-afb1-11ed-afa1-0242ac120002')
            ->orderBy('endpoint_name', 'asc')
            ->get();

        return $res;
    }

    public static function check_endpoint($url){
        $res = EndpointModel::selectRaw('1')
            ->where('endpoint_url', $url)
            ->first();

        if($res != null){
            return true;
        } else {
            return false;
        }
    }
}
