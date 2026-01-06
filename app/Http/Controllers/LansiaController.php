<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\Hipertensi;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    /**
     * Menampilkan daftar data lansia.
     */
    public function index()
    {
        // Eager load relasi hipertensi untuk performa query yang lebih cepat
        $lansias = Lansia::with('hipertensi')->orderBy('tanggal_kunjungan', 'desc')->get();

        // Data untuk dropdown di modal tambah/edit
        // PENTING: Nama variabel ini harus sama dengan yang ada di View (@foreach($hipertensis ...))
        $hipertensis = Hipertensi::orderBy('nama_pasien', 'asc')->get();

        return view('data_lansia', compact('lansias', 'hipertensis'));
    }

    /**
     * Menyimpan data lansia baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'no_e_rekam_medis' => 'nullable|string|max:100',
            'hipertensi_id' => 'nullable|exists:hipertensis,id', // Validasi Relasi
            'tanggal_kunjungan' => 'required|date',
            'nik' => 'required|numeric|digits_between:10,20',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'kelurahan' => 'nullable|string',

            // Fisik
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'lingkar_perut' => 'nullable|numeric',

            // Lab
            'sistole' => 'nullable|integer',
            'diastole' => 'nullable|integer',
            'gds' => 'nullable|integer',
            'kolesterol' => 'nullable|integer',

            // Screening & Gaya Hidup
            'merokok' => 'nullable|string',
            'depresi' => 'nullable|string',
            'kurang_makan_sayur_buah' => 'nullable|string',
            'kurang_aktifitas_fisik' => 'nullable|string',
            'tingkat_kemandirian' => 'nullable|string',
            'gangguan_mental' => 'nullable|string',
            'status_emosional' => 'nullable|string',

            // Riwayat
            'riwayat_penyakit_sendiri' => 'nullable|string',
            'riwayat_penyakit_keluarga' => 'nullable|string',
        ]);

        try {
            // 2. Hitung Otomatis IMT & Status Gizi di Server
            $hasilHitung = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);
            $validatedData['imt'] = $hasilHitung['imt'];
            $validatedData['status_gizi'] = $hasilHitung['status_gizi'];

            // 3. Simpan ke Database
            Lansia::create($validatedData);

            return redirect()->route('lansia.index')->with('success', 'Data Lansia berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('lansia.index')->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data lansia.
     */
    public function update(Request $request, $id)
    {
        $lansia = Lansia::findOrFail($id);

        // 1. Validasi Input
        $validatedData = $request->validate([
            'no_e_rekam_medis' => 'nullable|string|max:100',
            'hipertensi_id' => 'nullable|exists:hipertensis,id', // Validasi Relasi
            'tanggal_kunjungan' => 'required|date',
            'nik' => 'required|numeric',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'lingkar_perut' => 'nullable|numeric',
            'sistole' => 'nullable|integer',
            'diastole' => 'nullable|integer',
            'gds' => 'nullable|integer',
            'kolesterol' => 'nullable|integer',
            'merokok' => 'nullable|string',
            'depresi' => 'nullable|string',
            'kurang_makan_sayur_buah' => 'nullable|string',
            'kurang_aktifitas_fisik' => 'nullable|string',
            'tingkat_kemandirian' => 'nullable|string',
            'gangguan_mental' => 'nullable|string',
            'status_emosional' => 'nullable|string',
            'riwayat_penyakit_sendiri' => 'nullable|string',
            'riwayat_penyakit_keluarga' => 'nullable|string',
        ]);

        try {
            // 2. Hitung Ulang IMT jika diedit
            $hasilHitung = $this->hitungIMT($request->berat_badan, $request->tinggi_badan);
            $validatedData['imt'] = $hasilHitung['imt'];
            $validatedData['status_gizi'] = $hasilHitung['status_gizi'];

            // 3. Update Data
            $lansia->update($validatedData);

            return redirect()->route('lansia.index')->with('success', 'Data Lansia berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('lansia.index')->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data lansia.
     */
    public function destroy($id)
    {
        try {
            Lansia::findOrFail($id)->delete();
            return redirect()->route('lansia.index')->with('success', 'Data Lansia berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('lansia.index')->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Hitung IMT
     */
    private function hitungIMT($berat, $tinggi)
    {
        if ($berat > 0 && $tinggi > 0) {
            $tinggiMeter = $tinggi / 100;
            $imt = $berat / ($tinggiMeter * $tinggiMeter);
            $imt = round($imt, 2);

            $status = "";
            if ($imt < 18.5) {
                $status = "Kurus (Kekurangan berat badan)";
            } elseif ($imt >= 18.5 && $imt <= 25) {
                $status = "Normal (Ideal)";
            } elseif ($imt > 25 && $imt <= 27) {
                $status = "Gemuk (Kelebihan berat badan ringan)";
            } else {
                $status = "Obesitas (Kelebihan berat badan berat)";
            }

            return ['imt' => $imt, 'status_gizi' => $status];
        }
        return ['imt' => 0, 'status_gizi' => '-'];
    }
}
