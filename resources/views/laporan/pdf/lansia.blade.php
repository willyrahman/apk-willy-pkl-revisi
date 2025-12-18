<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $judul }}</title>
    <style>
        @php // Memaksa sistem menggunakan bahasa Indonesia untuk tanggal
        \Carbon\Carbon::setLocale('id');

        @endphp body {
            font-family: "Times New Roman", serif;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 landscape;
            margin: 10mm 10mm;
        }

        .kop-table {
            width: 100%;
            border-bottom: 3px solid #000;
            margin-bottom: 5px;
        }

        .kop-table td {
            border: none;
            vertical-align: middle;
        }

        .kop-logo {
            width: 70px;
            text-align: left;
        }

        .kop-text {
            text-align: center;
            padding-right: 70px;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 10px;
            font-style: italic;
        }

        .judul {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 12px;
            text-decoration: underline;
        }

        .tabel-data {
            width: 100%;
            border-collapse: collapse;
        }

        .tabel-data th,
        .tabel-data td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 8.5px;
            /* Perkecil font agar semua kolom muat */
            vertical-align: middle;
            word-wrap: break-word;
        }

        .tabel-data th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .ttd-container {
            width: 100%;
            margin-top: 20px;
        }

        .ttd-table {
            width: 100%;
            border: none;
        }

        .ttd-table td {
            border: none;
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>

<body>
    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('images/logo.png') }}" width="60px" height="auto">
            </td>
            <td class="kop-text">
                <h2>PEMERINTAH KOTA BANJARMASIN</h2>
                <h3>DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT</h3>
                <p>Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah</p>
                <p>Kota Banjarmasin, Kalimantan Selatan. Telp: (0511) 123456</p>
            </td>
        </tr>
    </table>

    <div class="judul">{{ $judul }}</div>

    {{-- TABEL DATA --}}
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="7%">Tgl Kunjungan</th>
                <th width="8%">NIK</th> {{-- NIK DITAMBAHKAN --}}
                <th width="10%">Nama Lansia</th>
                <th width="3%">Umur</th>
                <th width="12%">Alamat</th>
                <th width="5%">Tensi</th>
                <th width="4%">GDS</th>
                <th width="4%">Chol</th>
                <th width="6%">Status Gizi</th>
                <th width="5%">Merokok</th>
                <th width="5%">Depresi</th>
                <th width="5%">Kurang Sayur</th>
                <th width="5%">Kurang Aktif</th>
                <th width="8%">No E-RM</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}</td>
                <td class="center">{{ $item->nik }}</td> {{-- MENAMPILKAN NIK --}}
                <td>{{ $item->nama_lengkap }}</td>
                <td class="center">{{ $item->umur }}</td>
                <td>{{ $item->alamat }}</td>
                <td class="center">{{ $item->sistole }}/{{ $item->diastole }}</td>
                <td class="center">{{ $item->gds }}</td>
                <td class="center">{{ $item->kolesterol }}</td>
                <td class="center">{{ $item->status_gizi }}</td>

                {{-- Pastikan nama field di bawah ini sama dengan di database --}}
                <td class="center">{{ $item->merokok ?? '-' }}</td>
                <td class="center">{{ $item->depresi ?? '-' }}</td>
                <td class="center">{{ $item->kurang_makan_sayur_buah ?? '-' }}</td>
                <td class="center">{{ $item->kurang_aktifitas_fisik ?? '-' }}</td>

                <td class="center">{{ $item->no_e_rekam_medis ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td width="70%"></td>
                <td width="30%">
                    Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
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