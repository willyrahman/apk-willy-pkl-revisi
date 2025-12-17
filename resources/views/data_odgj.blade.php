<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Data Pasien ODGJ</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .table td,
        .table th {
            white-space: nowrap;
        }

        .modal-body th {
            width: 35%;
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
                                <h4 class="card-title">Data Pasien ODGJ</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPasienModal">
                                    <i class="nc-icon nc-simple-add"></i>&nbsp; Tambah Pasien
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-primary">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>No e-RM</th> {{-- KOLOM BARU --}}
                                                <th>NIK</th>
                                                <th>Nama Pasien</th>
                                                <th>JK</th>
                                                <th>Umur</th>
                                                <th>Alamat</th>
                                                <th>Status</th>
                                                <th>Jadwal Kontrol</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($odgjs as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td><span class="badge badge-info">{{ $item->no_e_rekam_medis ?? '-' }}</span></td> {{-- DATA BARU --}}
                                                <td>{{ $item->nik }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->jenis_kelamin }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Thn</td>
                                                <td>{{ Str::limit($item->alamat, 15) }}</td>
                                                <td>
                                                    <span class="badge {{ $item->status_pasien == 'Baru' ? 'badge-success' : 'badge-info' }}">
                                                        {{ $item->status_pasien }}
                                                    </span>
                                                </td>
                                                <td>{{ $item->jadwal_kontrol }}</td>
                                                <td class="text-center">
                                                    {{-- TOMBOL DETAIL --}}
                                                    <button class="btn btn-info btn-sm btn-detail"
                                                        data-toggle="modal"
                                                        data-target="#detailModal"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-nama="{{ $item->nama }}"
                                                        data-jk="{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                                                        data-tgl="{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d F Y') }}"
                                                        data-umur="{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }}"
                                                        data-alamat="{{ $item->alamat }}"
                                                        data-rt="{{ $item->rt }}"
                                                        data-status="{{ $item->status_pasien }}"
                                                        data-diagnosis="{{ $item->diagnosis }}"
                                                        data-kontrol="{{ $item->jadwal_kontrol }}"
                                                        data-ket="{{ $item->keterangan }}">
                                                        <i class="fa fa-info-circle"></i>
                                                    </button>

                                                    {{-- TOMBOL EDIT --}}
                                                    <button class="btn btn-warning btn-sm btn-edit"
                                                        data-toggle="modal"
                                                        data-target="#editPasienModal"
                                                        data-id="{{ $item->id }}"
                                                        data-nik="{{ $item->nik }}"
                                                        data-erm="{{ $item->no_e_rekam_medis }}"
                                                        data-nama="{{ $item->nama }}"
                                                        data-jk="{{ $item->jenis_kelamin }}"
                                                        data-tgl="{{ $item->tanggal_lahir }}"
                                                        data-alamat="{{ $item->alamat }}"
                                                        data-rt="{{ $item->rt }}"
                                                        data-status="{{ $item->status_pasien }}"
                                                        data-jadwal="{{ $item->jadwal_kontrol }}"
                                                        data-diagnosis="{{ $item->diagnosis }}"
                                                        data-ket="{{ $item->keterangan }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    {{-- TOMBOL HAPUS --}}
                                                    <form id="delete-form-{{ $item->id }}" action="{{ route('odgj.destroy', $item->id) }}" method="POST" style="display:inline;">
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

    <div class="modal fade" id="addPasienModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Pasien ODGJ Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('odgj.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis</label>
                            <input type="text" class="form-control" name="no_e_rekam_medis" placeholder="Opsional">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="text" class="form-control" name="nik" required maxlength="16"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Pasien</label><input type="text" class="form-control" name="nama" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date" class="form-control" name="tanggal_lahir" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group"><label>Alamat</label><input type="text" class="form-control" name="alamat" required></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>RT</label><input type="text" class="form-control" name="rt" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Status Pasien</label>
                                    <select class="form-control" name="status_pasien" required>
                                        <option value="Baru">Baru</option>
                                        <option value="Lama">Lama</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jadwal Kontrol</label>
                                    <select class="form-control" name="jadwal_kontrol" required>
                                        <option value="">Pilih Bulan</option>
                                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                                        <option value="{{ $bulan }}">{{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><label>Diagnosis</label><input type="text" class="form-control" name="diagnosis"></div>
                        <div class="form-group"><label>Keterangan</label><textarea class="form-control" name="keterangan" rows="2"></textarea></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPasienModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Data Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No e-Rekam Medis</label>
                            <input type="text" class="form-control" id="edit_erm" name="no_e_rekam_medis">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>NIK</label><input type="text" class="form-control" id="edit_nik" name="nik" required maxlength="16"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Nama Pasien</label><input type="text" class="form-control" id="edit_nama" name="nama" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Jenis Kelamin</label>
                                    <select class="form-control" id="edit_jk" name="jenis_kelamin" required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date" class="form-control" id="edit_tgl" name="tanggal_lahir" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group"><label>Alamat</label><input type="text" class="form-control" id="edit_alamat" name="alamat" required></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>RT</label><input type="text" class="form-control" id="edit_rt" name="rt" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label>Status Pasien</label>
                                    <select class="form-control" id="edit_status" name="status_pasien" required>
                                        <option value="Baru">Baru</option>
                                        <option value="Lama">Lama</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Jadwal Kontrol</label>
                                    <select class="form-control" id="edit_jadwal" name="jadwal_kontrol" required>
                                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                                        <option value="{{ $bulan }}">{{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><label>Diagnosis</label><input type="text" class="form-control" id="edit_diagnosis" name="diagnosis"></div>
                        <div class="form-group"><label>Keterangan</label><textarea class="form-control" id="edit_ket" name="keterangan" rows="2"></textarea></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Detail Pasien</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>NIK</th>
                            <td>: <span id="d-nik"></span></td>
                        </tr>
                        <tr>
                            <th>No e-RM</th> {{-- DETAIL BARU --}}
                            <td>: <span id="d-erm"></span></td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>: <span id="d-nama"></span></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: <span id="d-jk"></span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>: <span id="d-tgl"></span></td>
                        </tr>
                        <tr>
                            <th>Umur</th>
                            <td>: <span id="d-umur"></span> Tahun</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: <span id="d-alamat"></span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: <span id="d-status"></span></td>
                        </tr>
                        <tr>
                            <th>Diagnosis</th>
                            <td>: <span id="d-diagnosis"></span></td>
                        </tr>
                        <tr>
                            <th>Jadwal Kontrol</th>
                            <td>: <span id="d-kontrol"></span></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>: <span id="d-ket"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>

    <script>
        // 1. Script Detail Modal
        $(document).on('click', '.btn-detail', function() {
            $('#d-nik').text($(this).data('nik'));
            $('#d-erm').text($(this).data('erm') || '-'); // Isi Detail ERM
            $('#d-nama').text($(this).data('nama'));
            $('#d-jk').text($(this).data('jk'));
            $('#d-tgl').text($(this).data('tgl'));
            $('#d-umur').text($(this).data('umur'));
            $('#d-alamat').text($(this).data('alamat') + ' (RT ' + $(this).data('rt') + ')');
            $('#d-status').text($(this).data('status'));
            $('#d-diagnosis').text($(this).data('diagnosis'));
            $('#d-kontrol').text($(this).data('kontrol'));
            $('#d-ket').text($(this).data('ket'));
        });

        // 2. Script Edit Modal (Single Modal Logic)
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let url = "{{ route('odgj.update', ':id') }}";
            url = url.replace(':id', id);
            $('#editForm').attr('action', url);

            $('#edit_nik').val($(this).data('nik'));
            $('#edit_erm').val($(this).data('erm')); // Isi Edit ERM
            $('#edit_nama').val($(this).data('nama'));
            $('#edit_jk').val($(this).data('jk'));
            $('#edit_tgl').val($(this).data('tgl'));
            $('#edit_alamat').val($(this).data('alamat'));
            $('#edit_rt').val($(this).data('rt'));
            $('#edit_status').val($(this).data('status'));
            $('#edit_jadwal').val($(this).data('jadwal'));
            $('#edit_diagnosis').val($(this).data('diagnosis'));
            $('#edit_ket').val($(this).data('ket'));
        });

        // 3. Konfirmasi Hapus
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