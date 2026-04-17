<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::all();
        return view('admin.penghuni.index', compact('penghuni'));
    }
}
