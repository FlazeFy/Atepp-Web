<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;
    //use HasUuids;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'comment';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'endpoint_id', 'comment_context', 'comment_body', 'comment_attachment', 'created_at', 'created_by'];

    public static function get_comment_by_endpoint_ctx($user_id, $endpoint, $ctx){
        $res = CommentModel::selectRaw('comment_context, comment_body, comment_attachment,comment.created_at, username as created_by')
            ->leftjoin('user','user.id','=','comment.created_by')
            ->join('endpoint','endpoint.id','=','comment.endpoint_id')
            ->orderby('comment.created_at','ASC')
            ->where('endpoint.created_by',$user_id)
            ->where('comment_context',$ctx)
            ->where('endpoint_id',$endpoint)
            ->paginate(15);

        return $res;
    }
}
