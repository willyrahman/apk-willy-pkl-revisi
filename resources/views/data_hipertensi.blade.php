<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Data Hipertensi</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .table td,
        .table th {
            white-space: nowrap;
            font-size: 14px;
        }

        .modal-body label {
            font-weight: bold;
            color: #333;
        }

        .detail-text {
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #555;
        }

        .modal {
            z-index: 1050 !important;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }
    </style>
</head>

<body class="">
    <div class="wrapper ">
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
                                <h4 class="card-title">Data Pasien Hipertensi</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addHipertensiModal">
                                    <i class="nc-icon nc-simple-add"></i>&nbsp; Tambah Data
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="text-primary">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>No e-RM</th> {{-- KOLOM BARU --}}
                                                <th>Tanggal</th>
                                                <th>Nama Pasien</th>
                                                <th>NIK</th>
                                                <th>JK</th>
                                                <th>Alamat</th>
                                                <th>No. Asuransi</th>
                                                <th class="text-center">Skala Nyeri</th>
                                                <th>Diagnosa</th>
                                                <th>Kasus</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data_hipertensi as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td><span class="badge badge-info">{{ $item->no_e_rekam_medis ?? '-' }}</span></td> {{-- DATA BARU --}}
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                                <td>{{ $item->nama_pasien }}</td>
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->jenis_kelamin }}</td>
                                                <td>{{ Str::limit($item->alamat, 15) }}</td>
                                                <td>{{ $item->no_asuransi ?? '-' }}</td>
                                                <td class="text-center">{{ $item->skala_nyeri }}</td>
                                                <td>{{ $item->diagnosa_1 }} ({{ $item->icd_x_1 }})</td>
                                                <td>
                                                    <span class="badge {{ $item->jenis_kasus_1 == 'Baru' ? 'badge-success' : 'badge-warning' }}">
                                                        {{ $item->jenis_kasus_1 }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{-- TOMBOL DETAIL --}}
                                                    <button type="button" class="btn btn-sm btn-info btn-icon btn-detail"
                                                        data-toggle="modal" data-target="#detailHipertensiModal"
                                                        data-nama="{{ $item->nama_pasien }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-jk="{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                                                        data-tgl="{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}"
                                                        data-telp="{{ $item->no_telp }}"
                                                        data-alamat="{{ $item->alamat }}"
                                                        data-rt="{{ $item->rt }}"
                                                        data-rw="{{ $item->rw }}"
                                                        data-asuransi="{{ $item->no_asuransi ?? '-' }}"
                                                        data-nyeri="{{ $item->skala_nyeri }}"
                                                        data-icd="{{ $item->icd_x_1 }}"
                                                        data-diagnosa="{{ $item->diagnosa_1 }}"
                                                        data-kasus="{{ $item->jenis_kasus_1 }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    {{-- TOMBOL EDIT --}}
                                                    <button type="button" class="btn btn-sm btn-warning btn-icon btn-edit"
                                                        data-toggle="modal" data-target="#editHipertensiModal"
                                                        data-id="{{ $item->id }}"
                                                        data-nama="{{ $item->nama_pasien }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-jk="{{ $item->jenis_kelamin }}"
                                                        data-tgl="{{ $item->tanggal }}"
                                                        data-telp="{{ $item->no_telp }}"
                                                        data-alamat="{{ $item->alamat }}"
                                                        data-rt="{{ $item->rt }}"
                                                        data-rw="{{ $item->rw }}"
                                                        data-asuransi="{{ $item->no_asuransi }}"
                                                        data-nyeri="{{ $item->skala_nyeri }}"
                                                        data-icd="{{ $item->icd_x_1 }}"
                                                        data-diagnosa="{{ $item->diagnosa_1 }}"
                                                        data-kasus="{{ $item->jenis_kasus_1 }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    {{-- TOMBOL HAPUS --}}
                                                    <form id="delete-form-{{ $item->id }}" action="{{ route('hipertensi.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-danger btn-icon" onclick="confirmDelete({{ $item->id }})">
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

    <div class="modal fade" id="addHipertensiModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Input Data Pasien Hipertensi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('hipertensi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis</label>
                            <input type="text" name="no_e_rekam_medis" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group"><label>Nama Pasien</label><input type="text" name="nama_pasien" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="number" name="nik" class="form-control" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>No. Asuransi</label><input type="text" name="no_asuransi" class="form-control"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">- Pilih -</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>No Telp</label><input type="text" name="no_telp" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Skala Nyeri</label><input type="text" name="skala_nyeri" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Alamat Lengkap</label><textarea name="alamat" class="form-control" rows="2"></textarea></div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>RT</label><input type="text" name="rt" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>RW</label><input type="text" name="rw" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kasus 1</label>
                                    <select name="jenis_kasus_1" class="form-control">
                                        <option value="Baru">Baru</option>
                                        <option value="Lama">Lama</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>ICD-X 1</label><input type="text" name="icd_x_1" class="form-control"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group"><label>Diagnosa 1</label><input type="text" name="diagnosa_1" class="form-control"></div>
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

    <div class="modal fade" id="editHipertensiModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Data Hipertensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis</label>
                            <input type="text" name="no_e_rekam_medis" id="edit_erm" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" id="edit_tanggal" class="form-control" required></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group"><label>Nama Pasien</label><input type="text" name="nama_pasien" id="edit_nama" class="form-control" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="number" name="nik" id="edit_nik" class="form-control" required></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>No. Asuransi</label><input type="text" name="no_asuransi" id="edit_asuransi" class="form-control"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="edit_jk" class="form-control" required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>No Telp</label><input type="text" name="no_telp" id="edit_telp" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Skala Nyeri</label><input type="text" name="skala_nyeri" id="edit_nyeri" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-group"><label>Alamat Lengkap</label><textarea name="alamat" id="edit_alamat" class="form-control" rows="2"></textarea></div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group"><label>RT</label><input type="text" name="rt" id="edit_rt" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>RW</label><input type="text" name="rw" id="edit_rw" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kasus 1</label>
                                    <select name="jenis_kasus_1" id="edit_kasus" class="form-control">
                                        <option value="Baru">Baru</option>
                                        <option value="Lama">Lama</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"><label>ICD-X 1</label><input type="text" name="icd_x_1" id="edit_icd" class="form-control"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group"><label>Diagnosa 1</label><input type="text" name="diagnosa_1" id="edit_diagnosa" class="form-control"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailHipertensiModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Detail Data Pasien</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"><label>Nama Pasien</label>
                            <p class="detail-text" id="det_nama"></p>
                        </div>
                        <div class="col-md-6"><label>NIK</label>
                            <p class="detail-text" id="det_nik"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><label>No e-Rekam Medis</label> {{-- DETAIL BARU --}}
                            <p class="detail-text" id="det_erm"></p>
                        </div>
                        <div class="col-md-6"><label>Jenis Kelamin</label>
                            <p class="detail-text" id="det_jk"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label>Tanggal Periksa</label>
                            <p class="detail-text" id="det_tgl"></p>
                        </div>
                        <div class="col-md-4"><label>No. Asuransi</label>
                            <p class="detail-text" id="det_asuransi"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label>No. Telepon</label>
                            <p class="detail-text" id="det_telp"></p>
                        </div>
                        <div class="col-md-8"><label>Alamat Lengkap</label>
                            <p class="detail-text" id="det_alamat"></p>
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-primary">Data Medis</h6>
                    <div class="row">
                        <div class="col-md-4"><label>Skala Nyeri</label>
                            <p class="detail-text" id="det_nyeri"></p>
                        </div>
                        <div class="col-md-4"><label>Jenis Kasus</label>
                            <p class="detail-text" id="det_kasus"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label>Kode ICD-X</label>
                            <p class="detail-text font-weight-bold" id="det_icd"></p>
                        </div>
                        <div class="col-md-8"><label>Diagnosa</label>
                            <p class="detail-text" id="det_diagnosa"></p>
                        </div>
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
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            // 1. Handle Edit Modal
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                let url = "{{ route('hipertensi.update', ':id') }}";
                url = url.replace(':id', id);
                $('#editForm').attr('action', url);

                $('#edit_tanggal').val($(this).data('tgl'));
                $('#edit_nama').val($(this).data('nama'));
                $('#edit_nik').val($(this).data('nik'));
                $('#edit_erm').val($(this).data('erm')); // Isi Edit ERM
                $('#edit_jk').val($(this).data('jk'));
                $('#edit_asuransi').val($(this).data('asuransi'));
                $('#edit_telp').val($(this).data('telp'));
                $('#edit_nyeri').val($(this).data('nyeri'));
                $('#edit_alamat').val($(this).data('alamat'));
                $('#edit_rt').val($(this).data('rt'));
                $('#edit_rw').val($(this).data('rw'));
                $('#edit_kasus').val($(this).data('kasus'));
                $('#edit_icd').val($(this).data('icd'));
                $('#edit_diagnosa').val($(this).data('diagnosa'));
            });

            // 2. Handle Detail Modal
            $(document).on('click', '.btn-detail', function() {
                $('#det_nama').text($(this).data('nama'));
                $('#det_nik').text($(this).data('nik'));
                $('#det_erm').text($(this).data('erm') || '-'); // Isi Detail ERM
                $('#det_jk').text($(this).data('jk'));
                $('#det_tgl').text($(this).data('tgl'));
                $('#det_asuransi').text($(this).data('asuransi'));
                $('#det_telp').text($(this).data('telp'));
                $('#det_alamat').text($(this).data('alamat') + ' (RT ' + $(this).data('rt') + ' / RW ' + $(this).data('rw') + ')');
                $('#det_nyeri').text($(this).data('nyeri'));
                $('#det_kasus').text($(this).data('kasus'));
                $('#det_icd').text($(this).data('icd'));
                $('#det_diagnosa').text($(this).data('diagnosa'));
            });
        });

        // 3. Handle Delete
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
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