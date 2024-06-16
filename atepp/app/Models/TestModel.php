<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasFactory;
    //use HasUuids;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'test';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'endpoint_id', 'test_name', 'test_expected', 'test_result', 'test_notes', 'created_at', 'created_by'];

    public static function get_test_by_endpoint_id($endpoint_id){
        $res = TestModel::selectRaw('test_name,test_expected,test_result,test_notes,test.created_at,username as created_by')
            ->join('user', 'user.id', '=', 'test.created_by')
            ->where('endpoint_id',$endpoint_id)
            ->orderBy('test.created_at', 'desc')
            ->orderBy('test.created_by', 'desc')
            ->paginate(20);

        return $res;
    }
}
