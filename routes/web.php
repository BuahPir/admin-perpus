<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiBukuController;


Route::get('/buku/create', [InformasiBukuController::class, 'create'])->name('buku.create');


Route::post('/buku', [InformasiBukuController::class, 'store'])->name('buku.store');


Route::get('/', [InformasiBukuController::class, 'index'])->name('buku.index');

Route::get('/buku/{id}/edit', [InformasiBukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{id}', [InformasiBukuController::class, 'update'])->name('buku.update');


Route::get('/buku/{id}', [InformasiBukuController::class, 'show'])->name('buku.show');

// (Opsional) Hapus buku
Route::delete('/buku/{id}', [InformasiBukuController::class, 'destroy'])->name('buku.destroy');
