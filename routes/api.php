<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PeminjamanBukuController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('peminjaman', PeminjamanBukuController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);
