@extends('layouts.app')

@section('title', 'Data pengeluaran - Kas Buku')

@push('css')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        #tablepengeluaran thead th {
            background-color: #f8f9fc;
            color: #5a5c69;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 2px solid #e3e6f0;
            vertical-align: middle;
        }

        #tablepengeluaran tbody td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .nominal {
            font-weight: 700;
            color: #1cc88a;
        }
    </style>
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data pengeluaran</h1>
        <button class="btn btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#modalTambahpengeluaran">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah pengeluaran</span>
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

    <!-- Card Table pengeluaran -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi pengeluaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablepengeluaran" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Username</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengeluaran as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->username }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td class="nominal">Rp. {{ number_format($row->nominal) }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modalEditpengeluaran{{ $row->id }}" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapuspengeluaran{{ $row->id }}" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Edit pengeluaran  -->
                            <div class="modal fade" id="modalEditpengeluaran{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title" id="modalEditLabel1"><i class="fas fa-pencil-alt mr-2"></i>Edit pengeluaran</h5>
                                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('edit.pengeluaran', $row->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="tanggal_edit1">Tanggal <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="tanggal_edit1" name="tanggal" value="{{ $row->tanggal }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="keterangan_edit1">Keterangan</label>
                                                    <textarea class="form-control" id="keterangan_edit1" name="keterangan" rows="3">{{ $row->keterangan }}</textarea>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label for="jumlah_edit1">Nominal (Rp) <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="jumlah_edit1" name="nominal" value="{{ $row->nominal }}" required>
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

                            <!-- Modal Hapus pengeluaran 1 -->
                            <div class="modal fade" id="modalHapuspengeluaran{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="modalHapusLabel1"><i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Hapus</h5>
                                            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data pengeluaran <strong>{{ $row->keterangan }}</strong> senilai <strong>{{ $row->nominal }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('hapus.pengeluaran', $row->id) }}" method="POST" class="d-inline">
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
                                <td colspan="4" style="text-align: center;">Belum ada data pengeluaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah pengeluaran -->
    <div class="modal fade" id="modalTambahpengeluaran" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahLabel"><i class="fas fa-plus-circle mr-2"></i>Tambah pengeluaran</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tambah.pengeluaran') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan transaksi..."></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label for="jumlah">Nominal (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="jumlah" name="nominal" placeholder="Contoh: 500000" required>
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
@endsection

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#tablepengeluaran').DataTable({
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