<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IuranController extends Controller
{
    public function index()
    {
        return view('admin.iuran.index');
    }

    public function create()
    {
        return view('admin.iuran.create');
    }

    public function store(Request $request)
    {
        // simpan data
    }

    public function edit($id)
    {
        // edit data
    }

    public function update(Request $request, $id)
    {
        // update data
    }

    public function destroy($id)
    {
        // hapus data
    }
}
