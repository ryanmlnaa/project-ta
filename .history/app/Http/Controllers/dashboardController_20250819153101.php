<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $dashboard = 'Dashboard
        return view('admin.dashboard.index');
    }
}
