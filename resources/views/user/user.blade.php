@extends('layouts.app')

@section('title', 'Manajemen Akun - Kas Buku')

@push('css')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        #tableAkun thead th {
            background-color: #f8f9fc;
            color: #5a5c69;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 2px solid #e3e6f0;
            vertical-align: middle;
        }

        #tableAkun tbody td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .badge-level {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4em 0.7em;
        }
    </style>
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <button class="btn btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#modalTambahAkun">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Akun</span>
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Simpan gagal!</strong> Periksa kembali isian form berikut:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Card Table Akun -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tableAkun" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <!-- Example Data 1 -->
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->nama }}</td>
                                <td><span class="badge badge-primary badge-level">{{ $user->level }}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modalEditAkun{{ $user->id }}" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusAkun{{ $user->id }}" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>

                             <!-- Modal Edit Akun 1 -->
                            <div class="modal fade" id="modalEditAkun{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditAkunLabel1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title" id="modalEditAkunLabel1"><i class="fas fa-user-edit mr-2"></i>Edit Akun</h5>
                                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('user.edit', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="username_edit1">Username <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="username_edit1" name="username" value="{{ $user->username }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name_edit1">Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name_edit1" name="nama" value="{{ $user->nama }}" required>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label for="level_edit{{ $user->id }}">Level <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="level_edit{{ $user->id }}" name="level" required>
                                                        <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="user" {{ $user->level == 'user' ? 'selected' : '' }}>User</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                                <button class="btn btn-warning text-white" type="submit"><i class="fas fa-save mr-1"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus Akun -->
                            <div class="modal fade" id="modalHapusAkun{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusAkunLabel1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="modalHapusAkunLabel1"><i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Hapus</h5>
                                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus akun <strong>{{ $user->username }}</strong> atas nama <strong>{{ $user->nama }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('user.delete', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"><i class="fas fa-trash mr-1"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center;">Belum ada data akun.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Akun -->
    <div class="modal fade" id="modalTambahAkun" tabindex="-1" role="dialog" aria-labelledby="modalTambahAkunLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahAkunLabel"><i class="fas fa-user-plus mr-2"></i>Tambah Akun</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.tambah') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="level">Level <span class="text-danger">*</span></label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="">-- Pilih Level --</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save mr-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Akun 2 -->
    <div class="modal fade" id="modalEditAkun2" tabindex="-1" role="dialog" aria-labelledby="modalEditAkunLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditAkunLabel2"><i class="fas fa-user-edit mr-2"></i>Edit Akun</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username_edit2">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username_edit2" name="username" value="budi" required>
                        </div>
                        <div class="form-group">
                            <label for="name_edit2">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name_edit2" name="name" value="Budi Santoso" required>
                        </div>
                        <div class="form-group">
                            <label for="password_edit2">Password</label>
                            <input type="password" class="form-control" id="password_edit2" name="password" placeholder="Kosongkan jika tidak diubah">
                        </div>
                        <div class="form-group mb-0">
                            <label for="level_edit2">Level <span class="text-danger">*</span></label>
                            <select class="form-control" id="level_edit2" name="level" required>
                                <option value="admin">Admin</option>
                                <option value="user" selected>User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-warning text-white" type="submit"><i class="fas fa-save mr-1"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Akun 2 -->
    <div class="modal fade" id="modalHapusAkun2" tabindex="-1" role="dialog" aria-labelledby="modalHapusAkunLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusAkunLabel2"><i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Hapus</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus akun <strong>"budi"</strong> atas nama <strong>Budi Santoso</strong>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="#" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash mr-1"></i> Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#tableAkun').DataTable({
                order: [],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    zeroRecords: "Data tidak ditemukan",
                    infoEmpty: "Tidak ada data"
                }
            });
        });
    </script>
@endpush