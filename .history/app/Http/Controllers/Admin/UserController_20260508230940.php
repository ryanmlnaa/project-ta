<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\auth;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('admin.user.index', compact('user'));
    }

    // FORM CREATE
    public function create()
    {
        if(Auth::user()->role != 'admin'){
            abort(403);
        }

        return view('admin.user.create');
    }

// SIMPAN DATA
    public function store(Request $request)
    {
            if(Auth::user()->role != 'admin'){
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:rt' // 🔥 hanya boleh RT
        ]);

        // 🔥 VALIDASI TAMBAHAN (ANTI NAKAL)
        if ($request->role != 'rt') {
            return back()->with('error', 'Hanya boleh menambahkan role RT!');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->email, // biar aman
            'password' => bcrypt($request->password),
            'role' => 'rt'
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User RT berhasil ditambahkan');
    }

    // 🔥 FORM EDIT
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // 🔥 UPDATE DATA
    // 🔥 UPDATE DATA
    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'role'     => 'required|in:admin,rt,user',
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
        ]);

        $user->update([
            'name'     => $request->name,
            'role'     => $request->role,
            'username' => $request->username,
            // ❌ email TIDAK diupdate karena field locked/disabled
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'Data user berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}
