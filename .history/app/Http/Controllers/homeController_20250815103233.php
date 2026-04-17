<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    puublic function index()
    {
        return view('home');
    }
}
