<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IbuHamil;
use Carbon\Carbon;

class IbuHamilController extends Controller
{
    /**
     * Menampilkan daftar semua data ibu hamil.
     */
    public function index()
    {
        $ibuhampils = IbuHamil::orderBy('created_at', 'desc')->get();
        return view('data_ibu_hamil', compact('ibuhampils'));
    }

    /**
     * Menyimpan data ibu hamil baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data Input
        $request->validate([
            'nama_ibu' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|max:20|unique:ibu_hamils,nik',
            'nama_suami' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tgl_pemeriksaan_k6' => 'nullable|date',
            'jaminan_kesehatan' => 'required|string',
            'no_e_rekam_medis' => 'nullable|string|max:100',
        ]);

        try {
            // 2. Buat Data Baru
            IbuHamil::create($request->all());

            // 3. Redirect Sukses
            return redirect()->route('ibuHamil.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            // 4. Tangani Error (PERBAIKAN: Redirect ke ibuHamil.index, bukan barang.index)
            return redirect()->route('ibuHamil.index')->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate data ibu hamil yang sudah ada.
     */
    public function update(Request $request, $id) // Ubah parameter jadi $id agar lebih aman
    {
        // 1. Validasi Data Update
        $request->validate([
            'nama_ibu' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string|max:20|unique:ibu_hamils,nik,' . $id, // ID diambil dari parameter
            'nama_suami' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tgl_pemeriksaan_k6' => 'nullable|date',
            'jaminan_kesehatan' => 'required|string',
            'no_e_rekam_medis' => 'nullable|string|max:100',
        ]);

        try {
            // 2. Cari Data & Update
            $ibuhamil = IbuHamil::findOrFail($id);

            $ibuhamil->update([
                'nama_ibu' => $request->nama_ibu,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nik' => $request->nik,
                'nama_suami' => $request->nama_suami,
                'alamat' => $request->alamat,
                'tgl_pemeriksaan_k6' => $request->tgl_pemeriksaan_k6,
                'jaminan_kesehatan' => $request->jaminan_kesehatan,
                'no_e_rekam_medis' => $request->no_e_rekam_medis,
            ]);

            // 3. Redirect Sukses
            return redirect()->route('ibuHamil.index')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            // 4. Tangani Error (PERBAIKAN: Redirect ke ibuHamil.index)
            return redirect()->route('ibuHamil.index')->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data ibu hamil.
     */
    public function destroy($id) // Ubah parameter jadi $id
    {
        try {
            $ibuhamil = IbuHamil::findOrFail($id);
            $ibuhamil->delete();

            return redirect()->route('ibuHamil.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            // PERBAIKAN: Redirect ke ibuHamil.index
            return redirect()->route('ibuHamil.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
