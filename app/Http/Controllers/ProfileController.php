<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // SAYA TAMBAHKAN 'gif' DI SINI
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // SAYA TAMBAHKAN 'gif' DI SINI JUGA
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB buat GIF
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 1. Simpan Avatar (PP)
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // 2. Simpan Banner
        if ($request->hasFile('banner')) {
            if ($user->banner && Storage::disk('public')->exists($user->banner)) {
                Storage::disk('public')->delete($user->banner);
            }
            $user->banner = $request->file('banner')->store('banners', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}