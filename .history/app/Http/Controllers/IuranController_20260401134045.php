<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class IuranController extends Controller
{
    public function index()
    {
        $iuran = Iuran::all(); // ambil data dari database
        return view('admin.iuran.index', compact('iuran'));
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
