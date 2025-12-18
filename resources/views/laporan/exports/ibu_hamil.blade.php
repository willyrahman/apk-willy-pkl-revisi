<table>
    {{-- ================= KOP SURAT ================= --}}
    <thead>
        <tr>
            {{-- KOLOM LOGO (Merge 2 Kolom) --}}
            <td colspan="2" rowspan="4" style="text-align: center; vertical-align: middle;">
                {{-- Pastikan file 'logo.png' ada di public/images/ --}}
                {{-- Kita gunakan asset() agar path-nya absolut (http://localhost/...) --}}
                <img src="{{ asset('images/logo.png') }}" width="70" height="70" style="vertical-align: middle;">
            </td>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 14px;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 12px;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 10px; font-style: italic;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center; font-size: 10px; font-style: italic;">
                Kota Banjarmasin, Kalimantan Selatan. Telp: (0511) 123456
            </td>
        </tr>

        <tr></tr> {{-- Spasi Kosong --}}

        {{-- JUDUL LAPORAN --}}
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 12px; text-transform: uppercase;">
                LAPORAN DATA IBU HAMIL
            </td>
        </tr>

        <tr></tr> {{-- Spasi Kosong --}}

        {{-- HEADER TABEL --}}
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Nama Ibu</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Tgl Lahir</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">NIK</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Nama Suami</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Alamat</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Tgl Pemeriksaan K6</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Jaminan Kesehatan</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">No E Rekam Medis</th>
        </tr>
    </thead>

    {{-- ISI DATA --}}
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000;">{{ $item->nama_ibu }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>

            {{-- Tambahkan tanda kutip satu (') agar NIK terbaca sebagai teks di Excel --}}
            <td style="border: 1px solid #000000; text-align: center;">'{{ $item->nik }}</td>

            <td style="border: 1px solid #000000;">{{ $item->nama_suami }}</td>
            <td style="border: 1px solid #000000;">{{ $item->alamat }}</td>

            <td style="border: 1px solid #000000; text-align: center;">
                {{ $item->tgl_pemeriksaan_k6 ? \Carbon\Carbon::parse($item->tgl_pemeriksaan_k6)->format('d-m-Y') : '-' }}
            </td>

            <td style="border: 1px solid #000000; text-align: center;">{{ $item->jaminan_kesehatan }}</td>
            <td style="border: 1px solid #000000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>

    {{-- TANDA TANGAN --}}
    <tr></tr>
    <tr></tr>

    <tr>
        {{-- Kosongkan kolom kiri (1-4) --}}
        <td colspan="4"></td>

        {{-- Area Tanda Tangan (5-8) --}}
        <td colspan="4" style="text-align: center;">
            Banjarmasin, {{ now()->translatedFormat('d F Y') }} <br>
            Mengetahui, <br>
            <strong>Kepala Puskesmas</strong>
            <br><br><br><br>
            <strong><u>( .......................................... )</u></strong><br>
            NIP. 19..............................
        </td>
    </tr>
</table>