<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    // Menampilkan data petugas
    public function index()
    {
        $petugas = User::all();
        return view('tb_petugas', compact('petugas'));
    }

    // Menyimpan data petugas baru
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // Pastikan input di HTML bernama 'password_confirmation'
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:operator,admin,kepala',
        ]);

        // 2. Simpan ke Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Wajib Hash
            'role' => $request->role,
        ]);

        // 3. Kembali ke halaman dengan pesan sukses
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan');
    }
    // Mengupdate data petugas
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:operator,admin,kepala',
        ]);

        $petugas = User::findOrFail($id);
        $petugas->name = $request->name;
        $petugas->email = $request->email;

        // Update password jika ada, tanpa hashing
        if ($request->password) {
            $petugas->password = $request->password; 
        }

        $petugas->role = $request->role;
        $petugas->save();

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil diupdate');
    }

    // Menghapus data petugas
    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus');
    }
}
