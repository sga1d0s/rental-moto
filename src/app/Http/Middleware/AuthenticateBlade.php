<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateBlade
{
    /**
     * Si no hay user_id en sesión, redirige a /login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('user_id')) {
            return redirect('/login');
        }

        return $next($request);
    }
}