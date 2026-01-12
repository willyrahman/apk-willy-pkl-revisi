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

        .v-middle {
            vertical-align: middle;
        }

        /* Mencegah format angka ilmiah untuk NIK di Excel */
        .text-format {
            mso-number-format: "\@";
        }

        /* Penentuan Lebar Kolom */
        .col-no {
            width: 30pt;
        }

        .col-erm {
            width: 90pt;
        }

        .col-tgl {
            width: 100pt;
        }

        .col-nama {
            width: 160pt;
        }

        .col-nik {
            width: 130pt;
        }

        .col-alamat {
            width: 250pt;
        }

        .col-jaminan {
            width: 100pt;
        }
    </style>
</head>

<body>
    {{-- Menambahkan border="1" agar garis tabel muncul secara konsisten di Excel --}}
    <table border="1" style="border-collapse: collapse;">

        {{-- ================= KOP SURAT ================= --}}
        <tr>
            <td colspan="1" rowspan="4" style="text-align: center; vertical-align: middle; border:none;">
                @php $logo = public_path('images/logo.png'); @endphp
                @if(file_exists($logo))
                <img src="{{ $logo }}" width="70" height="80">
                @endif
            </td>
            <td colspan="8" style="text-align: center; font-size: 16pt; font-weight: bold; border:none;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 14pt; font-weight: bold; border:none;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Kota Banjarmasin, Kalimantan Selatan. Telp. (0511) 123456
            </td>
        </tr>

        {{-- GARIS TEBAL PEMBATAS KOP --}}
        <tr>
            <td colspan="9" style="border-top: 2.5pt solid #000; border-left:none; border-right:none; border-bottom:none; height: 5px;"></td>
        </tr>

        {{-- ================= JUDUL LAPORAN ================= --}}
        <tr>
            <td colspan="9" style="text-align: center; font-size: 13pt; font-weight: bold; text-decoration: underline; border:none; height: 30px; vertical-align: middle;">
                {{ strtoupper($judul ?? 'LAPORAN DATA IBU HAMIL') }}
            </td>
        </tr>

        {{-- Baris Periode --}}
        @if(isset($tgl_awal) && isset($tgl_akhir))
        <tr>
            <td colspan="9" style="text-align: center; font-size: 11pt; font-style: italic; border:none;">
                Periode: {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
            </td>
        </tr>
        @endif

        {{-- Spasi Kosong Sebelum Tabel --}}
        <tr>
            <td colspan="9" style="border:none; height: 10px;"></td>
        </tr>

        {{-- ================= HEADER TABEL ================= --}}
        <tr style="background-color: #d9d9d9;">
            <th class="col-no bold center v-middle" style="border: 1pt solid #000;">No</th>
            <th class="col-erm bold center v-middle" style="border: 1pt solid #000;">No e-RM</th>
            <th class="col-tgl bold center v-middle" style="border: 1pt solid #000;">Tgl Periksa</th>
            <th class="col-nama bold center v-middle" style="border: 1pt solid #000;">Nama Ibu Hamil</th>
            <th class="col-tgl bold center v-middle" style="border: 1pt solid #000;">Tgl Lahir</th>
            <th class="col-nik bold center v-middle" style="border: 1pt solid #000;">NIK</th>
            <th class="col-nama bold center v-middle" style="border: 1pt solid #000;">Nama Suami</th>
            <th class="col-alamat bold center v-middle" style="border: 1pt solid #000;">Alamat</th>
            <th class="col-jaminan bold center v-middle" style="border: 1pt solid #000;">Jaminan</th>
        </tr>

        {{-- ================= ISI DATA ================= --}}
        @foreach($data as $i => $item)
        <tr>
            <td class="center v-middle" style="border: 1pt solid #000;">{{ $i + 1 }}</td>
            <td class="center v-middle" style="border: 1pt solid #000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
            <td class="center v-middle" style="border: 1pt solid #000;">
                {{ $item->tgl_pemeriksaan_k6 ? \Carbon\Carbon::parse($item->tgl_pemeriksaan_k6)->format('d-m-Y') : '-' }}
            </td>
            <td class="v-middle" style="border: 1pt solid #000; padding-left: 5px;">{{ $item->nama_ibu }}</td>
            <td class="center v-middle" style="border: 1pt solid #000;">
                {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') : '-' }}
            </td>
            <td class="center v-middle text-format" style="border: 1pt solid #000;">'{{ $item->nik }}</td>
            <td class="v-middle" style="border: 1pt solid #000; padding-left: 5px;">{{ $item->nama_suami }}</td>
            <td class="v-middle" style="border: 1pt solid #000; padding-left: 5px;">{{ $item->alamat }}</td>
            <td class="center v-middle" style="border: 1pt solid #000;">{{ $item->jaminan_kesehatan }}</td>
        </tr>
        @endforeach

        {{-- ================= TANDA TANGAN ================= --}}
        <tr>
            <td colspan="9" style="border:none; height: 30px;"></td>
        </tr>
        <tr>
            <td colspan="6" style="border:none;"></td>
            <td colspan="3" class="center" style="border:none;">
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