<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'user' => Auth::user(),
        ];

        $hariIni = Carbon::today()->toDateString();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;    

        //pengeluaran
        $pengeluaranHariIni = Transaksi::where('jenis_transaksi', 'Pengeluaran')->whereDate('tanggal', $hariIni)->sum('nominal'); 
        $pengeluaranBulanIni = Transaksi::where('jenis_transaksi', 'Pengeluaran')->whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)->sum('nominal'); 
        $totalPengeluaran = Transaksi::where('jenis_transaksi', 'Pengeluaran')->sum('nominal');

        //pemasukan
        $pemasukanHariIni = Transaksi::where('jenis_transaksi', 'Pemasukan')->whereDate('tanggal', $hariIni)->sum('nominal'); 
        $pemasukanBulanIni = Transaksi::where('jenis_transaksi', 'Pemasukan')->whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)->sum('nominal'); 
        $totalPemasukan = Transaksi::where('jenis_transaksi', 'Pemasukan')->sum('nominal'); 

        $saldoSekarang = $totalPemasukan - $totalPengeluaran;

        return view('index', $data, compact(
            'pengeluaranHariIni',
            'pengeluaranBulanIni',
            'totalPengeluaran',
            'pemasukanHariIni',
            'pemasukanBulanIni',
            'totalPemasukan',
            'saldoSekarang'
        ));
    }

    public function laporan(Request $request)
    {
        $dari = $request->input('dari');
        $sampai = $request->input('sampai');

        $query = Transaksi::query();

        if ($dari && $sampai) {
            $query->whereBetween('tanggal', [$dari, $sampai]);
        } elseif ($dari) {
            $query->whereDate('tanggal', '>=', $dari);
        } elseif ($sampai) {
            $query->whereDate('tanggal', '<=', $sampai);
        }

        $transaksis = $query->orderBy('tanggal', 'asc')->get();

        $totalPemasukan = $transaksis->where('jenis_transaksi', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksis->where('jenis_transaksi', 'Pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('laporan', compact(
            'transaksis',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'dari',
            'sampai'
        ));
    }
}
