<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>Data Balita</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .table td,
        .table th {
            white-space: nowrap;
            font-size: 14px;
            vertical-align: middle;
        }

        /* Style Baru untuk Detail Modal */
        .detail-card {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .detail-icon {
            width: 30px;
            color: #51cbce;
            text-align: center;
            margin-right: 10px;
        }

        .stat-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            border: 1px solid #e9ecef;
            height: 100%;
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #9a9a9a;
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .section-title {
            border-bottom: 2px solid #51cbce;
            margin-bottom: 15px;
            margin-top: 5px;
            padding-bottom: 5px;
            font-weight: bold;
            color: #51cbce;
            text-transform: uppercase;
            font-size: 13px;
            display: flex;
            align-items: center;
        }

        .detail-label {
            font-weight: bold;
            color: #66615b;
            font-size: 12px;
            margin-bottom: 0;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .modal-header.bg-info {
            background-color: #51cbce !important;
        }

        .modal {
            z-index: 1050 !important;
        }

        .modal-backdrop {
            z-index: 1040 !important;
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
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <span>
                                <b> Gagal Menyimpan Data - Cek Kesalahan Berikut: </b>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </span>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">
                            <span><b>Error Database:</b> {{ session('error') }}</span>
                        </div>
                        @endif
                        {{-- === BATAS KODE === --}}
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Data Pemeriksaan Balita</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBalitaModal">
                                    <i class="nc-icon nc-simple-add"></i> Tambah Data
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="text-primary">
                                            <th>No</th>
                                            <th>No e-RM (Balita)</th>
                                            <th>Tgl Periksa</th>
                                            <th>Nama Balita</th>
                                            <th>NIK</th>
                                            <th>JK</th>
                                            <th>Nama Ibu & No. RM</th>
                                            <th>Umur</th>
                                            <th>Alamat</th>
                                            <th>Poli</th>
                                            <th>Dokter</th>
                                            <th>Berat (kg)</th>
                                            <th>Tinggi (cm)</th>
                                            <th>IMT</th>
                                            <th>Status Gizi</th>
                                            <th>Suhu (C)</th>
                                            <th>Keluhan</th>
                                            <th>Diagnosa</th>
                                            <th>ICD-X</th>
                                            <th>Obat</th>
                                            <th>Apoteker</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @foreach($balitas as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="badge badge-info">{{ $item->no_e_rekam_medis ?? '-' }}</span></td>
                                                <td>{{ \Carbon\Carbon::parse($item->tgl_pemeriksaan)->format('d-m-Y') }}</td>
                                                <td>{{ $item->nama_pasien }}</td>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->jenis_kelamin }}</td>
                                                <td>
                                                    <span class="font-weight-bold">{{ $item->ibuHamil->nama_ibu ?? '-' }}</span>
                                                    @if(isset($item->ibuHamil->no_e_rekam_medis))
                                                    <br>
                                                    <small class="text-muted" style="font-size: 11px;">
                                                        RM: {{ $item->ibuHamil->no_e_rekam_medis }}
                                                    </small>
                                                    @endif
                                                </td>
                                                <td>{{ $item->umur }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($item->alamat, 20) }}</td>
                                                <td>{{ $item->poli_ruangan }}</td>
                                                <td>{{ $item->dokter_tenaga_medis }}</td>
                                                <td>{{ $item->berat_badan }}</td>
                                                <td>{{ $item->tinggi_badan }}</td>
                                                <td>{{ $item->hasil_imt_status_gizi }}</td>
                                                <td>
                                                    @php
                                                    $status = $item->hasil_imt_status_gizi;
                                                    $badge = str_contains($status, 'Baik') ? 'badge-success' : 'badge-warning';
                                                    @endphp
                                                    <span class="badge {{ $badge }}">{{ $status }}</span>
                                                </td>
                                                <td>{{ $item->suhu }}</td>
                                                <td>{{ $item->keluhan_utama }}</td>
                                                <td>{{ $item->diagnosa_1 }}</td>
                                                <td>{{ $item->icd_x_1 }}</td>
                                                <td>{{ $item->obat }}</td>
                                                <td>{{ $item->apoteker }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm btn-detail"
                                                        data-nama="{{ $item->nama_pasien }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-jk="{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                                                        data-ibu="{{ $item->ibuHamil->nama_ibu ?? '-' }} {{ isset($item->ibuHamil->no_e_rekam_medis) ? '(RM: '.$item->ibuHamil->no_e_rekam_medis.')' : '' }}"
                                                        data-umur="{{ $item->umur }}"
                                                        data-tgl="{{ \Carbon\Carbon::parse($item->tgl_pemeriksaan)->format('d F Y') }}"
                                                        data-alamat="{{ $item->alamat }}"
                                                        data-berat="{{ $item->berat_badan }}"
                                                        data-tinggi="{{ $item->tinggi_badan }}"
                                                        data-imt="{{ $item->hasil_imt_status_gizi }}"
                                                        data-poli="{{ $item->poli_ruangan }}"
                                                        data-dokter="{{ $item->dokter_tenaga_medis }}"
                                                        data-suhu="{{ $item->suhu }}"
                                                        data-keluhan="{{ $item->keluhan_utama }}"
                                                        data-diagnosa="{{ $item->diagnosa_1 }}"
                                                        data-icd="{{ $item->icd_x_1 }}"
                                                        data-obat="{{ $item->obat }}"
                                                        data-apoteker="{{ $item->apoteker }}"
                                                        data-toggle="modal" data-target="#detailBalitaModal">
                                                        <i class="fa fa-info-circle"></i>
                                                    </button>

                                                    <button class="btn btn-warning btn-sm btn-edit"
                                                        data-id="{{ $item->id }}"
                                                        data-ibu_id="{{ $item->ibu_hamil_id }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-nama="{{ $item->nama_pasien }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-jk="{{ $item->jenis_kelamin }}"
                                                        data-umur="{{ $item->umur }}"
                                                        data-tgl="{{ $item->tgl_pemeriksaan }}"
                                                        data-alamat="{{ $item->alamat }}"
                                                        data-berat="{{ $item->berat_badan }}"
                                                        data-tinggi="{{ $item->tinggi_badan }}"
                                                        data-imt="{{ $item->hasil_imt_status_gizi }}"
                                                        data-poli="{{ $item->poli_ruangan }}"
                                                        data-dokter="{{ $item->dokter_tenaga_medis }}"
                                                        data-suhu="{{ $item->suhu }}"
                                                        data-keluhan="{{ $item->keluhan_utama }}"
                                                        data-diagnosa="{{ $item->diagnosa_1 }}"
                                                        data-icd="{{ $item->icd_x_1 }}"
                                                        data-obat="{{ $item->obat }}"
                                                        data-apoteker="{{ $item->apoteker }}"
                                                        data-toggle="modal" data-target="#editBalitaModal">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $item->id }}" action="{{ route('balita.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('footer')
        </div>
    </div>

    <div class="modal fade" id="addBalitaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Input Data Balita</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('balita.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Nama Ibu</label>
                            <select name="ibu_hamil_id" class="form-control" required>
                                <option value="">-- Cari Nama Ibu --</option>
                                @foreach($data_ibu as $ibu)
                                <option value="{{ $ibu->id }}">
                                    {{ $ibu->nama_ibu }} {{ $ibu->no_e_rekam_medis ? '(RM: '.$ibu->no_e_rekam_medis.')' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No e-Rekam Medis (Balita)</label>
                            <input type="text" name="no_e_rekam_medis" class="form-control" placeholder="Nomor RM Elektronik">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Balita</label><input type="text" name="nama_pasien" class="form-control" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="number" name="nik" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>JK</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Umur</label><input type="text" name="umur" class="form-control" required></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Tgl Periksa</label><input type="date" name="tgl_pemeriksaan" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control" rows="2"></textarea></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Poli / Ruangan</label>
                                    <input type="text" name="poli_ruangan" class="form-control" placeholder="Contoh: Poli Anak">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dokter / Tenaga Medis</label>
                                    <input type="text" name="dokter_tenaga_medis" class="form-control" placeholder="Nama Dokter/Bidan">
                                </div>
                            </div>
                        </div>
                        <div class="row bg-light p-2 mx-1 mb-3 border rounded">
                            <div class="col-md-3">
                                <div class="form-group"><label>Berat (Kg)</label><input type="number" step="0.1" name="berat_badan" id="add_berat" class="form-control" oninput="calcIMT('add')" required></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tinggi (Cm)</label><input type="number" step="0.1" name="tinggi_badan" id="add_tinggi" class="form-control" oninput="calcIMT('add')" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>IMT / Status</label><input type="text" name="hasil_imt_status_gizi" id="add_imt" class="form-control" readonly></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Suhu</label><input type="number" step="0.1" name="suhu" class="form-control"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group"><label>Keluhan</label><input type="text" name="keluhan_utama" class="form-control"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Diagnosa</label><input type="text" name="diagnosa_1" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>ICD-X</label><input type="text" name="icd_x_1" class="form-control"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group"><label>Obat</label><input type="text" name="obat" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Apoteker</label><input type="text" name="apoteker" class="form-control"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBalitaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Data Balita</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Ibu</label>
                            <select name="ibu_hamil_id" id="edit_ibu" class="form-control" required>
                                @foreach($data_ibu as $ibu)
                                <option value="{{ $ibu->id }}">
                                    {{ $ibu->nama_ibu }} {{ $ibu->no_e_rekam_medis ? '(RM: '.$ibu->no_e_rekam_medis.')' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No e-Rekam Medis (Balita)</label>
                            <input type="text" name="no_e_rekam_medis" id="edit_erm" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Balita</label><input type="text" name="nama_pasien" id="edit_nama" class="form-control" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="number" name="nik" id="edit_nik" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>JK</label>
                                    <select name="jenis_kelamin" id="edit_jk" class="form-control">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Umur</label><input type="text" name="umur" id="edit_umur" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Tgl Periksa</label><input type="date" name="tgl_pemeriksaan" id="edit_tgl" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Alamat</label><textarea name="alamat" id="edit_alamat" class="form-control" rows="2"></textarea></div>
                        <div class="row bg-light p-2 mx-1 mb-3 border rounded">
                            <div class="col-md-3">
                                <div class="form-group"><label>Berat (Kg)</label><input type="number" step="0.1" name="berat_badan" id="edit_berat" class="form-control" oninput="calcIMT('edit')" required></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tinggi (Cm)</label><input type="number" step="0.1" name="tinggi_badan" id="edit_tinggi" class="form-control" oninput="calcIMT('edit')" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>IMT / Status</label><input type="text" name="hasil_imt_status_gizi" id="edit_imt" class="form-control" readonly></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Poli</label><input type="text" name="poli_ruangan" id="edit_poli" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Dokter</label><input type="text" name="dokter_tenaga_medis" id="edit_dokter" class="form-control"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Suhu</label><input type="number" step="0.1" name="suhu" id="edit_suhu" class="form-control"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group"><label>Keluhan</label><input type="text" name="keluhan_utama" id="edit_keluhan" class="form-control"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Diagnosa</label><input type="text" name="diagnosa_1" id="edit_diagnosa" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>ICD-X</label><input type="text" name="icd_x_1" id="edit_icd" class="form-control"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group"><label>Obat</label><input type="text" name="obat" id="edit_obat" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Apoteker</label><input type="text" name="apoteker" id="edit_apoteker" class="form-control"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailBalitaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-child mr-2"></i> Detail Pemeriksaan Balita</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="detail-card">
                                <h6 class="section-title mt-0"><i class="fas fa-id-card detail-icon"></i>Identitas Pasien</h6>
                                <div class="row mb-1">
                                    <div class="col-sm-5 detail-label">Nama Balita</div>
                                    <div class="col-sm-7 detail-value" id="det_nama"></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-sm-5 detail-label">NIK / E-RM</div>
                                    <div class="col-sm-7 detail-value"><span id="det_nik"></span> / <span class="text-info" id="det_erm"></span></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-sm-5 detail-label">Nama Ibu (RM)</div>
                                    <div class="col-sm-7 detail-value" id="det_ibu"></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-sm-5 detail-label">Jenis Kelamin</div>
                                    <div class="col-sm-7 detail-value" id="det_jk"></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-sm-5 detail-label">Umur</div>
                                    <div class="col-sm-7 detail-value" id="det_umur"></div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-sm-5 detail-label">Alamat</div>
                                    <div class="col-sm-7 detail-value" id="det_alamat"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="detail-card text-center">
                                <h6 class="section-title mt-0 text-center"><i class="fas fa-weight detail-icon"></i>Antropometri</h6>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="stat-box">
                                            <span class="stat-label">Berat</span>
                                            <span class="stat-value" id="det_berat"></span>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="stat-box">
                                            <span class="stat-label">Tinggi</span>
                                            <span class="stat-value" id="det_tinggi"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="stat-box">
                                            <span class="stat-label">Suhu Tubuh</span>
                                            <span class="stat-value text-danger" id="det_suhu"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-2 border rounded bg-white">
                                            <span class="stat-label text-center">IMT & Status Gizi</span>
                                            <div id="det_imt_badge" class="mt-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="detail-card mb-0">
                                <h6 class="section-title mt-0"><i class="fas fa-stethoscope detail-icon"></i>Hasil Pemeriksaan Medis</h6>
                                <div class="row">
                                    <div class="col-md-6 border-right">
                                        <p class="detail-label"><i class="fas fa-user-md mr-1"></i> Pemeriksa</p>
                                        <p class="detail-value mb-3"><span id="det_dokter"></span> (<span id="det_poli"></span>)</p>

                                        <p class="detail-label"><i class="fas fa-comment-medical mr-1"></i> Keluhan Utama</p>
                                        <p class="detail-value font-italic" id="det_keluhan"></p>
                                    </div>
                                    <div class="col-md-6 pl-md-4">
                                        <p class="detail-label"><i class="fas fa-notes-medical mr-1"></i> Diagnosa (ICD-X)</p>
                                        <p class="detail-value text-primary"><span id="det_diagnosa"></span> [<span id="det_icd"></span>]</p>

                                        <p class="detail-label"><i class="fas fa-pills mr-1"></i> Terapi / Obat</p>
                                        <p class="detail-value" id="det_obat"></p>

                                        <p class="detail-label"><i class="fas fa-user-nurse mr-1"></i> Apoteker</p>
                                        <p class="detail-value" id="det_apoteker"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <small class="mr-auto text-muted">Tanggal Periksa: <span id="det_tgl"></span></small>
                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1"></script>

    <script>
        // 1. Script Modal Detail
        $(document).on('click', '.btn-detail', function() {
            $('#det_nama').text($(this).data('nama'));
            $('#det_nik').text($(this).data('nik'));
            $('#det_erm').text($(this).data('erm') || '-');
            $('#det_jk').text($(this).data('jk'));
            $('#det_ibu').text($(this).data('ibu'));
            $('#det_umur').text($(this).data('umur'));
            $('#det_tgl').text($(this).data('tgl'));
            $('#det_alamat').text($(this).data('alamat'));
            $('#det_berat').text($(this).data('berat') + ' Kg');
            $('#det_tinggi').text($(this).data('tinggi') + ' Cm');
            $('#det_suhu').text($(this).data('suhu') + ' °C');
            $('#det_poli').text($(this).data('poli'));
            $('#det_dokter').text($(this).data('dokter'));
            $('#det_keluhan').text($(this).data('keluhan') || '-');
            $('#det_diagnosa').text($(this).data('diagnosa') || '-');
            $('#det_icd').text($(this).data('icd') || '-');
            $('#det_obat').text($(this).data('obat') || '-');
            $('#det_apoteker').text($(this).data('apoteker') || '-');

            // Logika Badge Status Gizi
            var imtStatus = $(this).data('imt');
            var badgeClass = 'badge-secondary';
            if (imtStatus.includes('Baik')) badgeClass = 'badge-success';
            else if (imtStatus.includes('Kurang')) badgeClass = 'badge-warning';
            else if (imtStatus.includes('Lebih') || imtStatus.includes('Obesitas')) badgeClass = 'badge-danger';

            $('#det_imt_badge').html('<span class="badge ' + badgeClass + '" style="font-size:14px; padding:8px 12px; border-radius:20px;">' + imtStatus + '</span>');
        });

        // 2. Script Modal Edit
        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var url = "{{ route('balita.update', ':id') }}";
            url = url.replace(':id', id);
            $('#formEdit').attr('action', url);

            $('#edit_ibu').val($(this).data('ibu_id'));
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_nik').val($(this).data('nik'));
            $('#edit_erm').val($(this).data('erm'));
            $('#edit_jk').val($(this).data('jk'));
            $('#edit_umur').val($(this).data('umur'));
            $('#edit_tgl').val($(this).data('tgl'));
            $('#edit_alamat').val($(this).data('alamat'));
            $('#edit_berat').val($(this).data('berat'));
            $('#edit_tinggi').val($(this).data('tinggi'));
            $('#edit_imt').val($(this).data('imt'));
            $('#edit_poli').val($(this).data('poli'));
            $('#edit_dokter').val($(this).data('dokter'));
            $('#edit_suhu').val($(this).data('suhu'));
            $('#edit_keluhan').val($(this).data('keluhan'));
            $('#edit_diagnosa').val($(this).data('diagnosa'));
            $('#edit_icd').val($(this).data('icd'));
            $('#edit_obat').val($(this).data('obat'));
            $('#edit_apoteker').val($(this).data('apoteker'));
        });

        // 3. Kalkulasi IMT
        function calcIMT(prefix) {
            let berat = parseFloat(document.getElementById(prefix + '_berat').value);
            let tinggi = parseFloat(document.getElementById(prefix + '_tinggi').value);

            if (berat > 0 && tinggi > 0) {
                let tinggiM = tinggi / 100;
                let imt = berat / (tinggiM * tinggiM);
                let status = '';
                if (imt < 18.5) status = 'Gizi Kurang';
                else if (imt >= 18.5 && imt <= 25) status = 'Gizi Baik';
                else status = 'Gizi Lebih';

                document.getElementById(prefix + '_imt').value = imt.toFixed(2) + ' (' + status + ')';
            } else {
                document.getElementById(prefix + '_imt').value = '';
            }
        }

        // 4. Konfirmasi Hapus
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}"
        });
        @endif
    </script>
</body>

</html>