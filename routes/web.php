<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
 
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
 
    Route::middleware(['admin'])->group(function () {
        Route::get('admin', [AdminController::class, 'index']);
        Route::get('data_anggota', [AdminController::class, 'anggota']);
        Route::get('edit_anggota{id}', [AdminController::class, 'edit_anggota']);
        Route::put('update_anggota{id}', [AdminController::class, 'update_anggota']);
        Route::get('data_pengajuan', [AdminController::class, 'pengajuan']);
        Route::get('setuju{id}', [AdminController::class, 'setuju']);
        Route::get('tolak{id}', [AdminController::class, 'tolak']);
        Route::get('data_transaksi', [AdminController::class, 'transaksi']);
        Route::get('angsuran{id}', [AdminController::class, 'angsuran']);
        Route::get('angsur{id}', [AdminController::class, 'angsur']);
        Route::get('laporan_anggota', [AdminController::class, 'laporan_anggota']);
        Route::get('laporan_pinjaman', [AdminController::class, 'laporan_peminjaman']);
        Route::get('jenis_pinjaman', [AdminController::class, 'jenis_pinjaman']);
        Route::get('data_riwayat', [AdminController::class, 'riwayat']);
        Route::get('tambah_anggota', [AdminController::class, 'tambah_anggota']);
        Route::post('simpan_anggota', [AdminController::class, 'simpan_anggota']);
        Route::get('hapus_anggota{id}', [AdminController::class, 'hapus_anggota']);
        Route::get('tambah_pinjaman', [AdminController::class, 'tambah_pinjaman']);
        Route::post('simpan_pinjaman', [AdminController::class, 'simpan_pinjaman']);
        Route::get('hapus_pinjaman{id}', [AdminController::class, 'hapus_pinjaman']);
        Route::get('edit_pinjaman{id}', [AdminController::class, 'edit_pinjaman']);
        Route::put('update_pinjaman{id}', [AdminController::class, 'update_pinjaman']);
    });

    Route::middleware(['anggota'])->group(function () {
        Route::get('anggota', [AnggotaController::class, 'index']);
        Route::get('pengajuan', [AnggotaController::class, 'pengajuan']);
        Route::get('transaksi', [AnggotaController::class, 'transaksi']);
        Route::get('riwayat', [AnggotaController::class, 'riwayat']);
        Route::post('tambahpengajuan', [AnggotaController::class, 'simpan']);
    });
    
});