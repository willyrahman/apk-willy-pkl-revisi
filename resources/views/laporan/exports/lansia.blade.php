<table>
    {{-- ================= KOP SURAT ================= --}}
    <thead>
        <tr>
            <td colspan="19" style="text-align: center; font-weight: bold; font-size: 14px;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="19" style="text-align: center; font-weight: bold; font-size: 12px;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="19" style="text-align: center; font-size: 10px; font-style: italic;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="19" style="text-align: center; font-size: 10px; font-style: italic;">
                Kota Banjarmasin, Kalimantan Selatan. Telp: (0511) 123456
            </td>
        </tr>

        <tr></tr> {{-- Spasi Kosong --}}

        {{-- JUDUL LAPORAN --}}
        <tr>
            <td colspan="19" style="text-align: center; font-weight: bold; font-size: 12px; text-transform: uppercase;">
                LAPORAN DATA KESEHATAN LANSIA
            </td>
        </tr>

        <tr></tr> {{-- Spasi Kosong --}}

        {{-- HEADER TABEL --}}
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Tgl Kunjungan</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Nama Lansia</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">NIK</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Umur</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Link Hipertensi</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Alamat</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">BB (kg)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">TB (cm)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">IMT</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Status Gizi</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Sistole</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Diastole</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">GDS</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Kolesterol</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Merokok</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Depresi</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Kurang Sayur/Buah</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Kurang Aktivitas</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">No E Rekam Medis</th>
        </tr>
    </thead>

    {{-- ISI DATA --}}
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}</td>
            <td style="border: 1px solid #000000;">{{ $item->nama_lengkap }}</td>

            {{-- Tambahkan tanda kutip satu (') agar NIK terbaca sebagai teks di Excel --}}
            <td style="border: 1px solid #000000; text-align: center;">'{{ $item->nik }}</td>

            <td style="border: 1px solid #000000; text-align: center;">{{ $item->umur }}</td>
            <td style="border: 1px solid #000000;">{{ $item->hipertensi->nama_pasien ?? '-' }}</td>
            <td style="border: 1px solid #000000;">{{ $item->alamat }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->berat_badan }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->tinggi_badan }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->imt }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->status_gizi }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->sistole }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->diastole }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->gds }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->kolesterol }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->merokok }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->depresi }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->kurang_makan_sayur_buah }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->kurang_aktifitas_fisik }}</td>
            <td style="border: 1px solid #000000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>

    {{-- TANDA TANGAN --}}
    <tr></tr>
    <tr></tr>

    <tr>
        {{-- Kosongkan kolom kiri (1-15) --}}
        <td colspan="15"></td>

        {{-- Area Tanda Tangan (16-19) --}}
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