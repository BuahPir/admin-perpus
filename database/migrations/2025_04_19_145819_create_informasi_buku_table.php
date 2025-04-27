<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informasi_buku', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('file_buku_url');       // Link ke file PDF di AWS S3
            $table->text('cover_url');           // Link ke gambar cover di AWS S3
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_buku');
    }
};
