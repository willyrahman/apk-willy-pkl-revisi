<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\IbuHamil;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index()
    {
        // Ambil data balita beserta data ibunya (eager loading)
        $balitas = Balita::with('ibuHamil')->orderBy('tgl_pemeriksaan', 'desc')->get();

        // Ambil semua data ibu hamil untuk dropdown
        $data_ibu = IbuHamil::orderBy('nama_ibu', 'asc')->get();

        return view('data_balita', compact('balitas', 'data_ibu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_hamil_id'        => 'required|exists:ibu_hamils,id',
            'no_e_rekam_medis'    => 'nullable|string',
            'nama_pasien'         => 'required|string',
            'nik'                 => 'required|numeric',
            'jenis_kelamin'       => 'required|in:L,P',
            'umur'                => 'required',
            'tgl_pemeriksaan'     => 'required|date',
            'alamat'              => 'required',
            'poli_ruangan'        => 'required',
            'dokter_tenaga_medis' => 'required',
            'berat_badan'         => 'required|numeric',
            'tinggi_badan'        => 'required|numeric',
            'suhu'                => 'nullable|numeric',
            'keluhan_utama'       => 'nullable|string',
            'diagnosa_1'          => 'nullable|string',
            'icd_x_1'             => 'nullable|string',
            'obat'                => 'nullable|string',
            'apoteker'            => 'nullable|string',
        ]);

        try {
            $data = $request->all();

            // Hitung IMT & Status Gizi (Sinkron dengan JS)
            $data['hasil_imt_status_gizi'] = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);

            Balita::create($data);

            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);

        // Validasi disesuaikan dengan semua inputan di modal Edit
        $request->validate([
            'ibu_hamil_id'        => 'required|exists:ibu_hamils,id',
            'no_e_rekam_medis'    => 'nullable|string',
            'nama_pasien'         => 'required|string',
            'nik'                 => 'required|numeric',
            'jenis_kelamin'       => 'required|in:L,P',
            'umur'                => 'required',
            'tgl_pemeriksaan'     => 'required|date',
            'alamat'              => 'required',
            'poli_ruangan'        => 'required',
            'dokter_tenaga_medis' => 'required',
            'berat_badan'         => 'required|numeric',
            'tinggi_badan'        => 'required|numeric',
            'suhu'                => 'nullable|numeric',
            'keluhan_utama'       => 'nullable|string',
            'diagnosa_1'          => 'nullable|string',
            'icd_x_1'             => 'nullable|string',
            'obat'                => 'nullable|string',
            'apoteker'            => 'nullable|string',
        ]);

        try {
            $data = $request->all();

            // Hitung ulang IMT jika ada perubahan berat atau tinggi
            $data['hasil_imt_status_gizi'] = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);

            $balita->update($data);

            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Balita::findOrFail($id)->delete();
            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('balita.index')->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Helper untuk menghitung IMT dan Status Gizi
     * Output: "22.50 (Gizi Baik)"
     */
    private function hitungIMT($berat, $tinggi)
    {
        if ($berat > 0 && $tinggi > 0) {
            $tinggiMeter = $tinggi / 100;
            $imt = $berat / ($tinggiMeter * $tinggiMeter);

            $status = '';
            if ($imt < 18.5) {
                $status = 'Gizi Kurang';
            } elseif ($imt >= 18.5 && $imt <= 25) {
                $status = 'Gizi Baik';
            } else {
                $status = 'Gizi Lebih';
            }

            return number_format($imt, 2) . ' (' . $status . ')';
        }
        return '-';
    }

    public function laporan(Request $request)
    {
        // 1. Mulai Query (dengan Eager Loading relasi ibuHamil)
        $query = Balita::with('ibuHamil');

        // 2. Logika Filter
        // Menggunakan kolom 'tgl_pemeriksaan' sesuai view Anda
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_pemeriksaan', [
                $request->tgl_awal,
                $request->tgl_akhir
            ]);
        }

        // 3. Ambil data (urutkan dari tanggal terbaru)
        $data = $query->orderBy('tgl_pemeriksaan', 'desc')->get();

        // 4. Return View
        // Pastikan file view disimpan di: resources/views/laporan/balita.blade.php
        return view('laporan.balita', [
            'data' => $data,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir
        ]);
    }
}
