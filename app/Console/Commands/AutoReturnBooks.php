<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AutoReturnBooks extends Command
{
    protected $signature = 'books:auto-return';
    protected $description = 'Mengembalikan buku secara otomatis setelah 3 hari peminjaman';

    public function handle()
    {
        $this->info('Proses auto return buku dimulai...');

        // Cari semua peminjaman yang lebih dari 3 hari dan masih berstatus "dipinjam"
        $borrowedBooks = DB::table('peminjaman_buku')
            ->where('status', 'dipinjam')
            ->where('tanggal_peminjaman', '<=', Carbon::now()->subDays(3))
            ->get();

        foreach ($borrowedBooks as $peminjaman) {
            // Update status peminjaman
            DB::table('peminjaman_buku')
                ->where('id', $peminjaman->id)
                ->update([
                    'status' => 'selesai',
                ]);

            // Update status buku menjadi tersedia
            DB::table('informasi_buku')
                ->where('id', $peminjaman->informasi_buku_id)
                ->update([
                    'status' => 'tersedia',
                ]);
        }

        $this->info('Auto return selesai. ' . count($borrowedBooks) . ' buku diproses.');
    }
}
