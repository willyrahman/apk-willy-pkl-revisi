<table>
    {{-- ================= KOP SURAT ================= --}}
    <thead>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 14px; height: 30px; vertical-align: middle;">
                PEMERINTAH KOTA BANJARMASIN
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px; height: 30px; vertical-align: middle;">
                DINAS KESEHATAN PUSKESMAS PEKAPURAN LAUT
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center; font-size: 11px; font-style: italic; vertical-align: middle;">
                Jl. Pekapuran B Laut, Kel. Pekapuran Laut, Kec. Banjarmasin Tengah
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center; font-size: 11px; font-style: italic; vertical-align: middle;">
                Kota Banjarmasin, Kalimantan Selatan. Telp: (0511) 123456
            </td>
        </tr>

        <tr></tr>

        {{-- JUDUL LAPORAN --}}
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 12px; text-transform: uppercase; border: 1px solid #000000; background-color: #e0e0e0; vertical-align: middle; height: 30px;">
                {{ $judul ?? 'LAPORAN DATA IBU HAMIL' }}
            </td>
        </tr>

        @if(isset($tgl_awal) && isset($tgl_akhir) && $tgl_awal != '' && $tgl_akhir != '')
        <tr>
            <td colspan="9" style="text-align: center; font-size: 11px; font-style: italic; border: 1px solid #000000; vertical-align: middle;">
                Periode: {{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('d F Y') }}
                s/d
                {{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('d F Y') }}
            </td>
        </tr>
        @endif

        <tr></tr>

        {{-- HEADER TABEL --}}
        {{-- PERBAIKAN UTAMA: Menggunakan atribut 'width' langsung (bukan style CSS) --}}
        {{-- Angka width di sini adalah estimasi karakter Excel --}}
        <tr>
            <th width="5" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">No</th>
            <th width="15" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">No e-RM</th>
            <th width="18" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">Tgl Periksa K6</th>
            <th width="30" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">Nama Ibu</th>
            <th width="15" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">Tgl Lahir</th>
            <th width="20" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">NIK</th>
            <th width="25" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">Nama Suami</th>
            <th width="50" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">Alamat</th>
            <th width="15" style="font-weight: bold; border: 1px solid #000000; text-align: center; background-color: #f0f0f0; vertical-align: middle;">Jaminan</th>
        </tr>
    </thead>

    {{-- ISI DATA --}}
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td style="border: 1px solid #000000; text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000; text-align: center; vertical-align: middle;">{{ $item->no_e_rekam_medis ?? '-' }}</td>
            <td style="border: 1px solid #000000; text-align: center; vertical-align: middle;">
                {{ $item->tgl_pemeriksaan_k6 ? \Carbon\Carbon::parse($item->tgl_pemeriksaan_k6)->format('d-m-Y') : '-' }}
            </td>
            <td style="border: 1px solid #000000; vertical-align: middle;">{{ $item->nama_ibu }}</td>
            <td style="border: 1px solid #000000; text-align: center; vertical-align: middle;">
                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}
            </td>

            {{-- NIK --}}
            <td style="border: 1px solid #000000; text-align: center; vertical-align: middle;">'{{ $item->nik }}</td>

            <td style="border: 1px solid #000000; vertical-align: middle;">{{ $item->nama_suami }}</td>
            {{-- Wrap text diaktifkan untuk alamat --}}
            <td style="border: 1px solid #000000; vertical-align: middle; word-wrap: break-word;">{{ $item->alamat }}</td>
            <td style="border: 1px solid #000000; text-align: center; vertical-align: middle;">{{ $item->jaminan_kesehatan }}</td>
        </tr>
        @endforeach
    </tbody>

    {{-- TANDA TANGAN --}}
    <tr></tr>
    <tr></tr>

    <tr>
        <td colspan="6"></td>
        <td colspan="3" style="text-align: center; vertical-align: middle;">
            Banjarmasin, {{ now()->translatedFormat('d F Y') }} <br>
            Mengetahui, <br>
            <strong>Kepala Puskesmas</strong>
            <br><br><br><br>
            <strong><u>( .......................................... )</u></strong><br>
            NIP. 19..............................
        </td>
    </tr>
</table>