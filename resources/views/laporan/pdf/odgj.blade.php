<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $judul }}</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 10px;
            /* Font agak kecil agar muat banyak kolom */
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
            margin-bottom: 15px;
        }

        /* ===== JUDUL ===== */
        .judul {
            text-align: center;
            margin-bottom: 20px;
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
            font-size: 11px;
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
            padding: 4px;
            /* Padding sedikit lebih besar agar rapi */
            vertical-align: middle;
            word-wrap: break-word;
        }

        .tabel-data th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
            height: 25px;
            font-size: 9px;
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

    {{-- ================= KOP SURAT ================= --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <?php
                // TEKNIK BASE64 AGAR LOGO MUNCUL DI SEMUA ENVIRONMENT
                // Pastikan path ini benar: public/images/logo.png
                $path = public_path('images/logo.png');
                $base64 = '';

                if (file_exists($path)) {
                    $type = pathinfo($path, PATHINFO_EXTENSION);

                    // PENTING: Gunakan nama variabel '$logoData' (jangan '$data')
                    // agar tidak menimpa data pasien di bawah
                    $logoData = file_get_contents($path);

                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($logoData);
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
    <div class="judul">
        <span class="judul-utama">{{ $judul }}</span>

        {{-- Logika Periode --}}
        @if(!empty($tgl_awal) && !empty($tgl_akhir))
        <span class="sub-judul">
            <br>
            Periode Data:
            {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }}
            s/d
            {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
        </span>
        @endif
    </div>

    {{-- ================= TABEL DATA ================= --}}
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">No e-RM</th>
                <th width="10%">NIK</th>
                <th width="12%">Nama Pasien</th>
                <th width="3%">JK</th>
                <th width="9%">Tgl Lahir (Umur)</th>
                <th width="12%">Alamat</th>
                <th width="3%">RT</th>
                <th width="6%">Status</th>
                <th width="8%">Diagnosis</th>
                <th width="7%">Jadwal</th>
                <th width="8%">Keterangan</th>
                <th width="9%">Tgl Kontrol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="center">{{ $item->no_e_rekam_medis ?? '-' }}</td>
                <td class="center">{{ $item->nik }}</td>
                <td class="left">{{ $item->nama }}</td>
                <td class="center">{{ $item->jenis_kelamin }}</td>
                <td class="center">
                    {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }} <br>
                    ({{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Thn)
                </td>
                <td class="left">{{ $item->alamat }}</td>
                <td class="center">{{ $item->rt ?? '-' }}</td>
                <td class="center">{{ $item->status_pasien }}</td>
                <td class="left">{{ $item->diagnosis }}</td>
                <td class="center">{{ $item->jadwal_kontrol ?? '-' }}</td>
                <td class="left">{{ $item->keterangan ?? '-' }}</td>
                <td class="center">
                    {{ $item->tanggal_kontrol ? \Carbon\Carbon::parse($item->tanggal_kontrol)->format('d-m-Y') : '-' }}
                </td>
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