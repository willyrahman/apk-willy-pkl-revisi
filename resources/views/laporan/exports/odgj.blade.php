<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
    <style>
        body,
        table,
        td,
        th {
            font-family: "Times New Roman", serif;
        }

        table {
            border-collapse: collapse;
        }

        /* Border khusus untuk tabel data */
        .data-table th,
        .data-table td {
            border: 1pt solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        /* Pengaturan Lebar Kolom */
        .col-no {
            width: 30pt;
        }

        .col-nik {
            width: 130pt;
            mso-number-format: "\@";
        }

        .col-nama {
            width: 160pt;
        }

        .col-jk {
            width: 60pt;
        }

        .col-tgl {
            width: 110pt;
        }

        .col-alamat {
            width: 220pt;
        }

        .col-rt {
            width: 40pt;
        }

        .col-status {
            width: 90pt;
        }

        .col-kontrol {
            width: 100pt;
        }

        .col-diag {
            width: 140pt;
        }

        .col-ket {
            width: 120pt;
        }

        .col-erm {
            width: 100pt;
        }
    </style>
</head>

<body>
    {{-- Tambahkan border="1" agar garis muncul konsisten di Excel --}}
    <table border="1" style="border-collapse: collapse;">

        {{-- ================= KOP SURAT ================= --}}
        {{-- Gunakan border:none pada area kop agar garis tabel tidak muncul di sana --}}
        <tr>
            <td colspan="2" rowspan="4" style="text-align: center; vertical-align: middle; border:none;">
                @php $logo = public_path('images/logo.png'); @endphp
                @if(file_exists($logo))
                <img src="{{ $logo }}" width="70" height="80">
                @endif
            </td>
            <td colspan="10" style="text-align: center; font-size: 16pt; font-weight: bold; border:none;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="10" style="text-align: center; font-size: 14pt; font-weight: bold; border:none;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="10" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="10" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Kota Banjarmasin, Kalimantan Selatan. Telp. (0511) 123456
            </td>
        </tr>

        {{-- GARIS KOP --}}
        <tr>
            <td colspan="12" style="border-top: 2.5pt solid #000; border-left:none; border-right:none; border-bottom:none; height: 5px;"></td>
        </tr>

        {{-- ================= JUDUL (PERBAIKAN RATA TENGAH) ================= --}}
        <tr>
            <td colspan="2" style="border:none;"></td>

            <td colspan="10" style="text-align: center; font-size: 13pt; font-weight: bold; text-decoration: underline; border:none; height: 30px; vertical-align: middle;">
                {{ strtoupper($judul ?? 'LAPORAN DATA ODGJ') }}
            </td>
        </tr>

        {{-- Baris Periode (Jika Ada) --}}
        @if(isset($tgl_awal) && isset($tgl_akhir))
        <tr>
            <td colspan="12" style="text-align: center; font-size: 11pt; font-style: italic; border:none;">
                Periode: {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
            </td>
        </tr>
        @endif

        {{-- Spasi Kosong Sebelum Tabel --}}
        <tr>
            <td colspan="12" style="border:none; height: 10px;"></td>
        </tr>

        {{-- ================= HEADER TABEL ================= --}}
        <tr style="background-color: #d9d9d9;">
            <th class="border col-no" style="text-align: center; font-weight: bold;">No</th>
            <th class="border col-nik" style="text-align: center; font-weight: bold;">NIK</th>
            <th class="border col-nama" style="text-align: center; font-weight: bold;">Nama Pasien</th>
            <th class="border col-jk" style="text-align: center; font-weight: bold;">Jenis Kelamin</th>
            <th class="border col-tgl" style="text-align: center; font-weight: bold;">Tgl Lahir (Umur)</th>
            <th class="border col-alamat" style="text-align: center; font-weight: bold;">Alamat</th>
            <th class="border col-rt" style="text-align: center; font-weight: bold;">RT</th>
            <th class="border col-status" style="text-align: center; font-weight: bold;">Status Pasien</th>
            <th class="border col-kontrol" style="text-align: center; font-weight: bold;">Jadwal Kontrol</th>
            <th class="border col-diag" style="text-align: center; font-weight: bold;">Diagnosis</th>
            <th class="border col-ket" style="text-align: center; font-weight: bold;">Keterangan</th>
            <th class="border col-erm" style="text-align: center; font-weight: bold;">No e-RM</th>
        </tr>

        {{-- ================= DATA ================= --}}
        @foreach($data as $i => $item)
        <tr>
            <td class="center" style="border: 1pt solid #000;">{{ $i+1 }}</td>
            <td class="center" style="border: 1pt solid #000; mso-number-format:'\@';">'{{ $item->nik }}</td>
            <td style="border: 1pt solid #000;">{{ $item->nama }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->jenis_kelamin }}</td>
            <td class="center" style="border: 1pt solid #000;">
                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}<br>
                ({{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Thn)
            </td>
            <td style="border: 1pt solid #000;">{{ $item->alamat }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->rt }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->status_pasien }}</td>
            <td class="center" style="border: 1pt solid #000;">
                {{ $item->tanggal_kontrol ? \Carbon\Carbon::parse($item->tanggal_kontrol)->format('d-m-Y') : '-' }}
            </td>
            <td style="border: 1pt solid #000;">{{ $item->diagnosis }}</td>
            <td style="border: 1pt solid #000;">{{ $item->keterangan }}</td>
            <td style="border: 1pt solid #000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
        </tr>
        @endforeach

        {{-- ================= TANDA TANGAN ================= --}}
        <tr>
            <td colspan="12" style="height: 30px;"></td>
        </tr>
        <tr>
            <td colspan="8"></td>
            <td colspan="4" class="center">
                Banjarmasin, {{ now()->translatedFormat('d F Y') }}<br>
                Mengetahui,<br>
                <span class="bold">Kepala Puskesmas</span><br><br><br><br><br>
                <span class="bold"><u>( .................................. )</u></span><br>
                NIP. 19............................
            </td>
        </tr>
    </table>
</body>

</html>