<div class="container">
    <h2 class="mb-4">Detail Buku</h2>

    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                @if ($buku->cover_url)
                    <img src="{{ $buku->cover_url }}" class="img-fluid rounded-start" alt="Cover Buku">
                @else
                    <img src="https://via.placeholder.com/300x400?text=No+Cover" class="img-fluid rounded-start" alt="Tidak ada cover">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">{{ $buku->judul }}</h4>
                    <p class="card-text"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                    <p class="card-text"><strong>Penerbit:</strong> {{ $buku->penerbit ?? '-' }}</p>
                    <p class="card-text"><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit ?? '-' }}</p>
                    <p class="card-text"><strong>Kategori:</strong> {{ $buku->kategori ?? '-' }}</p>
                    <p class="card-text"><strong>Jumlah Halaman:</strong> {{ $buku->jumlah_halaman ?? '-' }}</p>
                    <p class="card-text"><strong>Kode Buku:</strong> {{ $buku->kode_buku ?? '-' }}</p>
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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('buku.index') }}" class="btn btn-secondary mt-4">← Kembali ke Daftar Buku</a>
</div>
