<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Tampilkan Halaman Edit Profil
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    // Proses Update Profil
    public function update(Request $request)
    {
        $user = Auth::user(); // Ambil data user yang sedang login

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'password' => 'nullable|min:6|confirmed', // Optional ganti password
        ]);

        // 1. Update Nama & Email
        $user->name = $request->name;
        $user->email = $request->email;

        // 2. Update Password (Jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 3. Update Foto Profil (Avatar)
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada (bukan foto default)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save(); // Simpan ke database

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function show($id)
{
    // Cari user berdasarkan ID, jika tidak ada tampilkan 404
    $user = \App\Models\User::findOrFail($id);
    
    return view('profile.show', compact('user'));
}
}