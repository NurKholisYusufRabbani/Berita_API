<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Jika request tidak terautentikasi dan bukan JSON, jangan redirect ke route 'login'.
     * Kita anggap ini murni API, jadi langsung beri respons 401 (Unauthorized).
     */
    protected function redirectTo(Request $request): ?string
    {
        // Tidak redirect, cukup return null agar Laravel balas 401 JSON
        return $request->expectsJson() ? null : null;
    }
}
