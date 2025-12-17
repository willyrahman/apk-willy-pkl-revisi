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
        $balitas = Balita::with('ibuHamil')->orderBy('created_at', 'desc')->get();

        // Ambil semua data ibu hamil untuk dropdown form tambah
        $data_ibu = IbuHamil::orderBy('nama_ibu', 'asc')->get();

        return view('data_balita', compact('balitas', 'data_ibu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_hamil_id' => 'required|exists:ibu_hamils,id',
            'nama_pasien' => 'required',
            'nik' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'tgl_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'suhu' => 'required|numeric',
        ]);

        try {
            // Ambil semua data input
            $data = $request->all();

            // HITUNG IMT DI BACKEND
            // Kita hitung otomatis agar data 'hasil_imt_status_gizi' terisi valid
            $data['hasil_imt_status_gizi'] = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);

            Balita::create($data);

            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('balita.index')->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $balita = Balita::findOrFail($id);

        $request->validate([
            'ibu_hamil_id' => 'required|exists:ibu_hamils,id',
            'nama_pasien' => 'required',
            'nik' => 'required|numeric',
            // Validasi berat dan tinggi jika diubah
            'berat_badan' => 'numeric',
            'tinggi_badan' => 'numeric',
        ]);

        try {
            $data = $request->all();

            // Hitung ulang IMT jika Berat atau Tinggi diubah
            if ($request->has('berat_badan') && $request->has('tinggi_badan')) {
                $data['hasil_imt_status_gizi'] = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);
            }

            $balita->update($data);

            return redirect()->route('balita.index')->with('success', 'Data Balita berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('balita.index')->with('error', 'Gagal update: ' . $e->getMessage());
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
     * Fungsi Helper untuk Menghitung IMT
     * Rumus: Berat (kg) / (Tinggi (m) * Tinggi (m))
     */
    private function hitungIMT($berat, $tinggi)
    {
        if ($berat > 0 && $tinggi > 0) {
            // Konversi tinggi dari cm ke meter
            $tinggiMeter = $tinggi / 100;

            // Hitung rumus
            $imt = $berat / ($tinggiMeter * $tinggiMeter);

            // Kembalikan hasil dengan 2 angka di belakang koma
            return number_format($imt, 2, '.', '');
        }
        return 0;
    }
}
