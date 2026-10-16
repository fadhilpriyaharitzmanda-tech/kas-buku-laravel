<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laporan Kas Buku</title>

    <!-- Custom fonts -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Bootstrap + SB Admin styles -->
    <link href="{{ asset('template/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #f8f9fc;
        }

        .toolbar {
            margin: 20px 0 25px;
        }

        .report-header h3 {
            font-weight: 800;
            color: #4e73df;
            margin-bottom: 0;
        }

        .report-header .period {
            font-size: 0.9rem;
            color: #858796;
        }

        .report-summary .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .report-summary .card-body {
            text-align: center;
            color: #fff;
        }

        .report-summary .label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: rgba(255, 255, 255, 0.75);
        }

        .report-summary .value {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .table-report thead th {
            background-color: #4e73df;
            color: #fff;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: none;
            vertical-align: middle;
        }

        .table-report tbody td {
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .badge-pemasukan {
            background-color: #1cc88a;
            color: #fff;
            font-size: 0.75rem;
        }

        .badge-pengeluaran {
            background-color: #e74a3b;
            color: #fff;
            font-size: 0.75rem;
        }

        .th-nominal {
            width: 160px;
        }

        @media print {
            .toolbar {
                display: none !important;
            }

            body {
                background: #fff;
            }

            .report-summary .card-body {
                color: #000;
            }

            .report-summary .label {
                color: #6c757d;
            }

            .report-summary .value {
                color: #000;
            }

            .table-report thead th {
                background-color: #e9ecef !important;
                color: #212529 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .badge-pemasukan,
            .badge-pengeluaran {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Toolbar (hidden saat print) -->
        <div class="text-center toolbar">
            <button type="button" onclick="window.print()" class="btn btn-primary shadow-sm">
                <i class="fas fa-print fa-sm mr-1"></i> Cetak / Simpan PDF
            </button>
            <a href="{{ url()->previous() ?: route('dashboard') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
            </a>
        </div>

        <div class="report paper bg-white" style="padding: 30px 25px; border-radius: 0.5rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);">

            <!-- Kop Laporan -->
            <div class="report-header text-center mb-4">
                <h4 class="font-weight-bold mb-1">LAPORAN KAS BUKU</h4>
                <div class="period">
                    @if ($dari && $sampai)
                        Periode: {{ Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }} s/d
                        {{ Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}
                    @else
                        Periode: Semua Tanggal
                    @endif
                </div>
                <div class="period">
                    Dicetak pada: {{ Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="row report-summary mb-4">
                <div class="col-md-4 mb-2">
                    <div class="card" style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                        <div class="card-body">
                            <div class="label">Total Pemasukan</div>
                            <div class="value">Rp {{ number_format($totalPemasukan) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card" style="background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);">
                        <div class="card-body">
                            <div class="label">Total Pengeluaran</div>
                            <div class="value">Rp {{ number_format($totalPengeluaran) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="card" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                        <div class="card-body">
                            <div class="label">Saldo</div>
                            <div class="value">Rp {{ number_format($saldo) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rincian Transaksi -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-report mb-0" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
                            <th>Username</th>
                            <th class="th-nominal text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $index => $row)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $row->keterangan }}</td>
                                <td>
                                    @if (strtolower($row->jenis_transaksi) === 'pemasukan')
                                        <span class="badge badge-pemasukan">Pemasukan</span>
                                    @else
                                        <span class="badge badge-pengeluaran">Pengeluaran</span>
                                    @endif
                                </td>
                                <td>{{ $row->username }}</td>
                                <td class="text-right">Rp {{ number_format($row->nominal) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Tidak ada transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tanda tangan -->
            <div class="row mt-5">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4 text-center">
                    <div>Petugas,</div>
                    <div style="margin-top: 90px;">
                        <strong>{{ Auth::user()->nama ?? Auth::user()->username }}</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>
