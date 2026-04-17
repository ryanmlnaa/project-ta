<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|confirmed|min:6'
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
    ];

    if ($request->password) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return back()->with('success', 'Profile berhasil diupdate');
}
