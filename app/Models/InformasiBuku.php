<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InformasiBuku extends Model
{
    protected $table = 'informasi_buku';

    protected $primaryKey = 'id';

    public $incrementing = false; // karena pakai UUID

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'deskripsi',
        'file_buku_url',
        'cover_url',
        'status',
    ];

    // Generate UUID saat membuat instance baru
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
