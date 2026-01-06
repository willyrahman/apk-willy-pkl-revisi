<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>Manajemen Petugas</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
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
                                <h4 class="card-title">Data Petugas</h4>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPetugasModal">
                                    <i class="nc-icon nc-simple-add"></i>&nbsp; Tambah Petugas
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    <table class="table">
                                        <thead class="text-primary">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Petugas</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Password</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($petugas as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->email }}</td>
                                                <td class="text-center"><span class="badge badge-info">{{ ucfirst($item->role) }}</span></td>
                                                <td class="text-center">******</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPetugasModal{{ $item->id }}" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('petugas.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus petugas ini?');" title="Hapus">
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
        </div>
    </div>

    <div class="modal fade" id="addPetugasModal" tabindex="-1" role="dialog" aria-labelledby="addPetugasModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPetugasModalLabel">Tambah Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('petugas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <script>
                            window.onload = function() {
                                $('#addPetugasModal').modal('show');
                            };
                        </script>
                        @endif
                        <div class="form-group">
                            <label for="name">Nama Petugas</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" name="role" required>
                                <option value="operator">Operator</option>
                                <option value="admin">Admin</option>
                                <option value="kepala">Kepala</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($petugas as $item)
    <div class="modal fade" id="editPetugasModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editPetugasModalLabel{{ $item->id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPetugasModalLabel{{ $item->id }}">Edit Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('petugas.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Petugas</label>
                            <input type="text" class="form-control" name="name" value="{{ $item->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>Password (Isi jika ingin mengganti)</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="role" required>
                                <option value="operator" {{ $item->role == 'operator' ? 'selected' : '' }}>Operator</option>
                                <option value="admin" {{ $item->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kepala" {{ $item->role == 'kepala' ? 'selected' : '' }}>Kepala</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/dist/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
</body>

</html>