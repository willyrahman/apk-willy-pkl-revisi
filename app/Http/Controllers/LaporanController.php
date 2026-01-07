<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Import semua Model
use App\Models\IbuHamil;
use App\Models\Odgj;
use App\Models\Hipertensi;
use App\Models\Balita;
use App\Models\Lansia;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF Library

class LaporanController extends Controller
{
    // --- 1. LAPORAN IBU HAMIL ---
    public function ibuHamil(Request $request)
    {
        $query = IbuHamil::query();
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('created_at', [$request->tgl_awal, $request->tgl_akhir]);
        }
        $data = $query->orderBy('created_at', 'desc')->get();

        return view('laporan.ibu_hamil', compact('data'));
    }

    // --- 2. LAPORAN ODGJ ---
    public function odgj(Request $request)
    {
        $query = Odgj::query();
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('created_at', [$request->tgl_awal, $request->tgl_akhir]);
        }
        $data = $query->orderBy('created_at', 'desc')->get();

        return view('laporan.odgj', compact('data'));
    }

    // --- 3. LAPORAN HIPERTENSI ---
    public function hipertensi(Request $request)
    {
        $query = Hipertensi::query();
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tanggal', [$request->tgl_awal, $request->tgl_akhir]);
        }
        $data = $query->orderBy('tanggal', 'desc')->get();

        return view('laporan.hipertensi', compact('data'));
    }

    // --- 4. LAPORAN BALITA ---
    public function balita(Request $request)
    {
        $query = Balita::with('ibuHamil');
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_pemeriksaan', [$request->tgl_awal, $request->tgl_akhir]);
        }
        $data = $query->orderBy('tgl_pemeriksaan', 'desc')->get();

        return view('laporan.balita', compact('data'));
    }

    // --- 5. LAPORAN LANSIA ---
    public function lansia(Request $request)
    {
        $query = Lansia::with('hipertensi');
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tanggal_kunjungan', [$request->tgl_awal, $request->tgl_akhir]);
        }
        $data = $query->orderBy('tanggal_kunjungan', 'desc')->get();

        return view('laporan.lansia', compact('data'));
    }

    // --- FITUR EXPORT EXCEL ---
    public function exportExcel(Request $request, $jenis)
    {
        $data = [];
        $view = '';
        $judul = ''; // Tambahkan variabel judul untuk Excel

        switch ($jenis) {
            case 'ibuHamil':
                $query = IbuHamil::query();
                if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
                    $query->whereBetween('created_at', [$request->tgl_awal, $request->tgl_akhir]);
                }
                $data = $query->orderBy('created_at', 'desc')->get();
                $view = 'laporan.exports.ibu_hamil';
                $judul = 'LAPORAN DATA IBU HAMIL';
                break;

            case 'odgj':
                $query = Odgj::query();
                if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
                    $query->whereBetween('created_at', [$request->tgl_awal, $request->tgl_akhir]);
                }
                $data = $query->orderBy('created_at', 'desc')->get();
                $view = 'laporan.exports.odgj';
                $judul = 'LAPORAN DATA ODGJ';
                break;

            case 'hipertensi':
                $query = Hipertensi::query();
                if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
                    $query->whereBetween('tanggal', [$request->tgl_awal, $request->tgl_akhir]);
                }
                $data = $query->orderBy('tanggal', 'desc')->get();
                $view = 'laporan.exports.hipertensi';
                $judul = 'LAPORAN DATA HIPERTENSI';
                break;

            case 'balita':
                $query = Balita::with('ibuHamil');
                if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
                    $query->whereBetween('tgl_pemeriksaan', [$request->tgl_awal, $request->tgl_akhir]);
                }
                $data = $query->orderBy('tgl_pemeriksaan', 'desc')->get();
                $view = 'laporan.exports.balita';
                $judul = 'LAPORAN DATA BALITA';
                break;

            case 'lansia':
                $query = Lansia::with('hipertensi');
                if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
                    $query->whereBetween('tanggal_kunjungan', [$request->tgl_awal, $request->tgl_akhir]);
                }
                $data = $query->orderBy('tanggal_kunjungan', 'desc')->get();
                $view = 'laporan.exports.lansia';
                $judul = 'LAPORAN DATA LANSIA';
                break;

            default:
                return redirect()->back()->with('error', 'Jenis laporan tidak ditemukan.');
        }

        // PENTING: Bersihkan buffer output sebelum download agar file tidak corrupt
        if (ob_get_length()) ob_end_clean();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_{$jenis}_" . date('Y-m-d') . ".xls");

        // Kirim $judul ke view excel juga
        return view($view, compact('data', 'judul'));
    }

    // --- FITUR EXPORT PDF ---
    public function exportPdf(Request $request, $jenis)
    {
        // 1. AMBIL VARIABEL TANGGAL DARI REQUEST (PENTING!)
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        $data = [];
        $judul = "";
        $view = "";

        // Setting Memory & Time Limit
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        switch ($jenis) {
            case 'ibuHamil':
                $query = IbuHamil::query();
                if ($tgl_awal && $tgl_akhir) {
                    $query->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
                }
                $data = $query->orderBy('created_at', 'desc')->get();
                $judul = "Laporan Data Ibu Hamil";
                $view = 'laporan.pdf.ibu_hamil';
                break;

            case 'odgj':
                $query = Odgj::query();
                if ($tgl_awal && $tgl_akhir) {
                    // PERBAIKAN 1: Filter berdasarkan 'tanggal_kontrol', BUKAN 'created_at'
                    // Agar sesuai dengan filter di halaman web
                    $query->whereBetween('tanggal_kontrol', [$tgl_awal, $tgl_akhir]);
                }
                // Urutkan juga berdasarkan tanggal kontrol
                $data = $query->orderBy('tanggal_kontrol', 'desc')->get();
                $judul = "Laporan Data ODGJ";
                $view = 'laporan.pdf.odgj';
                break;

            case 'hipertensi':
                $query = Hipertensi::query();
                if ($tgl_awal && $tgl_akhir) {
                    $query->whereBetween('tanggal', [$tgl_awal, $tgl_akhir]);
                }
                $data = $query->orderBy('tanggal', 'desc')->get();
                $judul = "Laporan Data Hipertensi";
                $view = 'laporan.pdf.hipertensi';
                break;

            case 'balita':
                $query = Balita::with('ibuHamil');
                if ($tgl_awal && $tgl_akhir) {
                    $query->whereBetween('tgl_pemeriksaan', [$tgl_awal, $tgl_akhir]);
                }
                $data = $query->orderBy('tgl_pemeriksaan', 'desc')->get();
                $judul = "Laporan Data Balita";
                $view = 'laporan.pdf.balita';
                break;

            case 'lansia':
                $query = Lansia::with('hipertensi');
                if ($tgl_awal && $tgl_akhir) {
                    $query->whereBetween('tanggal_kunjungan', [$tgl_awal, $tgl_akhir]);
                }
                $data = $query->orderBy('tanggal_kunjungan', 'desc')->get();
                $judul = "Laporan Data Lansia";
                $view = 'laporan.pdf.lansia';
                break;

            default:
                return redirect()->back()->with('error', 'Jenis laporan tidak ditemukan.');
        }

        // 2. KIRIM VARIABEL TANGGAL KE DALAM COMPACT (SOLUSI ERROR ANDA)
        $pdf = Pdf::loadView($view, compact('data', 'judul', 'tgl_awal', 'tgl_akhir'));

        // Aktifkan remote enabled agar gambar dari public_path terbaca
        $pdf->setOptions(['isRemoteEnabled' => true]);
        $pdf->setPaper('A4', 'landscape');

        // Gunakan stream() dulu untuk melihat hasilnya di browser (memudahkan debug)
        // Jika sudah fix, baru ganti ke download()
        return $pdf->stream("Laporan_{$jenis}_" . date('Y-m-d') . ".pdf");
    }
}
