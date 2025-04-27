<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;

class PeminjamanBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
        \App\Models\InformasiBuku::where('id', $request->informasi_buku_id)
        ->update(['status' => 'dipinjam']);

        return response()->json([
            'message' => 'Buku berhasil dipinjam!',
            'data' => $peminjaman
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
