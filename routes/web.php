<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiBukuController;
use App\Http\Controllers\PeminjamanBukuController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create', [InformasiBukuController::class, 'create'])->name('buku.create');
// Simpan data buku
Route::post('/buku', [InformasiBukuController::class, 'store'])->name('buku.store');

// (Opsional) Tampilkan daftar buku
Route::get('/buku', [InformasiBukuController::class, 'index'])->name('buku.index');

// (Opsional) Tampilkan detail buku
Route::get('/buku/{id}', [InformasiBukuController::class, 'show'])->name('buku.show');

// (Opsional) Hapus buku
Route::delete('/buku/{id}', [InformasiBukuController::class, 'destroy'])->name('buku.destroy');
