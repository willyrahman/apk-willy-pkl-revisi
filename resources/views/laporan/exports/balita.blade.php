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

            {{-- KOLOM TEKS KOP (Merge Sisa Kolom) --}}
            <td colspan="14" style="text-align: center; font-weight: bold; font-size: 14px; vertical-align: middle;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="14" style="text-align: center; font-weight: bold; font-size: 12px; vertical-align: middle;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="14" style="text-align: center; font-size: 10px; font-style: italic; vertical-align: middle;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="14" style="text-align: center; font-size: 10px; font-style: italic; vertical-align: middle;">
                Kota Banjarmasin, Kalimantan Selatan. Telp: (0511) 123456
            </td>
        </tr>

        {{-- Jarak Kosong --}}
        <tr></tr>

        {{-- JUDUL LAPORAN --}}
        <tr>
            <td colspan="16" style="text-align: center; font-weight: bold; font-size: 12px; text-transform: uppercase;">
                {{ $judul }}
            </td>
        </tr>

        {{-- HEADER TABEL --}}
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">No</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Tgl Periksa</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Nama Balita</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">NIK</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">JK</th>

            {{-- UPDATE: JUDUL KOLOM --}}
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Nama Ibu & No. RM</th>

            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Umur</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Alamat</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Berat (kg)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Tinggi (cm)</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Status Gizi / IMT</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Suhu</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Keluhan</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Diagnosa</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">Obat</th>
            <th style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #dbf1ff;">No E Rekam Medis (Balita)</th>
        </tr>
    </thead>

    {{-- ISI DATA --}}
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ \Carbon\Carbon::parse($item->tgl_pemeriksaan)->format('d-m-Y') }}</td>
            <td style="border: 1px solid #000000;">{{ $item->nama_pasien }}</td>
            <td style="border: 1px solid #000000; text-align: center;">'{{ $item->nik }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->jenis_kelamin }}</td>

            {{-- UPDATE: ISI KOLOM NAMA IBU & RM --}}
            <td style="border: 1px solid #000000;">
                {{ $item->ibuHamil->nama_ibu ?? '-' }}
                @if(!empty($item->ibuHamil->no_e_rekam_medis))
                <br>RM: {{ $item->ibuHamil->no_e_rekam_medis }}
                @endif
            </td>

            <td style="border: 1px solid #000000; text-align: center;">{{ $item->umur }}</td>
            <td style="border: 1px solid #000000;">{{ $item->alamat }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->berat_badan }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->tinggi_badan }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->hasil_imt_status_gizi }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $item->suhu }}</td>
            <td style="border: 1px solid #000000;">{{ $item->keluhan_utama }}</td>
            <td style="border: 1px solid #000000;">{{ $item->diagnosa_1 }}</td>
            <td style="border: 1px solid #000000;">{{ $item->obat }}</td>
            <td style="border: 1px solid #000000;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>

    {{-- TANDA TANGAN --}}
    <tr></tr>
    <tr></tr>

    <tr>
        {{-- Spacer Kiri (Geser colspan jadi 12 karena total kolom bertambah 1 akibat merge logo) --}}
        <td colspan="12"></td>

        {{-- Area Tanda Tangan --}}
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