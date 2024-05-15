<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DummyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dummy.index')
            ->with('active_page','dummy');
    }
}
