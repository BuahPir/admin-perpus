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
        $buku = InformasiBuku::all();
        return view('index', compact('buku'));
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
            'deskripsi' => $validated['deskripsi'] ?? null,
            'file_buku_url' => $fileBukuUrl,
            'cover_url' => $coverUrl,
            'status' => 'tersedia',
        ]);

        return response()->json([
            'message' => 'Data buku berhasil disimpan.',
            'data' => $buku
        ], 201);
    }
    public function edit($id)
    {
        // Ambil data buku berdasarkan ID
        $buku = InformasiBuku::findOrFail($id);

        // Kembalikan ke tampilan edit dengan membawa data buku
        return view('edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
            'file_buku' => 'nullable|file|mimes:pdf,epub|max:50000', // Misalnya hanya mendukung PDF atau EPUB
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Maksimal 10MB untuk cover
        ]);

        // Mencari buku yang akan diupdate
        $buku = InformasiBuku::findOrFail($id);

        // Jika ada file buku yang diupload, upload ke S3 dan update URL-nya
        if ($request->hasFile('file_buku')) {
            // Hapus file lama dari S3 jika ada
            $this->deleteFromS3($buku->file_buku_url);

            // Upload file baru ke S3
            $fileBukuUrl = $this->uploadToS3($request->file('file_buku'), 'buku');
            $buku->file_buku_url = $fileBukuUrl; // Update URL file buku
        }

        // Jika ada cover yang diupload, upload ke S3 dan update URL-nya
        if ($request->hasFile('cover')) {
            // Hapus cover lama dari S3 jika ada
            $this->deleteFromS3($buku->cover_url);

            // Upload cover baru ke S3
            $coverUrl = $this->uploadToS3($request->file('cover'), 'cover');
            $buku->cover_url = $coverUrl; // Update URL cover
        }

        // Update informasi buku lainnya
        $buku->judul = $validated['judul'];
        $buku->penulis = $validated['penulis'];
        $buku->penerbit = $validated['penerbit'] ?? null;
        $buku->tahun_terbit = $validated['tahun_terbit'] ?? null;
        $buku->deskripsi = $validated['deskripsi'] ?? null;

        // Simpan perubahan ke database
        $buku->save();

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate.');
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

        // Hapus file dari S3
        $this->deleteFromS3($buku->file_buku_url);
        $this->deleteFromS3($buku->cover_url);

        // Hapus data buku dari database
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');

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
        if (!$file) {
            return null;
        }
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
