<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('project.index')
            ->with('active_page','project');
    }

    public function set_open_project(Request $request){
        $request->session()->put('project_key', $request->project_slug);

        return redirect()->back();
    }
}
