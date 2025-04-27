<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanBukuController;

Route::post('/peminjaman', [PeminjamanBukuController::class, 'store']);
