<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $judul }}</title>
    <style>
        /* Mengatur Bahasa Carbon ke Indonesia */
        @php \Carbon\Carbon::setLocale('id');

        @endphp body {
            font-family: "Times New Roman", serif;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        @page {
            size: A4 landscape;
            margin: 10mm 10mm;
        }

        .kop-table {
            width: 100%;
            border-bottom: 3px solid #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
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
        }

        .kop-text h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
            font-style: italic;
        }

        .judul {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14px;
            text-decoration: underline;
        }

        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Memaksa lebar kolom sesuai yang ditentukan */
        }

        .tabel-data th,
        .tabel-data td {
            border: 1px solid #000;
            padding: 4px 2px;
            font-size: 9px;
            vertical-align: middle;
            word-wrap: break-word;
            /* Memastikan teks panjang pindah baris */
        }

        .tabel-data th {
            background-color: #e9ecef;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .center {
            text-align: center;
        }

        .text-left {
            text-align: left;
            padding-left: 5px;
        }

        .ttd-container {
            width: 100%;
            margin-top: 30px;
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
    </style>
</head>

<body>
    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ asset('images/logo.png') }}" width="70px" height="auto">
            </td>
            <td class="kop-text">
                <h2>PEMERINTAH KOTA BANJARMASIN</h2>
                <h3>DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT</h3>
                <p>Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah</p>
                <p>Kota Banjarmasin, Kalimantan Selatan. Kode Pos: 70233</p>
            </td>
        </tr>
    </table>

    <div class="judul">{{ $judul }}</div>

    {{-- TABEL DATA --}}
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="25px">No</th>
                <th width="75px">Tgl Kunjungan</th>
                <th width="95px">NIK</th>
                <th width="110px">Nama Lansia</th>
                <th width="30px">Umur</th>
                <th width="120px">Alamat</th>
                <th width="50px">Tensi</th>
                <th width="35px">GDS</th>
                <th width="35px">Chol</th>
                <th width="70px">Status Gizi</th>
                <th width="40px">Rokok</th>
                <th width="45px">Depresi</th>
                <th width="40px">Sayur</th>
                <th width="40px">Aktif</th>
                <th width="70px">No E-RM</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d-m-Y') }}</td>
                <td class="center">{{ $item->nik }}</td>
                <td class="text-left">{{ $item->nama_lengkap }}</td>
                <td class="center">{{ $item->umur }}</td>
                <td class="text-left">{{ $item->alamat }}</td>
                <td class="center">{{ $item->sistole }}/{{ $item->diastole }}</td>
                <td class="center">{{ $item->gds ?? '-' }}</td>
                <td class="center">{{ $item->kolesterol ?? '-' }}</td>
                <td class="center">{{ $item->status_gizi }}</td>
                <td class="center">{{ $item->merokok ?? 'Tidak' }}</td>
                <td class="center">{{ $item->depresi ?? 'Tidak' }}</td>
                <td class="center">{{ $item->kurang_makan_sayur_buah ?? 'Tidak' }}</td>
                <td class="center">{{ $item->kurang_aktifitas_fisik ?? 'Tidak' }}</td>
                <td class="center">{{ $item->no_e_rekam_medis ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="15" class="center">Data tidak ditemukan dalam periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td width="65%"></td>
                <td width="35%">
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