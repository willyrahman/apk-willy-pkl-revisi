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

        .bg-custom {
            background-color: #f8f9fa;
        }

        .detail-label {
            font-weight: bold;
            color: #66615b;
            font-size: 12px;
            margin-bottom: 2px;
            text-align: left;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .section-title {
            border-bottom: 2px solid #51cbce;
            margin-bottom: 15px;
            margin-top: 10px;
            padding-bottom: 5px;
            font-weight: bold;
            color: #51cbce;
            text-align: left;
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
                                                <th>No e-RM (Lansia)</th>
                                                <th>Tgl Kunjungan</th>
                                                <th>Nama Lansia</th>
                                                <th>Umur</th>
                                                <th>Link Hipertensi & No. RM</th> {{-- JUDUL KOLOM DIUPDATE --}}
                                                <th>Alamat</th>
                                                <th>BB (kg)</th>
                                                <th>TB (cm)</th>
                                                <th>IMT</th>
                                                <th>Status Gizi</th>
                                                <th>Tensi</th>
                                                <th>GDS/Chol</th>
                                                <th class="bg-custom">Merokok</th>
                                                <th class="bg-custom">Depresi</th>
                                                <th class="bg-custom">Kurang Sayur</th>
                                                <th class="bg-custom">Kurang Aktif</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lansias as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="badge badge-info">{{ $item->no_e_rekam_medis ?? '-' }}</span></td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}</td>
                                                <td class="text-left">{{ $item->nama_lengkap }}</td>
                                                <td>{{ $item->umur }}</td>

                                                {{-- KOLOM LINK HIPERTENSI DIPERBARUI --}}
                                                <td>
                                                    <span class="font-weight-bold">{{ $item->hipertensi->nama_pasien ?? '-' }}</span>
                                                    @if(isset($item->hipertensi->no_e_rekam_medis))
                                                    <br>
                                                    <small class="text-muted" style="font-size: 11px;">
                                                        RM: {{ $item->hipertensi->no_e_rekam_medis }}
                                                    </small>
                                                    @endif
                                                </td>

                                                <td class="text-left">{{ \Illuminate\Support\Str::limit($item->alamat, 15) }}</td>
                                                <td>{{ $item->berat_badan }}</td>
                                                <td>{{ $item->tinggi_badan }}</td>
                                                <td>{{ $item->imt }}</td>
                                                <td><span class="badge badge-default">{{ $item->status_gizi }}</span></td>
                                                <td>{{ $item->sistole }}/{{ $item->diastole }}</td>
                                                <td>{{ $item->gds }} / {{ $item->kolesterol }}</td>
                                                <td class="bg-custom">
                                                    @if($item->merokok == 'Ya') <span class="text-danger font-weight-bold">Ya</span> @else Tidak @endif
                                                </td>
                                                <td class="bg-custom">
                                                    @if($item->depresi == 'Ya') <span class="text-danger font-weight-bold">Ya</span> @else Tidak @endif
                                                </td>
                                                <td class="bg-custom">
                                                    @if($item->kurang_makan_sayur_buah == 'Ya') <span class="text-danger font-weight-bold">Ya</span> @else Tidak @endif
                                                </td>
                                                <td class="bg-custom">
                                                    @if($item->kurang_aktifitas_fisik == 'Ya') <span class="text-danger font-weight-bold">Ya</span> @else Tidak @endif
                                                </td>
                                                <td>
                                                    {{-- TOMBOL DETAIL --}}
                                                    <button class="btn btn-info btn-sm btn-icon btn-detail"
                                                        data-toggle="modal" data-target="#detailLansiaModal"
                                                        data-nama="{{ $item->nama_lengkap }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-tgl="{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d F Y') }}"
                                                        data-ttl="{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir }}"
                                                        data-umur="{{ $item->umur }}"
                                                        data-jk="{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"

                                                        {{-- Mengirim data link hipertensi dan RM ke modal detail --}}
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
                                                        data-merokok="{{ $item->merokok }}"
                                                        data-depresi="{{ $item->depresi }}"
                                                        data-sayur="{{ $item->kurang_makan_sayur_buah }}"
                                                        data-aktif="{{ $item->kurang_aktifitas_fisik }}"
                                                        data-mandiri="{{ $item->tingkat_kemandirian }}"
                                                        data-mental="{{ $item->gangguan_mental }}"
                                                        data-emosi="{{ $item->status_emosional }}"
                                                        data-r_sendiri="{{ $item->riwayat_penyakit_sendiri }}"
                                                        data-r_keluarga="{{ $item->riwayat_penyakit_keluarga }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    {{-- TOMBOL EDIT --}}
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
                                                        data-merokok="{{ $item->merokok }}"
                                                        data-depresi="{{ $item->depresi }}"
                                                        data-sayur="{{ $item->kurang_makan_sayur_buah }}"
                                                        data-aktif="{{ $item->kurang_aktifitas_fisik }}"
                                                        data-sistole="{{ $item->sistole }}"
                                                        data-diastole="{{ $item->diastole }}"
                                                        data-gds="{{ $item->gds }}"
                                                        data-chol="{{ $item->kolesterol }}"
                                                        data-mandiri="{{ $item->tingkat_kemandirian }}"
                                                        data-mental="{{ $item->gangguan_mental }}"
                                                        data-emosi="{{ $item->status_emosional }}"
                                                        data-r_sendiri="{{ $item->riwayat_penyakit_sendiri }}"
                                                        data-r_keluarga="{{ $item->riwayat_penyakit_keluarga }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    {{-- TOMBOL HAPUS --}}
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
                    <h5 class="modal-title">Input Data Lansia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('lansia.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis (Lansia)</label>
                            <input type="text" class="form-control" name="no_e_rekam_medis" placeholder="Nomor RM Elektronik">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" class="form-control" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="number" name="nik" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Link Hipertensi (Opsional)</label>
                                    <select name="hipertensi_id" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($data_hipertensi as $h)
                                        <option value="{{ $h->id }}">
                                            {{ $h->nama_pasien }} {{ $h->no_e_rekam_medis ? '(RM: '.$h->no_e_rekam_medis.')' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tgl Kunjungan</label><input type="date" name="tanggal_kunjungan" class="form-control" required></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Umur</label><input type="number" name="umur" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Alamat</label><input type="text" name="alamat" class="form-control"></div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tgl Lahir</label><input type="date" name="tanggal_lahir" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Kelurahan</label><input type="text" name="kelurahan" class="form-control"></div>
                            </div>
                        </div>

                        <h6 class="mt-2 text-muted">Fisik</h6>
                        <div class="row bg-light p-2 mx-1 mb-2">
                            <div class="col-md-3">
                                <div class="form-group"><label>Berat (Kg)</label><input type="number" step="0.1" name="berat_badan" id="add_berat" class="form-control" required oninput="calcIMT('add')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tinggi (Cm)</label><input type="number" step="0.1" name="tinggi_badan" id="add_tinggi" class="form-control" required oninput="calcIMT('add')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>IMT</label><input type="number" step="0.01" name="imt" id="add_imt" class="form-control" readonly></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Status Gizi</label><input type="text" name="status_gizi" id="add_status" class="form-control" readonly placeholder="Otomatis"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Lingkar Perut</label><input type="number" name="lingkar_perut" class="form-control"></div>

                        <h6 class="mt-2 text-muted">Gaya Hidup & Risiko</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Merokok</label><select name="merokok" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Depresi</label><select name="depresi" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Kurang Sayur/Buah</label><select name="kurang_makan_sayur_buah" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Kurang Aktif</label><select name="kurang_aktifitas_fisik" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                        </div>

                        <h6 class="mt-2 text-muted">Lab</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Sistole</label><input type="number" name="sistole" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Diastole</label><input type="number" name="diastole" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>GDS</label><input type="number" name="gds" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Chol</label><input type="number" name="kolesterol" class="form-control"></div>
                            </div>
                        </div>

                        <h6 class="mt-2 text-muted">Lainnya</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Tingkat Kemandirian</label><input type="text" name="tingkat_kemandirian" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Gangguan Mental</label><input type="text" name="gangguan_mental" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Status Emosional</label><input type="text" name="status_emosional" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Riwayat Penyakit Sendiri</label><textarea name="riwayat_penyakit_sendiri" class="form-control" rows="1"></textarea></div>
                        <div class="form-group"><label>Riwayat Penyakit Keluarga</label><textarea name="riwayat_penyakit_keluarga" class="form-control" rows="1"></textarea></div>
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
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis (Lansia)</label>
                            <input type="text" class="form-control" id="edit_erm" name="no_e_rekam_medis">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-left"><label>Nama Lengkap</label><input type="text" name="nama_lengkap" id="edit_nama" class="form-control" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-left"><label>NIK</label><input type="number" name="nik" id="edit_nik" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group text-left"><label>Link Hipertensi</label>
                                    <select name="hipertensi_id" id="edit_hipertensi" class="form-control">
                                        <option value="">- Tidak Ada -</option>
                                        @foreach($data_hipertensi as $h)
                                        <option value="{{ $h->id }}">
                                            {{ $h->nama_pasien }} {{ $h->no_e_rekam_medis ? '(RM: '.$h->no_e_rekam_medis.')' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-left"><label>Tgl Kunjungan</label><input type="date" name="tanggal_kunjungan" id="edit_kunjungan" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-left"><label>Umur</label><input type="number" name="umur" id="edit_umur" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group text-left"><label>Alamat</label><input type="text" name="alamat" id="edit_alamat" class="form-control"></div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Tgl Lahir</label><input type="date" name="tanggal_lahir" id="edit_tgl_lahir" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="edit_jk" class="form-control">
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Kelurahan</label><input type="text" name="kelurahan" id="edit_kelurahan" class="form-control"></div>
                            </div>
                        </div>

                        <h6 class="mt-2 text-muted text-left">Fisik (Edit)</h6>
                        <div class="row bg-light p-2 mx-1 mb-2">
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Berat (Kg)</label><input type="number" step="0.1" name="berat_badan" id="edit_berat" class="form-control" oninput="calcIMT('edit')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Tinggi (Cm)</label><input type="number" step="0.1" name="tinggi_badan" id="edit_tinggi" class="form-control" oninput="calcIMT('edit')"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>IMT</label><input type="number" step="0.01" name="imt" id="edit_imt" class="form-control" readonly></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Status Gizi</label><input type="text" name="status_gizi" id="edit_status" class="form-control" readonly></div>
                            </div>
                        </div>
                        <div class="form-group text-left"><label>Lingkar Perut</label><input type="number" name="lingkar_perut" id="edit_lingkar" class="form-control"></div>

                        <h6 class="mt-2 text-muted text-left">Gaya Hidup & Risiko</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Merokok</label><select name="merokok" id="edit_merokok" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Depresi</label><select name="depresi" id="edit_depresi" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Kurang Sayur</label><select name="kurang_makan_sayur_buah" id="edit_sayur" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Kurang Aktif</label><select name="kurang_aktifitas_fisik" id="edit_aktif" class="form-control">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select></div>
                            </div>
                        </div>

                        <h6 class="mt-2 text-muted text-left">Lab</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Sistole</label><input type="number" name="sistole" id="edit_sistole" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Diastole</label><input type="number" name="diastole" id="edit_diastole" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>GDS</label><input type="number" name="gds" id="edit_gds" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-left"><label>Chol</label><input type="number" name="kolesterol" id="edit_chol" class="form-control"></div>
                            </div>
                        </div>

                        <h6 class="mt-2 text-muted text-left">Lainnya</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group text-left"><label>Tingkat Kemandirian</label><input type="text" name="tingkat_kemandirian" id="edit_mandiri" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-left"><label>Gangguan Mental</label><input type="text" name="gangguan_mental" id="edit_mental" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-left"><label>Status Emosional</label><input type="text" name="status_emosional" id="edit_emosi" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group text-left"><label>Riwayat Penyakit Sendiri</label><textarea name="riwayat_penyakit_sendiri" id="edit_r_sendiri" class="form-control" rows="1"></textarea></div>
                        <div class="form-group text-left"><label>Riwayat Penyakit Keluarga</label><textarea name="riwayat_penyakit_keluarga" id="edit_r_keluarga" class="form-control" rows="1"></textarea></div>
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
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-white">Detail Data Lansia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="section-title">Identitas Pribadi</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-label">Nama Lengkap</div>
                            <div class="detail-value" id="det_nama"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">NIK</div>
                            <div class="detail-value" id="det_nik"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">No e-RM</div>
                            <div class="detail-value" id="det_erm"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-label">Tanggal Kunjungan</div>
                            <div class="detail-value" id="det_tgl"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">TTL</div>
                            <div class="detail-value" id="det_ttl"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Umur / JK</div>
                            <div class="detail-value"><span id="det_umur"></span> Tahun / <span id="det_jk"></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-label">Link Hipertensi & No RM</div>
                            <div class="detail-value" id="det_link"></div>
                        </div>
                        <div class="col-md-8">
                            <div class="detail-label">Alamat Lengkap (Kelurahan)</div>
                            <div class="detail-value" id="det_alamat"></div>
                        </div>
                    </div>

                    <div class="section-title">Pemeriksaan Fisik & Gizi</div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="detail-label">Berat Badan</div>
                            <div class="detail-value"><span id="det_bb"></span> Kg</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Tinggi Badan</div>
                            <div class="detail-value"><span id="det_tb"></span> Cm</div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">IMT</div>
                            <div class="detail-value" id="det_imt"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Lingkar Perut</div>
                            <div class="detail-value"><span id="det_lingkar"></span> Cm</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="detail-label">Status Gizi</div>
                            <div class="detail-value text-primary" id="det_gizi"></div>
                        </div>
                    </div>

                    <div class="section-title">Tanda Vital & Laboratorium</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-label">Tekanan Darah</div>
                            <div class="detail-value"><span id="det_tensi"></span> mmHg</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Gula Darah Sewaktu</div>
                            <div class="detail-value"><span id="det_gds"></span> mg/dL</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Kolesterol</div>
                            <div class="detail-value"><span id="det_chol"></span> mg/dL</div>
                        </div>
                    </div>

                    <div class="section-title">Gaya Hidup & Risiko</div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="detail-label">Merokok</div>
                            <div class="detail-value" id="det_merokok"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Depresi</div>
                            <div class="detail-value" id="det_depresi"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Kurang Sayur/Buah</div>
                            <div class="detail-value" id="det_sayur"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-label">Kurang Aktivitas</div>
                            <div class="detail-value" id="det_aktif"></div>
                        </div>
                    </div>

                    <div class="section-title">Lainnya</div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-label">Tingkat Kemandirian</div>
                            <div class="detail-value" id="det_mandiri"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Gangguan Mental</div>
                            <div class="detail-value" id="det_mental"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Status Emosional</div>
                            <div class="detail-value" id="det_emosi"></div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="detail-label">Riwayat Penyakit Sendiri</label>
                        <div class="p-2 bg-light border rounded" id="det_r_sendiri"></div>
                    </div>
                    <div class="form-group">
                        <label class="detail-label">Riwayat Penyakit Keluarga</label>
                        <div class="p-2 bg-light border rounded" id="det_r_keluarga"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
        // 1. Script Detail Modal
        $(document).on('click', '.btn-detail', function() {
            $('#det_nama').text($(this).data('nama'));
            $('#det_nik').text($(this).data('nik'));
            $('#det_erm').text($(this).data('erm') || '-');
            $('#det_tgl').text($(this).data('tgl'));
            $('#det_ttl').text($(this).data('ttl'));
            $('#det_umur').text($(this).data('umur'));
            $('#det_jk').text($(this).data('jk'));
            $('#det_link').text($(this).data('link'));
            $('#det_alamat').text($(this).data('alamat'));
            $('#det_bb').text($(this).data('bb'));
            $('#det_tb').text($(this).data('tb'));
            $('#det_imt').text($(this).data('imt'));
            $('#det_lingkar').text($(this).data('lingkar'));
            $('#det_gizi').text($(this).data('gizi'));
            $('#det_tensi').text($(this).data('tensi'));
            $('#det_gds').text($(this).data('gds'));
            $('#det_chol').text($(this).data('chol'));
            $('#det_merokok').text($(this).data('merokok'));
            $('#det_depresi').text($(this).data('depresi'));
            $('#det_sayur').text($(this).data('sayur'));
            $('#det_aktif').text($(this).data('aktif'));
            $('#det_mandiri').text($(this).data('mandiri'));
            $('#det_mental').text($(this).data('mental'));
            $('#det_emosi').text($(this).data('emosi'));
            $('#det_r_sendiri').text($(this).data('r_sendiri'));
            $('#det_r_keluarga').text($(this).data('r_keluarga'));
        });

        // 2. Script Edit Modal
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let url = "{{ route('lansia.update', ':id') }}";
            url = url.replace(':id', id);
            $('#editForm').attr('action', url);

            $('#edit_nama').val($(this).data('nama'));
            $('#edit_nik').val($(this).data('nik'));
            $('#edit_erm').val($(this).data('erm'));
            $('#edit_hipertensi').val($(this).data('hipertensi'));
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
            $('#edit_depresi').val($(this).data('depresi'));
            $('#edit_sayur').val($(this).data('sayur'));
            $('#edit_aktif').val($(this).data('aktif'));
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

        // 3. Logic Status Gizi & Hitung IMT
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