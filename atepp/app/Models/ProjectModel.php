<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    use HasFactory;
    //use HasUuids;
    public $incrementing = false;

    protected $table = 'project';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'project_slug', 'project_title', 'project_category', 'project_type', 'project_desc', 'project_main_lang', 'project_pin_code', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'];

    public static function get_all_project($user_id){
        $res = ProjectModel::select('project_slug','project_title', 'project_category', 'project_type')
            ->where('created_by', $user_id)
            ->orderBy('project_title', 'asc')
            ->get();

        return $res;
    }
}
