<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
   public function update(Request $request)
    {
    /** @var \App\Models\User $user */
            $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = $request->password; // auto hash dari model kamu ✅
        }

        $user->update($data);

        return back()->with('success', 'Profile berhasil diupdate');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $user = auth()->user();

        // hapus foto lama (opsional tapi bagus)
        if ($user->photo && file_exists(public_path('profile/'.$user->photo))) {
            unlink(public_path('profile/'.$user->photo));
        }

        $file = $request->file('photo');
        $filename = time().'.'.$file->getClientOriginalExtension();

        $file->move(public_path('profile'), $filename);

        $user->update([
            'photo' => $filename
        ]);

        return back()->with('success', 'Foto berhasil diupload');
    }
}
