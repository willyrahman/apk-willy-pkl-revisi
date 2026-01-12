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

    public function laporan(Request $request)
    {
        // 1. Mulai Query
        $query = IbuHamil::query();

        // 2. Logika Filter
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            // Filter berdasarkan Tanggal Pemeriksaan K6
            $query->whereBetween('tgl_pemeriksaan_k6', [
                $request->tgl_awal,
                $request->tgl_akhir
            ]);
        }

        // 3. Ambil data (urutkan dari yang terbaru)
        $data = $query->orderBy('tgl_pemeriksaan_k6', 'desc')->get();

        // 4. Return View
        // PENTING: Sesuaikan nama view dengan lokasi file Anda.
        // Jika file ada di folder resources/views/laporan/ibuHamil.blade.php
        return view('laporan.ibu_hamil', [
            'data' => $data,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir
        ]);
    }

    public function exportPdf(Request $request, $jenis)
    {
        // 1. TANGKAP INPUT TANGGAL (PENTING!)
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        // ... (Logika Switch Case Query Anda di sini) ...
        // Contoh untuk Ibu Hamil:
        if ($jenis == 'ibuHamil') {
            $query = \App\Models\IbuHamil::query();
            if ($tgl_awal && $tgl_akhir) {
                $query->whereBetween('tgl_pemeriksaan_k6', [$tgl_awal, $tgl_akhir]);
            }
            $data = $query->get();
            $judul = 'Laporan Data Ibu Hamil';
            $view = 'laporan.pdf_view'; // Sesuaikan nama file view PDF Anda
        }
        // ... (Logika jenis lain) ...

        // 2. KIRIM DATA KE VIEW (Pastikan tgl_awal & tgl_akhir masuk compact)
        $pdf = PDF::loadView($view, compact('data', 'judul', 'tgl_awal', 'tgl_akhir'));

        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan.pdf');
    }
}
