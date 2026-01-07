<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>Data Lansia</title>
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
            text-align: center;
        }

        .badge-style {
            display: block;
            margin-bottom: 2px;
            font-size: 10px;
            text-align: left;
        }

        .detail-card {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .detail-icon {
            width: 30px;
            color: #51cbce;
            text-align: center;
            margin-right: 10px;
            font-size: 18px;
        }

        .stat-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            border: 1px solid #e9ecef;
            transition: all 0.3s;
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

        .section-title-custom {
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

        .detail-label-custom {
            font-weight: bold;
            color: #66615b;
            font-size: 12px;
            margin-bottom: 0;
        }

        .detail-value-custom {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid #f4f4f4;
            padding-bottom: 5px;
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
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Data Kesehatan Lansia</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLansiaModal">
                                    <i class="nc-icon nc-simple-add"></i> Tambah Data
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="text-primary font-weight-bold">
                                            <tr>
                                                <th>No</th>
                                                <th>Link Hipertensi & No. RM</th>
                                                <th>Nama Lansia</th>
                                                <th>Tgl Kunjungan</th>
                                                <th>Umur</th>
                                                <th>Alamat</th>
                                                <th>BB / TB</th>
                                                <th>IMT / Gizi</th>
                                                <th>Tensi</th>
                                                <th>GDS / Chol</th>
                                                <th>Gaya Hidup</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lansias as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td class="text-left">
                                                    @if($item->hipertensi)
                                                    <span class="font-weight-bold text-primary">{{ $item->hipertensi->nama_pasien }}</span><br>
                                                    <small class="text-muted">RM: {{ $item->hipertensi->no_e_rekam_medis ?? '-' }}</small>
                                                    @else
                                                    <span class="text-muted text-center d-block">-</span>
                                                    @endif
                                                </td>

                                                <td class="text-left">
                                                    {{ $item->nama_lengkap }} <br>
                                                    <small class="text-muted">Lansia RM: {{ $item->no_e_rekam_medis ?? '-' }}</small>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') }}</td>
                                                <td>{{ $item->umur }}</td>
                                                <td class="text-left">{{ \Illuminate\Support\Str::limit($item->alamat, 10) }}</td>
                                                <td>{{ $item->berat_badan }} / {{ $item->tinggi_badan }}</td>
                                                <td>
                                                    {{ $item->imt }} <br>
                                                    <span class="badge badge-default" style="font-size: 9px;">{{ $item->status_gizi }}</span>
                                                </td>
                                                <td>{{ $item->sistole }}/{{ $item->diastole }}</td>
                                                <td>{{ $item->gds }} / {{ $item->kolesterol }}</td>

                                                <td class="text-left">
                                                    <span class="badge-style {{ $item->merokok == 'Ya' ? 'text-danger' : 'text-success' }}">
                                                        <i class="fas fa-smoking"></i> Rokok: {{ $item->merokok ?? '-' }}
                                                    </span>
                                                    <span class="badge-style {{ $item->kurang_makan_sayur_buah == 'Ya' ? 'text-warning' : 'text-success' }}">
                                                        <i class="fas fa-apple-alt"></i> Kurang Sayur: {{ $item->kurang_makan_sayur_buah ?? '-' }}
                                                    </span>
                                                    <span class="badge-style {{ $item->kurang_aktifitas_fisik == 'Ya' ? 'text-warning' : 'text-success' }}">
                                                        <i class="fas fa-walking"></i> Kurang Aktif: {{ $item->kurang_aktifitas_fisik ?? '-' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{-- TOMBOL DETAIL --}}
                                                    <button class="btn btn-info btn-sm btn-icon btn-detail"
                                                        data-toggle="modal" data-target="#detailLansiaModal"
                                                        data-nama="{{ $item->nama_lengkap }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-tgl="{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}"
                                                        data-ttl="{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') }}"
                                                        data-umur="{{ $item->umur }}"
                                                        data-jk="{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                                                        data-link="{{ $item->hipertensi->nama_pasien ?? 'Tidak Terhubung' }} {{ isset($item->hipertensi->no_e_rekam_medis) ? '(RM: '.$item->hipertensi->no_e_rekam_medis.')' : '' }}"
                                                        data-alamat="{{ $item->alamat }} (Kel. {{ $item->kelurahan }})"
                                                        data-bb="{{ $item->berat_badan }}"
                                                        data-tb="{{ $item->tinggi_badan }}"
                                                        data-imt="{{ $item->imt }}"
                                                        data-lingkar="{{ $item->lingkar_perut }}"
                                                        data-gizi="{{ $item->status_gizi }}"
                                                        data-tensi="{{ $item->sistole }}/{{ $item->diastole }}"
                                                        data-gds="{{ $item->gds }}"
                                                        data-chol="{{ $item->kolesterol }}"
                                                        data-merokok="{{ $item->merokok ?? 'Tidak' }}"
                                                        data-depresi="{{ $item->depresi ?? 'Tidak' }}"
                                                        data-sayur="{{ $item->kurang_makan_sayur_buah ?? 'Tidak' }}"
                                                        data-aktif="{{ $item->kurang_aktifitas_fisik ?? 'Tidak' }}"
                                                        data-mandiri="{{ $item->tingkat_kemandirian ?? '-' }}"
                                                        data-mental="{{ $item->gangguan_mental ?? '-' }}"
                                                        data-emosi="{{ $item->status_emosional ?? '-' }}"
                                                        data-r_sendiri="{{ $item->riwayat_penyakit_sendiri ?? '-' }}"
                                                        data-r_keluarga="{{ $item->riwayat_penyakit_keluarga ?? '-' }}">
                                                        <i class="fa fa-info-circle"></i>
                                                    </button>

                                                    <button class="btn btn-warning btn-sm btn-icon btn-edit"
                                                        data-toggle="modal" data-target="#editLansiaModal"
                                                        data-id="{{ $item->id }}"
                                                        data-nama="{{ $item->nama_lengkap }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-hipertensi="{{ $item->hipertensi_id }}"
                                                        data-tgl_kunjungan="{{ $item->tanggal_kunjungan }}"
                                                        data-umur="{{ $item->umur }}"
                                                        data-alamat="{{ $item->alamat }}"
                                                        data-tempat_lahir="{{ $item->tempat_lahir }}"
                                                        data-tgl_lahir="{{ $item->tanggal_lahir }}"
                                                        data-jk="{{ $item->jenis_kelamin }}"
                                                        data-kelurahan="{{ $item->kelurahan }}"
                                                        data-bb="{{ $item->berat_badan }}"
                                                        data-tb="{{ $item->tinggi_badan }}"
                                                        data-imt="{{ $item->imt }}"
                                                        data-gizi="{{ $item->status_gizi }}"
                                                        data-lingkar="{{ $item->lingkar_perut }}"
                                                        data-sistole="{{ $item->sistole }}"
                                                        data-diastole="{{ $item->diastole }}"
                                                        data-gds="{{ $item->gds }}"
                                                        data-chol="{{ $item->kolesterol }}"
                                                        data-merokok="{{ $item->merokok }}"
                                                        data-sayur="{{ $item->kurang_makan_sayur_buah }}"
                                                        data-aktif="{{ $item->kurang_aktifitas_fisik }}"
                                                        data-depresi="{{ $item->depresi }}"
                                                        data-mandiri="{{ $item->tingkat_kemandirian }}"
                                                        data-mental="{{ $item->gangguan_mental }}"
                                                        data-emosi="{{ $item->status_emosional }}"
                                                        data-r_sendiri="{{ $item->riwayat_penyakit_sendiri }}"
                                                        data-r_keluarga="{{ $item->riwayat_penyakit_keluarga }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $item->id }}" action="{{ route('lansia.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm btn-icon" onclick="confirmDelete({{ $item->id }})">
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

    <div class="modal fade" id="addLansiaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Lansia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('lansia.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info py-2">
                            <i class="fas fa-link"></i> Hubungkan dengan Data Hipertensi
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pilih Pasien Hipertensi (Opsional)</label>
                                    <select class="form-control" name="hipertensi_id">
                                        <option value="">-- Tidak Terhubung / Pasien Baru --</option>
                                        @foreach($hipertensis as $h)
                                        <option value="{{ $h->id }}">{{ $h->nama_pasien }} - (RM: {{ $h->no_e_rekam_medis ?? 'Tanpa RM' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Lengkap</label><input type="text" class="form-control" name="nama_lengkap" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="text" class="form-control" name="nik" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>No e-RM</label><input type="text" class="form-control" name="no_e_rekam_medis"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Kunjungan</label><input type="date" class="form-control" name="tanggal_kunjungan" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Lahir</label><input type="text" class="form-control" name="tempat_lahir"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Umur</label><input type="number" class="form-control" name="umur"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Jenis Kelamin</label><select class="form-control" name="jenis_kelamin">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Kelurahan</label><input type="text" class="form-control" name="kelurahan"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Alamat</label><textarea class="form-control" name="alamat"></textarea></div>
                        <hr>
                        <h6 class="text-info">Pemeriksaan Fisik & Lab</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Berat (kg)</label><input type="number" step="0.01" class="form-control" name="berat_badan" id="add_berat" onkeyup="calcIMT('add')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tinggi (cm)</label><input type="number" step="0.01" class="form-control" name="tinggi_badan" id="add_tinggi" onkeyup="calcIMT('add')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>IMT</label><input type="text" class="form-control" name="imt" id="add_imt" readonly></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Status Gizi</label><input type="text" class="form-control" name="status_gizi" id="add_status" readonly></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Sistole</label><input type="number" class="form-control" name="sistole"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Diastole</label><input type="number" class="form-control" name="diastole"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>GDS</label><input type="number" class="form-control" name="gds"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Kolesterol</label><input type="number" class="form-control" name="kolesterol"></div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-info">Gaya Hidup & Mental</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Merokok?</label><select class="form-control" name="merokok">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Kurang Makan Sayur/Buah?</label><select class="form-control" name="kurang_makan_sayur_buah">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Kurang Aktivitas Fisik?</label><select class="form-control" name="kurang_aktifitas_fisik">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Lingkar Perut</label><input type="number" class="form-control" name="lingkar_perut"></div>
                            </div>
                        </div>
                        <h6 class="text-info">Kemandirian & Psikologis</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Tingkat Kemandirian</label><select class="form-control" name="tingkat_kemandirian">
                                        <option value="">Pilih...</option>
                                        <option value="Mandiri">Mandiri (A)</option>
                                        <option value="Ketergantungan Ringan">Ketergantungan Ringan (B)</option>
                                        <option value="Ketergantungan Sedang">Ketergantungan Sedang (C)</option>
                                        <option value="Ketergantungan Berat">Ketergantungan Berat</option>
                                        <option value="Ketergantungan Total">Ketergantungan Total</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Gangguan Mental</label><select class="form-control" name="gangguan_mental">
                                        <option value="Tidak Ada">Tidak Ada</option>
                                        <option value="Ada">Ada</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Masalah Emosional</label><select class="form-control" name="status_emosional">
                                        <option value="Tidak Ada">Tidak Ada</option>
                                        <option value="Ada">Ada</option>
                                    </select></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Riwayat Penyakit Sendiri</label><input type="text" class="form-control" name="riwayat_penyakit_sendiri"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Riwayat Penyakit Keluarga</label><input type="text" class="form-control" name="riwayat_penyakit_keluarga"></div>
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

    <div class="modal fade" id="editLansiaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Data Lansia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="alert alert-warning py-2">
                            <i class="fas fa-link"></i> Update Link Data Hipertensi
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pilih Pasien Hipertensi</label>
                                    <select class="form-control" name="hipertensi_id" id="edit_hipertensi">
                                        <option value="">-- Tidak Terhubung --</option>
                                        @foreach($hipertensis as $h)
                                        <option value="{{ $h->id }}">{{ $h->nama_pasien }} - (RM: {{ $h->no_e_rekam_medis ?? 'Tanpa RM' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Lengkap</label><input type="text" class="form-control" name="nama_lengkap" id="edit_nama" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="text" class="form-control" name="nik" id="edit_nik" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>No e-RM</label><input type="text" class="form-control" name="no_e_rekam_medis" id="edit_erm"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Kunjungan</label><input type="date" class="form-control" name="tanggal_kunjungan" id="edit_kunjungan" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Tempat Lahir</label><input type="text" class="form-control" name="tempat_lahir" id="edit_tempat_lahir"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" id="edit_tgl_lahir"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Umur</label><input type="number" class="form-control" name="umur" id="edit_umur"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Jenis Kelamin</label><select class="form-control" name="jenis_kelamin" id="edit_jk">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Kelurahan</label><input type="text" class="form-control" name="kelurahan" id="edit_kelurahan"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Alamat</label><textarea class="form-control" name="alamat" id="edit_alamat"></textarea></div>
                        <hr>
                        <h6 class="text-info">Pemeriksaan Fisik</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Berat (kg)</label><input type="number" step="0.01" class="form-control" name="berat_badan" id="edit_berat" onkeyup="calcIMT('edit')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tinggi (cm)</label><input type="number" step="0.01" class="form-control" name="tinggi_badan" id="edit_tinggi" onkeyup="calcIMT('edit')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>IMT</label><input type="text" class="form-control" name="imt" id="edit_imt" readonly></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Status Gizi</label><input type="text" class="form-control" name="status_gizi" id="edit_status" readonly></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Sistole</label><input type="number" class="form-control" name="sistole" id="edit_sistole"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Diastole</label><input type="number" class="form-control" name="diastole" id="edit_diastole"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>GDS</label><input type="number" class="form-control" name="gds" id="edit_gds"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Kolesterol</label><input type="number" class="form-control" name="kolesterol" id="edit_chol"></div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-info">Gaya Hidup & Mental</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Merokok?</label><select class="form-control" name="merokok" id="edit_merokok">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Kurang Sayur/Buah?</label><select class="form-control" name="kurang_makan_sayur_buah" id="edit_sayur">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Kurang Aktif?</label><select class="form-control" name="kurang_aktifitas_fisik" id="edit_aktif">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Lingkar Perut</label><input type="number" class="form-control" name="lingkar_perut" id="edit_lingkar"></div>
                            </div>
                        </div>
                        <h6 class="text-info">Kemandirian & Psikologis</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Tingkat Kemandirian</label><select class="form-control" name="tingkat_kemandirian" id="edit_mandiri">
                                        <option value="Mandiri">Mandiri (A)</option>
                                        <option value="Ketergantungan Ringan">Ketergantungan Ringan (B)</option>
                                        <option value="Ketergantungan Sedang">Ketergantungan Sedang (C)</option>
                                        <option value="Ketergantungan Berat">Ketergantungan Berat</option>
                                        <option value="Ketergantungan Total">Ketergantungan Total</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Gangguan Mental</label><select class="form-control" name="gangguan_mental" id="edit_mental">
                                        <option value="Tidak Ada">Tidak Ada</option>
                                        <option value="Ada">Ada</option>
                                    </select></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Masalah Emosional</label><select class="form-control" name="status_emosional" id="edit_emosi">
                                        <option value="Tidak Ada">Tidak Ada</option>
                                        <option value="Ada">Ada</option>
                                    </select></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Riwayat Penyakit Sendiri</label><input type="text" class="form-control" name="riwayat_penyakit_sendiri" id="edit_r_sendiri"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Riwayat Penyakit Keluarga</label><input type="text" class="form-control" name="riwayat_penyakit_keluarga" id="edit_r_keluarga"></div>
                            </div>
                        </div>

                        <input type="hidden" name="depresi" id="edit_depresi">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailLansiaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-user-clock mr-2"></i> Detail Pemeriksaan Lansia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="detail-card h-100 mb-md-0">
                                <h6 class="section-title-custom"><i class="fas fa-id-card detail-icon"></i>Identitas Pribadi</h6>
                                <div class="row">
                                    <div class="col-sm-6"><label class="detail-label-custom">Nama Lengkap</label>
                                        <div class="detail-value-custom" id="d_nama"></div>
                                    </div>
                                    <div class="col-sm-6"><label class="detail-label-custom">NIK</label>
                                        <div class="detail-value-custom" id="d_nik"></div>
                                    </div>
                                    <div class="col-sm-6"><label class="detail-label-custom">No e-RM</label>
                                        <div class="detail-value-custom text-info" id="d_erm"></div>
                                    </div>
                                    <div class="col-sm-6"><label class="detail-label-custom">TTL</label>
                                        <div class="detail-value-custom" id="d_ttl"></div>
                                    </div>
                                    <div class="col-sm-12"><label class="detail-label-custom">Alamat</label>
                                        <div class="detail-value-custom" id="d_alamat"></div>
                                    </div>
                                    <div class="col-sm-12"><label class="detail-label-custom">Link Hipertensi</label>
                                        <div class="detail-value-custom font-italic text-primary" id="d_link"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="detail-card h-100 mb-0">
                                <h6 class="section-title-custom"><i class="fas fa-weight detail-icon"></i>Antropometri</h6>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="stat-box"><span class="stat-label">IMT</span><span class="stat-value" id="d_imt"></span></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box" id="tensi_box"><span class="stat-label" id="tensi_label">Tensi</span><span class="stat-value" id="d_tensi"></span></div>
                                    </div>
                                </div>
                                <div class="stat-box mb-2"><span class="stat-label">Status Gizi</span>
                                    <div id="d_gizi" class="font-weight-bold text-primary" style="font-size: 15px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="detail-card mb-0">
                                <h6 class="section-title-custom"><i class="fas fa-flask detail-icon"></i>Laboratorium & Gaya Hidup</h6>
                                <div class="row text-center mb-3">
                                    <div class="col-md-3"><label class="detail-label-custom">Gula Darah</label>
                                        <p class="font-weight-bold mb-0" id="d_gds"></p>
                                    </div>
                                    <div class="col-md-3 border-left border-right"><label class="detail-label-custom">Kolesterol</label>
                                        <p class="font-weight-bold mb-0" id="d_chol"></p>
                                    </div>
                                    <div class="col-md-3 border-right"><label class="detail-label-custom">Merokok</label>
                                        <div id="d_merokok"></div>
                                    </div>
                                    <div class="col-md-3"><label class="detail-label-custom">Depresi</label>
                                        <div id="d_depresi"></div>
                                    </div>
                                </div>
                                <div class="row text-center border-top pt-3">
                                    <div class="col-md-3"><label class="detail-label-custom">Kurang Sayur</label>
                                        <div id="d_sayur"></div>
                                    </div>
                                    <div class="col-md-3 border-left border-right"><label class="detail-label-custom">Kurang Aktif</label>
                                        <div id="d_aktif"></div>
                                    </div>
                                    <div class="col-md-3 border-right"><label class="detail-label-custom">Kemandirian</label>
                                        <p class="small font-weight-bold mb-0" id="d_mandiri"></p>
                                    </div>
                                    <div class="col-md-3"><label class="detail-label-custom">Psikologis</label>
                                        <p class="small font-weight-bold mb-0"><span id="d_mental"></span> / <span id="d_emosi"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="detail-card mb-0 h-100">
                                <h6 class="section-title-custom"><i class="fas fa-history detail-icon"></i>Riwayat Sendiri</h6>
                                <p class="small text-muted mb-0" id="d_r_sendiri"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-card mb-0 h-100">
                                <h6 class="section-title-custom"><i class="fas fa-users detail-icon"></i>Riwayat Keluarga</h6>
                                <p class="small text-muted mb-0" id="d_r_keluarga"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <small class="mr-auto text-muted ml-3">Tgl Kunjungan: <span id="d_tgl"></span></small>
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
        // SCRIPT MODAL DETAIL
        $(document).on('click', '.btn-detail', function() {
            // ... (Kode detail lainnya) ...
            $('#d_nama').text($(this).data('nama'));
            $('#d_nik').text($(this).data('nik'));
            $('#d_erm').text($(this).data('erm') || '-');
            $('#d_tgl').text($(this).data('tgl'));
            $('#d_ttl').text($(this).data('ttl'));
            $('#d_umur').text($(this).data('umur') + ' Tahun');
            $('#d_jk').text($(this).data('jk'));

            // LINK HIPERTENSI
            $('#d_link').text($(this).data('link'));

            $('#d_alamat').text($(this).data('alamat'));
            $('#d_bb').text($(this).data('bb'));
            $('#d_tb').text($(this).data('tb'));
            $('#d_imt').text($(this).data('imt'));
            $('#d_gizi').text($(this).data('gizi'));
            $('#d_gds').text(($(this).data('gds') || '-') + ' mg/dL');
            $('#d_chol').text(($(this).data('chol') || '-') + ' mg/dL');

            // WARNA TENSI
            var tensiRaw = $(this).data('tensi');
            $('#d_tensi').text(tensiRaw + ' mmHg');
            var parts = tensiRaw.split('/');
            var sistole = parseInt(parts[0]);
            var diastole = parseInt(parts[1]);
            $('#d_tensi').removeClass('text-success text-danger text-warning');
            $('#tensi_box').removeClass('border-danger border-success');
            $('#tensi_label').removeClass('text-danger text-success').text('Tensi');
            if (sistole >= 140 || diastole >= 90) {
                $('#d_tensi').addClass('text-danger');
                $('#tensi_box').addClass('border-danger');
                $('#tensi_label').addClass('text-danger').text('Tensi (Tinggi)');
            } else if (sistole < 90 || diastole < 60) {
                $('#d_tensi').addClass('text-warning');
                $('#tensi_label').text('Tensi (Rendah)');
            } else {
                $('#d_tensi').addClass('text-success');
                $('#tensi_box').addClass('border-success');
                $('#tensi_label').addClass('text-success').text('Tensi (Normal)');
            }

            // BADGE YA/TIDAK
            function formatYaTidak(val) {
                if (!val) return '-';
                return val === 'Ya' ? '<span class="badge badge-danger">Ya</span>' : '<span class="badge badge-success">Tidak</span>';
            }
            $('#d_merokok').html(formatYaTidak($(this).data('merokok')));
            $('#d_depresi').html(formatYaTidak($(this).data('depresi')));
            $('#d_sayur').html(formatYaTidak($(this).data('sayur')));
            $('#d_aktif').html(formatYaTidak($(this).data('aktif')));

            $('#d_mandiri').text($(this).data('mandiri') || '-');
            $('#d_mental').text($(this).data('mental') || '-');
            $('#d_emosi').text($(this).data('emosi') || '-');
            $('#d_r_sendiri').text($(this).data('r_sendiri') || '-');
            $('#d_r_keluarga').text($(this).data('r_keluarga') || '-');
        });

        // SCRIPT EDIT MODAL
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let url = "{{ route('lansia.update', ':id') }}";
            url = url.replace(':id', id);
            $('#editForm').attr('action', url);

            // ISI DATA DROPDOWN HIPERTENSI
            $('#edit_hipertensi').val($(this).data('hipertensi'));

            $('#edit_nama').val($(this).data('nama'));
            $('#edit_nik').val($(this).data('nik'));
            $('#edit_erm').val($(this).data('erm'));
            $('#edit_kunjungan').val($(this).data('tgl_kunjungan'));
            $('#edit_umur').val($(this).data('umur'));
            $('#edit_alamat').val($(this).data('alamat'));
            $('#edit_tempat_lahir').val($(this).data('tempat_lahir'));
            $('#edit_tgl_lahir').val($(this).data('tgl_lahir'));
            $('#edit_jk').val($(this).data('jk'));
            $('#edit_kelurahan').val($(this).data('kelurahan'));
            $('#edit_berat').val($(this).data('bb'));
            $('#edit_tinggi').val($(this).data('tb'));
            $('#edit_imt').val($(this).data('imt'));
            $('#edit_status').val($(this).data('gizi'));
            $('#edit_lingkar').val($(this).data('lingkar'));
            $('#edit_merokok').val($(this).data('merokok'));
            $('#edit_sayur').val($(this).data('sayur'));
            $('#edit_aktif').val($(this).data('aktif'));
            $('#edit_depresi').val($(this).data('depresi'));
            $('#edit_sistole').val($(this).data('sistole'));
            $('#edit_diastole').val($(this).data('diastole'));
            $('#edit_gds').val($(this).data('gds'));
            $('#edit_chol').val($(this).data('chol'));
            $('#edit_mandiri').val($(this).data('mandiri'));
            $('#edit_mental').val($(this).data('mental'));
            $('#edit_emosi').val($(this).data('emosi'));
            $('#edit_r_sendiri').val($(this).data('r_sendiri'));
            $('#edit_r_keluarga').val($(this).data('r_keluarga'));
        });

        // FUNGSI HITUNG IMT
        function getStatusGizi(imt) {
            if (imt < 18.5) return "Kurus (Kekurangan BB)";
            if (imt >= 18.5 && imt <= 25) return "Normal (Ideal)";
            if (imt > 25 && imt <= 27) return "Gemuk (Kelebihan BB Ringan)";
            return "Obesitas (Kelebihan BB Berat)";
        }

        function calcIMT(prefix) {
            let berat = parseFloat(document.getElementById(prefix + '_berat').value);
            let tinggi = parseFloat(document.getElementById(prefix + '_tinggi').value);
            if (berat > 0 && tinggi > 0) {
                let tinggiM = tinggi / 100;
                let imt = berat / (tinggiM * tinggiM);
                document.getElementById(prefix + '_imt').value = imt.toFixed(2);
                document.getElementById(prefix + '_status').value = getStatusGizi(imt);
            } else {
                document.getElementById(prefix + '_imt').value = "";
                document.getElementById(prefix + '_status').value = "";
            }
        }

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