@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Detail Buku</h2>

    <div class="card shadow-lg">
        <div class="row g-0 p-8">
            <div class="col-md-4">
                <!-- Menampilkan cover buku atau placeholder jika tidak ada -->
                @if ($buku->cover_url)
                    <img src="{{ $buku->cover_url }}" class="img-fluid rounded-start" alt="Cover Buku">
                @else
                    <img src="https://via.placeholder.com/300x400?text=No+Cover" class="img-fluid rounded-start" alt="Tidak ada cover">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title text-uppercase font-bold">{{ $buku->judul }}</h4>
                    <p class="card-text"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                    <p class="card-text"><strong>Penerbit:</strong> {{ $buku->penerbit ?? '-' }}</p>
                    <p class="card-text"><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit ?? '-' }}</p>
                    <p class="card-text"><strong>Status:</strong>
                        <span class="badge bg-{{ $buku->status === 'tersedia' ? 'success' : 'danger' }}">
                            {{ ucfirst($buku->status) }}
                        </span>
                    </p>
                    <p class="card-text"><strong>Deskripsi:</strong> <br>{{ $buku->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                    @if ($buku->file_buku_url)
                        <a href="{{ $buku->file_buku_url }}" target="_blank" class="btn btn-outline-primary mt-3">
                            Baca / Download Buku
                        </a>
                    @else
                        <p class="mt-3 text-muted">Tidak ada file buku untuk diunduh.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">← Kembali ke Daftar Buku</a>
        <!-- Tombol pinjam buku jika tersedia -->
        @if ($buku->status === 'tersedia')
            <a href="{{ route('buku.pinjam', $buku->id) }}" class="btn btn-primary">Pinjam Buku</a>
        @endif
    </div>
</div>
@endsection
