<table>
    {{-- ================= KOP SURAT ================= --}}
    <thead>
        <tr>
            <td colspan="20" style="text-align: center; font-weight: bold; font-size: 14px;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="20" style="text-align: center; font-weight: bold; font-size: 12px;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="20" style="text-align: center; font-size: 10px; font-style: italic;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="20" style="text-align: center; font-size: 10px; font-style: italic;">
                Kota Banjarmasin, Kalimantan Selatan. Telp: (0511) 123456
            </td>
        </tr>
        <tr>
            <td colspan="20"></td>
        </tr>
        <tr>
            <td colspan="20" style="text-align: center; font-weight: bold; font-size: 12px; text-transform: uppercase;">
                LAPORAN DATA KESEHATAN LANSIA
            </td>
        </tr>
        <tr>
            <td colspan="20"></td>
        </tr>

        {{-- HEADER TABEL --}}
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Tgl Kunjungan</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Nama Lansia</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">NIK</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Umur</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Alamat</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">BB (kg)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">TB (cm)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">IMT</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Status Gizi</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Sistole</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Diastole</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">GDS</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Chol</th>

            {{-- KOLOM YANG BERMASALAH --}}
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Merokok</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Depresi</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Kurang Sayur/Buah</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Kurang Aktivitas</th>

            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">No E-Rekam Medis</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0;">Link Hipertensi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}</td>
            <td style="border: 1px solid #000000;">{{ $item->nama_lengkap }}</td>
            <td style="border: 1px solid #000000; text-align: center;">'{{ $item->nik }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->umur }}</td>
            <td style="border: 1px solid #000000;">{{ $item->alamat }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->berat_badan }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->tinggi_badan }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->imt }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->status_gizi }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->sistole }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->diastole }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->gds ?? '-' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->kolesterol ?? '-' }}</td>

            {{-- PASTIKAN NAMA VARIABEL INI SAMA DENGAN DI DATABASE --}}
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->merokok ?? 'Tidak' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->depresi ?? 'Tidak' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->kurang_makan_sayur_buah ?? 'Tidak' }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->kurang_aktifitas_fisik ?? 'Tidak' }}</td>

            <td style="border: 1px solid #000000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
            <td style="border: 1px solid #000000;">{{ $item->hipertensi->nama_pasien ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>

    {{-- TANDA TANGAN --}}
    <tbody>
        <tr>
            <td colspan="20"></td>
        </tr>
        <tr>
            <td colspan="16"></td>
            <td colspan="4" style="text-align: center;">
                Banjarmasin, {{ now()->translatedFormat('d F Y') }} <br>
                Mengetahui, <br>
                <strong>Kepala Puskesmas</strong>
                <br><br><br><br>
                <strong><u>( .......................................... )</u></strong><br>
                NIP. 19..............................
            </td>
        </tr>
    </tbody>
</table>