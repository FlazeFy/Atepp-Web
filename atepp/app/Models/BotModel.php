<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'bot';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'bot_platform', 'bot_id', 'is_valid', 'created_at', 'created_by'];

    public static function get_user_bots($user_id){
        $res = BotModel::select('bot_platform', 'bot_id','user.username','bot.is_valid','bot.created_at')
            ->join('user','user.id','=','bot.created_by')
            ->orderby('bot.created_at','ASC')
            ->where('bot.created_by',$user_id)
            ->get();

        return $res;
    }
}
