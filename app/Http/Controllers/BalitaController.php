<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\IbuHamil;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index()
    {
        $balitas = Balita::with('ibuHamil')->orderBy('tgl_pemeriksaan', 'desc')->get();
        $data_ibu = IbuHamil::orderBy('nama_ibu', 'asc')->get();

        return view('data_balita', compact('balitas', 'data_ibu'));
    }

    public function store(Request $request)
    {
        // 1. VALIDASI DIPERBAIKI (Nullable untuk data yang tidak wajib)
        $validated = $request->validate([
            'ibu_hamil_id' => 'required|exists:ibu_hamils,id',
            'no_e_rekam_medis' => 'nullable',
            'nama_pasien' => 'required',
            'nik' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'tgl_pemeriksaan' => 'required|date',
            'umur' => 'required', // Bisa string "2 Tahun 3 Bulan" atau integer
            'alamat' => 'nullable', // Diubah jadi nullable

            // Fisik
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'suhu' => 'nullable|numeric', // Diubah jadi nullable

            // Medis (Nullable semua agar tidak error jika kosong)
            'keluhan_utama' => 'nullable',
            'diagnosa_1' => 'nullable',
            'icd_x_1' => 'nullable',
            'obat' => 'nullable',
            'apoteker' => 'nullable',
            'dokter_tenaga_medis' => 'nullable',
            'poli_ruangan' => 'nullable',
        ]);

        try {
            // 2. HITUNG IMT & STATUS GIZI (LENGKAP DENGAN TEXT)
            $hasilImt = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);

            // Masukkan hasil hitungan ke array data
            $data = $request->all();
            $data['hasil_imt_status_gizi'] = $hasilImt;

            // 3. SIMPAN KE DATABASE
            Balita::create($data);

            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tampilkan error spesifik jika gagal
            return redirect()->back()
                ->withInput() // Kembalikan inputan user agar tidak mengetik ulang
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);

        $request->validate([
            'ibu_hamil_id' => 'required',
            'nama_pasien' => 'required',
            'nik' => 'required|numeric',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
        ]);

        try {
            $data = $request->all();

            // Hitung ulang IMT jika berat/tinggi diubah
            if ($request->filled('berat_badan') && $request->filled('tinggi_badan')) {
                $data['hasil_imt_status_gizi'] = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);
            }

            $balita->update($data);

            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Balita::findOrFail($id)->delete();
            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('balita.index')->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Hitung IMT Lengkap dengan Status
     * Format Output: "16.5 (Gizi Baik)"
     */
    private function hitungIMT($berat, $tinggi)
    {
        if ($berat > 0 && $tinggi > 0) {
            $tinggiMeter = $tinggi / 100;
            $imt = $berat / ($tinggiMeter * $tinggiMeter);
            $imtFormatted = number_format($imt, 2, '.', '');

            // Logika Status Gizi (Standar WHO Sederhana)
            $status = "";
            if ($imt < 18.5) {
                $status = "Gizi Kurang";
            } elseif ($imt >= 18.5 && $imt <= 25) {
                $status = "Gizi Baik";
            } else {
                $status = "Gizi Lebih";
            }

            return "$imtFormatted ($status)";
        }
        return "0 (Tidak Diketahui)";
    }
}
