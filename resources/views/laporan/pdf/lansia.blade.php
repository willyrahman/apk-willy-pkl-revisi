<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $judul }}</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 9px;
            /* Font diperkecil sedikit agar muat semua kolom */
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4 landscape;
            margin: 10mm 10mm;
        }

        /* ===== KOP SURAT ===== */
        .kop-table {
            width: 100%;
            border-bottom: 3px solid #000;
            margin-bottom: 5px;
        }

        .kop-table td {
            border: none;
            padding: 0;
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
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 10px;
            font-style: italic;
        }

        /* ===== JUDUL ===== */
        .judul {
            text-align: center;
            margin-bottom: 10px;
        }

        .judul-utama {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            display: block;
            margin-bottom: 5px;
        }

        .sub-judul {
            font-size: 10px;
            font-weight: normal;
            font-style: italic;
        }

        /* ===== TABEL DATA ===== */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .tabel-data th,
        .tabel-data td {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .tabel-data th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            height: 25px;
            text-transform: uppercase;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        /* Helper untuk text kecil dalam sel */
        .small-text {
            font-size: 8px;
            color: #333;
        }

        /* ===== TTD ===== */
        .ttd-container {
            width: 100%;
            margin-top: 20px;
            page-break-inside: avoid;
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
                <?php
                $path = public_path('images/logo.png');
                $base64 = '';
                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $logoData = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($logoData);
                }
                ?>
                @if($base64)
                <img src="{{ $base64 }}" width="70px" height="auto" alt="Logo">
                @endif
            </td>
            <td class="kop-text">
                <h2>PEMERINTAH KOTA BANJARMASIN</h2>
                <h3>DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT</h3>
                <p>Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah</p>
                <p>Kota Banjarmasin, Kalimantan Selatan. Kode Pos: 70233</p>
            </td>
        </tr>
    </table>

    {{-- JUDUL & PERIODE --}}
    <div class="judul">
        <span class="judul-utama">{{ $judul }}</span>
        @if(!empty($tgl_awal) && !empty($tgl_akhir))
        <span class="sub-judul">
            Periode Data: {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }}
            s/d {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
        </span>
        @endif
    </div>

    {{-- TABEL DATA --}}
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="7%">Tgl Kunjungan</th>
                <th width="8%">No E-RM</th>
                <th width="12%">Nama & NIK</th>
                <th width="4%">JK</th>
                <th width="4%">Umur</th>
                <th width="10%">Alamat</th>
                <th width="8%">Fisik (BB/TB/IMT)</th>
                <th width="5%">Tensi</th>
                <th width="6%">Lab (GDS/Chol)</th>
                <th width="8%">Kemandirian</th>
                <th width="8%">Mental & Emosi</th>
                <th width="12%">Perilaku Berisiko</th>
                <th width="5%">Sts Gizi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}</td>
                <td class="center">{{ $item->no_e_rekam_medis ?? '-' }}</td>

                {{-- Nama & NIK Digabung --}}
                <td class="left">
                    <b>{{ $item->nama_lengkap }}</b><br>
                    <span class="small-text">{{ $item->nik }}</span>
                </td>

                <td class="center">{{ $item->jenis_kelamin }}</td>
                <td class="center">{{ $item->umur }}</td>
                <td class="left">{{ $item->alamat }}</td>

                {{-- Fisik Digabung --}}
                <td class="center">
                    BB: {{ $item->berat_badan }} kg<br>
                    TB: {{ $item->tinggi_badan }} cm<br>
                    IMT: {{ $item->imt ?? '-' }}
                </td>

                <td class="center">{{ $item->sistole }}/{{ $item->diastole }}</td>

                {{-- Lab Digabung --}}
                <td class="center">
                    GDS: {{ $item->gds ?? '-' }}<br>
                    Chol: {{ $item->kolesterol ?? '-' }}
                </td>

                <td class="center">{{ $item->tingkat_kemandirian ?? '-' }}</td>

                {{-- Mental & Emosi --}}
                <td class="left">
                    <span class="small-text">Mental: {{ $item->gangguan_mental ?? '-' }}</span><br>
                    <span class="small-text">Emosi: {{ $item->status_emosional ?? '-' }}</span>
                </td>

                {{-- Perilaku --}}
                <td class="left">
                    <span class="small-text">
                        - Rokok: {{ $item->merokok ?? '-' }} <br>
                        - Sayur: {{ $item->kurang_makan_sayur_buah ?? '-' }} <br>
                        - Fisik: {{ $item->kurang_aktifitas_fisik ?? '-' }}
                    </span>
                </td>

                <td class="center">{{ $item->status_gizi ?? '-' }}</td>
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
                    Banjarmasin, {{ now()->translatedFormat('d F Y') }} <br>
                    Mengetahui, <br>
                    <strong>Kepala Puskesmas</strong>
                    <br><br><br><br>
                    <strong><u>( .......................................... )</u></strong><br>
                    NIP. 19..............................
                </td>
            </tr>
        </table>
    </div>

</body>

</html>