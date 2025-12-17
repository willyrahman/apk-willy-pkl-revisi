<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Laporan Balita</title>
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
                        <h4 class="card-title">Laporan Data Balita</h4>
                    </div>
                    <div class="card-body">
                        {{-- FILTER --}}
                        <form action="{{ route('laporan.balita') }}" method="GET" class="mb-4">
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
                                    <a href="{{ route('laporan.balita') }}" class="btn btn-warning btn-round mr-2">Reset</a>
                                    <a href="{{ route('laporan.export.pdf', ['jenis' => 'balita'] + request()->all()) }}" class="btn btn-danger btn-round" target="_blank">PDF</a>
                                    <a href="{{ route('laporan.export.excel', ['jenis' => 'balita'] + request()->all()) }}" class="btn btn-success btn-round" target="_blank">Excel</a>
                                </div>
                            </div>
                        </form>

                        {{-- TABEL --}}
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>No e-RM (Balita)</th>
                                        <th>Tgl Periksa</th>
                                        <th>Nama Balita</th>
                                        <th>JK</th>
                                        <th>Nama Ibu & No. RM</th> {{-- JUDUL KOLOM DIUPDATE --}}
                                        <th>Berat (kg)</th>
                                        <th>Tinggi (cm)</th>
                                        <th>Status Gizi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->no_e_rekam_medis ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tgl_pemeriksaan)->format('d-m-Y') }}</td>
                                        <td>{{ $item->nama_pasien }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>

                                        {{-- KOLOM NAMA IBU & RM IBU DIPERBARUI --}}
                                        <td>
                                            <span style="font-weight: bold;">{{ $item->ibuHamil->nama_ibu ?? '-' }}</span>
                                            @if(isset($item->ibuHamil->no_e_rekam_medis))
                                            <br>
                                            <small class="text-muted" style="font-size: 11px;">
                                                RM: {{ $item->ibuHamil->no_e_rekam_medis }}
                                            </small>
                                            @endif
                                        </td>

                                        <td>{{ $item->berat_badan }}</td>
                                        <td>{{ $item->tinggi_badan }}</td>
                                        <td>{{ $item->hasil_imt_status_gizi }}</td>
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