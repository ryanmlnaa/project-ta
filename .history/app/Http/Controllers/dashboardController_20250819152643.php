<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class dashboardController extends Controller
{
    public function index()
    {
        $penghuni = Dashboard::all();
        return view('admin.penghuni.index', compact('penghuni'));
    }
}
