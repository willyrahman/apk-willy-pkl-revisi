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

        /* Mencegah format angka ilmiah (scientific notation) untuk NIK di Excel */
        .text-format {
            mso-number-format: "\@";
        }

        /* Pengaturan Lebar Kolom Standar */
        .col-no {
            width: 30pt;
        }

        .col-tgl {
            width: 90pt;
        }

        .col-nama {
            width: 150pt;
        }

        .col-nik {
            width: 130pt;
        }

        .col-alamat {
            width: 200pt;
        }
    </style>
</head>

<body>
    {{-- Menambahkan border="1" agar garis tabel muncul secara konsisten di Excel --}}
    <table border="1" style="border-collapse: collapse;">

        {{-- ================= KOP SURAT ================= --}}
        <tr>
            <td colspan="2" rowspan="4" style="text-align: center; vertical-align: middle; border:none;">
                @php $logo = public_path('images/logo.png'); @endphp
                @if(file_exists($logo))
                <img src="{{ $logo }}" width="70" height="80">
                @endif
            </td>
            <td colspan="18" style="text-align: center; font-size: 16pt; font-weight: bold; border:none;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="18" style="text-align: center; font-size: 14pt; font-weight: bold; border:none;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="18" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="18" style="text-align: center; font-size: 10pt; font-style: italic; border:none;">
                Kota Banjarmasin, Kalimantan Selatan. Telp. (0511) 123456
            </td>
        </tr>

        {{-- GARIS TEBAL PEMBATAS KOP --}}
        <tr>
            <td colspan="20" style="border-top: 2.5pt solid #000; border-left:none; border-right:none; border-bottom:none; height: 5px;"></td>
        </tr>

        {{-- ================= JUDUL LAPORAN (PERBAIKAN) ================= --}}
        <tr>
            <td colspan="2" style="border:none;"></td>

            <td colspan="18" style="text-align: center; font-size: 13pt; font-weight: bold; text-decoration: underline; border:none; height: 30px; vertical-align: middle;">
                {{ strtoupper($judul ?? 'LAPORAN DATA KESEHATAN LANSIA') }}
            </td>
        </tr>

        {{-- Baris Periode (Jika Ada) --}}
        @if(isset($tgl_awal) && isset($tgl_akhir))
        <tr>
            <td colspan="2" style="border:none;"></td>
            <td colspan="18" style="text-align: center; font-size: 11pt; font-style: italic; border:none;">
                Periode: {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
            </td>
        </tr>
        @endif

        {{-- Spasi Kosong Sebelum Tabel --}}
        <tr>
            <td colspan="20" style="border:none; height: 10px;"></td>
        </tr>

        {{-- ================= HEADER TABEL ================= --}}
        <tr style="background-color: #d9d9d9;">
            <th class="col-no" style="border: 1pt solid #000; font-weight: bold; text-align: center;">No</th>
            <th class="col-tgl" style="border: 1pt solid #000; font-weight: bold; text-align: center;">Tgl Kunjungan</th>
            <th class="col-nama" style="border: 1pt solid #000; font-weight: bold; text-align: center;">Nama Lansia</th>
            <th class="col-nik" style="border: 1pt solid #000; font-weight: bold; text-align: center;">NIK</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Umur</th>
            <th class="col-alamat" style="border: 1pt solid #000; font-weight: bold; text-align: center;">Alamat</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">BB</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">TB</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">IMT</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Status Gizi</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Sistole</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Diastole</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">GDS</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Chol</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Merokok</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Depresi</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Sayur/Buah</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Aktivitas</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">No e-RM</th>
            <th style="border: 1pt solid #000; font-weight: bold; text-align: center;">Link Hipertensi</th>
        </tr>

        {{-- ================= ISI DATA ================= --}}
        @foreach($data as $i => $item)
        <tr>
            <td class="center" style="border: 1pt solid #000;">{{ $i + 1 }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}</td>
            <td style="border: 1pt solid #000;">{{ $item->nama_lengkap }}</td>
            <td class="center text-format" style="border: 1pt solid #000;">'{{ $item->nik }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->umur }}</td>
            <td style="border: 1pt solid #000;">{{ $item->alamat }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->berat_badan }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->tinggi_badan }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->imt }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->status_gizi }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->sistole }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->diastole }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->gds ?? '-' }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->kolesterol ?? '-' }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->merokok ?? 'Tidak' }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->depresi ?? 'Tidak' }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->kurang_makan_sayur_buah ?? 'Tidak' }}</td>
            <td class="center" style="border: 1pt solid #000;">{{ $item->kurang_aktifitas_fisik ?? 'Tidak' }}</td>
            <td style="border: 1pt solid #000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
            <td style="border: 1pt solid #000;">{{ $item->hipertensi->nama_pasien ?? '-' }}</td>
        </tr>
        @endforeach

        {{-- ================= TANDA TANGAN ================= --}}
        <tr>
            <td colspan="20" style="border:none; height: 30px;"></td>
        </tr>
        <tr>
            <td colspan="16" style="border:none;"></td>
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