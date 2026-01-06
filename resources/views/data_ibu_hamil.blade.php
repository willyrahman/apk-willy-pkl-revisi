<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Data Ibu Hamil</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        table td,
        table th {
            padding: 10px 15px;
            white-space: nowrap;
        }

        .btn:hover {
            transform: scale(1.05);
            transition: transform 0.2s;
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
                                <h4 class="card-title">Data Ibu Hamil</h4>
                                <button type="button" class="btn btn-primary mr-4" data-toggle="modal" data-target="#addIbuHamilModal">
                                    <i class="nc-icon nc-simple-add"></i>&nbsp; Tambah Data
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="text-primary">
                                            <th class="text-center">No</th>
                                            <th>No e-RM</th>
                                            <th class="text-center">Tanggal Pemeriksaan K6</th>
                                            <th>Nama Ibu Hamil</th>
                                            <th class="text-center">Tgl Lahir</th>
                                            <th class="text-center">NIK</th>
                                            <th>Nama Suami</th>
                                            <th>Alamat</th>

                                            <th class="text-center">Jaminan</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($ibuhampils as $index => $ibuhamil)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td><span class="badge badge-info">{{ $ibuhamil->no_e_rekam_medis ?? '-' }}</span></td>
                                                <td class="text-center">
                                                    @if($ibuhamil->tgl_pemeriksaan_k6)
                                                    {{ \Carbon\Carbon::parse($ibuhamil->tgl_pemeriksaan_k6)->translatedFormat('d F Y') }}
                                                    @else
                                                    <span class="badge badge-warning">Belum</span>
                                                    @endif
                                                </td>
                                                <td>{{ $ibuhamil->nama_ibu }}</td>
                                                {{-- FORMAT TANGGAL INDONESIA --}}
                                                <td class="text-center">{{ \Carbon\Carbon::parse($ibuhamil->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                                                <td class="text-center">{{ $ibuhamil->nik }}</td>
                                                <td>{{ $ibuhamil->nama_suami }}</td>
                                                <td>{{ Str::limit($ibuhamil->alamat, 20) }}</td>

                                                <td class="text-center">{{ $ibuhamil->jaminan_kesehatan }}</td>
                                                <td class="text-center">
                                                    {{-- TOMBOL DETAIL --}}
                                                    <button class="btn btn-info btn-sm btn-detail"
                                                        data-toggle="modal"
                                                        data-target="#detailIbuHamilModal"
                                                        data-nama="{{ $ibuhamil->nama_ibu }}"
                                                        data-lahir="{{ \Carbon\Carbon::parse($ibuhamil->tanggal_lahir)->translatedFormat('d F Y') }}"
                                                        data-nik="{{ $ibuhamil->nik }}"
                                                        data-erm="{{ $ibuhamil->no_e_rekam_medis }}"
                                                        data-suami="{{ $ibuhamil->nama_suami }}"
                                                        data-alamat="{{ $ibuhamil->alamat }}"
                                                        data-k6="{{ $ibuhamil->tgl_pemeriksaan_k6 ? \Carbon\Carbon::parse($ibuhamil->tgl_pemeriksaan_k6)->translatedFormat('d F Y') : 'Belum diperiksa' }}"
                                                        data-jaminan="{{ $ibuhamil->jaminan_kesehatan }}"
                                                        title="Detail">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>

                                                    {{-- TOMBOL EDIT --}}
                                                    <button class="btn btn-warning btn-sm btn-edit"
                                                        data-toggle="modal"
                                                        data-target="#editIbuHamilModal"
                                                        data-id="{{ $ibuhamil->id }}"
                                                        data-nama="{{ $ibuhamil->nama_ibu }}"
                                                        data-lahir="{{ $ibuhamil->tanggal_lahir }}"
                                                        data-nik="{{ $ibuhamil->nik }}"
                                                        data-erm="{{ $ibuhamil->no_e_rekam_medis }}"
                                                        data-suami="{{ $ibuhamil->nama_suami }}"
                                                        data-alamat="{{ $ibuhamil->alamat }}"
                                                        data-k6="{{ $ibuhamil->tgl_pemeriksaan_k6 }}"
                                                        data-jaminan="{{ $ibuhamil->jaminan_kesehatan }}"
                                                        title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>

                                                    {{-- TOMBOL HAPUS --}}
                                                    <form id="delete-form-{{ $ibuhamil->id }}" action="{{ route('ibuHamil.destroy', $ibuhamil->id) }}" method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $ibuhamil->id }})" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
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

    <div class="modal fade" id="addIbuHamilModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Ibu Hamil</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('ibuHamil.store') }}" method="POST" onsubmit="showLoading()">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis</label>
                            <input type="text" class="form-control" name="no_e_rekam_medis" placeholder="Opsional">
                        </div>
                        <div class="form-group"><label>Nama Ibu Hamil</label><input type="text" class="form-control" name="nama_ibu" required></div>
                        <div class="form-group"><label>Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" required></div>
                        <div class="form-group"><label>NIK</label><input type="number" class="form-control" name="nik" required></div>
                        <div class="form-group"><label>Nama Suami</label><input type="text" class="form-control" name="nama_suami" required></div>
                        <div class="form-group"><label>Alamat</label><textarea class="form-control" name="alamat" rows="3" required></textarea></div>
                        <div class="form-group">
                            <label>Tanggal Pemeriksaan K6 <small class="text-muted">(Opsional)</small></label>
                            <input type="date" class="form-control" name="tgl_pemeriksaan_k6">
                        </div>
                        <div class="form-group">
                            <label>Jaminan Kesehatan</label>
                            <select class="form-control" name="jaminan_kesehatan" required>
                                <option value="">Pilih Jaminan</option>
                                <option value="BPJS Mandiri">BPJS Mandiri</option>
                                <option value="BPJS PBI">BPJS PBI</option>
                                <option value="Asuransi Swasta">Asuransi Swasta</option>
                                <option value="Umum">Umum</option>
                            </select>
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

    <div class="modal fade" id="editIbuHamilModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Data Ibu Hamil</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="editForm" method="POST" onsubmit="showLoading()">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis</label>
                            <input type="text" class="form-control" id="edit_erm" name="no_e_rekam_medis">
                        </div>
                        <div class="form-group"><label>Nama Ibu Hamil</label><input type="text" class="form-control" id="edit_nama" name="nama_ibu" required></div>
                        <div class="form-group"><label>Tanggal Lahir</label><input type="date" class="form-control" id="edit_lahir" name="tanggal_lahir" required></div>
                        <div class="form-group"><label>NIK</label><input type="number" class="form-control" id="edit_nik" name="nik" required></div>
                        <div class="form-group"><label>Nama Suami</label><input type="text" class="form-control" id="edit_suami" name="nama_suami" required></div>
                        <div class="form-group"><label>Alamat</label><textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea></div>
                        <div class="form-group">
                            <label>Tanggal Pemeriksaan K6</label>
                            <input type="date" class="form-control" id="edit_k6" name="tgl_pemeriksaan_k6">
                        </div>
                        <div class="form-group">
                            <label>Jaminan Kesehatan</label>
                            <select class="form-control" id="edit_jaminan" name="jaminan_kesehatan" required>
                                <option value="BPJS Mandiri">BPJS Mandiri</option>
                                <option value="BPJS PBI">BPJS PBI</option>
                                <option value="Asuransi Swasta">Asuransi Swasta</option>
                                <option value="Umum">Umum</option>
                            </select>
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

    <div class="modal fade" id="detailIbuHamilModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><strong>Detail Data Ibu Hamil</strong></h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="35%"><strong>Nama Ibu</strong></td>
                            <td>: <span id="det_nama"></span></td>
                        </tr>
                        <tr>
                            <td><strong>No e-RM</strong></td>
                            <td>: <span id="det_erm"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Tgl Lahir</strong></td>
                            <td>: <span id="det_lahir"></span></td>
                        </tr>
                        <tr>
                            <td><strong>NIK</strong></td>
                            <td>: <span id="det_nik"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Nama Suami</strong></td>
                            <td>: <span id="det_suami"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>: <span id="det_alamat"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Pemeriksaan K6</strong></td>
                            <td>: <span id="det_k6"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Jaminan</strong></td>
                            <td>: <span id="det_jaminan"></span></td>
                        </tr>
                    </table>
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
        $(document).on('click', '.btn-detail', function() {
            $('#det_nama').text($(this).data('nama'));
            $('#det_lahir').text($(this).data('lahir'));
            $('#det_nik').text($(this).data('nik'));
            $('#det_erm').text($(this).data('erm') || '-');
            $('#det_suami').text($(this).data('suami'));
            $('#det_alamat').text($(this).data('alamat'));
            $('#det_k6').text($(this).data('k6'));
            $('#det_jaminan').text($(this).data('jaminan'));
        });

        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var url = "{{ route('ibuHamil.update', ':id') }}".replace(':id', id);
            $('#editForm').attr('action', url);
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_lahir').val($(this).data('lahir'));
            $('#edit_nik').val($(this).data('nik'));
            $('#edit_erm').val($(this).data('erm'));
            $('#edit_suami').val($(this).data('suami'));
            $('#edit_alamat').val($(this).data('alamat'));
            $('#edit_k6').val($(this).data('k6'));
            $('#edit_jaminan').val($(this).data('jaminan'));
        });

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
                    showLoading();
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function showLoading() {
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        }

        @if(session('success')) Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}"
        });
        @endif
        @if(session('error')) Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}"
        });
        @endif
    </script>
</body>

</html>