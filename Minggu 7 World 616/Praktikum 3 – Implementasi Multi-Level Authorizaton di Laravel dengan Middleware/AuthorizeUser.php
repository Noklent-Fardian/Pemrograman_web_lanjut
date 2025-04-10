<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        $user_role = $request->user()->getLevelCode();  // ambil user yang sedang login
        if(in_array($user_role,$roles)){  // jika user memiliki level yang sesuai
            // Jika user memiliki level yang sesuai, lanjutkan ke request berikutnya
            return $next($request);
        }
        

        // Jika user tidak memiliki level yang sesuai, redirect ke halaman login
        abort(403, 'Forbidden. Kamu tidak punya akes ke halaman ini.');
    }
}
