<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        return view('admin.informasi.index');
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        // nanti simpan ke database
        return redirect()->route('informasi.index');
    }
}
