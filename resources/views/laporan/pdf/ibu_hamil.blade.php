<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $judul }}</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 11px;
            /* Ukuran font sedikit diperkecil agar muat */
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 landscape;
            margin: 10mm 15mm;
        }

        /* ===== KOP SURAT ===== */
        .kop-table {
            width: 100%;
            border-bottom: 3px solid #000;
            margin-bottom: 2px;
        }

        .kop-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .kop-logo {
            width: 80px;
            text-align: left;
        }

        .kop-text {
            text-align: center;
            padding-right: 80px;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
            font-style: italic;
        }

        .garis-tipis {
            border-top: 1px solid #000;
            margin-bottom: 10px;
        }

        /* ===== JUDUL & PERIODE ===== */
        .judul-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .judul {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14px;
            text-decoration: underline;
            margin-bottom: 5px;
        }

        .periode {
            font-size: 12px;
            font-style: italic;
        }

        /* ===== TABEL DATA ===== */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Agar lebar kolom konsisten */
        }

        .tabel-data th,
        .tabel-data td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
            word-wrap: break-word;
            /* Agar teks panjang turun ke bawah */
        }

        .tabel-data th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
            height: 30px;
            font-size: 11px;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        /* ===== TTD ===== */
        .ttd-container {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
            /* Mencegah TTD terpotong ke halaman baru */
        }

        .ttd-table {
            width: 100%;
            border: none;
        }

        .ttd-table td {
            border: none;
            text-align: center;
            font-size: 12px;
        }

        .periode {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    {{-- ================= KOP SURAT ================= --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <?php
                $path = public_path('images/logo.png');
                $base64 = ''; // Inisialisasi variabel agar tidak error

                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);

                    // PERBAIKAN: Ganti nama variabel '$data' menjadi '$imageData'
                    // Agar tidak menimpa variabel $data utama dari controller
                    $imageData = file_get_contents($path);

                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($imageData);
                }
                ?>

                @if($base64)
                <img src="{{ $base64 }}" width="70px" height="auto" alt="Logo">
                @else
                <span style="color:red; font-size:10px;">Logo Not Found</span>
                @endif
            </td>
            <td class="kop-text">
                <h2>PEMERINTAH KOTA BANJARMASIN</h2>
                <h3>DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT</h3>
                <p>Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah</p>
                <p>Kota Banjarmasin, Kalimantan Selatan. Telp: (0511) 123456</p>
            </td>
        </tr>
    </table>
    <div class="garis-tipis"></div>

    {{-- ================= JUDUL & PERIODE ================= --}}
    <div class="judul-container">
        <div class="judul">{{ $judul }}</div>

        {{-- SOLUSI PERIODE: Tampilkan hanya jika variabel tidak kosong --}}
        @if($tgl_awal != null && $tgl_akhir != null)
        <div class="periode" style="text-align: center; font-size: 12px; margin-bottom: 10px;">
            Periode: {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }}
            s/d
            {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
        </div>
        @endif
    </div>

    {{-- ================= TABEL DATA ================= --}}
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">No e-RM</th>
                <th width="10%">Tgl Periksa K6</th>
                <th width="15%">Nama Ibu Hamil</th>
                <th width="10%">Tgl Lahir</th>
                <th width="11%">NIK</th>
                <th width="12%">Nama Suami</th>
                <th width="18%">Alamat</th>
                <th width="10%">Jaminan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="center">{{ $item->no_e_rekam_medis ?? '-' }}</td>
                <td class="center">
                    {{ $item->tgl_pemeriksaan_k6 ? \Carbon\Carbon::parse($item->tgl_pemeriksaan_k6)->format('d-m-Y') : '-' }}
                </td>
                <td class="left">{{ $item->nama_ibu }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>
                <td class="center">{{ $item->nik }}</td>
                <td class="left">{{ $item->nama_suami }}</td>
                <td class="left">{{ $item->alamat }}</td>
                <td class="center">{{ $item->jaminan_kesehatan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ================= TTD ================= --}}
    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td width="70%"></td>
                <td width="30%">
                    Banjarmasin, {{ now()->translatedFormat('d F Y') }} <br>
                    Mengetahui, <br>
                    <strong>Kepala Puskesmas</strong>
                    <br><br><br><br><br>
                    <strong><u>( .......................................... )</u></strong><br>
                    NIP. 19..............................
                </td>
            </tr>
        </table>
    </div>

</body>

</html>