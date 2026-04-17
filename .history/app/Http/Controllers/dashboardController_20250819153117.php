<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $dashboard = Dashboard::all();
        return view('admin.dashboard.index');
    }
}
