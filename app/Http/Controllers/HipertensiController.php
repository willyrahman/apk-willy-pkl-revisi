<?php

namespace App\Http\Controllers;

use App\Models\Hipertensi;
use Illuminate\Http\Request;

class HipertensiController extends Controller
{
    /**
     * Menampilkan daftar pasien Hipertensi.
     */
    public function index()
    {
        $data_hipertensi = Hipertensi::orderBy('tanggal', 'desc')->get();
        return view('data_hipertensi', compact('data_hipertensi'));
    }

    /**
     * Menyimpan data pasien baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal' => 'required|date',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'jenis_kasus_1' => 'required|in:Baru,Lama',
            'skala_nyeri' => 'nullable|string|max:20',
            'no_e_rekam_medis' => 'nullable|string|max:100', // Kolom baru
        ]);

        // 2. Simpan Data
        try {
            Hipertensi::create($request->all());
            return redirect()->route('hipertensi.index')->with('success', 'Data Pasien Hipertensi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data pasien (Fungsi ini yang sebelumnya hilang).
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal' => 'required|date',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'jenis_kasus_1' => 'required|in:Baru,Lama',
            'skala_nyeri' => 'nullable|string|max:20',
            'no_e_rekam_medis' => 'nullable|string|max:100',
        ]);

        // 2. Update Data
        try {
            $item = Hipertensi::findOrFail($id);
            $item->update($request->all());
            return redirect()->route('hipertensi.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data pasien.
     */
    public function destroy($id)
    {
        try {
            $item = Hipertensi::findOrFail($id);
            $item->delete();
            return redirect()->route('hipertensi.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function laporan(Request $request)
    {
        // 1. Mulai Query
        $query = Hipertensi::query();

        // 2. Logika Filter
        // Kita gunakan kolom 'tanggal' sesuai dengan yang ada di view Anda
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tanggal', [
                $request->tgl_awal,
                $request->tgl_akhir
            ]);
        }

        // 3. Ambil data (urutkan dari tanggal terbaru)
        $data = $query->orderBy('tanggal', 'desc')->get();

        // 4. Return View
        // Pastikan nama file sesuai lokasi: resources/views/laporan/hipertensi.blade.php
        return view('laporan.hipertensi', [
            'data' => $data,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir
        ]);
    }
}
