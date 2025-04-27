<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_buku';

    protected $fillable = [
        'user_id',
        'informasi_buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];
}
