<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\FolderModel;
use App\Models\ProjectModel;

use App\Helpers\Generator;
use App\Helpers\Converter;

class Commands extends Controller
{
    public function post_folder(Request $request,$slug) 
    {
        try{
            $user_id = $request->user()->id;
            $project = ProjectModel::select('id')->where('project_slug',$slug)->first();

            $res = FolderModel::create([
                'id' => Generator::get_uuid(), 
                'project_id' => $project->id, 
                'folder_slug' => Converter::to_slug($request->folder_name),  
                'folder_name' => $request->folder_name,  
                'folder_pin_code' => $request->folder_pin_code, 
                'folder_desc' => $request->folder_desc, 
                'created_at' => date('Y-m-d H:i:s'), 
                'created_by' => $user_id, 
                'updated_at' => null, 
                'updated_by' => null, 
                'deleted_at' => null, 
                'deleted_by' => null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'endpoint created',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
