<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderModel extends Model
{
    use HasFactory;
    //use HasUuids;
    public $incrementing = false;

    protected $table = 'folder';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'project_id', 'folder_slug', 'folder_name', 'folder_pin_code', 'folder_desc', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'];

    public static function get_folder_by_context($target, $ctx){
        $res = FolderModel::select('folder.id','folder_name', 'folder_slug', 'folder_desc')
            ->join('project', 'project.id','=','folder.project_id')
            ->where($target, $ctx)
            ->orderBy('folder_name', 'asc')
            ->get();

        return $res;
    }
}
