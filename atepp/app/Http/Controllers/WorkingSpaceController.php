<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkingSpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('workingspace.index')
            ->with('active_page','workingspace');
    }
}
