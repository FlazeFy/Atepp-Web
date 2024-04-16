<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\FolderModel;

class Queries extends Controller
{
    public function get_folder_by_project_slug($slug) 
    {
        try{
            $res = FolderModel::get_folder_by_context('project_slug',$slug);

            return response()->json([
                'status' => 'success',
                'message' => 'project fetched',
                'data' => $res
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
