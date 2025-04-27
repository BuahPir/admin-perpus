<?php

namespace App\Http\Controllers;

use App\Models\InformasiBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InformasiBukuController extends Controller
{

    public function create()
    {
        return view('create');
    }
    public function index()
    {
        return response()->json(InformasiBuku::all(), 200);
    }

    /**
     * Menyimpan buku baru
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $fileBukuUrl = $this->uploadToS3($request->file('file_buku'), 'buku');
        $coverUrl = $this->uploadToS3($request->file('cover'), 'cover');

        $buku = InformasiBuku::create([
            'judul' => $validated['judul'],
            'penulis' => $validated['penulis'],
            'penerbit' => $validated['penerbit'] ?? null,
            'tahun_terbit' => $validated['tahun_terbit'] ?? null,
            'kategori' => $validated['kategori'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'jumlah_halaman' => $validated['jumlah_halaman'] ?? null,
            'kode_buku' => $validated['kode_buku'] ?? null,
            'file_buku_url' => $fileBukuUrl,
            'cover_url' => $coverUrl,
            'status' => 'tersedia',
            'tanggal_ditambahkan' => now(),
        ]);

        return response()->json([
            'message' => 'Data buku berhasil disimpan.',
            'data' => $buku
        ], 201);
    }

    /**
     * Menampilkan detail buku berdasarkan ID
     */
    public function show($id)
    {
        $buku = InformasiBuku::findOrFail($id);
        return view('show', compact('buku'));
    }

    /**
     * Menghapus buku beserta file di S3
     */
    public function destroy($id)
    {
        $buku = InformasiBuku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        $this->deleteFromS3($buku->file_buku_url);
        $this->deleteFromS3($buku->cover_url);

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.']);
    }

    // =========================
    //  HELPER FUNCTIONS
    // =========================

    /**
     * Validasi input dari form
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'nullable|string',
            'tahun_terbit' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'file_buku' => 'required|file|mimes:pdf',
            'cover' => 'required|image|mimes:jpeg,jpg,png',
        ]);
    }

    /**
     * Upload file ke AWS S3 dan kembalikan URL-nya
     */
    private function uploadToS3($file, $folder)
    {
        $filename = $folder . '/' . Str::random(10) . '_' . $file->getClientOriginalName();
        Storage::disk('s3')->put($filename, file_get_contents($file), 'public');
        return Storage::disk('s3')->url($filename);
    }

    /**
     * Hapus file dari AWS S3
     */
    private function deleteFromS3($url)
    {
        $path = ltrim(parse_url($url, PHP_URL_PATH), '/');
        Storage::disk('s3')->delete($path);
    }
}
