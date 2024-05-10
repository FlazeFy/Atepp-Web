<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\ProjectModel;
use App\Models\EndpointModel;

class Queries extends Controller
{
    public function get_all_project(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = ProjectModel::get_all_project($user_id,'');

            return response()->json([
                'status' => 'success',
                'message' => 'project fetched',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => $e->getMessage(),
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_all_project_dashboard(Request $request) 
    {
        try{
            $user_id = $request->user()->id;
            $ext = ',count(1) as total_endpoint,project.created_at,project_desc';

            $res = ProjectModel::get_all_project($user_id,$ext);

            return response()->json([
                'status' => 'success',
                'message' => 'project fetched',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'something wrong. Please contact admin',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_working_space(Request $request) 
    {
        try{
            $user_id = $request->user()->id;

            $res = EndpointModel::selectRaw('project_slug, project_title, project_category, project_desc, endpoint.id as endpoint_id, 
                    endpoint.project_id, folder_name, endpoint_name, endpoint_desc, endpoint_url,endpoint_method, endpoint.created_at, username as created_by,
                    ROUND(AVG(response_time),2) as avg_response_time, ROUND(MAX(response_time),2) as max_response_time, ROUND(MIN(response_time),2) as min_response_time')
                ->leftjoin('folder','folder.id','=','endpoint.folder_id')
                ->leftjoin('response','response.endpoint_id','=','endpoint.id')
                ->leftjoin('project','project.id','=','endpoint.project_id')
                ->leftjoin('user','user.id','=','endpoint.created_by')
                ->groupby('endpoint.id')
                ->orderby('project_title','ASC')
                ->orderby('endpoint.created_at','ASC')
                ->paginate(20);

            return response()->json([
                'status' => 'success',
                'message' => 'project fetched',
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
