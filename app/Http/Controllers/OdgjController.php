<?php

namespace App\Http\Controllers;

use App\Models\Odgj;
use PDF; // Pastikan library PDF dipanggil (barryvdh/laravel-dompdf)
use Illuminate\Http\Request;

class OdgjController extends Controller
{
    /**
     * Menampilkan daftar pasien ODGJ.
     */
    public function index()
    {
        $odgjs = Odgj::orderBy('created_at', 'desc')->get();

        // PERBAIKAN: Gunakan 'tb_odgj' karena nama file Anda belum diubah
        return view('data_odgj', compact('odgjs'));
    }

    /**
     * Menyimpan data pasien baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:odgjs,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'status_pasien' => 'required|in:Lama,Baru',
            'jadwal_kontrol' => 'required|string',
            'diagnosis' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_kontrol' => 'nullable|date',
            'no_e_rekam_medis' => 'nullable|string|max:100',
        ]);

        // 2. Simpan Data
        try {
            Odgj::create($request->all());
            return redirect()->route('odgj.index')->with('success', 'Data Pasien ODGJ berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate data pasien.
     */
    public function update(Request $request, $id)
    {
        // Cari data berdasarkan ID
        $odgj = Odgj::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            // Validasi unik NIK dikecualikan untuk ID pasien ini sendiri
            'nik' => 'required|numeric|digits:16|unique:odgjs,nik,' . $id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'status_pasien' => 'required|in:Lama,Baru',
            'jadwal_kontrol' => 'required|string',
            'diagnosis' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_kontrol' => 'nullable|date',
            'no_e_rekam_medis' => 'nullable|string|max:100',
        ]);

        // 2. Update Data
        try {
            $odgj->update($request->all());
            return redirect()->route('odgj.index')->with('success', 'Data Pasien berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data pasien.
     */
    public function destroy($id)
    {
        try {
            $odgj = Odgj::findOrFail($id);
            $odgj->delete();
            return redirect()->route('odgj.index')->with('success', 'Data Pasien berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function cetakPdf(Request $request)
    {
        // 1. AMBIL INPUT TANGGAL DARI FORM
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        // 2. QUERY DATA
        $query = Odgj::query();

        // Jika user memfilter tanggal, lakukan filter query
        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('tanggal_kontrol', [$tgl_awal, $tgl_akhir]);
        }

        $data = $query->orderBy('tanggal_kontrol', 'desc')->get();
        $judul = 'Laporan Data Pasien ODGJ';

        // 3. LOAD PDF (PENTING: Pastikan $tgl_awal dan $tgl_akhir masuk ke compact)
        $pdf = PDF::loadView('laporan_pdf', compact('data', 'judul', 'tgl_awal', 'tgl_akhir'));

        return $pdf->stream('laporan_odgj.pdf');
    }

    /**
     * Menampilkan halaman Laporan dengan Filter Tanggal Kontrol.
     * Pastikan route 'laporan.odgj' mengarah ke method ini.
     */
    public function laporan(Request $request)
    {
        $query = Odgj::query();

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tanggal_kontrol', [$request->tgl_awal, $request->tgl_akhir]);
        }

        $data = $query->orderBy('tanggal_kontrol', 'desc')->get();

        // PERBAIKAN: Tambahkan 'laporan.' karena file ada di dalam folder laporan
        return view('laporan.odgj', [
            'data' => $data,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir
        ]);
    }
}
