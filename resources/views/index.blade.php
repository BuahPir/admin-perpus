@extends('layouts.app')

@section('content')
    <div class="container mt-4 paddi">
        <h1 class="mb-4 text-center text-5xl">Daftar Buku</h1>

        <div class="mb-3">
            <a href="{{ route('buku.create') }}" class="btn btn-primary btn-lg">Tambah Buku</a>
        </div>

        <div class="row">
            @foreach ($buku as $item)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-8">
                        <img src="{{ $item->cover_url }}" class="card-img-top" alt="Cover Buku" style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text">
                                <strong>Penulis:</strong> {{ $item->penulis }}<br>
                                <strong>Penerbit:</strong> {{ $item->penerbit ?? '-' }}<br>
                                <strong>Tahun Terbit:</strong> {{ $item->tahun_terbit ?? '-' }}
                            </p>
                            <span class="badge bg-{{ $item->status === 'tersedia' ? 'success' : 'secondary' }}">
                                <strong>Status: </strong>{{ ucfirst($item->status) }}
                            </span>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('buku.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            </div>
                            @if ($item->status === 'tersedia')
                                <form action="{{ route('buku.destroy', $item->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
