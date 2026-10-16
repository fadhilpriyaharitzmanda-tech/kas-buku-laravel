<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function pemasukan(){
        $data = [
            'user' => Auth::user(),
            'pemasukan' => Transaksi::where('jenis_transaksi', 'Pemasukan')->get(),
        ];
        
        return view('transaksi.pemasukan', $data);
    }

    public function tambah_pemasukan(Request $request){
        $request->validate([
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0',
        ]);

        $data = [
            'tanggal'         => $request->tanggal,
            'username'        => Auth::user()->username,
            'keterangan'      => $request->keterangan,
            'nominal'         => $request->nominal,
            'jenis_transaksi' => 'Pemasukan',
        ];

        Transaksi::create($data);
        return redirect()->route('pemasukan')->with('success', 'Pemasukan Berhasil ditambahkan.');
    }

    public function edit_pemasukan(Request $request, $id){
        $request->validate([
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0',
        ]);

        $id = Transaksi::findOrFail($id);

        $data = [
            'tanggal'         => $request->tanggal,
            'username'        => Auth::user()->username,
            'keterangan'      => $request->keterangan,
            'nominal'         => $request->nominal,
            'jenis_transaksi' => 'Pemasukan',
        ];

        $id->update($data);
        return redirect()->route('pemasukan')->with('success', 'Pemasukan Berhasil diubah.');
    }

    public function hapus_pemasukan($id){
        $id = Transaksi::findOrFail($id);

        $id->delete();
        return redirect()->route('pemasukan')->with('success', 'Pemasukan Berhasil dihapus.');
    }

    public function pengeluaran(){
        $data = [
            'user' => Auth::user(),
            'pengeluaran' => Transaksi::where('jenis_transaksi', 'Pengeluaran')->get(),
        ];

        return view('transaksi.pengeluaran', $data);
    }

    public function tambah_pengeluaran(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0',
        ]);

        $data = [
            'tanggal'         => $request->tanggal,
            'username'        => Auth::user()->username,
            'keterangan'      => $request->keterangan,
            'nominal'         => $request->nominal,
            'jenis_transaksi' => 'pengeluaran',
        ];

        Transaksi::create($data);
        return redirect()->route('pengeluaran')->with('success', 'pengeluaran Berhasil ditambahkan.');
    }

    public function edit_pengeluaran(Request $request, $id)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal'    => 'required|numeric|min:0',
        ]);

        $id = Transaksi::findOrFail($id);

        $data = [
            'tanggal'         => $request->tanggal,
            'username'        => Auth::user()->username,
            'keterangan'      => $request->keterangan,
            'nominal'         => $request->nominal,
            'jenis_transaksi' => 'pengeluaran',
        ];

        $id->update($data);
        return redirect()->route('pengeluaran')->with('success', 'pengeluaran Berhasil diubah.');
    }

    public function hapus_pengeluaran($id)
    {
        $id = Transaksi::findOrFail($id);

        $id->delete();
        return redirect()->route('pengeluaran')->with('success', 'pengeluaran Berhasil dihapus.');
    }
}
