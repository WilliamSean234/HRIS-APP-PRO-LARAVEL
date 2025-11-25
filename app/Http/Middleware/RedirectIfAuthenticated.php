<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // 💥 Bagian KRUSIAL 💥
                // Jika sudah login, redirect ke halaman utama (sesuai RouteServiceProvider::HOME)
                return redirect(RouteServiceProvider::HOME); 
            }
        }

        return $next($request);
    }
}