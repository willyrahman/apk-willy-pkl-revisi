<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Laporan Lansia</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table th {
            background-color: #f8f9fa;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle !important;
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
                                    <button type="submit" class="btn btn-primary btn-round mr-2">Filter</button>
                                    <a href="{{ route('laporan.lansia') }}" class="btn btn-warning btn-round mr-2">Reset</a>
                                    <a href="{{ route('laporan.export.pdf', ['jenis' => 'lansia'] + request()->all()) }}" class="btn btn-danger btn-round" target="_blank">PDF</a>
                                    <a href="{{ route('laporan.export.excel', ['jenis' => 'lansia'] + request()->all()) }}" class="btn btn-success btn-round" target="_blank">Excel</a>
                                </div>
                            </div>
                        </form>

                        {{-- TABEL DATA --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>No e-RM (Lansia)</th>
                                        <th>Tgl Kunjungan</th>
                                        <th>NIK</th>
                                        <th>Nama Lansia</th>
                                        <th>Umur</th>
                                        {{-- UPDATE: JUDUL KOLOM --}}
                                        <th>Link Hipertensi & No. RM</th>
                                        <th>Tensi</th>
                                        <th>GDS</th>
                                        <th>Chol</th>
                                        <th>Status Gizi</th>
                                        <th>Merokok</th>
                                        <th>Depresi</th>
                                        <th>Kurang Sayur</th>
                                        <th>Kurang Aktif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><span class="badge badge-info">{{ $item->no_e_rekam_medis ?? '-' }}</span></td>

                                        {{-- FORMAT TANGGAL INDONESIA --}}
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}</td>

                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama_lengkap }}</td>
                                        <td class="text-center">{{ $item->umur }}</td>

                                        {{-- UPDATE: KOLOM LINK HIPERTENSI & RM --}}
                                        <td>
                                            @if($item->hipertensi)
                                            <span class="font-weight-bold">{{ $item->hipertensi->nama_pasien }}</span>
                                            <br>
                                            <small class="text-muted" style="font-size: 11px;">
                                                RM: {{ $item->hipertensi->no_e_rekam_medis ?? '-' }}
                                            </small>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td class="text-center">{{ $item->sistole }}/{{ $item->diastole }}</td>
                                        <td class="text-center">{{ $item->gds ?? '-' }}</td>
                                        <td class="text-center">{{ $item->kolesterol ?? '-' }}</td>
                                        <td>{{ $item->status_gizi }}</td>

                                        <td class="text-center">
                                            <span class="badge {{ $item->merokok == 'Ya' ? 'badge-danger' : 'badge-success' }}">
                                                {{ $item->merokok ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $item->depresi == 'Ya' ? 'badge-danger' : 'badge-success' }}">
                                                {{ $item->depresi ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $item->kurang_makan_sayur_buah == 'Ya' ? 'badge-danger' : 'badge-success' }}">
                                                {{ $item->kurang_makan_sayur_buah ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $item->kurang_aktifitas_fisik == 'Ya' ? 'badge-danger' : 'badge-success' }}">
                                                {{ $item->kurang_aktifitas_fisik ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="15" class="text-center">Data tidak ditemukan.</td>
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
</body>

</html>