<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>Kelola Petugas</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .table td,
        .table th {
            white-space: nowrap;
            vertical-align: middle;
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
                                <h4 class="card-title">Kelola Akun Petugas & Admin</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPetugasModal">
                                    <i class="nc-icon nc-single-02"></i> Tambah Akun
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="text-primary">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Dibuat Pada</th>
                                            <th class="text-center">Aksi</th>
                                        </thead>
                                        <tbody>
                                            @foreach($petugas as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    <span class="badge {{ $item->role == 'admin' ? 'badge-danger' : 'badge-success' }}">
                                                        {{ ucfirst($item->role) }}
                                                    </span>
                                                </td>
                                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                <td class="text-center">
                                                    {{-- TOMBOL EDIT --}}
                                                    <button class="btn btn-warning btn-sm btn-icon btn-edit"
                                                        data-toggle="modal" data-target="#editPetugasModal"
                                                        data-id="{{ $item->id }}"
                                                        data-name="{{ $item->name }}"
                                                        data-email="{{ $item->email }}"
                                                        data-role="{{ $item->role }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    {{-- TOMBOL HAPUS --}}
                                                    {{-- Mencegah menghapus akun sendiri --}}
                                                    @if(auth()->id() != $item->id)
                                                    <form id="delete-form-{{ $item->id }}" action="{{ route('petugas.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm btn-icon" onclick="confirmDelete({{ $item->id }})">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endif
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

    <div class="modal fade" id="addPetugasModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Akun Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('petugas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" class="form-control" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                        <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required minlength="6"></div>
                        <div class="form-group"><label>Role</label>
                            <select name="role" class="form-control">
                                <option value="petugas">Petugas</option>
                                <option value="admin">Admin</option>
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

    <div class="modal fade" id="editPetugasModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" id="edit_name" class="form-control" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" id="edit_email" class="form-control" required></div>
                        <div class="form-group">
                            <label>Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group"><label>Role</label>
                            <select name="role" id="edit_role" class="form-control">
                                <option value="petugas">Petugas</option>
                                <option value="admin">Admin</option>
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

    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1"></script>

    <script>
        // Script Edit Modal
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let url = "{{ route('petugas.update', ':id') }}";
            url = url.replace(':id', id);
            $('#editForm').attr('action', url);

            $('#edit_name').val($(this).data('name'));
            $('#edit_email').val($(this).data('email'));
            $('#edit_role').val($(this).data('role'));
        });

        // Script Delete
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Akun?',
                text: "Akses user ini akan hilang permanen!",
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

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}"
        });
        @endif
    </script>
</body>

</html>