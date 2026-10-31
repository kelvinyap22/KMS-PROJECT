<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekMahasiswa
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('mahasiswa_id')) {
            return redirect('/login-mahasiswa');
        }

        return $next($request);
    }
}