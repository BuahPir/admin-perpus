@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Edit Buku</h2>

        <!-- Success Message -->
        @if (session('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Judul Buku -->
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $buku->judul) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Penulis -->
            <div class="mb-4">
                <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
                <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $buku->penulis) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Penerbit -->
            <div class="mb-4">
                <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Tahun Terbit -->
            <div class="mb-4">
                <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="file_buku" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"style="text-align: justify">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
            </div>

            <!-- File Buku -->
            <div class="mb-4">
                <label for="file_buku" class="block text-sm font-medium text-gray-700">File Buku (Opsional)</label>
                <input type="file" name="file_buku" id="file_buku" accept="application/pdf,application/epub"
                    class="mt-1 block w-full text-sm text-gray-700 border p-3 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @if ($buku->file_buku_url)
                    <p class="text-sm mt-2">File Buku:
                        <a href="{{ $buku->file_buku_url }}" target="_blank" class="text-indigo-600 underline">Download</a>
                    </p>
                @endif
            </div>

            <!-- Gambar Sampul -->
            <div class="mb-4">
                <label for="cover" class="block text-sm font-medium text-gray-700">Gambar Sampul (Opsional)</label>
                <input type="file" name="cover" id="cover" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-700 border p-3 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @if ($buku->cover_url)
                    <div class="mt-2">
                        <img src="{{ $buku->cover_url }}" alt="Cover Buku" class="w-32 h-auto border rounded shadow-sm">
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('buku.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">← Kembali ke Daftar Buku</a>
                <button type="submit" class="py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    Update Buku
                </button>
            </div>
        </form>
    </div>
@endsection
