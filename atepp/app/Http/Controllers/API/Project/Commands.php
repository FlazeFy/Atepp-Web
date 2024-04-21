<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\FolderModel;
use App\Models\ProjectModel;

use App\Helpers\Generator;
use App\Helpers\Converter;

class Commands extends Controller
{
    public function post_project(Request $request) 
    {
        try{
            $user_id = $request->user()->id;
            $id = Generator::get_uuid();

            $res_project = ProjectModel::create([
                'id' => $id, 
                'project_slug' => Converter::to_slug($request->project_title), 
                'project_title' => $request->project_title,  
                'project_category' => $request->project_category, 
                'project_type' => $request->project_type, 
                'project_desc' => $request->project_desc, 
                'project_main_lang' => $request->project_main_lang,
                'project_pin_code' => $request->project_pin_code, 
                'created_at' => date('Y-m-d H:i:s'), 
                'created_by' => $user_id, 
                'updated_at' => null, 
                'updated_by' => null, 
                'deleted_at' => null, 
                'deleted_by' => null
            ]);

            $res_folder = FolderModel::create([
                'id' => Generator::get_uuid(), 
                'project_id' => $id, 
                'folder_slug' => 'authentication',  
                'folder_name' => 'Authentication',  
                'folder_pin_code' => null, 
                'folder_desc' => null, 
                'created_at' => date('Y-m-d H:i:s'), 
                'created_by' => $user_id, 
                'updated_at' => null, 
                'updated_by' => null, 
                'deleted_at' => null, 
                'deleted_by' => null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'project created',
                'data' => [
                    'project' => $res_project,
                    'folder' => $res_folder
                ]
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
