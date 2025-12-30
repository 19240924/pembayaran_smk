<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman pengaturan profil
     * Digunakan oleh admin / kepsek (dan bisa dikembangkan untuk role lain)
     */
    public function index()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Tampilkan halaman profil admin
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Proses update data profil (nama & email)
     */
    public function updateProfile(Request $request)
    {
        // Validasi input profil
        $request->validate([
            'name'  => 'required|string|max:255',
            // Email harus unik, kecuali milik user yang sedang login
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        // Update data user login
        Auth::user()->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Kembali ke halaman profil dengan pesan sukses
        return back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Proses update password
     */
    public function updatePassword(Request $request)
    {
        // Validasi input password
        $request->validate([
            'old_password' => 'required',                 // Password lama wajib diisi
            'password'     => 'required|min:8|confirmed', // Password baru + konfirmasi
        ]);

        // Cek apakah password lama sesuai dengan database
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors([
                'old_password' => 'Password lama tidak sesuai'
            ]);
        }

        // Update password baru (di-hash)
        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Password berhasil diubah');
    }
}
