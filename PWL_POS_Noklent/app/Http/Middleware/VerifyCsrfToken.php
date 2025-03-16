<?php

namespace App\Http\Middleware;

use App\Models\Kategori;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/kategori',
        '/level',
        '/user',
        '/barang'
    ];
}
