<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'user'  => Auth::user(),
            'users' => User::all(),
            'title' => 'Manajement Akun',
        ];

        return view('user.user', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nama' => ['required', 'string'],
            'level' => ['required', 'string'],
        ]);

        $data = [
            'username' => $request->username,
            'password' => $request->password,
            'nama' => $request->nama,
            'level' => $request->level,
        ];

        User::create($data);

        return redirect()->route('user')->with('success', 'Akun Berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'nama' => ['required', 'string'],
            'level' => ['required', 'string'],
        ]);

        $user = User::findOrFail($id);

        $data = [
            'username' => $request->username,
            'nama' => $request->nama,
            'level' => $request->level,
        ];

        $user->update($data);

        return redirect()->route('user')->with('success', 'Akun Berhasil diubah.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('user')->with('success', 'Berhasil menghapus Akun.');
    }
}
