<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Laporan Ibu Hamil</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                        <h4 class="card-title">Laporan Data Ibu Hamil</h4>
                    </div>
                    <div class="card-body">
                        {{-- FILTER --}}
                        <form action="{{ route('laporan.ibuHamil') }}" method="GET" class="mb-4">
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
                                    <a href="{{ route('laporan.ibuHamil') }}" class="btn btn-warning btn-round mr-2">Reset</a>
                                    <a href="{{ route('laporan.export.pdf', ['jenis' => 'ibuHamil'] + request()->all()) }}" class="btn btn-danger btn-round" target="_blank">PDF</a>
                                    <a href="{{ route('laporan.export.excel', ['jenis' => 'ibuHamil'] + request()->all()) }}" class="btn btn-success btn-round" target="_blank">Excel</a>
                                </div>
                            </div>
                        </form>

                        {{-- TABEL DATA --}}
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>No e-RM</th> {{-- KOLOM BARU --}}
                                        <th>Nama Ibu</th>
                                        <th>Tgl Lahir</th>
                                        <th>NIK</th>
                                        <th>Suami</th>
                                        <th>Alamat</th>
                                        <th>Tgl Periksa K6</th>
                                        <th>Jaminan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->no_e_rekam_medis ?? '-' }}</td> {{-- DATA BARU --}}
                                        <td>{{ $item->nama_ibu }}</td>

                                        {{-- FORMAT TANGGAL INDONESIA --}}
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') }}</td>

                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama_suami }}</td>
                                        <td>{{ $item->alamat }}</td>

                                        {{-- FORMAT TANGGAL INDONESIA (K6) --}}
                                        <td>
                                            @if($item->tgl_pemeriksaan_k6)
                                            {{ \Carbon\Carbon::parse($item->tgl_pemeriksaan_k6)->translatedFormat('d F Y') }}
                                            @else
                                            -
                                            @endif
                                        </td>

                                        <td>{{ $item->jaminan_kesehatan }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Data tidak ditemukan.</td>
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