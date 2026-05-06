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

      // ================= PROFIL =================

    public function profil()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = User::find(Auth::id());

        $request->validate([
            'name'                  => 'required|string|max:255',
            'username'              => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'                 => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'              => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable',
        ]);

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

       // ❌ SEBELUM (redirect ke home)
       return redirect()->route('user.home')->with('success', 'Profile berhasil diupdate');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        /** @var \App\Models\User $user */
            $user = Auth::user();

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

        return back()->with('success', 'Data berhasil diubah');
    }

    // ================= PROFIL RT =================

public function rtProfil()
{
    return view('profile.edit', [
        'user' => Auth::user()
    ]);
}

    public function rtUpdateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = User::find(Auth::id());

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'photo'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle upload foto jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path('profile/' . $user->photo))) {
                unlink(public_path('profile/' . $user->photo));
            }
            $file     = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->route('rt.profil')->with('success', 'Profile berhasil diupdate');
    }

    // ================= PROFIL RT =================

        public function editProfile()
    {
        $user = Auth::user();
        return view('rt.profile.edit', compact('user')); // ✅ ganti ini
    }

     public function updateprofile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = User::find(Auth::id());

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->email    = $request->email;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return back()->with('success', 'Profile berhasil diupdate');
    }

        public function uploadPhotoRT(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->photo && file_exists(public_path('profile/' . $user->photo))) {
            unlink(public_path('profile/' . $user->photo));
        }

        $file     = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('profile'), $filename);

        $user->photo = $filename;
        $user->save();

        return back()->with('success', 'Foto berhasil diupload');
    }
}
