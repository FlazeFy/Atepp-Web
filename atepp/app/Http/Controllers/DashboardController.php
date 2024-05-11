<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!session()->get('comment_mode_key')){
            session()->put('comment_mode_key', "false");
        }

        return view('dashboard.index')
            ->with('active_page','dashboard');
    }
}
