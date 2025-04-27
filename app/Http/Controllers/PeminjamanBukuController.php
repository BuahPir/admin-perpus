<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
            'user_id' => 'required|exists:users,firebase_uid', // VALIDASI Firebase UID
            'informasi_buku_id' => 'required|uuid|exists:informasi_buku,id',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan'
        ]);

        // Cari buku
        $buku = \App\Models\InformasiBuku::find($validated['informasi_buku_id']);
        if (!$buku) {
            return response()->json([
                'message' => 'Buku tidak ditemukan!'
            ], 404);
        }

        if ($buku->status !== 'tersedia') {
            return response()->json([
                'message' => 'Buku tidak tersedia untuk dipinjam!'
            ], 400);
        }

        // Jalankan transaction (optional, tapi aman banget)
        DB::beginTransaction();
        try {
            $peminjaman = \App\Models\PeminjamanBuku::create([
                'user_id' => $validated['user_id'], // SIMPAN FIREBASE UID!
                'informasi_buku_id' => $validated['informasi_buku_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'status' => $validated['status']
            ]);

            $buku->update(['status' => 'dipinjam']);

            DB::commit();

            return response()->json([
                'message' => 'Buku berhasil dipinjam!',
                'data' => $peminjaman
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat meminjam buku.',
                'error' => $e->getMessage()
            ], 500);
        }
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
