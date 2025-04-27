<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SkipCsrfForPeminjaman extends Middleware
{
    protected function shouldSkip(Request $request): bool
    {
        return $request->is('peminjaman'); // <-- sesuaikan endpoint URL kamu di sini
    }
}
