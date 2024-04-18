<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasFactory;
    //use HasUuids;
    use HasApiTokens;
    public $incrementing = false;

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'username', 'password', 'email', 'phone', 'company', 'social_media', 'job', 'account_type', 'created_at', 'updated_at'];
}
