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

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        /* Pengaturan format kolom agar NIK/No Asuransi tidak menjadi scientific notation */
        .text-format {
            mso-number-format: "\@";
        }

        /* Lebar Kolom (Opsional, menyesuaikan kebutuhan data Hipertensi) */
        .col-no {
            width: 30pt;
        }

        .col-tgl {
            width: 80pt;
        }

        .col-nama {
            width: 150pt;
        }

        .col-nik {
            width: 130pt;
        }

        .col-asuransi {
            width: 130pt;
        }

        .col-jk {
            width: 40pt;
        }

        .col-alamat {
            width: 200pt;
        }
    </style>
</head>

<body>
    {{-- Menambahkan border="1" agar garis muncul di Excel --}}
    <table border="1" style="border-collapse: collapse;">

        {{-- ================= KOP SURAT ================= --}}
        <tr>
            <td colspan="2" rowspan="4" style="text-align: center; vertical-align: middle; border:none;">
                @php $logo = public_path('images/logo.png'); @endphp
                @if(file_exists($logo))
                <img src="{{ $logo }}" width="70" height="80">
                @else
                {{-- Fallback jika file tidak ditemukan --}}
                @endif
            </td>
            <td colspan="13" style="text-align: center; font-size: 16pt; font-weight: bold; border:none;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="13" style="text-align: center; font-size: 14pt; font-weight: bold; border:none;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="13" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="13" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Kota Banjarmasin, Kalimantan Selatan. Telp. (0511) 123456
            </td>
        </tr>

        {{-- GARIS KOP --}}
        <tr>
            <td colspan="15" style="border-top: 2.5pt solid #000; border-left:none; border-right:none; border-bottom:none; height: 5px;"></td>
        </tr>

        {{-- ================= JUDUL ================= --}}
        <tr>
            <td colspan="15" style="text-align: center; font-size: 13pt; font-weight: bold; text-decoration: underline; border:none; height: 30px; vertical-align: middle;">
                {{ strtoupper($judul ?? 'LAPORAN DATA PASIEN HIPERTENSI') }}
            </td>
        </tr>

        {{-- Baris Periode (Jika Ada) --}}
        @if(isset($tgl_awal) && isset($tgl_akhir))
        <tr>
            <td colspan="15" style="text-align: center; font-size: 11pt; font-style: italic; border:none;">
                Periode: {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
            </td>
        </tr>
        @endif

        {{-- Spasi Kosong Sebelum Tabel --}}
        <tr>
            <td colspan="15" style="border:none; height: 10px;"></td>
        </tr>

        {{-- ================= HEADER TABEL ================= --}}
        <tr style="background-color: #d9d9d9;">
            <th class="col-no" style="border: 1pt solid #000; font-weight: bold; text-align: center;">No</th>
            <th class="col-tgl" style="border: 1pt solid #000; font-weight: bold; text-align: center;">Tanggal</th>
            <th class="col-nama" style="border: 1pt solid #000; font-weight: bold; text-align: center;">Nama Pasien</th>
            <th class="col-nik" style="border: 1pt solid #000; font-weight: bold; text-align: center;">NIK</th>
            <th class="col-asuransi" style="border: 1pt solid #000; font-weight: bold; text-align: center;">No Asuransi</th>
            <th class="col-jk" style="border: 1pt solid #000; font-weight: bold; text-align: center;">JK</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">No Telp</th>
            <th class="col-alamat" style="border: 1pt solid #000; font-weight: bold; text-align: center;">Alamat</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">RT</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">RW</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Nyeri</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">ICD-X</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Diagnosa</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Kasus</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">No e-RM</th>
        </tr>

        {{-- ================= ISI DATA ================= --}}
        @foreach($data as $i => $item)
        <tr>
            <td class="center" style="border: 1pt solid #000;">{{ $i+1 }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
            <td style="border: 1pt solid #000;">{{ $item->nama_pasien }}</td>
            <td class="center text-format" style="border: 1pt solid #000;">'{{ $item->nik }}</td>
            <td class="center text-format" style="border: 1pt solid #000;">'{{ $item->no_asuransi }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->jenis_kelamin }}</td>
            <td class="center text-format" style="border: 1pt solid #000;">'{{ $item->no_telp }}</td>
            <td style="border: 1pt solid #000;">{{ $item->alamat }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->rt }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->rw }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->skala_nyeri }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->icd_x_1 }}</td>
            <td style="border: 1pt solid #000;">{{ $item->diagnosa_1 }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->jenis_kasus_1 }}</td>
            <td style="border: 1pt solid #000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
        </tr>
        @endforeach

        {{-- ================= TANDA TANGAN ================= --}}
        <tr>
            <td colspan="15" style="border:none; height: 30px;"></td>
        </tr>
        <tr>
            <td colspan="11" style="border:none;"></td>
            <td colspan="4" class="center" style="border:none;">
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