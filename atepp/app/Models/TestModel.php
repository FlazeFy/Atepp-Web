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
}
