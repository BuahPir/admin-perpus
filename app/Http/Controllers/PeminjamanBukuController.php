<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;
use Illuminate\Support\Str;

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
        $validated = $request->validate([
            'user_id' => 'required|exists:users,firebase_uid',
            'informasi_buku_id' => 'required|uuid|exists:informasi_buku,id',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan'
        ]);

        // Cek status buku sebelum meminjam
        $buku = \App\Models\InformasiBuku::find($validated['informasi_buku_id']);

        if ($buku->status !== 'tersedia') {
            return response()->json([
                'message' => 'Buku tidak tersedia untuk dipinjam!'
            ], 400);
        }

        // Buat peminjaman
        $peminjaman = PeminjamanBuku::create([
            'user_id' => $validated['user_id'],
            'informasi_buku_id' => $validated['informasi_buku_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'status' => $validated['status']
        ]);

        // Update status buku menjadi "dipinjam"
        $buku->update(['status' => 'dipinjam']);

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
