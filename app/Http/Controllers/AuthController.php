<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // <--- WAJIB TAMBAHKAN INI

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // 1. Cari user berdasarkan email
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user) {
            // 2. Cek Password: Apakah cocok dengan Hash? ATAU apakah cocok dengan Plain Text?
            // Ini membuat akun lama (polos) dan akun baru (hash) sama-sama bisa masuk.
            if (Hash::check($credentials['password'], $user->password) || $user->password === $credentials['password']) {

                // (Opsional) Fitur Otomatis: Jika password masih polos, update jadi Hash biar aman
                if (!Hash::check($credentials['password'], $user->password)) {
                    $user->password = Hash::make($credentials['password']);
                    $user->save();
                }

                // 3. Login User
                Auth::login($user);

                // 4. Logika Redirect (Sesuai perbaikan sebelumnya)
                // Jika Operator -> Scan
                if ($user->role == 'operator') {
                    return redirect('/dashboard');
                }

                // Admin, Petugas, Kepala -> Dashboard
                return redirect('/dashboard');
            }
        }

        // Jika user tidak ketemu atau password salah dua-duanya
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
