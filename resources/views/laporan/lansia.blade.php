<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Laporan Lansia</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    {{-- PERBAIKAN 1: Gunakan asset() agar CSS terbaca di folder laporan --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .table th {
            background-color: #f8f9fa;
            white-space: nowrap;
            text-align: center;
            vertical-align: middle !important;
        }

        .table td {
            vertical-align: middle !important;
            text-align: center;
        }

        .badge {
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            @include('sidebar')
        </div>
        <div class="main-panel">
            @include('navbar')
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Laporan Data Lansia</h4>
                    </div>
                    <div class="card-body">
                        {{-- FILTER --}}
                        <form action="{{ route('laporan.lansia') }}" method="GET" class="mb-4">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-round">Filter</button>
                                    <a href="{{ route('laporan.lansia') }}" class="btn btn-warning btn-round">Reset</a>
                                    <a href="{{ route('laporan.export.pdf', ['jenis' => 'lansia'] + request()->all()) }}" class="btn btn-danger btn-round" target="_blank">PDF</a>
                                    <a href="{{ route('laporan.export.excel', ['jenis' => 'lansia'] + request()->all()) }}" class="btn btn-success btn-round" target="_blank">Excel</a>
                                </div>
                            </div>
                        </form>

                        {{-- TABEL DATA --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="text-primary font-weight-bold">
                                    <tr>
                                        <th>No</th>
                                        <th>No e-RM (Lansia)</th>
                                        <th>Tgl Kunjungan</th>
                                        <th>NIK</th>
                                        <th>Nama Lansia</th>
                                        <th>Umur</th>
                                        <th>Link Hipertensi & No. RM</th>
                                        <th>Tensi</th>
                                        <th>GDS</th>
                                        <th>Chol</th>
                                        <th>Status Gizi</th>
                                        <th>Merokok</th>
                                        <th>Depresi</th>
                                        <th>Sayur</th>
                                        <th>Aktif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- PERBAIKAN 2: Pastikan variabel sesuai dengan yang dikirim Controller (biasanya $data) --}}
                                    @forelse($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge badge-info">{{ $item->no_e_rekam_medis ?? '-' }}</span></td>
                                        <td>{{ $item->tanggal_kunjungan ? \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') : '-' }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td class="text-left">{{ $item->nama_lengkap }}</td>
                                        <td>{{ $item->umur }}</td>
                                        <td>
                                            @if($item->hipertensi)
                                            <span class="font-weight-bold">{{ $item->hipertensi->nama_pasien }}</span><br>
                                            <small class="text-muted">RM: {{ $item->hipertensi->no_e_rekam_medis ?? '-' }}</small>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->sistole }}/{{ $item->diastole }}</td>
                                        <td>{{ $item->gds ?? '-' }}</td>
                                        <td>{{ $item->kolesterol ?? '-' }}</td>
                                        <td>{{ $item->status_gizi }}</td>
                                        <td>
                                            <span class="badge {{ $item->merokok == 'Ya' ? 'badge-danger' : 'badge-success' }}">{{ $item->merokok ?? 'Tidak' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->depresi == 'Ya' ? 'badge-danger' : 'badge-success' }}">{{ $item->depresi ?? 'Tidak' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->kurang_makan_sayur_buah == 'Ya' ? 'badge-danger' : 'badge-success' }}">{{ $item->kurang_makan_sayur_buah ?? 'Tidak' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->kurang_aktifitas_fisik == 'Ya' ? 'badge-danger' : 'badge-success' }}">{{ $item->kurang_aktifitas_fisik ?? 'Tidak' }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="15" class="text-center">Data tidak ditemukan untuk periode ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('footer')
        </div>
    </div>

    {{-- PERBAIKAN 3: Gunakan asset() untuk JS --}}
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
</body>

</html>