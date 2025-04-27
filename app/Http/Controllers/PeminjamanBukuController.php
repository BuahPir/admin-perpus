<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;

class PeminjamanBukuController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id',
            'informasi_buku_id' => 'required|uuid|exists:informasi_buku,id',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan'
        ]);

        $peminjaman = PeminjamanBuku::create([
            'user_id' => $request->user_id,
            'informasi_buku_id' => $request->informasi_buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Buku berhasil dipinjam!',
            'data' => $peminjaman
        ], 201);
    }
}
