<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::get('/pengeluaran', [TransaksiController::class, 'pengeluaran']);

    // route user
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user/tambah', [UserController::class, 'tambah'])->name('user.tambah');
    Route::put('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::delete('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    // route pemasukan
    Route::get('/pemasukan', [TransaksiController::class, 'pemasukan'])->name('pemasukan');
    Route::post('/pemasukan/tambah', [TransaksiController::class, 'tambah_pemasukan'])->name('tambah.pemasukan');
    Route::put('/pemasukan/edit/{id}', [TransaksiController::class, 'edit_pemasukan'])->name('edit.pemasukan');
    Route::delete('/pemasukan/hapus/{id}', [TransaksiController::class, 'hapus_pemasukan'])->name('hapus.pemasukan');

    // route pengeluaran
    Route::get('/pengeluaran', [TransaksiController::class, 'pengeluaran'])->name('pengeluaran');
    Route::post('/pengeluaran/tambah', [TransaksiController::class, 'tambah_pengeluaran'])->name('tambah.pengeluaran');
    Route::put('/pengeluaran/edit/{id}', [TransaksiController::class, 'edit_pengeluaran'])->name('edit.pengeluaran');
    Route::delete('/pengeluaran/hapus/{id}', [TransaksiController::class, 'hapus_pengeluaran'])->name('hapus.pengeluaran');
});
